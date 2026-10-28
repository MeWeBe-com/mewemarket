import { CATEGORIES, getCategory, listCatalogApps } from "@mewe/core";
import type { Metadata } from "next";
import { notFound } from "next/navigation";
import { CatalogBrowser } from "@/components/site/catalog-browser";

export const revalidate = 3600;
export const generateStaticParams = () => CATEGORIES.map((c) => ({ slug: c.slug }));

export async function generateMetadata({ params }: { params: Promise<{ slug: string }> }): Promise<Metadata> {
  const c = getCategory((await params).slug);
  return c ? { title: `${c.name} apps`, description: `${c.blurb} Browse ${c.name.toLowerCase()} apps on MeweMarket.` } : {};
}

export default async function CategoryPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const category = getCategory(slug);
  if (!category) notFound();
  const apps = await listCatalogApps(slug);
  return (
    <div className="mx-auto max-w-6xl px-4 py-14">
      <h1 className="text-4xl font-bold tracking-tight">{category.name} apps</h1>
      <p className="mt-3 max-w-2xl text-[var(--muted)]">{category.blurb}</p>
      <div className="mt-10"><CatalogBrowser apps={apps} active={slug} /></div>
    </div>
  );
}
