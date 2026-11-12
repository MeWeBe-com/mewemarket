import { getAppDef, openHostedApp } from "@mewe/core";
import { NextResponse } from "next/server";
import { requireWorkspace } from "@/lib/session";

// "Open in new tab": a fresh one-time sign-in link straight into the hosted product.
export async function GET(_req: Request, { params }: { params: Promise<{ slug: string; app: string }> }) {
  const { slug, app } = await params;
  const { workspace, role, session } = await requireWorkspace(slug);
  if (getAppDef(app)?.kind !== "hosted") return new NextResponse("Not found", { status: 404 });
  const url = await openHostedApp(workspace, app, { id: session.user.id, name: session.user.name }, role).catch(() => null);
  return NextResponse.redirect(url ?? new URL(`/${slug}/${app}`, process.env.APP_URL), { headers: { "Cache-Control": "no-store", "Referrer-Policy": "no-referrer" } });
}
