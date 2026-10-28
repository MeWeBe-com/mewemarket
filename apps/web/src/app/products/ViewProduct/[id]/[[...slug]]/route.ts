import { legacyProductSlug } from "@mewe/core";

// Old CodeIgniter product URLs: /products/ViewProduct/<id>/<slug> → /apps/<new-slug>
export async function GET(req: Request, { params }: { params: Promise<{ id: string }> }) {
  const slug = legacyProductSlug(Number((await params).id));
  return Response.redirect(new URL(slug ? `/apps/${slug}` : "/apps", req.url), 301);
}
