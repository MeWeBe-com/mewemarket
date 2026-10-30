import type { CatalogApp } from "@mewe/core";
import { CATEGORIES } from "@mewe/core";
import { LayoutGrid } from "lucide-react";
import Link from "next/link";
import { CategoryIcon, tone } from "@/components/app-icon";
import { AppCard } from "./app-card";

export function CatalogBrowser({ apps, active, counts }: { apps: CatalogApp[]; active?: string; counts?: Record<string, number> }) {
  const item = "flex shrink-0 items-center gap-2.5 rounded-xl px-3 py-2 font-medium transition";
  return (
    <div className="grid gap-8 lg:grid-cols-[240px_1fr]">
      <nav aria-label="Categories" className="-mx-4 flex gap-1 overflow-x-auto px-4 pb-2 text-sm lg:sticky lg:top-24 lg:mx-0 lg:h-fit lg:flex-col lg:overflow-visible lg:px-0">
        <Link href="/apps" className={`${item} ${!active ? "bg-[var(--card)] shadow-[var(--shadow)] ring-1 ring-[var(--border)]" : "text-[var(--muted)] hover:bg-[var(--bg-subtle)] hover:text-[var(--fg)]"}`}>
          <span className="grid size-7 place-items-center rounded-lg bg-accent/10 text-accent"><LayoutGrid className="size-4" /></span>All apps
        </Link>
        {CATEGORIES.map((c) => {
          const t = tone(c.slug), on = active === c.slug;
          return (
            <Link key={c.slug} href={`/apps/category/${c.slug}`} aria-current={on ? "page" : undefined}
              className={`${item} ${on ? "bg-[var(--card)] shadow-[var(--shadow)] ring-1 ring-[var(--border)]" : "text-[var(--muted)] hover:bg-[var(--bg-subtle)] hover:text-[var(--fg)]"}`}>
              <span className="grid size-7 place-items-center rounded-lg" style={{ background: `${t.from}1a`, color: t.from }}><CategoryIcon category={c.slug} className="size-4" /></span>
              <span className="flex-1">{c.name}</span>
              {counts?.[c.slug] !== undefined && <span className="hidden text-xs text-[var(--muted)] lg:inline">{counts[c.slug]}</span>}
            </Link>
          );
        })}
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
