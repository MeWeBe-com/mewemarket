// Easy!Appointments (https://github.com/alextselegidis/easyappointments, GPL-3.0): online appointment booking.
// Easy!Appointments is single-company, so ONE container serves every company through a small router file mounted
// as its config.php (spike: /tmp/claude-0/spike-booking/ea/config.php): company "acme" lives on the main site at
// ${APP_URL}/acme/book/ (nginx strips the prefix and sends X-Ea-Tenant + the proxy secret), database ea_t_acme,
// its own session directory, cookies on Path=/acme/book/. The router also takes platform-only calls (header X-Platform-Key)
// to create/drop a company database, change a role and end a person's sessions, and lets the platform name the
// company in X-Ea-Tenant when it calls the internal address. Everything else is Easy!Appointments' own installer,
// login form and REST API v1 (basic auth as the per-company platform admin).
// The router and its start script are infra/easyappointments/. Roles: admin -> Administrator, member -> Provider
// (bookable staff). Sign-in: server-side login, cookies handed to the browser via the /api/hosted-sso bridge, on
// MeweMarket's own origin with Path=/{slug}/book/. Removing a user deletes the row; Easy!Appointments then destroys
// any open session of a missing user on its next request (verified).
import { createHmac } from "node:crypto";
import { HostedError, HostedServiceError } from "./twenty";
import type { HostedProvider, HostedTenant, ProductRole, SignIn } from "./types";

type Config = { internal: string; app: string; key: string };

export function easyAppointmentsConfig(): Config | null {
  const { EA_INTERNAL_URL, APP_URL, EA_PLATFORM_KEY } = process.env;
  if (!EA_INTERNAL_URL || !APP_URL || !EA_PLATFORM_KEY) return null;
  return { internal: EA_INTERNAL_URL.replace(/\/$/, ""), app: APP_URL.replace(/\/$/, ""), key: EA_PLATFORM_KEY };
}
function cfg() {
  const c = easyAppointmentsConfig();
  if (!c) throw new HostedError("The booking service is not set up on this server yet.");
  return c;
}
const slugOf = (t: Pick<HostedTenant, "externalId">) => t.externalId;
/** The per-company platform admin's password, derived so nothing extra is stored. */
const platformPassword = (slug: string) => createHmac("sha256", cfg().key).update(`ea-admin:${slug}`).digest("base64url");
const PLATFORM_USER = "platform";

class Jar {
  jar = new Map<string, string>();
  take(res: Response) {
    for (const c of res.headers.getSetCookie()) { const [p = ""] = c.split(";"); const i = p.indexOf("="); this.jar.set(p.slice(0, i), p.slice(i + 1)); }
  }
  get cookie() { return [...this.jar].map(([k, v]) => `${k}=${v}`).join("; "); }
}

async function call(slug: string, method: string, path: string, init: { body?: string; type?: string; cookie?: string; basic?: boolean } = {}) {
  const res = await fetch(`${cfg().internal}/index.php${path}`, {
    method, redirect: "manual",
    headers: {
      "x-platform-key": cfg().key, "x-ea-tenant": slug, accept: "application/json",
      ...(init.type ? { "content-type": init.type } : {}), ...(init.cookie ? { cookie: init.cookie } : {}),
      ...(init.basic ? { authorization: "Basic " + Buffer.from(`${PLATFORM_USER}:${platformPassword(slug)}`).toString("base64") } : {}),
    },
    body: init.body, signal: AbortSignal.timeout(60_000),
  });
  return res;
}
async function ok(res: Response, what: string) {
  const text = await res.text();
  if (!res.ok) throw new HostedServiceError(`Easy!Appointments ${what}: ${res.status} ${text.slice(0, 300)}`);
  return text ? JSON.parse(text) : {};
}
const api = (slug: string, method: string, path: string, body?: unknown) =>
  call(slug, method, `/api/v1${path}`, { basic: true, body: body === undefined ? undefined : JSON.stringify(body), type: "application/json" }).then((r) => ok(r, `${method} ${path}`));

/** The login form, as Easy!Appointments' page submits it (CSRF token from its cookie). */
async function formLogin(slug: string, username: string, password: string) {
  const j = new Jar();
  j.take(await call(slug, "GET", "/login"));
  const res = await call(slug, "POST", "/login/validate", {
    cookie: j.cookie, type: "application/x-www-form-urlencoded",
    body: new URLSearchParams({ csrf_token: j.jar.get("csrf_cookie") ?? "", username, password }).toString(),
  });
  j.take(res);
  const out = (await res.json().catch(() => ({}))) as { success?: boolean };
  if (!out.success || !j.jar.get("ea_session")) throw new HostedServiceError(`Easy!Appointments login: ${res.status}`);
  return j;
}

const person = (login: string, name: string, password?: string) => {
  const [firstName = name, ...rest] = name.trim().split(/\s+/);
  return { firstName, lastName: rest.join(" ") || "-", email: login, phone: "-", timezone: "UTC", language: "english",
    settings: { username: login, ...(password ? { password } : {}), notifications: false, calendarView: "default" } };
};

export const easyAppointments: HostedProvider = {
  configured: () => easyAppointmentsConfig() !== null,
  accountScope: "tenant",

  async createTenant(ws: { slug: string; name: string; currency: string }): Promise<Omit<HostedTenant, "id">> {
    const slug = ws.slug.toLowerCase().replace(/[^a-z0-9-]/g, "").slice(0, 40);
    await ok(await call(slug, "GET", "/__platform/create"), "create");
    const j = new Jar();
    j.take(await call(slug, "GET", "/installation"));
    const f = new URLSearchParams({
      csrf_token: j.jar.get("csrf_cookie") ?? "",
      "admin[first_name]": "MeweMarket", "admin[last_name]": "Platform", "admin[email]": "platform@accounts.mewemarket.com",
      "admin[username]": PLATFORM_USER, "admin[password]": platformPassword(slug), "admin[language]": "english",
      "company[company_name]": ws.name, "company[company_email]": "platform@accounts.mewemarket.com", "company[company_link]": "",
    });
    const out = await ok(await call(slug, "POST", "/installation/perform", { cookie: j.cookie, type: "application/x-www-form-urlencoded", body: f.toString() }), "install");
    if (!out.success) throw new HostedServiceError("Easy!Appointments install failed");
    // The installer seeds a demo provider and customer.
    for (const p of (await api(slug, "GET", "/providers")) as { id: number }[]) await api(slug, "DELETE", `/providers/${p.id}`);
    for (const c of (await api(slug, "GET", "/customers")) as { id: number }[]) await api(slug, "DELETE", `/customers/${c.id}`);
    await api(slug, "PUT", "/services/1", { currency: ws.currency });
    const url = `${cfg().app}/${slug}/book`; // public booking page: url + "/"; staff UI: url + "/index.php/calendar"
    return { externalId: slug, subdomain: slug, url };
  },

  async deleteTenant(t: HostedTenant) { await ok(await call(slugOf(t), "GET", "/__platform/drop"), "drop"); },

  async addMember(t: HostedTenant, login: string, password: string, name: string, role: ProductRole): Promise<string> {
    const slug = slugOf(t);
    const created = role === "admin"
      ? await api(slug, "POST", "/admins", person(login, name, password))
      : await api(slug, "POST", "/providers", { ...person(login, name, password), services: [] });
    return String((created as { id: number }).id);
  },

  /** No role-change API: the router updates the role and ends the person's sessions (they hold the old role). */
  async setRole(t: HostedTenant, memberId: string, role: ProductRole) {
    await ok(await call(slugOf(t), "GET", `/__platform/set-role?user_id=${Number(memberId)}&role=${role === "admin" ? "admin" : "provider"}`), "set-role");
  },

  /** A hard delete; Easy!Appointments destroys a session whose user no longer exists on its next request (that one
   *  request still renders an empty shell, every data call is 403, the next load goes to /login). */
  async removeMember(t: HostedTenant, memberId: string) {
    const slug = slugOf(t), id = Number(memberId);
    const res = await call(slug, "DELETE", `/api/v1/providers/${id}`, { basic: true });
    if (res.status >= 400) await ok(await call(slug, "DELETE", `/api/v1/admins/${id}`, { basic: true }), "remove");
    await ok(await call(slug, "GET", `/__platform/end-sessions?user_id=${id}`), "end-sessions"); // belt and braces
  },

  /** Same origin as MeweMarket: the bridge must set these with Path=/{slug}/book/ (the pathname of `base` + "/"),
   *  exactly the path Easy!Appointments uses, or the browser keeps two ea_session cookies. */
  async signIn(t: HostedTenant, login: string, password: string): Promise<SignIn> {
    const j = await formLogin(slugOf(t), login, password);
    const prefix = new URL(t.url).pathname.replace(/\/$/, "");
    return { kind: "cookies", base: t.url, path: `${prefix}/index.php/calendar`, cookiePath: `${prefix}/`,
      cookies: [...j.jar].map(([name, value]) => ({ name, value, httpOnly: true })) };
  },
};
