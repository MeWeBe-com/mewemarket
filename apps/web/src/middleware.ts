import { getSessionCookie } from "better-auth/cookies";
import { type NextRequest, NextResponse } from "next/server";

// Fast cookie-presence check only; pages still verify the session server-side.
const PROTECTED = ["/dashboard", "/onboarding", "/w/", "/account", "/invite/"];

export function middleware(req: NextRequest) {
  const { pathname, search } = req.nextUrl;
  if (PROTECTED.some((p) => pathname.startsWith(p)) && !getSessionCookie(req)) {
    const url = new URL("/sign-in", req.url);
    url.searchParams.set("next", pathname + search);
    return NextResponse.redirect(url);
  }
  return NextResponse.next();
}

export const config = { matcher: ["/dashboard", "/onboarding", "/w/:path*", "/account", "/invite/:path*"] };
