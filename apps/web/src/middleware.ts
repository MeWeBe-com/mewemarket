import { getSessionCookie } from "better-auth/cookies";
import { type NextRequest, NextResponse } from "next/server";

// Fast cookie-presence check only; pages still verify the session server-side.
const PROTECTED = ["/dashboard", "/onboarding", "/w/", "/account", "/invite/"];

export function middleware(req: NextRequest) {
  const { pathname, search } = req.nextUrl;
  if (PROTECTED.some((p) => pathname.startsWith(p)) && !getSessionCookie(req)) {
    // Relative Location: behind the proxy req.url has the internal host (127.0.0.1:port), not the site's.
    return new NextResponse(null, { status: 307, headers: { Location: `/sign-in?next=${encodeURIComponent(pathname + search)}` } });
  }
  return NextResponse.next();
}

export const config = { matcher: ["/dashboard", "/onboarding", "/w/:path*", "/account", "/invite/:path*"] };
