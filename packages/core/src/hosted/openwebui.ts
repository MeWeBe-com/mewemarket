// Open WebUI (https://github.com/open-webui/open-webui, "Open WebUI License":
// BSD-3 plus a branding clause — over 50 end users in 30 days the "Open WebUI" name/logo must stay unaltered).
// AI chat. One server at OPENWEBUI_URL holds every company; Open WebUI has no organisations, so each company is
// a pair of Open WebUI groups (`mm-{slug}` for everyone, `mm-{slug}-admins` with workspace rights: own models,
// knowledge, prompts, shared only with groups they are in). People are plain "user" accounts; only the platform
// account is an Open WebUI admin (its admin role is server-wide). A person in two companies gets a separate user
// per company (accountScope "tenant"), so chats and groups never mix.
//
// LLM keys: Open WebUI holds ONE connection, to MeweMarket's AI gateway (APP_URL/api/ai-gateway/v1, see
// ../ai-gateway.ts), with
// ENABLE_FORWARD_USER_INFO_HEADERS=true. Open WebUI's server sets X-OpenWebUI-User-Email on every model call
// (checked in the spike: browsers cannot set it); the gateway maps the generated login to the company, decrypts
// that company's Claude/OpenAI key, enforces caps and forwards. No company key is stored in Open WebUI. The
// gateway's one model is visible to everyone (BYPASS_MODEL_ACCESS_CONTROL=true) since the key follows the user.
//
// Sign-in: server-side /api/v1/auths/signin returns a JWT; the bridge sets it as the non-HttpOnly `token` cookie
// on Open WebUI's host and opens /auth, whose page copies the cookie into localStorage (build 0.13.3,
// nodes/53.*.js `Ee()`). Removal deletes the user, which makes their JWT fail at once (checked: 401).
import { HostedError, HostedServiceError } from "./twenty";
import type { HostedProvider } from "./types";
import type { HostedTenant, SignIn } from "./types";

type Config = { internal: string; public: URL; email: string; password: string };

export function openWebUiConfig(): Config | null {
  const { OPENWEBUI_URL, OPENWEBUI_INTERNAL_URL, OPENWEBUI_PLATFORM_EMAIL, OPENWEBUI_PLATFORM_PASSWORD } = process.env;
  if (!OPENWEBUI_URL || !OPENWEBUI_PLATFORM_EMAIL || !OPENWEBUI_PLATFORM_PASSWORD) return null;
  return { internal: (OPENWEBUI_INTERNAL_URL || OPENWEBUI_URL).replace(/\/$/, ""), public: new URL(OPENWEBUI_URL), email: OPENWEBUI_PLATFORM_EMAIL, password: OPENWEBUI_PLATFORM_PASSWORD };
}

function cfg() {
  const c = openWebUiConfig();
  if (!c) throw new HostedError("The AI chat service is not set up on this server yet.");
  return c;
}

async function call<T>(token: string | null, method: string, path: string, body?: unknown): Promise<T> {
  const res = await fetch(`${cfg().internal}${path}`, {
    method,
    headers: { "content-type": "application/json", accept: "application/json", ...(token ? { authorization: `Bearer ${token}` } : {}) },
    body: body === undefined ? undefined : JSON.stringify(body),
    signal: AbortSignal.timeout(30_000),
  });
  const text = await res.text();
  if (!res.ok) throw new HostedServiceError(`Open WebUI ${method} ${path}: ${res.status} ${text.slice(0, 300)}`);
  return (text ? JSON.parse(text) : {}) as T;
}

async function signInToken(email: string, password: string) {
  const r = await call<{ token: string }>(null, "POST", "/api/v1/auths/signin", { email, password });
  return r.token;
}

let platform: { token: string; until: number } | null = null;
async function admin<T>(method: string, path: string, body?: unknown) {
  if (!platform || platform.until < Date.now()) platform = { token: await signInToken(cfg().email, cfg().password), until: Date.now() + 60 * 60_000 };
  return call<T>(platform.token, method, path, body);
}

/** What company admins may do beyond members (groups add to the server defaults, which stay all-off). */
const ADMIN_PERMISSIONS = {
  workspace: { models: true, knowledge: true, prompts: true },
  sharing: { models: true, knowledge: true, prompts: true }, // to groups only; public_* stays off
};

type Group = { id: string; name: string };
// externalId = "{membersGroupId}:{adminsGroupId}"
const groupsOf = (t: HostedTenant) => {
  const [members, admins] = t.externalId.split(":");
  return { members: members!, admins: admins! };
};

export async function createOpenWebUiTenant(slug: string, name: string): Promise<Omit<HostedTenant, "id">> {
  const members = await admin<Group>("POST", "/api/v1/groups/create", { name: `mm-${slug}`, description: name });
  const admins = await admin<Group>("POST", "/api/v1/groups/create", { name: `mm-${slug}-admins`, description: `${name} (admins)`, permissions: ADMIN_PERMISSIONS });
  return { externalId: `${members.id}:${admins.id}`, subdomain: slug, url: cfg().public.origin };
}

async function memberIds(groupId: string) {
  return (await admin<{ id: string }[]>("POST", `/api/v1/groups/id/${groupId}/users`)).map((u) => u.id);
}

/** Deletes everyone in the company (with their chats, files, models, knowledge, prompts), then its groups. */
export async function deleteOpenWebUiTenant(t: HostedTenant) {
  const g = groupsOf(t);
  for (const id of await memberIds(g.members)) await admin("DELETE", `/api/v1/users/${id}`);
  await admin("DELETE", `/api/v1/groups/id/${g.admins}/delete`).catch(() => undefined);
  await admin("DELETE", `/api/v1/groups/id/${g.members}/delete`);
}

export async function addOpenWebUiMember(t: HostedTenant, login: string, password: string, name: string, role: "admin" | "member") {
  const u = await admin<{ id: string }>("POST", "/api/v1/auths/add", { name: name || "Member", email: login, password, role: "user" });
  await admin("POST", `/api/v1/groups/id/${groupsOf(t).members}/users/add`, { user_ids: [u.id] });
  if (role === "admin") await admin("POST", `/api/v1/groups/id/${groupsOf(t).admins}/users/add`, { user_ids: [u.id] });
  return u.id;
}

export async function setOpenWebUiRole(t: HostedTenant, memberId: string, role: "admin" | "member") {
  await admin("POST", `/api/v1/groups/id/${groupsOf(t).admins}/users/${role === "admin" ? "add" : "remove"}`, { user_ids: [memberId] });
}

/** Deleting the user ends their open sessions (the JWT is checked against the user on every request). */
export async function removeOpenWebUiMember(_t: HostedTenant, memberId: string) {
  await admin("DELETE", `/api/v1/users/${memberId}`);
}

export async function reconcileOpenWebUi(t: HostedTenant, keep: string[]) {
  for (const id of await memberIds(groupsOf(t).members)) if (!keep.includes(id)) await admin("DELETE", `/api/v1/users/${id}`);
}

/** Open WebUI keeps its JWT in localStorage; its /auth page adopts a `token` cookie, which must be readable by script. */
export async function openWebUiSignIn(_t: HostedTenant, login: string, password: string): Promise<SignIn> {
  const token = await signInToken(login, password);
  return { kind: "cookies", base: cfg().public.origin, path: "/auth?redirect=%2F", cookies: [{ name: "token", value: token, httpOnly: false }] };
}

export const openWebUi: HostedProvider = {
  configured: () => openWebUiConfig() !== null,
  accountScope: "tenant",
  createTenant: (ws) => createOpenWebUiTenant(ws.slug, ws.name),
  deleteTenant: deleteOpenWebUiTenant,
  addMember: addOpenWebUiMember,
  setRole: setOpenWebUiRole,
  removeMember: (t, id) => removeOpenWebUiMember(t, id),
  signIn: (t, login, password) => openWebUiSignIn(t, login, password),
  reconcile: reconcileOpenWebUi,
};
