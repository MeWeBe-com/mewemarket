// Plane (https://github.com/makeplane/plane, AGPL-3.0, Community Edition): projects, issues, cycles and
// modules. One server at PLANE_URL holds every company as a Plane workspace at /{slug}/. Plane's member API is
// its own app API (session cookie + CSRF), used here exactly as its web app does: the platform account (the
// instance admin) creates workspaces and invites people; each person signs up through the invitation, accepts
// it and has Plane's onboarding marked done. Plane shows a user every workspace it is in, so each person gets
// a separate user per company. Sign-in: MeweMarket signs in server-side and hands the session cookie to the
// browser through the /api/hosted-sso bridge on Plane's host. Removal also rotates the person's password,
// which ends their open Plane sessions.
import { randomPassword } from "../crypto";
import { HostedError, HostedServiceError } from "./twenty";
import type { HostedTenant, SignIn } from "./types";

type Config = { internal: string; public: URL; email: string; password: string };

export function planeConfig(): Config | null {
  const { PLANE_URL, PLANE_INTERNAL_URL, PLANE_PLATFORM_EMAIL, PLANE_PLATFORM_PASSWORD } = process.env;
  if (!PLANE_URL || !PLANE_PLATFORM_EMAIL || !PLANE_PLATFORM_PASSWORD) return null;
  return { internal: (PLANE_INTERNAL_URL || PLANE_URL).replace(/\/$/, ""), public: new URL(PLANE_URL), email: PLANE_PLATFORM_EMAIL, password: PLANE_PLATFORM_PASSWORD };
}

function cfg() {
  const c = planeConfig();
  if (!c) throw new HostedError("The projects service is not set up on this server yet.");
  return c;
}

/** Requests as Plane's own page sends them: its host, origin and referer (Django's CSRF and host checks). */
const browserish = () => ({ host: cfg().public.host, origin: cfg().public.origin, referer: `${cfg().public.origin}/` });

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

  /** Form posts to /auth/... (sign-in, sign-up), the way Plane's login page submits them. */
  async form(path: string, fields: Record<string, string>) {
    const t = await fetch(`${cfg().internal}/auth/get-csrf-token/`, { headers: { ...browserish(), cookie: this.cookie }, signal: AbortSignal.timeout(30_000) });
    this.take(t);
    const { csrf_token } = (await t.json()) as { csrf_token: string };
    const res = await fetch(`${cfg().internal}${path}`, {
      method: "POST", redirect: "manual",
      headers: { ...browserish(), "content-type": "application/x-www-form-urlencoded", cookie: this.cookie },
      body: new URLSearchParams({ csrfmiddlewaretoken: csrf_token, ...fields }),
      signal: AbortSignal.timeout(30_000),
    });
    this.take(res);
    // Plane reports auth failures as a redirect carrying error_code.
    const location = res.headers.get("location") ?? "";
    if (res.status >= 400 || /error_code=/.test(location) || !this.jar.get("session-id")) {
      throw new HostedServiceError(`Plane ${path}: ${res.status} ${location.slice(0, 200)}`);
    }
  }

  async api<T>(method: string, path: string, body?: unknown): Promise<T> {
    const res = await fetch(`${cfg().internal}${path}`, {
      method,
      headers: { ...browserish(), "content-type": "application/json", accept: "application/json", cookie: this.cookie, "x-csrftoken": this.jar.get("csrftoken") ?? "" },
      body: body === undefined ? undefined : JSON.stringify(body),
      signal: AbortSignal.timeout(60_000),
    });
    this.take(res);
    const text = await res.text();
    if (!res.ok) throw new HostedServiceError(`Plane ${method} ${path}: ${res.status} ${text.slice(0, 300)}`);
    return (text ? JSON.parse(text) : {}) as T;
  }
}

async function signedIn(email: string, password: string) {
  const s = new Session();
  await s.form("/auth/sign-in/", { email, password });
  return s;
}

let platform: { s: Session; until: number } | null = null;
async function admin() {
  if (platform && platform.until > Date.now()) return platform.s;
  const s = await signedIn(cfg().email, cfg().password);
  platform = { s, until: Date.now() + 10 * 60_000 };
  return s;
}

// --- Workspaces --------------------------------------------------------------

/** Plane slugs: lowercase letters, digits and hyphens; varied if taken. */
const slugFor = (slug: string, attempt: number) =>
  (attempt === 0 ? slug : `${slug.slice(0, 40)}-${Math.random().toString(36).slice(2, 6)}`).toLowerCase().replace(/[^a-z0-9-]/g, "-");

export async function createPlaneWorkspace(slug: string, name: string): Promise<Omit<HostedTenant, "id">> {
  const s = await admin();
  for (let attempt = 0; ; attempt++) {
    const want = slugFor(slug, attempt);
    try {
      const w = await s.api<{ id: string; slug: string }>("POST", "/api/workspaces/", { name, slug: want, organization_size: "2-10" });
      return { externalId: w.id, subdomain: w.slug, url: cfg().public.origin };
    } catch (e) {
      if (attempt < 3 && e instanceof HostedServiceError && /slug|already|exist/i.test(e.message)) continue;
      throw e;
    }
  }
}

export async function deletePlaneWorkspace(t: HostedTenant) {
  await (await admin()).api("DELETE", `/api/workspaces/${t.subdomain}/`);
}

// --- Members -----------------------------------------------------------------

const roleCode = (role: "admin" | "member") => (role === "admin" ? 20 : 15);

type Member = { id: string; member: { email?: string; id: string } };

async function memberIdFor(t: HostedTenant, email: string) {
  const list = await (await admin()).api<Member[]>("GET", `/api/workspaces/${t.subdomain}/members/`);
  const m = list.find((x) => x.member.email?.toLowerCase() === email.toLowerCase());
  if (!m) throw new HostedServiceError(`Plane: ${email} is not a member of ${t.subdomain}`);
  return m.id;
}

export async function addPlaneMember(t: HostedTenant, login: string, password: string, name: string, role: "admin" | "member") {
  await (await admin()).api("POST", `/api/workspaces/${t.subdomain}/invitations/`, { emails: [{ email: login, role: roleCode(role) }] });
  // Sign-up is allowed for invited addresses even with public sign-up off.
  const me = new Session();
  await me.form("/auth/sign-up/", { email: login, password });
  const invitations = await me.api<{ id: string; workspace: { slug: string } }[]>("GET", "/api/users/me/workspaces/invitations/");
  const mine = invitations.filter((i) => i.workspace.slug === t.subdomain).map((i) => i.id);
  await me.api("POST", "/api/users/me/workspaces/invitations/", { invitations: mine });
  // Plane's own onboarding and product tours: done, since MeweMarket already knows who this is.
  const [first = "", ...rest] = (name || "Member").trim().split(/\s+/);
  await me.api("PATCH", "/api/users/me/", { first_name: first, last_name: rest.join(" "), display_name: (first || "member").toLowerCase() });
  await me.api("PATCH", "/api/users/me/profile/", {
    is_onboarded: true, is_tour_completed: true, is_navigation_tour_completed: true,
    onboarding_step: { profile_complete: true, workspace_create: true, workspace_invite: true, workspace_join: true },
    product_tour: { work_items: true, cycles: true, modules: true, intake: true, pages: true },
    last_workspace_id: t.externalId,
  });
  return memberIdFor(t, login);
}

export async function setPlaneRole(t: HostedTenant, memberId: string, role: "admin" | "member") {
  await (await admin()).api("PATCH", `/api/workspaces/${t.subdomain}/members/${memberId}/`, { role: roleCode(role) });
}

/** Takes the person out of the workspace, then rotates their password, which ends their open sessions. */
export async function removePlaneMember(t: HostedTenant, memberId: string, login: string, password: string) {
  await (await admin()).api("DELETE", `/api/workspaces/${t.subdomain}/members/${memberId}/`);
  const me = await signedIn(login, password);
  await me.api("POST", "/auth/change-password/", { old_password: password, new_password: randomPassword() });
}

// --- Sign-in -----------------------------------------------------------------

export async function planeSignIn(t: HostedTenant, login: string, password: string): Promise<SignIn> {
  const me = await signedIn(login, password);
  return {
    kind: "cookies", base: cfg().public.origin, path: `/${t.subdomain}/`,
    cookies: [...me.jar].map(([name, value]) => ({ name, value, httpOnly: name !== "csrftoken" })),
  };
}
