// Hosted apps: keeps MeweMarket workspaces, members and roles in step with each hosted product's tenants.
import { randomUUID } from "node:crypto";
import { db, schema } from "@mewe/db";
import { and, eq, sql } from "drizzle-orm";
import { getAppDef } from "../apps";
import { decryptSecret, encryptSecret, randomPassword } from "../crypto";
import type { Role } from "../workspaces";
import * as twenty from "./twenty";

export { HostedCapacityError, HostedError, twentyConfig } from "./twenty";

type Provider = "twenty";
type Tenant = typeof schema.hostedTenants.$inferSelect;
const T = schema.hostedTenants, A = schema.hostedAccounts, M = schema.hostedMembers;

function providerOf(app: string): Provider {
  const def = getAppDef(app);
  if (def?.kind !== "hosted" || !def.hosted) throw new twenty.HostedError(`${app} is not a hosted app`);
  return def.hosted.provider;
}

export function isHostedApp(app: string) {
  return getAppDef(app)?.kind === "hosted";
}

/** Whether the server has the product configured at all (the App Store hides the app otherwise). */
export function hostedAvailable(app: string) {
  return providerOf(app) === "twenty" && twenty.twentyConfig() !== null;
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
export async function provisionHostedApp(workspace: { id: string; slug: string; name: string }, app: string) {
  const provider = providerOf(app);
  return locked(`hosted:${provider}:${workspace.id}`, async () => {
    const existing = await findTenant(workspace.id, provider);
    if (existing) return existing;
    const created = await twenty.createTwentyWorkspace(workspace.slug, workspace.name);
    const [row] = await db.insert(T).values({ id: randomUUID(), workspaceId: workspace.id, provider, ...created }).returning();
    return row!;
  });
}

async function accountFor(provider: Provider, user: { id: string }) {
  const [a] = await db.select().from(A).where(and(eq(A.provider, provider), eq(A.userId, user.id))).limit(1);
  if (a) return { login: a.login, password: decryptSecret(a.passwordEnc) };
  // Sign-in name in the product: not the person's real email, so nothing there can mail them or collide
  // with an account someone made directly on the product's site.
  const domain = new URL(process.env.APP_URL ?? "https://mewemarket.com").hostname.replace(/^www\./, "");
  const login = `u-${user.id.toLowerCase().replace(/[^a-z0-9]/g, "")}@accounts.${domain}`;
  const password = randomPassword();
  await db.insert(A).values({ id: randomUUID(), provider, userId: user.id, login, passwordEnc: encryptSecret(password) });
  return { login, password };
}

const productRole = (role: Role): "admin" | "member" => (role === "owner" || role === "admin" ? "admin" : "member");

/**
 * The URL that opens the app for this person, signed in. Adds them to the tenant on first use and keeps
 * their role in step. Guests are read-only in MeweMarket and the products have no read-only role, so they
 * don't get in.
 */
export async function openHostedApp(workspace: { id: string }, app: string, user: { id: string; name: string }, role: Role) {
  const provider = providerOf(app);
  if (role === "guest") throw new twenty.HostedError("Guests can't open this app. Ask an admin to make you a member.");
  const tenant = await findTenant(workspace.id, provider);
  if (!tenant) return null;
  const want = productRole(role);
  const { login, password } = await locked(`hosted:${provider}:user:${user.id}`, async () => {
    const account = await accountFor(provider, user);
    const [m] = await db.select().from(M).where(and(eq(M.tenantId, tenant.id), eq(M.userId, user.id))).limit(1);
    if (!m) {
      const memberId = await twenty.addTwentyMember(tenant, account.login, account.password, user.name, want);
      await db.insert(M).values({ tenantId: tenant.id, userId: user.id, externalMemberId: memberId, role: want });
    } else if (m.role !== want) {
      await twenty.setTwentyRole(tenant, m.externalMemberId, want);
      await db.update(M).set({ role: want }).where(and(eq(M.tenantId, tenant.id), eq(M.userId, user.id)));
    }
    return account;
  });
  return twenty.twentyLoginUrl(tenant, login, password);
}

/** Someone left or was removed from the workspace: take them out of every hosted tenant. */
export async function removeHostedMember(workspaceId: string, userId: string) {
  const rows = await db.select({ t: T, m: M }).from(M).innerJoin(T, eq(T.id, M.tenantId))
    .where(and(eq(T.workspaceId, workspaceId), eq(M.userId, userId)));
  for (const { t, m } of rows) {
    await twenty.removeTwentyMember(t, m.externalMemberId);
    await db.delete(M).where(and(eq(M.tenantId, t.id), eq(M.userId, userId)));
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
    await twenty.setTwentyRole(t, m.externalMemberId, want);
    await db.update(M).set({ role: want }).where(and(eq(M.tenantId, t.id), eq(M.userId, userId)));
  }
}

async function dropTenant(t: Tenant) {
  await twenty.deleteTwentyWorkspace(t);
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
