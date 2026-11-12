import { getAppDef, openHostedApp } from "@mewe/core";
import { NextResponse } from "next/server";
import { frameUrl, signInAllowed } from "@/lib/hosted-sso";
import { requireWorkspace } from "@/lib/session";

// "Open in new tab": a fresh one-time sign-in link straight into the hosted product.
export async function GET(_req: Request, { params }: { params: Promise<{ slug: string; app: string }> }) {
  const { slug, app } = await params;
  const { workspace, role, session } = await requireWorkspace(slug);
  if (getAppDef(app)?.kind !== "hosted") return new NextResponse("Not found", { status: 404 });
  if (!(await signInAllowed(session.user.id))) return new NextResponse("Too many requests. Please wait a moment.", { status: 429, headers: { "Retry-After": "60" } });
  const signIn = await openHostedApp(workspace, app, { id: session.user.id, name: session.user.name }, role).catch(() => null);
  const url = signIn && (await frameUrl(signIn));
  return NextResponse.redirect(url ?? new URL(`/${slug}/${app}`, process.env.APP_URL), { headers: { "Cache-Control": "no-store", "Referrer-Policy": "no-referrer" } });
}
