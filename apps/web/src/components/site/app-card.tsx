import type { CatalogApp } from "@mewe/core";
import Link from "next/link";

export const TIER_LABEL: Record<string, string> = {
  app: "App", tool: "Free tool",
};

export function AppCard({ app }: { app: Pick<CatalogApp, "slug" | "name" | "tagline" | "tier"> }) {
  return (
    <Link href={app.tier === "tool" ? `/tools/${app.slug}` : `/apps/${app.slug}`}
      className="group flex flex-col rounded-xl border border-[var(--border)] bg-[var(--card)] p-5 transition hover:-translate-y-0.5 hover:border-accent/50 hover:shadow-lg hover:shadow-accent/5">
      <span className="flex items-start justify-between gap-3">
        <span className="grid size-10 shrink-0 place-items-center rounded-lg bg-accent/10 font-bold text-accent">{app.name[0]}</span>
        <span className="rounded-full border border-[var(--border)] px-2 py-0.5 text-[11px] font-medium text-[var(--muted)]">{TIER_LABEL[app.tier]}</span>
      </span>
      <span className="mt-4 font-semibold group-hover:text-accent">{app.name}</span>
      <span className="mt-1 text-sm text-[var(--muted)]">{app.tagline}</span>
    </Link>
  );
}
