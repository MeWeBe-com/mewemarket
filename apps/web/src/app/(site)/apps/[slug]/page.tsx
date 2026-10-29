import { RENAMED_APPS, getAppDef, getCatalogApp, getCategory, legacyAppDirSlug, listCatalogApps } from "@mewe/core";
import { Check } from "lucide-react";
import type { Metadata } from "next";
import Link from "next/link";
import { notFound, permanentRedirect } from "next/navigation";
import { AppCard, TIER_LABEL } from "@/components/site/app-card";

export const revalidate = 3600;

export async function generateMetadata({ params }: { params: Promise<{ slug: string }> }): Promise<Metadata> {
  const app = await getCatalogApp((await params).slug);
  return app ? { title: app.name, description: `${app.tagline} ${app.description}` } : {};
}

export default async function AppPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const app = await getCatalogApp(slug);
  if (!app) {
    const moved = RENAMED_APPS[slug] ?? legacyAppDirSlug(slug);
    if (moved) permanentRedirect(`/apps/${moved}`);
    notFound();
  }
  const category = getCategory(app.category);
  const related = (await listCatalogApps(app.category)).filter((a) => a.slug !== slug).slice(0, 3);
  if (app.tier === "tool") permanentRedirect(`/tools/${app.slug}`);
  const def = getAppDef(app.slug);

  return (
    <div className="mx-auto max-w-6xl px-4 py-14">
      <nav className="text-sm text-[var(--muted)]">
        <Link href="/apps" className="hover:text-[var(--fg)]">Apps</Link>
        {category && <> / <Link href={`/apps/category/${category.slug}`} className="hover:text-[var(--fg)]">{category.name}</Link></>}
      </nav>
      <div className="mt-6 grid gap-12 lg:grid-cols-[1fr_320px]">
        <div>
          <div className="flex items-center gap-4">
            <span className="grid size-14 place-items-center rounded-xl bg-accent/10 text-2xl font-bold text-accent">{app.name[0]}</span>
            <div>
              <h1 className="text-3xl font-bold tracking-tight">{app.name}</h1>
              <p className="text-[var(--muted)]">{app.tagline}</p>
            </div>
          </div>
          <p className="mt-8 text-lg leading-relaxed">{app.description}</p>
          <h2 className="mt-10 text-xl font-semibold">Features</h2>
          <ul className="mt-4 grid gap-3 sm:grid-cols-2">
            {app.features.map((f) => <li key={f} className="flex gap-2"><Check className="mt-0.5 size-5 shrink-0 text-emerald-500" />{f}</li>)}
          </ul>
          {def && (
            <>
              <h2 className="mt-10 text-xl font-semibold">What's inside</h2>
              <div className="mt-4 grid gap-3 sm:grid-cols-2">
                {def.entities.map((e) => (
                  <div key={e.key} className="rounded-xl border border-[var(--border)] p-4">
                    <p className="font-semibold">{e.plural}</p>
                    <p className="mt-1 text-sm text-[var(--muted)]">{e.fields.map((f) => f.label).join(", ")}</p>
                    <p className="mt-2 text-xs text-[var(--muted)]">{["Table", e.board && "Board", e.calendar && "Calendar", e.totals?.length && "Totals"].filter(Boolean).join(" · ")}</p>
                  </div>
                ))}
              </div>
            </>
          )}
        </div>
        <aside className="h-fit rounded-xl border border-[var(--border)] p-6 lg:sticky lg:top-24">
          <span className="rounded-full border border-[var(--border)] px-2 py-0.5 text-xs font-medium text-[var(--muted)]">{TIER_LABEL[app.tier]}</span>
          <Link href={`/sign-up?app=${app.slug}`}
            className="mt-5 flex w-full items-center justify-center rounded-lg bg-accent px-4 py-3 font-semibold text-white hover:bg-accent-strong">
            Start using {app.name}
          </Link>
          <p className="mt-3 text-center text-xs text-[var(--muted)]">Free plan available · 14-day Business trial</p>
          <Link href="/sign-in" className="mt-3 block text-center text-sm text-accent hover:underline">Already have an account? Sign in</Link>
        </aside>
      </div>
      {related.length > 0 && (
        <section className="mt-20">
          <h2 className="text-xl font-semibold">More {category?.name.toLowerCase()} apps</h2>
          <div className="mt-6 grid gap-4 sm:grid-cols-3">{related.map((a) => <AppCard key={a.slug} app={a} />)}</div>
        </section>
      )}
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify({
        "@context": "https://schema.org", "@type": "SoftwareApplication", name: app.name, description: app.description,
        applicationCategory: "BusinessApplication", operatingSystem: "Web",
        offers: { "@type": "Offer", price: "0", priceCurrency: "USD" },
      }) }} />
    </div>
  );
}
