// Twenty CRM (https://github.com/twentyhq/twenty, AGPL-3.0) run as a separate service in multi-workspace mode.
// Each workspace allows APP_URL to frame it (Twenty's allowedEmbeddingOrigins), so the proxy needs no header changes.
// Each MeweMarket workspace is one Twenty workspace at <subdomain>.<TWENTY_URL host>. One platform account
// (the first Twenty user, so its server admin) creates the workspaces and administers them; every person
// gets their own Twenty user with a random password that only MeweMarket knows, and is signed in with a
// one-time login token. Uses only Twenty's public GraphQL API: no Enterprise features.
//
// Free Twenty allows 5 workspaces per server; more needs an Enterprise key, set as ENTERPRISE_KEY on the
// Twenty server (not here). Until then the 6th company gets HostedCapacityError.

/** A problem the person can be told about as it is (its message is written for them). */
export class HostedError extends Error {}
/** A product's API failed; logged, and the person sees a general "try again" message. */
export class HostedServiceError extends Error {}
/** The hosted product cannot take another company (Twenty's 5-workspace limit without an Enterprise key). */
export class HostedCapacityError extends HostedError {}

type Config = { internal: string; public: URL; email: string; password: string };

export function twentyConfig(): Config | null {
  const { TWENTY_URL, TWENTY_INTERNAL_URL, TWENTY_PLATFORM_EMAIL, TWENTY_PLATFORM_PASSWORD } = process.env;
  if (!TWENTY_URL || !TWENTY_PLATFORM_EMAIL || !TWENTY_PLATFORM_PASSWORD) return null;
  return { internal: (TWENTY_INTERNAL_URL || TWENTY_URL).replace(/\/$/, ""), public: new URL(TWENTY_URL), email: TWENTY_PLATFORM_EMAIL, password: TWENTY_PLATFORM_PASSWORD };
}

function cfg() {
  const c = twentyConfig();
  if (!c) throw new HostedError("The CRM service is not set up on this server yet.");
  return c;
}

type GqlError = { message: string; extensions?: { subCode?: string; code?: string; userFriendlyMessage?: string } };

class TwentyCallError extends HostedServiceError {
  constructor(public op: string, public errors: GqlError[]) {
    super(`Twenty ${op}: ${errors.map((e) => e.extensions?.subCode ?? e.message).join(", ")}`);
  }
  has(sub: string) { return this.errors.some((e) => e.extensions?.subCode === sub || e.message.includes(sub)); }
}

async function call<T>(path: "/metadata" | "/graphql", op: string, query: string, variables: Record<string, unknown> = {}, token?: string): Promise<T> {
  const res = await fetch(cfg().internal + path, {
    method: "POST",
    headers: { "content-type": "application/json", ...(token ? { authorization: `Bearer ${token}` } : {}) },
    body: JSON.stringify({ query, variables }),
    signal: AbortSignal.timeout(60_000),
  });
  const body = (await res.json().catch(() => null)) as { data?: T; errors?: GqlError[] } | null;
  if (!body) throw new HostedServiceError(`Twenty ${op}: HTTP ${res.status}`);
  if (body.errors?.length) {
    if (body.errors.some((e) => /enterprise key|Workspace limit reached/i.test(e.message + (e.extensions?.userFriendlyMessage ?? "")))) {
      throw new HostedCapacityError("The CRM service is full right now. We've been told and will make room soon.");
    }
    throw new TwentyCallError(op, body.errors);
  }
  return body.data as T;
}
const meta = <T>(op: string, q: string, v?: Record<string, unknown>, t?: string) => call<T>("/metadata", op, q, v, t);
const data = <T>(op: string, q: string, v?: Record<string, unknown>, t?: string) => call<T>("/graphql", op, q, v, t);

export function twentyWorkspaceUrl(subdomain: string) {
  const u = new URL(cfg().public.href);
  u.hostname = `${subdomain}.${u.hostname}`;
  return u.origin;
}

// --- Tokens ------------------------------------------------------------------

type Agnostic = { tokens: { accessOrWorkspaceAgnosticToken: { token: string } } };

/** The platform account's workspace-agnostic token. The first run creates the account (Twenty's first user is its server admin). */
async function platformToken() {
  const { email, password } = cfg();
  try {
    const d = await meta<{ signIn: Agnostic }>("signIn", `mutation($email:String!,$password:String!){signIn(email:$email,password:$password){tokens{accessOrWorkspaceAgnosticToken{token}}}}`, { email, password });
    return d.signIn.tokens.accessOrWorkspaceAgnosticToken.token;
  } catch (e) {
    if (!(e instanceof TwentyCallError && e.has("USER_NOT_FOUND"))) throw e;
    const d = await meta<{ signUp: Agnostic }>("signUp", `mutation($email:String!,$password:String!){signUp(email:$email,password:$password){tokens{accessOrWorkspaceAgnosticToken{token}}}}`, { email, password });
    return d.signUp.tokens.accessOrWorkspaceAgnosticToken.token;
  }
}

async function exchange(loginToken: string, origin: string) {
  const d = await meta<{ getAuthTokensFromLoginToken: Agnostic }>("getAuthTokensFromLoginToken",
    `mutation($l:String!,$o:String!){getAuthTokensFromLoginToken(loginToken:$l,origin:$o){tokens{accessOrWorkspaceAgnosticToken{token}}}}`, { l: loginToken, o: origin });
  return d.getAuthTokensFromLoginToken.tokens.accessOrWorkspaceAgnosticToken.token;
}

async function loginToken(email: string, password: string, origin: string) {
  const d = await meta<{ getLoginTokenFromCredentials: { loginToken: { token: string } } }>("getLoginTokenFromCredentials",
    `mutation($email:String!,$password:String!,$o:String!){getLoginTokenFromCredentials(email:$email,password:$password,origin:$o){loginToken{token}}}`, { email, password, o: origin });
  return d.getLoginTokenFromCredentials.loginToken.token;
}

// Admin access tokens are short-lived JWTs; reuse each for a few minutes rather than signing in per call.
const adminTokens = new Map<string, { token: string; until: number }>();
async function adminToken(origin: string) {
  const hit = adminTokens.get(origin);
  if (hit && hit.until > Date.now()) return hit.token;
  const { email, password } = cfg();
  const token = await exchange(await loginToken(email, password, origin), origin);
  adminTokens.set(origin, { token, until: Date.now() + 5 * 60_000 });
  return token;
}

// --- Workspaces --------------------------------------------------------------

/** Twenty subdomains: 3-30 of [a-z0-9-], not starting or ending with "-". */
function subdomainFor(slug: string, attempt: number) {
  let s = slug.toLowerCase().replace(/[^a-z0-9-]/g, "-").replace(/^-+|-+$/g, "");
  if (attempt > 0) s = `${s.slice(0, 24)}-${Math.random().toString(36).slice(2, 6)}`;
  if (s.length < 3) s = `${s}-ws`;
  return s.slice(0, 30).replace(/-+$/, "");
}

export type TwentyTenant = { externalId: string; subdomain: string; url: string };

export async function createTwentyWorkspace(slug: string, name: string): Promise<TwentyTenant> {
  const agnostic = await platformToken();
  for (let attempt = 0; ; attempt++) {
    const subdomain = subdomainFor(slug, attempt);
    try {
      const d = await meta<{ signUpInNewWorkspace: { loginToken: { token: string }; workspace: { id: string } } }>("signUpInNewWorkspace",
        `mutation($i:SignUpInNewWorkspaceInput){signUpInNewWorkspace(input:$i){loginToken{token} workspace{id}}}`,
        { i: { displayName: name, subdomain } }, agnostic);
      const url = twentyWorkspaceUrl(subdomain);
      const token = await exchange(d.signUpInNewWorkspace.loginToken.token, url);
      try {
        await meta("activateWorkspace", `mutation($i:ActivateWorkspaceInput!){activateWorkspace(data:$i){id}}`, { i: { displayName: name } }, token);
        await allowEmbedding(token);
        await harden(url, token);
        await finishProfile(token, "MeweMarket", "");
        // Twenty asks a new workspace's creator to invite their team; MeweMarket adds members itself.
        await meta("sendInvitations", `mutation($e:[String!]!){sendInvitations(emails:$e){success}}`, { e: [] }, token);
      } catch (e) {
        // Don't leave a half-made workspace behind: it would hold the subdomain and one of the free slots.
        await meta("deleteCurrentWorkspace", `mutation{deleteCurrentWorkspace{id}}`, {}, token).catch(() => undefined);
        throw e;
      }
      return { externalId: d.signUpInNewWorkspace.workspace.id, subdomain, url };
    } catch (e) {
      // Taken or not allowed as a subdomain: try a varied one.
      if (e instanceof TwentyCallError && attempt < 3 && e.errors.some((x) => /subdomain/i.test(x.message))) continue;
      throw e;
    }
  }
}

// --- Hardening ----------------------------------------------------------------
//
// Company owners and admins get "Company admin", not Twenty's Admin role: full use of the CRM (records, fields,
// views, imports and exports) but no say over roles, members, security, API keys, webhooks or workflows. So
// they can't demote MeweMarket's platform account, add people behind MeweMarket's back, or point webhooks and
// workflow HTTP steps at internal addresses. The public invite link stays off: it's switched on only for the
// moment MeweMarket adds someone (inside the per-company lock).

const COMPANY_ADMIN = "Company admin";
const COMPANY_ADMIN_FLAGS = ["WORKSPACE", "DATA_MODEL", "VIEWS", "LAYOUTS", "IMPORT_CSV", "EXPORT_CSV", "UPLOAD_FILE", "DOWNLOAD_FILE", "PROFILE_INFORMATION"];

const hardened = new Set<string>();
async function harden(origin: string, token: string) {
  if (hardened.has(origin)) return;
  const roles = (await meta<{ getRoles: { id: string; label: string }[] }>("getRoles", `{getRoles{id label}}`, {}, token)).getRoles;
  if (!roles.some((r) => r.label === COMPANY_ADMIN)) {
    const role = (await meta<{ createOneRole: { id: string } }>("createOneRole", `mutation($i:CreateRoleInput!){createOneRole(createRoleInput:$i){id}}`, {
      i: {
        id: crypto.randomUUID(), label: COMPANY_ADMIN, description: "Managed by MeweMarket",
        canUpdateAllSettings: false, canReadAllObjectRecords: true, canUpdateAllObjectRecords: true,
        canSoftDeleteAllObjectRecords: true, canDestroyAllObjectRecords: true,
        canBeAssignedToUsers: true, canBeAssignedToAgents: false, canBeAssignedToApiKeys: false,
      },
    }, token)).createOneRole;
    await meta("upsertPermissionFlags", `mutation($i:UpsertPermissionFlagsInput!){upsertPermissionFlags(upsertPermissionFlagsInput:$i){flag}}`,
      { i: { roleId: role.id, permissionFlagKeys: COMPANY_ADMIN_FLAGS } }, token);
  }
  await setInviteLink(token, false);
  hardened.add(origin);
}

const setInviteLink = (token: string, on: boolean) =>
  meta("updateWorkspace", `mutation($d:UpdateWorkspaceInput!){updateWorkspace(data:$d){id}}`, { d: { isPublicInviteLinkEnabled: on } }, token);

/**
 * Removes anyone in the workspace MeweMarket doesn't know about (e.g. who got in through an invite link while it
 * was open). `keep` is MeweMarket's member ids for this workspace; the platform account always stays.
 */
export async function reconcileTwentyMembers(t: TwentyTenant, keep: string[]) {
  const token = await adminToken(t.url);
  await harden(t.url, token);
  const me = (await meta<{ currentUser: { workspaceMember: { id: string } } }>("currentUser", `{currentUser{workspaceMember{id}}}`, {}, token)).currentUser.workspaceMember.id;
  const members = (await data<{ workspaceMembers: { edges: { node: { id: string } }[] } }>("workspaceMembers",
    `{workspaceMembers(first:1000){edges{node{id}}}}`, {}, token)).workspaceMembers.edges.map((e) => e.node.id);
  const known = new Set([...keep, me]);
  for (const id of members) if (!known.has(id)) await removeTwentyMember(t, id);
}

/** Lets MeweMarket's pages show this workspace in a frame (Twenty's own per-workspace embedding setting). */
async function allowEmbedding(token: string) {
  const origin = new URL(process.env.APP_URL ?? "https://mewemarket.com").origin;
  await meta("updateWorkspaceAllowedEmbeddingOrigins",
    `mutation($d:UpdateWorkspaceAllowedEmbeddingOriginsInput!){updateWorkspaceAllowedEmbeddingOrigins(data:$d){id}}`, { d: { operation: "add", origin } }, token);
}

export async function deleteTwentyWorkspace(t: TwentyTenant) {
  await meta("deleteCurrentWorkspace", `mutation{deleteCurrentWorkspace{id}}`, {}, await adminToken(t.url));
  adminTokens.delete(t.url);
}

// --- Members -----------------------------------------------------------------

/**
 * Gives the person their name in the workspace and clears Twenty's own onboarding screens (profile, email sync),
 * since MeweMarket already knows who they are. Setting the name through updateWorkspaceMemberSettings is what
 * completes Twenty's profile step.
 */
async function finishProfile(memberAccess: string, firstName: string, lastName: string) {
  const me = await meta<{ currentUser: { onboardingStatus: string | null; workspaceMember: { id: string } } }>("currentUser",
    `{currentUser{onboardingStatus workspaceMember{id}}}`, {}, memberAccess);
  const id = me.currentUser.workspaceMember.id;
  if (me.currentUser.onboardingStatus === "SYNC_EMAIL") {
    await meta("skipSyncEmailOnboardingStep", `mutation{skipSyncEmailOnboardingStep{success}}`, {}, memberAccess);
  }
  await meta("updateWorkspaceMemberSettings", `mutation($i:UpdateWorkspaceMemberSettingsInput!){updateWorkspaceMemberSettings(input:$i)}`,
    { i: { workspaceMemberId: id, update: { name: { firstName: firstName || "Member", lastName: lastName || "" } } } }, memberAccess);
  return id;
}

async function roleId(origin: string, role: "admin" | "member") {
  const token = await adminToken(origin);
  await harden(origin, token);
  const d = await meta<{ getRoles: { id: string; label: string }[] }>("getRoles", `{getRoles{id label}}`, {}, token);
  const label = role === "admin" ? COMPANY_ADMIN : "Member";
  const r = d.getRoles.find((x) => x.label === label);
  if (!r) throw new HostedServiceError(`Twenty has no ${label} role`);
  return r.id;
}

/** Adds the person to the workspace (creating their Twenty user on first use) and returns their member id. */
export async function addTwentyMember(t: TwentyTenant, login: string, password: string, name: string, role: "admin" | "member") {
  const admin = await adminToken(t.url);
  await harden(t.url, admin);
  const hash = (await meta<{ currentWorkspace: { inviteHash: string } }>("currentWorkspace", `{currentWorkspace{inviteHash}}`, {}, admin)).currentWorkspace.inviteHash;
  // The invite link is open only for this one sign-up.
  await setInviteLink(admin, true);
  const d = await meta<{ signUpInWorkspace: { loginToken: { token: string } } }>("signUpInWorkspace",
    `mutation($email:String!,$password:String!,$h:String,$w:UUID){signUpInWorkspace(email:$email,password:$password,workspaceInviteHash:$h,workspaceId:$w){loginToken{token}}}`,
    { email: login, password, h: hash, w: t.externalId }).finally(() => setInviteLink(admin, false));
  const member = await exchange(d.signUpInWorkspace.loginToken.token, t.url);
  const [first = "", ...rest] = name.trim().split(/\s+/);
  const memberId = await finishProfile(member, first, rest.join(" "));
  await setTwentyRole(t, memberId, role);
  return memberId;
}

export async function setTwentyRole(t: TwentyTenant, memberId: string, role: "admin" | "member") {
  await meta("updateWorkspaceMemberRole", `mutation($w:UUID!,$r:UUID!){updateWorkspaceMemberRole(workspaceMemberId:$w,roleId:$r){id}}`,
    { w: memberId, r: await roleId(t.url, role) }, await adminToken(t.url));
}

/** Removes the person from the workspace; their open Twenty sessions stop working at once. */
export async function removeTwentyMember(t: TwentyTenant, memberId: string) {
  try {
    await meta("deleteUserFromWorkspace", `mutation($id:String!){deleteUserFromWorkspace(workspaceMemberIdToDelete:$id){id}}`, { id: memberId }, await adminToken(t.url));
  } catch (e) {
    if (!(e instanceof TwentyCallError && e.errors.some((x) => /not found/i.test(x.message)))) throw e;
  }
}

/** A one-time link that opens the workspace already signed in as this person. */
export async function twentyLoginUrl(t: TwentyTenant, login: string, password: string) {
  return `${t.url}/verify?loginToken=${encodeURIComponent(await loginToken(login, password, t.url))}`;
}
