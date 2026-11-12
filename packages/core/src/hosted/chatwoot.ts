// Chatwoot (https://github.com/chatwoot/chatwoot, MIT; run the community "-ce" image, which has no
// enterprise code): a shared inbox and helpdesk. One server at CHATWOOT_URL holds every company as a
// Chatwoot account, managed through its Platform API with a platform-app token. Chatwoot shows one user every
// account it belongs to, so each person gets a separate user per company; removing them deletes that user,
// which ends their sessions. Sign-in uses the Platform API's one-time SSO link.
import { HostedError, HostedServiceError } from "./twenty";
import type { HostedTenant, SignIn } from "./types";

type Config = { internal: string; public: URL; token: string };

export function chatwootConfig(): Config | null {
  const { CHATWOOT_URL, CHATWOOT_INTERNAL_URL, CHATWOOT_PLATFORM_TOKEN } = process.env;
  if (!CHATWOOT_URL || !CHATWOOT_PLATFORM_TOKEN) return null;
  return { internal: (CHATWOOT_INTERNAL_URL || CHATWOOT_URL).replace(/\/$/, ""), public: new URL(CHATWOOT_URL), token: CHATWOOT_PLATFORM_TOKEN };
}

function cfg() {
  const c = chatwootConfig();
  if (!c) throw new HostedError("The helpdesk service is not set up on this server yet.");
  return c;
}

async function platform<T>(method: string, path: string, body?: unknown): Promise<T> {
  const res = await fetch(`${cfg().internal}/platform/api/v1${path}`, {
    method,
    headers: { "content-type": "application/json", accept: "application/json", api_access_token: cfg().token },
    body: body === undefined ? undefined : JSON.stringify(body),
    signal: AbortSignal.timeout(60_000),
  });
  const text = await res.text();
  if (!res.ok) throw new HostedServiceError(`Chatwoot ${method} ${path}: ${res.status} ${text.slice(0, 300)}`);
  return (text ? JSON.parse(text) : {}) as T;
}

export async function createChatwootAccount(name: string): Promise<Omit<HostedTenant, "id">> {
  const a = await platform<{ id: number }>("POST", "/accounts", { name });
  return { externalId: String(a.id), subdomain: String(a.id), url: cfg().public.origin };
}

export async function deleteChatwootAccount(t: HostedTenant) {
  await platform("DELETE", `/accounts/${t.externalId}`);
}

const roleName = (role: "admin" | "member") => (role === "admin" ? "administrator" : "agent");

export async function addChatwootMember(t: HostedTenant, login: string, password: string, name: string, role: "admin" | "member") {
  const u = await platform<{ id: number }>("POST", "/users", { name: name || "Member", email: login, password });
  await platform("POST", `/accounts/${t.externalId}/account_users`, { user_id: u.id, role: roleName(role) });
  return String(u.id);
}

/** Adding again with another role updates it in place. */
export async function setChatwootRole(t: HostedTenant, memberId: string, role: "admin" | "member") {
  await platform("POST", `/accounts/${t.externalId}/account_users`, { user_id: Number(memberId), role: roleName(role) });
}

export async function removeChatwootMember(t: HostedTenant, memberId: string) {
  await platform("DELETE", `/accounts/${t.externalId}/account_users`, { user_id: Number(memberId) }).catch(() => undefined);
  await platform("DELETE", `/users/${memberId}`);
}

/** The Platform API's one-time sign-in link (valid 5 minutes, works once). */
export async function chatwootSignIn(t: HostedTenant, memberId: string): Promise<SignIn> {
  const r = await platform<{ url: string }>("GET", `/users/${memberId}/login`);
  return { kind: "url", url: r.url };
}
