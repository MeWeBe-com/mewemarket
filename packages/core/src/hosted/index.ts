// Hosted apps: keeps MeweMarket workspaces, members and roles in step with each hosted product's tenants.
import { randomUUID } from "node:crypto";
import { db, schema } from "@mewe/db";
import { and, eq, sql } from "drizzle-orm";
import { getAppDef } from "../apps";
import { decryptSecret, encryptSecret, randomPassword } from "../crypto";
import type { Role } from "../workspaces";
import { PROVIDERS, type ProviderName } from "./providers";
import { HostedError } from "./twenty";
import type { SignIn } from "./types";

export { HostedCapacityError, HostedError, HostedServiceError } from "./twenty";
export type { SignIn } from "./types";
export { easyAppointmentsPublicUrl } from "./easyappointments";

type Provider = ProviderName;
type Tenant = typeof schema.hostedTenants.$inferSelect;
const T = schema.hostedTenants, A = schema.hostedAccounts, M = schema.hostedMembers;

function providerOf(app: string): Provider {
  const def = getAppDef(app);
  if (def?.kind !== "hosted" || !def.hosted) throw new HostedError(`${app} is not a hosted app`);
  return def.hosted.provider;
}

export function isHostedApp(app: string) {
  return getAppDef(app)?.kind === "hosted";
}

/** Whether the server has the product configured at all (the App Store hides the app otherwise). */
export function hostedAvailable(app: string) {
  return PROVIDERS[providerOf(app)].configured();
}

/** Serialises provisioning per key across app servers (Postgres advisory lock held for the transaction). */
async function locked<R>(key: string, fn: () => Promise<R>) {
  return db.transaction(async (tx) => {
    await tx.execute(sql`select pg_advisory_xact_lock(hashtext(${key}))`);
    return fn();
  });
}

async function findTenant(workspaceId: string, provider: Provider) {
  const [t] = await db.select().from(T).where(and(eq(T.workspaceId, workspaceId), eq(T.provider, provider))).limit(1);
  return t ?? null;
}

/** Creates the workspace's tenant in the product, once. Safe to call again (e.g. after a failed first try). */
export async function provisionHostedApp(workspace: { id: string; slug: string; name: string; currency?: string }, app: string) {
  const provider = providerOf(app);
  // One at a time per product: some products are opened up briefly while a company is created (Plane's
  // workspace creation, Twenty's invite link), so creations mustn't overlap.
  return locked(`hosted:${provider}:provision`, async () => {
    const existing = await findTenant(workspace.id, provider);
    if (existing) return existing;
    const created = await PROVIDERS[provider].createTenant({ slug: workspace.slug, name: workspace.name, currency: workspace.currency ?? "USD" });
    const [row] = await db.insert(T).values({ id: randomUUID(), workspaceId: workspace.id, provider, ...created }).returning();
    return row!;
  });
}

async function accountFor(provider: Provider, tenant: Tenant, user: { id: string }) {
  const scope = PROVIDERS[provider].accountScope === "tenant" ? tenant.id : "";
  const [a] = await db.select().from(A).where(and(eq(A.provider, provider), eq(A.userId, user.id), eq(A.scope, scope))).limit(1);
  if (a) return { login: a.login, password: decryptSecret(a.passwordEnc) };
  // Sign-in name in the product: not the person's real email, so nothing there can mail them or collide
  // with an account someone made directly on the product's site.
  const domain = new URL(process.env.APP_URL ?? "https://mewemarket.com").hostname.replace(/^www\./, "");
  // Short and random: it's stored, never typed, and some products keep tokens derived from it in short columns.
  const login = `u-${randomUUID().replace(/-/g, "").slice(0, 16)}@accounts.${domain}`;
  const password = randomPassword();
  await db.insert(A).values({ id: randomUUID(), provider, userId: user.id, scope, login, passwordEnc: encryptSecret(password) });
  return { login, password };
}

// Tenants checked for strangers recently (per process).
const reconciledAt = new Map<string, number>();
async function reconcile(tenant: Tenant, force = false) {
  const p = PROVIDERS[tenant.provider as Provider];
  if (!p.reconcile) return;
  if (!force && (reconciledAt.get(tenant.id) ?? 0) > Date.now() - 10 * 60_000) return;
  const keep = await db.select({ id: M.externalMemberId, role: M.role }).from(M).where(eq(M.tenantId, tenant.id));
  await p.reconcile(tenant, keep.map((k) => k.id));
  // First check in this process: re-apply roles, so tenants made before a role change (e.g. Twenty admins
  // moving to the restricted "Company admin") catch up.
  if (!reconciledAt.has(tenant.id)) for (const k of keep) await p.setRole(tenant, k.id, k.role as "admin" | "member");
  reconciledAt.set(tenant.id, Date.now());
}

const productRole = (role: Role): "admin" | "member" => (role === "owner" || role === "admin" ? "admin" : "member");

/**
 * The URL that opens the app for this person, signed in. Adds them to the tenant on first use and keeps
 * their role in step. Guests are read-only in MeweMarket and the products have no read-only role, so they
 * don't get in.
 */
export async function openHostedApp(workspace: { id: string }, app: string, user: { id: string; name: string }, role: Role): Promise<SignIn | null> {
  const provider = providerOf(app);
  const p = PROVIDERS[provider];
  if (role === "guest") throw new HostedError("Guests can't open this app. Ask an admin to make you a member.");
  const tenant = await findTenant(workspace.id, provider);
  if (!tenant) return null;
  const want = productRole(role);
  const { login, password, memberId } = await locked(`hosted:${provider}:user:${user.id}`, async () => {
    const account = await accountFor(provider, tenant, user);
    const [m] = await db.select().from(M).where(and(eq(M.tenantId, tenant.id), eq(M.userId, user.id))).limit(1);
    if (!m) {
      const memberId = await p.addMember(tenant, account.login, account.password, user.name, want);
      await db.insert(M).values({ tenantId: tenant.id, userId: user.id, externalMemberId: memberId, role: want });
      await reconcile(tenant, true);
      return { ...account, memberId };
    }
    if (m.role !== want) {
      await p.setRole(tenant, m.externalMemberId, want);
      await db.update(M).set({ role: want }).where(and(eq(M.tenantId, tenant.id), eq(M.userId, user.id)));
    }
    await reconcile(tenant);
    return { ...account, memberId: m.externalMemberId };
  });
  return p.signIn(tenant, login, password, memberId);
}

/** Someone left or was removed from the workspace: take them out of every hosted tenant. */
export async function removeHostedMember(workspaceId: string, userId: string) {
  const rows = await db.select({ t: T, m: M }).from(M).innerJoin(T, eq(T.id, M.tenantId))
    .where(and(eq(T.workspaceId, workspaceId), eq(M.userId, userId)));
  for (const { t, m } of rows) {
    const p = PROVIDERS[t.provider as Provider];
    const [acc] = await db.select().from(A)
      .where(and(eq(A.provider, t.provider), eq(A.userId, userId), eq(A.scope, p.accountScope === "tenant" ? t.id : ""))).limit(1);
    await p.removeMember(t, m.externalMemberId, acc ? { login: acc.login, password: decryptSecret(acc.passwordEnc) } : null);
    await db.delete(M).where(and(eq(M.tenantId, t.id), eq(M.userId, userId)));
    // A per-company product account is deleted with the membership.
    await db.delete(A).where(and(eq(A.provider, t.provider), eq(A.userId, userId), eq(A.scope, t.id)));
  }
}

/** A role changed in the workspace: apply it in every hosted tenant the person is already in. */
export async function syncHostedRole(workspaceId: string, userId: string, role: Role) {
  if (role === "guest") return removeHostedMember(workspaceId, userId);
  const want = productRole(role);
  const rows = await db.select({ t: T, m: M }).from(M).innerJoin(T, eq(T.id, M.tenantId))
    .where(and(eq(T.workspaceId, workspaceId), eq(M.userId, userId)));
  for (const { t, m } of rows) {
    if (m.role === want) continue;
    await PROVIDERS[t.provider as Provider].setRole(t, m.externalMemberId, want);
    await db.update(M).set({ role: want }).where(and(eq(M.tenantId, t.id), eq(M.userId, userId)));
  }
}

async function dropTenant(t: Tenant) {
  await PROVIDERS[t.provider as Provider].deleteTenant(t);
  // Per-company product accounts go with their company.
  await db.delete(A).where(and(eq(A.provider, t.provider), eq(A.scope, t.id)));
  await db.delete(T).where(eq(T.id, t.id));
}

/** Deletes the workspace's data in the product (when the app is removed with "delete data"). */
export async function deleteHostedApp(workspaceId: string, app: string) {
  const t = await findTenant(workspaceId, providerOf(app));
  if (t) await dropTenant(t);
}

/** The workspace itself is being deleted: remove all of its hosted tenants. */
export async function deleteHostedTenants(workspaceId: string) {
  for (const t of await db.select().from(T).where(eq(T.workspaceId, workspaceId))) await dropTenant(t);
}

export async function hasHostedTenant(workspaceId: string, app: string) {
  return (await findTenant(workspaceId, providerOf(app))) !== null;
}
