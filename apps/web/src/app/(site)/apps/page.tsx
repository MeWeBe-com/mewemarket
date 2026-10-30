import { listCatalogApps } from "@mewe/core";
import type { Metadata } from "next";
import { CatalogBrowser } from "@/components/site/catalog-browser";
import { PageHero } from "@/components/site/page-hero";

export const revalidate = 3600;
export const metadata: Metadata = {
  title: "App catalogue",
  description: "Browse business apps for CRM, invoicing, projects, inventory, HR, bookings, healthcare, hospitality and more. Install any app into your workspace in one click.",
};

export default async function AppsPage() {
  const apps = await listCatalogApps();
  const counts = Object.fromEntries(apps.reduce((m, a) => m.set(a.category, (m.get(a.category) ?? 0) + 1), new Map<string, number>()));
  return (
    <>
      <PageHero eyebrow="App catalogue" title={<>{apps.length} apps. <span className="text-gradient">One workspace.</span></>}
        intro="Apps that share one workspace, one login and one set of customer data. Install what you need, when you need it." />
      <div className="mx-auto max-w-6xl px-4 py-12"><CatalogBrowser apps={apps} counts={counts} /></div>
    </>
  );
}
