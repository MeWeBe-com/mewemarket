import { CATEGORIES, listCatalogApps } from "@mewe/core";

export const revalidate = 3600;

export async function GET() {
  const base = process.env.APP_URL ?? "https://mewemarket.com";
  const apps = await listCatalogApps();
  const lines = [
    "# MeweMarket",
    "> Every business app a small company needs (CRM, invoicing, projects, inventory, HR, bookings and more) in one workspace, on one subscription. Over 100 apps plus free browser tools.",
    "",
    "## Key pages",
    `- [App catalogue](${base}/apps): ${apps.filter((a) => a.tier === "app").length} business apps across ${CATEGORIES.length} categories, plus ${apps.filter((a) => a.tier === "tool").length} browser tools`,
    `- [Free tools](${base}/tools): browser tools, no sign-up`,
    `- [Pricing](${base}/pricing): Free, Starter $19, Business $49, Scale $129 per month`,
    `- [About](${base}/about)`,
    "",
    ...CATEGORIES.flatMap((c) => {
      const inCat = apps.filter((a) => a.category === c.slug);
      return inCat.length ? [`## ${c.name}`, ...inCat.map((a) => `- [${a.name}](${base}/${a.tier === "tool" ? "tools" : "apps"}/${a.slug}): ${a.tagline}`), ""] : [];
    }),
    "Part of the MeWeBe Studio Network (https://mewebe.com).",
  ];
  return new Response(lines.join("\n"), { headers: { "Content-Type": "text/plain; charset=utf-8" } });
}
