// InvoiceShelf (https://github.com/InvoiceShelf/InvoiceShelf, AGPL-3.0): invoicing, estimates, payments and
// expenses. One server at INVOICESHELF_URL holds every company (InvoiceShelf's own multi-company support); a
// platform account (the install's first user) owns all of them and adds each person to their company with
// a role. InvoiceShelf shows one account every company it belongs to, so each person gets a separate account
// per company. Sign-in: MeweMarket logs in server-side like InvoiceShelf's own login page and hands the
// session cookies to the browser through the /api/hosted-sso bridge, which the proxy serves on InvoiceShelf's
// host. No InvoiceShelf code is changed.
import { HostedError, HostedServiceError } from "./twenty";
import type { HostedTenant, SignIn } from "./types";

type Config = { internal: string; public: URL; email: string; password: string };

export function invoiceShelfConfig(): Config | null {
  const { INVOICESHELF_URL, INVOICESHELF_INTERNAL_URL, INVOICESHELF_PLATFORM_EMAIL, INVOICESHELF_PLATFORM_PASSWORD } = process.env;
  if (!INVOICESHELF_URL || !INVOICESHELF_PLATFORM_EMAIL || !INVOICESHELF_PLATFORM_PASSWORD) return null;
  return {
    internal: (INVOICESHELF_INTERNAL_URL || INVOICESHELF_URL).replace(/\/$/, ""), public: new URL(INVOICESHELF_URL),
    email: INVOICESHELF_PLATFORM_EMAIL, password: INVOICESHELF_PLATFORM_PASSWORD,
  };
}

function cfg() {
  const c = invoiceShelfConfig();
  if (!c) throw new HostedError("The invoicing service is not set up on this server yet.");
  return c;
}

/** Headers that make a server-side request look like InvoiceShelf's own page (Sanctum's stateful-domain check). */
const browserish = () => ({ origin: cfg().public.origin, referer: `${cfg().public.origin}/` });

async function api<T>(method: string, path: string, body?: unknown, company?: string | number, token?: string): Promise<T> {
  const res = await fetch(`${cfg().internal}/api/v1${path}`, {
    method,
    headers: {
      "content-type": "application/json", accept: "application/json",
      ...(token ? { authorization: `Bearer ${token}` } : {}), ...(company ? { company: String(company) } : {}),
    },
    body: body === undefined ? undefined : JSON.stringify(body),
    signal: AbortSignal.timeout(60_000),
  });
  const text = await res.text();
  if (!res.ok) throw new HostedServiceError(`InvoiceShelf ${method} ${path}: ${res.status} ${text.slice(0, 300)}`);
  return (text ? JSON.parse(text) : {}) as T;
}

// --- Platform account ----------------------------------------------------------

let platform: { token: string; home: number; until: number } | null = null;

/** The platform account's API token and its home company (every company call needs a company header). */
async function admin() {
  if (platform && platform.until > Date.now()) return platform;
  const { email, password } = cfg();
  const r = await api<{ token?: string } | string>("POST", "/auth/login", { username: email, password, device_name: "mewemarket" });
  const token = typeof r === "string" ? r : r.token;
  if (!token) throw new HostedServiceError("InvoiceShelf did not return a token for the platform account");
  const companies = await api<{ data: { id: number }[] }>("GET", "/companies", undefined, undefined, token);
  platform = { token, home: companies.data[0]!.id, until: Date.now() + 30 * 60_000 };
  return platform;
}

// --- Companies -----------------------------------------------------------------

type Ability = { ability: string; model: string };

/** Day-to-day invoicing without company settings, custom fields or exchange-rate providers. */
const isMemberAbility = (a: Ability) => !/custom-field|exchange-rate-provider/.test(a.ability) || a.ability === "view-custom-field";

export async function createInvoiceShelfCompany(name: string, slug: string, currencyCode: string): Promise<Omit<HostedTenant, "id">> {
  const { token, home } = await admin();
  const currencies = await api<{ data?: { id: number; code: string }[] } | { id: number; code: string }[]>("GET", "/currencies", undefined, home, token);
  const list = Array.isArray(currencies) ? currencies : (currencies.data ?? []);
  const currency = list.find((c) => c.code === currencyCode)?.id ?? list.find((c) => c.code === "USD")?.id;
  // InvoiceShelf needs a country for the company address; the company can change it in its settings.
  const countries = await api<{ data?: { id: number; code: string }[] } | { id: number; code: string }[]>("GET", "/countries", undefined, home, token);
  const country = (Array.isArray(countries) ? countries : (countries.data ?? [])).find((c) => c.code === "US")?.id;
  const create = (n: string) => api<{ data: { id: number; slug: string } }>("POST", "/companies", { name: n, currency, address: { country_id: country } }, home, token);
  // Company names are unique in InvoiceShelf; two MeweMarket companies may share one, so fall back to name + address.
  const taken = (e: unknown) => e instanceof HostedServiceError && /name has already been taken/.test(e.message);
  const created = await create(name)
    .catch((e) => { if (taken(e)) return create(`${name} (${slug})`); throw e; })
    .catch((e) => { if (taken(e)) return create(`${name} (${slug}-${Math.random().toString(36).slice(2, 6)})`); throw e; });
  const id = created.data.id;
  try {
    const abilities = await api<{ abilities: Ability[] }>("GET", "/abilities", undefined, id, token);
    await api("POST", "/roles", { name: "member", abilities: abilities.abilities.filter(isMemberAbility).map(({ ability, model }) => ({ ability, model })) }, id, token);
  } catch (e) {
    await deleteInvoiceShelfCompany({ externalId: String(id), subdomain: created.data.slug, url: cfg().public.origin }).catch(() => undefined);
    throw e;
  }
  return { externalId: String(id), subdomain: created.data.slug, url: cfg().public.origin };
}

export async function deleteInvoiceShelfCompany(t: Pick<HostedTenant, "externalId" | "subdomain" | "url">) {
  const { token } = await admin();
  const company = await api<{ data: { name: string } }>("GET", "/current-company", undefined, t.externalId, token);
  // InvoiceShelf asks for the company's name as confirmation.
  await api("POST", "/companies/delete", { name: company.data.name }, t.externalId, token);
}

// --- Members -------------------------------------------------------------------

const roleName = (role: "admin" | "member") => (role === "admin" ? "super admin" : "member");

export async function addInvoiceShelfMember(t: HostedTenant, login: string, password: string, name: string, role: "admin" | "member") {
  const { token } = await admin();
  const u = await api<{ data: { id: number } }>("POST", "/users",
    { name: name || "Member", email: login, password, companies: [{ id: Number(t.externalId), role: roleName(role) }] }, t.externalId, token);
  return String(u.data.id);
}

export async function setInvoiceShelfRole(t: HostedTenant, memberId: string, role: "admin" | "member") {
  const { token } = await admin();
  const u = await api<{ data: { name: string; email: string } }>("GET", `/users/${memberId}`, undefined, t.externalId, token);
  await api("PUT", `/users/${memberId}`, { name: u.data.name, email: u.data.email, companies: [{ id: Number(t.externalId), role: roleName(role) }] }, t.externalId, token);
}

/** Deletes the person's account for this company (it belongs to no other), which ends their sessions. */
export async function removeInvoiceShelfMember(t: HostedTenant, memberId: string) {
  const { token } = await admin();
  await api("POST", "/users/delete", { users: [Number(memberId)] }, t.externalId, token);
}

// --- Sign-in -------------------------------------------------------------------

/** Logs in exactly as InvoiceShelf's login page does and returns the session cookies for the browser. */
export async function invoiceShelfSignIn(_t: HostedTenant, login: string, password: string): Promise<SignIn> {
  const jar = new Map<string, string>();
  const take = (res: Response) => {
    for (const c of res.headers.getSetCookie()) {
      const [pair = ""] = c.split(";");
      const i = pair.indexOf("=");
      jar.set(pair.slice(0, i), pair.slice(i + 1));
    }
  };
  const cookie = () => [...jar].map(([k, v]) => `${k}=${v}`).join("; ");
  take(await fetch(`${cfg().internal}/sanctum/csrf-cookie`, { headers: browserish(), signal: AbortSignal.timeout(30_000) }));
  const xsrf = jar.get("XSRF-TOKEN");
  if (!xsrf) throw new HostedServiceError("InvoiceShelf sent no CSRF cookie");
  const res = await fetch(`${cfg().internal}/login`, {
    method: "POST", redirect: "manual",
    headers: { ...browserish(), "content-type": "application/json", accept: "application/json", cookie: cookie(), "x-xsrf-token": decodeURIComponent(xsrf) },
    body: JSON.stringify({ email: login, password }),
    signal: AbortSignal.timeout(30_000),
  });
  if (res.status >= 400) throw new HostedServiceError(`InvoiceShelf login: ${res.status}`);
  take(res);
  return {
    kind: "cookies", base: cfg().public.origin, path: "/admin/dashboard",
    cookies: [...jar].map(([name, value]) => ({ name, value, httpOnly: name !== "XSRF-TOKEN" })),
  };
}
