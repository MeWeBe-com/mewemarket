import { getSessionCookie } from "better-auth/cookies";
import { type NextRequest, NextResponse } from "next/server";
import { internalWorkspacePath, publicWorkspacePath } from "@mewe/core/urls";

// Fast cookie-presence check only; pages still verify the session server-side.
const PROTECTED = ["/dashboard", "/onboarding", "/account", "/invite/"];

// Behind the proxy req.url has the internal host (127.0.0.1:port) and Cloudflare reaches the server over
// plain HTTP, so redirects are built on the public site address.
const origin = (req: NextRequest) => process.env.APP_URL ?? `https://${req.headers.get("x-forwarded-host") ?? req.headers.get("host")}`;

export function middleware(req: NextRequest) {
  const { pathname, search } = req.nextUrl;
  // skipTrailingSlashRedirect is on so /insights/ keeps its slash; every other path drops it.
  if (pathname.length > 1 && pathname.endsWith("/") && !pathname.startsWith("/insights/")) {
    return NextResponse.redirect(new URL(pathname.replace(/\/+$/, "") + search, origin(req)), 308);
  }
  // Old /w/acme/a/crm links → /acme/crm.
  const moved = publicWorkspacePath(pathname);
  if (moved) return NextResponse.redirect(new URL(moved + search, origin(req)), 308);
  // Workspace URLs are mewemarket.com/{company}/{product}; the pages live under /w/[slug].
  const internal = internalWorkspacePath(pathname);
  if ((internal || PROTECTED.some((p) => pathname.startsWith(p))) && !getSessionCookie(req)) {
    const url = new URL("/sign-in", origin(req));
    url.searchParams.set("next", pathname + search);
    return NextResponse.redirect(url);
  }
  if (internal) {
    const url = req.nextUrl.clone();
    url.pathname = internal;
    return NextResponse.rewrite(url);
  }
  return NextResponse.next();
}

export const config = { matcher: ["/((?!_next/|api/|favicon\\.ico|icon\\.svg).*)"] };
