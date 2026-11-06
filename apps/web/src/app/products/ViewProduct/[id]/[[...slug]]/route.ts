import { legacyProductPath } from "@mewe/core";

// Old CodeIgniter product URLs: /products/ViewProduct/<id>/<slug> → the matching app or tool page
export async function GET(_req: Request, { params }: { params: Promise<{ id: string }> }) {
  const path = legacyProductPath(Number((await params).id));
  // Relative Location: behind the proxy req.url has the internal host, not the site's.
  return new Response(null, { status: 301, headers: { Location: path ?? "/apps" } });
}
