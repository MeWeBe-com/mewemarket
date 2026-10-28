import { CATEGORIES, listCatalogApps } from "@mewe/core";
import type { MetadataRoute } from "next";

export const revalidate = 3600;

export default async function sitemap(): Promise<MetadataRoute.Sitemap> {
  const base = process.env.APP_URL ?? "https://mewemarket.com";
  const apps = await listCatalogApps();
  const pages = ["", "/apps", "/ai", "/pricing", "/about", "/contact", "/terms", "/privacy", "/cookies"];
  return [
    ...pages.map((p) => ({ url: `${base}${p}`, changeFrequency: "weekly" as const, priority: p === "" ? 1 : 0.8 })),
    ...CATEGORIES.map((c) => ({ url: `${base}/apps/category/${c.slug}`, changeFrequency: "weekly" as const, priority: 0.7 })),
    ...apps.map((a) => ({ url: `${base}/apps/${a.slug}`, lastModified: a.updatedAt, changeFrequency: "monthly" as const, priority: 0.6 })),
  ];
}
