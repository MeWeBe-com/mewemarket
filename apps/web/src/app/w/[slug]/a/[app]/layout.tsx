import Link from "next/link";
import { AppIcon } from "@/components/app-icon";
import { NavLink } from "@/components/shell/nav-link";
import { CATEGORIES } from "@mewe/core";
import { appContext } from "../context";

export default async function AppLayout({ children, params }: { children: React.ReactNode; params: Promise<{ slug: string; app: string }> }) {
  const { slug, app: appSlug } = await params;
  const { app } = await appContext(slug, appSlug);
  // Hosted products bring their own navigation and fill the page.
  if (app.kind === "hosted") return children;
  const cat = CATEGORIES.find((c) => c.slug === app.category);
  const base = `/${slug}/${app.slug}`;
  return (
    <div>
      <div className="flex flex-wrap items-center gap-3.5 print:hidden">
        <AppIcon slug={app.slug} name={app.name} category={app.category} />
        <div>
          <Link href={base} className="font-display text-xl font-extrabold tracking-tight hover:text-accent">{app.name}</Link>
          {cat && <p className="text-xs font-medium text-[var(--muted)]">{cat.name}</p>}
        </div>
      </div>
      {!app.kind && <nav className="mt-5 flex gap-1 overflow-x-auto border-b border-[var(--border)] print:hidden" aria-label={`${app.name} sections`}>
        <NavLink variant="tab" href={base} exact>Overview</NavLink>
        {app.entities.map((e) => <NavLink key={e.key} variant="tab" href={`${base}/${e.key}`}>{e.plural}</NavLink>)}
      </nav>}
      <div className="mt-6">{children}</div>
    </div>
  );
}
