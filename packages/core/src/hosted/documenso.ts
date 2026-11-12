// Documenso (https://github.com/documenso/documenso, AGPL-3.0; nothing from its commercial packages/ee features
// is used, and billing stays off so there are no plan limits): e-signatures. One server at DOCUMENSO_URL holds
// every company as a Documenso organisation with one team (/t/<team url>/). The platform account (a Documenso
// instance admin, owner of every organisation) manages them through Documenso's own tRPC API, the one its web
// app uses (session cookie; mutations must carry the public Origin). Documenso shows a user every organisation
// they are in, so each person gets a separate user per company.
//
// Documenso has no API to create a user with a password: the admin "create user" route makes a verified user
// with no password and emails them a reset link. MeweMarket reads that reset token from Documenso's database
// (DOCUMENSO_DATABASE_URL, a read-only role is enough) and sets the password through the normal reset endpoint.
// The person then accepts the organisation invitation through their own session (only they can see its token).
//
// Sign-in: MeweMarket signs in server-side and hands the session cookie to the browser through the
// /api/hosted-sso bridge on Documenso's host. Removal deletes the person's user, which deletes their sessions
// (their open page is signed out on its next request); documents they created move to the organisation owner.
import postgres from "postgres";
import { HostedError, HostedServiceError } from "./twenty";
import type { HostedTenant, SignIn } from "./types";

type Config = { internal: string; public: URL; email: string; password: string; db: string };

export function documensoConfig(): Config | null {
  const { DOCUMENSO_URL, DOCUMENSO_INTERNAL_URL, DOCUMENSO_PLATFORM_EMAIL, DOCUMENSO_PLATFORM_PASSWORD, DOCUMENSO_DATABASE_URL } = process.env;
  if (!DOCUMENSO_URL || !DOCUMENSO_PLATFORM_EMAIL || !DOCUMENSO_PLATFORM_PASSWORD || !DOCUMENSO_DATABASE_URL) return null;
  return {
    internal: (DOCUMENSO_INTERNAL_URL || DOCUMENSO_URL).replace(/\/$/, ""), public: new URL(DOCUMENSO_URL),
    email: DOCUMENSO_PLATFORM_EMAIL, password: DOCUMENSO_PLATFORM_PASSWORD, db: DOCUMENSO_DATABASE_URL,
  };
}

function cfg() {
  const c = documensoConfig();
  if (!c) throw new HostedError("The e-signature service is not set up on this server yet.");
  return c;
}

let sqlClient: postgres.Sql | null = null;
const sql = () => (sqlClient ??= postgres(cfg().db, { max: 2, idle_timeout: 30 }));

class Session {
  jar = new Map<string, string>();
  take(res: Response) {
    for (const c of res.headers.getSetCookie()) {
      const [pair = ""] = c.split(";");
      const i = pair.indexOf("=");
      this.jar.set(pair.slice(0, i), pair.slice(i + 1));
    }
  }
  get cookie() { return [...this.jar].map(([k, v]) => `${k}=${v}`).join("; "); }
  /** Documenso refuses cookie-authenticated POSTs whose Origin is not its public URL. */
  headers(extra: Record<string, string> = {}) { return { origin: cfg().public.origin, cookie: this.cookie, accept: "application/json", ...extra }; }

  async send(method: string, path: string, body?: unknown) {
    const res = await fetch(`${cfg().internal}${path}`, {
      method, headers: this.headers(body === undefined ? {} : { "content-type": "application/json" }),
      body: body === undefined ? undefined : JSON.stringify(body), signal: AbortSignal.timeout(60_000),
    });
    this.take(res);
    const text = await res.text();
    if (!res.ok) throw new HostedServiceError(`Documenso ${method} ${path.split("?")[0]}: ${res.status} ${text.slice(0, 300)}`);
    return text;
  }

  /** tRPC (superjson): mutations POST {json}, queries GET ?input={json}. */
  async mutate<T>(proc: string, input: unknown): Promise<T> {
    const text = await this.send("POST", `/api/trpc/${proc}`, { json: input });
    return JSON.parse(text).result?.data?.json as T;
  }
  async query<T>(proc: string, input?: unknown): Promise<T> {
    const qs = input === undefined ? "" : `?input=${encodeURIComponent(JSON.stringify({ json: input }))}`;
    const text = await this.send("GET", `/api/trpc/${proc}${qs}`);
    return JSON.parse(text).result?.data?.json as T;
  }
}

async function signedIn(email: string, password: string) {
  const s = new Session();
  const { csrfToken } = JSON.parse(await s.send("GET", "/api/auth/csrf")) as { csrfToken: string };
  await s.send("POST", "/api/auth/email-password/authorize", { email, password, csrfToken });
  if (![...s.jar.keys()].some((k) => k.endsWith("sessionId"))) throw new HostedServiceError("Documenso sign-in: no session cookie");
  return s;
}

let platform: { s: Session; userId: number; until: number } | null = null;
async function admin() {
  if (platform && platform.until > Date.now()) return platform;
  const s = await signedIn(cfg().email, cfg().password);
  const me = JSON.parse(await s.send("GET", "/api/auth/session")) as { user: { id: number } | null };
  if (!me.user) throw new HostedServiceError("Documenso: platform session not recognised");
  platform = { s, userId: me.user.id, until: Date.now() + 10 * 60_000 };
  return platform;
}

// --- Organisations (one per company, with one team) --------------------------------------

/** Team URLs: 3-30 chars, lowercase letters, digits and single dashes; unique on the server, varied if taken. */
const teamUrlFor = (slug: string, attempt: number) => {
  const base = slug.toLowerCase().replace(/[^a-z0-9]+/g, "-").replace(/^-+|-+$/g, "").slice(0, 24) || "company";
  const url = attempt === 0 ? base : `${base.slice(0, 24)}-${Math.random().toString(36).slice(2, 6)}`;
  return url.length >= 3 ? url : `${url}-co`;
};

export async function createDocumensoOrganisation(slug: string, name: string): Promise<Omit<HostedTenant, "id">> {
  const { s, userId } = await admin();
  const { organisationId } = await s.mutate<{ organisationId: string }>("admin.organisation.create", { ownerUserId: userId, data: { name } });
  for (let attempt = 0; ; attempt++) {
    const teamUrl = teamUrlFor(slug, attempt);
    try {
      await s.mutate("team.create", { organisationId, teamName: name, teamUrl, inheritMembers: true });
      return { externalId: organisationId, subdomain: teamUrl, url: cfg().public.origin };
    } catch (e) {
      if (attempt < 3 && e instanceof HostedServiceError && /already|exist|taken|unique/i.test(e.message)) continue;
      throw e;
    }
  }
}

export async function deleteDocumensoOrganisation(t: HostedTenant) {
  const { s } = await admin();
  const org = await s.query<{ name: string; members: { userId: number }[] }>("admin.organisation.get", { organisationId: t.externalId });
  // People's users exist only for this company: delete them too (this also ends their sessions).
  for (const m of org.members) if (m.userId !== platform?.userId) await s.mutate("admin.user.delete", { id: m.userId }).catch(() => undefined);
  await s.mutate("admin.organisation.delete", { organisationId: t.externalId, organisationName: org.name, sendEmailToOwner: false });
}

// --- Members -----------------------------------------------------------------

/** Organisation MANAGER gives team admin without the right to delete the organisation (which ADMIN has). */
const roleName = (role: "admin" | "member") => (role === "admin" ? "MANAGER" : "MEMBER");

type OrgMember = { id: string; userId: number; email: string };

async function orgMembers(t: HostedTenant) {
  const r = await (await admin()).s.query<{ data: OrgMember[] }>("organisation.member.find", { organisationId: t.externalId, perPage: 100 });
  return r.data;
}

/** The reset token Documenso's welcome job creates for an admin-created user (the job runs just after). */
async function resetToken(userId: number) {
  for (let i = 0; i < 40; i++) {
    const [row] = await sql()<{ token: string }[]>`SELECT token FROM "PasswordResetToken" WHERE "userId" = ${userId} AND expiry > now() ORDER BY "createdAt" DESC LIMIT 1`;
    if (row) return row.token;
    await new Promise((r) => setTimeout(r, 250));
  }
  throw new HostedServiceError(`Documenso: no password reset token for user ${userId}`);
}

/** Returns the member id as "<userId>" so removal can delete the user. */
export async function addDocumensoMember(t: HostedTenant, login: string, password: string, name: string, role: "admin" | "member") {
  const { s } = await admin();
  const { userId } = await s.mutate<{ userId: number }>("admin.user.create", { email: login, name: (name || "Member").slice(0, 100) });
  const res = await fetch(`${cfg().internal}/api/auth/email-password/reset-password`, {
    method: "POST", headers: { origin: cfg().public.origin, "content-type": "application/json" },
    body: JSON.stringify({ token: await resetToken(userId), password }), signal: AbortSignal.timeout(30_000),
  });
  if (!res.ok) throw new HostedServiceError(`Documenso reset-password: ${res.status} ${(await res.text()).slice(0, 200)}`);
  // Documenso saves the invitation, then emails it (to the generated address, which nobody reads). The person
  // accepts it below through their own session, so a failed email doesn't matter.
  await s.mutate("organisation.member.invite.createMany", { organisationId: t.externalId, invitations: [{ email: login, organisationRole: roleName(role) }] })
    .catch((e) => { if (!(e instanceof HostedServiceError && /EmailDeliveryFailed/.test(e.message))) throw e; });
  const me = await signedIn(login, password);
  const invites = await me.query<{ organisationId: string; token: string }[]>("organisation.member.invite.getMany", { status: "PENDING" });
  const mine = invites.find((i) => i.organisationId === t.externalId);
  if (!mine) throw new HostedServiceError(`Documenso: invitation for ${login} not found`);
  await me.mutate("organisation.member.invite.accept", { token: mine.token });
  return String(userId);
}

export async function setDocumensoRole(t: HostedTenant, memberId: string, role: "admin" | "member") {
  const m = (await orgMembers(t)).find((x) => String(x.userId) === memberId);
  if (!m) throw new HostedServiceError(`Documenso: user ${memberId} is not in ${t.externalId}`);
  await (await admin()).s.mutate("organisation.member.update", { organisationId: t.externalId, organisationMemberId: m.id, data: { role: roleName(role) } });
}

/** Deletes the person's user (it belongs to this company only): their sessions go with it. */
export async function removeDocumensoMember(t: HostedTenant, memberId: string) {
  await (await admin()).s.mutate("admin.user.delete", { id: Number(memberId) });
}

// --- Sign-in -----------------------------------------------------------------

export async function documensoSignIn(t: HostedTenant, login: string, password: string): Promise<SignIn> {
  const me = await signedIn(login, password);
  return {
    kind: "cookies", base: cfg().public.origin, path: `/t/${t.subdomain}/documents`,
    cookies: [...me.jar].map(([name, value]) => ({ name, value, httpOnly: true })),
  };
}
