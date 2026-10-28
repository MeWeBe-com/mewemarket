import type { CatalogApp } from "@mewe/core";
import { CATEGORIES } from "@mewe/core";
import Link from "next/link";
import { AppCard } from "./app-card";
import { CategoryIcon } from "./category-icon";

export function CatalogBrowser({ apps, active }: { apps: CatalogApp[]; active?: string }) {
  return (
    <div className="grid gap-8 lg:grid-cols-[220px_1fr]">
      <nav aria-label="Categories" className="flex gap-1 overflow-x-auto pb-2 text-sm lg:flex-col lg:overflow-visible">
        <Link href="/apps" className={`shrink-0 rounded-lg px-3 py-2 ${!active ? "bg-accent/10 font-semibold text-accent" : "hover:bg-black/5 dark:hover:bg-white/5"}`}>All apps</Link>
        {CATEGORIES.map((c) => (
          <Link key={c.slug} href={`/apps/category/${c.slug}`}
            className={`flex shrink-0 items-center gap-2 rounded-lg px-3 py-2 ${active === c.slug ? "bg-accent/10 font-semibold text-accent" : "hover:bg-black/5 dark:hover:bg-white/5"}`}>
            <CategoryIcon name={c.icon} className="size-4" />{c.name}
          </Link>
        ))}
      </nav>
      {apps.length ? (
        <div className="grid content-start gap-4 sm:grid-cols-2 xl:grid-cols-3">
          {apps.map((a) => <AppCard key={a.slug} app={a} />)}
        </div>
      ) : (
        <p className="text-[var(--muted)]">No apps in this category yet. <Link href="/contact" className="text-accent hover:underline">Tell us what you need</Link>.</p>
      )}
    </div>
  );
}
