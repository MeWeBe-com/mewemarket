// Public workspace URLs: mewemarket.com/{company}/{product}.
// Internally the pages still live under /w/[slug] and /w/[slug]/a/[app]; middleware rewrites the public form
// onto them. This file has no imports so the edge middleware can use it.

/** Pages that belong to a workspace itself rather than to an app. App slugs may not use these names. */
export const WORKSPACE_PAGES = ["apps", "tools", "billing", "settings"] as const;

/**
 * Public pages the reverse proxy serves under a company's address, ahead of MeweMarket: /{company}/book/ is the
 * company's booking page (the hosted Bookings app). App slugs may not use these names either.
 */
export const PUBLIC_COMPANY_PATHS = ["book"] as const;

/**
 * Names a company may not take as its address: every top-level route on the site, legacy URLs that redirect,
 * and words kept back for later use or because they would confuse people.
 */
export const RESERVED_SLUGS = new Set([
  // routes
  "about", "account", "api", "apps", "check-email", "contact", "cookies", "dashboard", "forgot-password",
  "insights", "invite", "llms.txt", "llms-full.txt", "onboarding", "pricing", "privacy", "products",
  "reset-password", "robots.txt", "sign-in", "sign-up", "sitemap.xml", "terms", "tools", "two-factor", "w",
  "_next", "favicon.ico", "icon.svg",
  // legacy CodeIgniter URLs
  "ai", "category", "users", "home", "page", "pricing", "search", "billing", "payment", "admin",
  // kept back
  "app", "assets", "auth", "blog", "cdn", "docs", "help", "hosted", "login", "logout", "mail", "mcp", "me",
  "new", "oauth", "settings", "signin", "signup", "static", "status", "support", "www", "mewemarket", "mewebe",
]);

export const SLUG_PATTERN = /^[a-z0-9](?:[a-z0-9-]{0,38}[a-z0-9])?$/;

/** True when a company can use this as its address (format only; whether it is taken is a DB question). */
export function isUsableWorkspaceSlug(slug: string) {
  return slug.length >= 2 && SLUG_PATTERN.test(slug) && !RESERVED_SLUGS.has(slug);
}

/** Public URL inside a workspace: wsUrl("acme") → /acme, wsUrl("acme", "crm", "deal") → /acme/crm/deal. */
export function wsUrl(slug: string, ...rest: (string | number)[]) {
  return "/" + [slug, ...rest.map(String)].map(encodeURIComponent).join("/");
}

/**
 * Maps a public path onto the internal route, or returns null when the path is not a workspace path.
 * /acme → /w/acme, /acme/billing → /w/acme/billing, /acme/crm/deal/1 → /w/acme/a/crm/deal/1.
 */
export function internalWorkspacePath(pathname: string): string | null {
  const [, slug, first, ...rest] = pathname.split("/");
  if (!slug || !isUsableWorkspaceSlug(slug)) return null;
  if (!first) return `/w/${slug}`;
  if ((WORKSPACE_PAGES as readonly string[]).includes(first)) return `/w/${slug}/${[first, ...rest].join("/")}`;
  return `/w/${slug}/a/${[first, ...rest].join("/")}`;
}

/** The reverse, for old /w/... links: /w/acme/a/crm → /acme/crm. */
export function publicWorkspacePath(pathname: string): string | null {
  const m = /^\/w\/([^/]+)(?:\/a(?=\/|$))?(\/.*)?$/.exec(pathname);
  return m ? `/${m[1]}${m[2] ?? ""}` : null;
}
