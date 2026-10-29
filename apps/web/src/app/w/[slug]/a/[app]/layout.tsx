import Link from "next/link";
import { CategoryIcon } from "@/components/site/category-icon";
import { CATEGORIES } from "@mewe/core";
import { appContext } from "../context";

export default async function AppLayout({ children, params }: { children: React.ReactNode; params: Promise<{ slug: string; app: string }> }) {
  const { slug, app: appSlug } = await params;
  const { app } = await appContext(slug, appSlug);
  const cat = CATEGORIES.find((c) => c.slug === app.category);
  const base = `/w/${slug}/a/${app.slug}`;
  return (
    <div>
      <div className="flex flex-wrap items-center gap-3 print:hidden">
        <span className="grid size-9 place-items-center rounded-lg bg-accent/10 text-accent"><CategoryIcon name={cat?.icon ?? "app-window"} className="size-5" /></span>
        <Link href={base} className="text-xl font-bold hover:underline">{app.name}</Link>
      </div>
      <nav className="mt-4 flex gap-1 overflow-x-auto print:hidden border-b border-[var(--border)] text-sm" aria-label={`${app.name} sections`}>
        <Link href={base} className="whitespace-nowrap px-3 py-2 text-[var(--muted)] hover:text-[var(--fg)]">Overview</Link>
        {app.entities.map((e) => (
          <Link key={e.key} href={`${base}/${e.key}`} className="whitespace-nowrap px-3 py-2 text-[var(--muted)] hover:text-[var(--fg)]">{e.plural}</Link>
        ))}
      </nav>
      <div className="mt-6">{children}</div>
    </div>
  );
}
