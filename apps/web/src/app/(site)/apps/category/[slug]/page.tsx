import { CATEGORIES, getCategory, listCatalogApps } from "@mewe/core";
import type { Metadata } from "next";
import { notFound } from "next/navigation";
import { CategoryIcon, tone } from "@/components/app-icon";
import { CatalogBrowser } from "@/components/site/catalog-browser";
import { PageHero } from "@/components/site/page-hero";

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
  const t = tone(slug);
  return (
    <>
      <PageHero tint={t.from} eyebrow={<><CategoryIcon category={slug} className="size-4" />{apps.length} apps</>} title={`${category.name} apps`} intro={category.blurb} />
      <div className="mx-auto max-w-6xl px-4 py-12"><CatalogBrowser apps={apps} active={slug} /></div>
    </>
  );
}
