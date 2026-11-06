import { legacyProductPath } from "@mewe/core";

// Old CodeIgniter product URLs: /products/ViewProduct/<id>/<slug> → the matching app or tool page
export async function GET(req: Request, { params }: { params: Promise<{ id: string }> }) {
  const path = legacyProductPath(Number((await params).id));
  return Response.redirect(new URL(path ?? "/apps", req.url), 301);
}
