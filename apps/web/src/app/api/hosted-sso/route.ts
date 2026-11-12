import { NextResponse } from "next/server";
import { redeem } from "@/lib/hosted-sso";

// Sign-in bridge for hosted products: the reverse proxy for a product's host (e.g. invoices.mewemarket.com)
// sends /api/hosted-sso here. It turns a one-time ticket into the product's session cookies, set on that
// host only, then opens the product.
export async function GET(req: Request) {
  const url = new URL(req.url);
  const ticket = await redeem(url.searchParams.get("t") ?? "");
  const host = req.headers.get("x-forwarded-host") ?? req.headers.get("host");
  if (!ticket || new URL(ticket.base).host !== host) {
    return new NextResponse("This sign-in link has expired. Open the app again from MeweMarket.", { status: 410, headers: { "Cache-Control": "no-store" } });
  }
  const res = new NextResponse(null, { status: 302, headers: { location: ticket.path, "Cache-Control": "no-store", "Referrer-Policy": "no-referrer" } });
  const secure = ticket.base.startsWith("https:");
  // Raw headers: the values are already encoded by the product, and the cookie helper would encode them again.
  for (const c of ticket.cookies) {
    res.headers.append("set-cookie", `${c.name}=${c.value}; Path=/; SameSite=Lax${c.httpOnly ? "; HttpOnly" : ""}${secure ? "; Secure" : ""}`);
  }
  return res;
}
