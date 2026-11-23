/** The public site address used for canonical URLs, whatever APP_URL a deployment runs under. */
export const SITE_ORIGIN = (process.env.SITE_URL ?? "https://mewemarket.com").replace(/\/+$/, "");

/** `alternates` for a page's metadata: an absolute canonical URL for `path` (no trailing slash). */
export const canonical = (path: string) => ({ canonical: `${SITE_ORIGIN}${path === "/" ? "" : path}` });
