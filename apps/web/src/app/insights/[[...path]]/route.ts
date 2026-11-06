import { readFile } from "node:fs/promises";
import { extname, join } from "node:path";

// The insights articles are published daily by the separate mewebe-seo pipeline into INSIGHTS_DIR
// (the old site's public_html/insights). Serve them read-only, exactly as published.
export const dynamic = "force-dynamic";

const TYPES: Record<string, string> = {
  ".html": "text/html; charset=utf-8", ".xml": "application/xml; charset=utf-8", ".json": "application/json; charset=utf-8",
  ".js": "application/javascript; charset=utf-8", ".txt": "text/plain; charset=utf-8",
};
const NAME = /^[A-Za-z0-9][A-Za-z0-9._-]*$/;
const notFound = () => new Response("Not found", { status: 404, headers: { "content-type": "text/plain" } });

export async function GET(req: Request, { params }: { params: Promise<{ path?: string[] }> }) {
  const dir = process.env.INSIGHTS_DIR;
  const parts = (await params).path ?? [];
  if (!dir || parts.length > 1) return notFound();
  // The index's canonical URL is /insights/ (with the slash).
  if (!parts.length && !new URL(req.url).pathname.endsWith("/")) return new Response(null, { status: 308, headers: { Location: "/insights/" } });
  const name = parts[0] ?? "index.html";
  const type = TYPES[extname(name)];
  if (!NAME.test(name) || !type) return notFound();
  try {
    const body = await readFile(join(dir, name));
    // The widget and feed change through the day; articles are fine to cache briefly.
    const live = name === "widget.js" || name === "feed.json";
    return new Response(body, { headers: { "content-type": type, "cache-control": live ? "no-cache, no-store, must-revalidate" : "public, max-age=300" } });
  } catch {
    return notFound();
  }
}
