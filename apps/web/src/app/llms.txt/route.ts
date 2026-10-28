import { CATEGORIES, listCatalogApps } from "@mewe/core";

export const revalidate = 3600;

export async function GET() {
  const base = process.env.APP_URL ?? "https://mewemarket.com";
  const apps = await listCatalogApps();
  const lines = [
    "# MeweMarket",
    "> Every business app a small company needs (CRM, invoicing, projects, inventory, HR, bookings and more) in one workspace. Usable in the browser or by AI assistants (Claude, ChatGPT, Gemini) through MCP.",
    "",
    "## Key pages",
    `- [App catalogue](${base}/apps): ${apps.length} apps across ${CATEGORIES.length} categories`,
    `- [AI & MCP](${base}/ai): how assistants connect to a workspace`,
    `- [Pricing](${base}/pricing): Free, Starter $19, Business $49, Scale $129 per month`,
    `- [About](${base}/about)`,
    "",
    ...CATEGORIES.flatMap((c) => {
      const inCat = apps.filter((a) => a.category === c.slug);
      return inCat.length ? [`## ${c.name}`, ...inCat.map((a) => `- [${a.name}](${base}/apps/${a.slug}): ${a.tagline}`), ""] : [];
    }),
    "Part of the MeWeBe Studio Network (https://mewebe.com).",
  ];
  return new Response(lines.join("\n"), { headers: { "Content-Type": "text/plain; charset=utf-8" } });
}
