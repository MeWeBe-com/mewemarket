import type { CatalogApp } from "@mewe/core";
import { ArrowUpRight } from "lucide-react";
import Link from "next/link";
import { AppIcon } from "@/components/app-icon";

export const TIER_LABEL: Record<string, string> = {
  app: "App", tool: "Free tool",
};

export function AppCard({ app }: { app: Pick<CatalogApp, "slug" | "name" | "tagline" | "tier" | "category"> }) {
  return (
    <Link href={app.tier === "tool" ? `/tools/${app.slug}` : `/apps/${app.slug}`} className="surface surface-hover group relative flex flex-col p-5">
      <span className="flex items-start justify-between gap-3">
        <AppIcon slug={app.slug} name={app.name} category={app.category} />
        {app.tier === "tool"
          ? <span className="rounded-full bg-emerald-500/10 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 dark:text-emerald-400">Free tool</span>
          : <ArrowUpRight className="size-4 text-[var(--muted)] opacity-0 transition group-hover:opacity-100" />}
      </span>
      <span className="mt-4 font-display font-bold tracking-tight">{app.name}</span>
      <span className="mt-1 text-sm leading-relaxed text-[var(--muted)]">{app.tagline}</span>
    </Link>
  );
}
