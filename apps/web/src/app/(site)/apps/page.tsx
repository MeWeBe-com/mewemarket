import { listCatalogApps } from "@mewe/core";
import type { Metadata } from "next";
import { CatalogBrowser } from "@/components/site/catalog-browser";

export const revalidate = 3600;
export const metadata: Metadata = {
  title: "App catalogue",
  description: "Browse business apps for CRM, invoicing, projects, inventory, HR, bookings, healthcare, hospitality and more. Install any app into your workspace in one click.",
};

export default async function AppsPage() {
  const apps = await listCatalogApps();
  return (
    <div className="mx-auto max-w-6xl px-4 py-14">
      <h1 className="text-4xl font-bold tracking-tight">App catalogue</h1>
      <p className="mt-3 max-w-2xl text-[var(--muted)]">{apps.length} apps that share one workspace, one login and one set of customer data. Install what you need, when you need it.</p>
      <div className="mt-10"><CatalogBrowser apps={apps} /></div>
    </div>
  );
}
