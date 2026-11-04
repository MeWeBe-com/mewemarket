import { APPS, CATEGORIES, canManageWorkspace, getSubscription, listInstalledApps } from "@mewe/core";
import { Check, Search } from "lucide-react";
import Link from "next/link";
import { AppIcon, tone } from "@/components/app-icon";
import { Alert, BUTTON_BASE, BUTTON_PRIMARY, BUTTON_SECONDARY } from "@/components/ui";
import { requireWorkspace } from "@/lib/session";
import { installAppAction } from "../a/actions";

export const metadata = { title: "App Store" };

export default async function WorkspaceApps({ params, searchParams }: { params: Promise<{ slug: string }>; searchParams: Promise<{ q?: string; c?: string; error?: string; app?: string }> }) {
  const { slug } = await params;
  const sp = await searchParams;
  const { workspace, role } = await requireWorkspace(slug);
  const [installed, sub] = await Promise.all([listInstalledApps(workspace.id), getSubscription(workspace.id)]);
  const have = new Set(installed.map((a) => a.slug));
  const manage = canManageWorkspace(role);
  const q = sp.q?.trim().toLowerCase() ?? "";
  const apps = [...APPS].sort((x, y) => Number(!!y.kind) - Number(!!x.kind)).filter((a) => (!sp.c || a.category === sp.c) && (!q || `${a.name} ${a.tagline} ${a.category}`.toLowerCase().includes(q)));
  const max = sub?.plan.limits.apps ?? 3;
  const cats = CATEGORIES.filter((c) => APPS.some((a) => a.category === c.slug));

  return (
    <>
      <div className="flex flex-wrap items-end justify-between gap-3">
        <div>
          <h1 className="text-3xl font-extrabold">App Store</h1>
          <p className="mt-1 text-sm text-[var(--muted)]">
            {APPS.length} apps. {installed.filter((a) => !a.kind).length} added to {workspace.name}{max >= 0 ? ` (your ${sub?.plan.name ?? "Free"} plan includes ${max})` : ""}.
          </p>
        </div>
        <form className="flex gap-2">
          {sp.c && <input type="hidden" name="c" value={sp.c} />}
          <span className="relative">
            <Search className="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-[var(--muted)]" />
            <input name="q" defaultValue={sp.q} placeholder="Search apps…" aria-label="Search apps" className="h-10 w-64 rounded-xl border border-[var(--border)] bg-[var(--card)] pl-9 pr-3 text-sm shadow-[var(--shadow-sm)] outline-none focus:border-accent focus:ring-4 focus:ring-accent/15" />
          </span>
        </form>
      </div>
      {sp.error && <div className="mt-4"><Alert>{sp.error} {max >= 0 && <Link href={`/w/${slug}/billing`} className="font-semibold underline">See plans</Link>}</Alert></div>}
      {sp.app && !have.has(sp.app) && <div className="mt-4"><Alert tone="success">Add this app to your workspace to start using it.</Alert></div>}

      <nav className="mt-5 flex flex-wrap gap-2 text-sm" aria-label="Categories">
        <Link href={`/w/${slug}/apps`} className={`rounded-full px-3.5 py-1.5 font-semibold transition ${!sp.c ? "bg-[var(--fg)] text-[var(--bg)]" : "bg-[var(--card)] text-[var(--muted)] ring-1 ring-[var(--border)] hover:text-[var(--fg)]"}`}>All</Link>
        {cats.map((c) => {
          const on = sp.c === c.slug, t = tone(c.slug);
          return (
            <Link key={c.slug} href={`/w/${slug}/apps?c=${c.slug}`} className={`inline-flex items-center gap-1.5 rounded-full px-3.5 py-1.5 font-semibold transition ${on ? "text-white" : "bg-[var(--card)] text-[var(--muted)] ring-1 ring-[var(--border)] hover:text-[var(--fg)]"}`}
              style={on ? { background: t.from } : undefined}>
              {!on && <span className="size-2 rounded-full" style={{ background: t.from }} />}{c.name}
            </Link>
          );
        })}
      </nav>

      <ul className="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        {apps.map((a) => {
          const cat = CATEGORIES.find((c) => c.slug === a.category);
          const added = have.has(a.slug);
          return (
            <li key={a.slug} id={a.slug} className={`surface flex scroll-mt-6 flex-col p-5 transition hover:shadow-[var(--shadow-lg)] ${sp.app === a.slug ? "!border-accent ring-4 ring-accent/15" : ""}`}>
              <div className="flex items-center gap-3">
                <AppIcon slug={a.slug} name={a.name} category={a.category} />
                <div className="min-w-0 flex-1"><p className="truncate font-bold">{a.name}</p><p className="text-xs font-medium" style={{ color: tone(a.category).text }}>{cat?.name}</p></div>
                {a.kind && !added && <span className="rounded-full bg-gradient-to-r from-accent to-fuchsia-500 px-2 py-0.5 text-[11px] font-bold text-white">AI</span>}
                {added && <span className="inline-flex items-center gap-1 rounded-full bg-emerald-500/10 px-2 py-0.5 text-[11px] font-bold text-emerald-600"><Check className="size-3" strokeWidth={3} />Added</span>}
              </div>
              <p className="mt-3 flex-1 text-sm leading-relaxed text-[var(--muted)]">{a.tagline}</p>
              <div className="mt-4 border-t border-[var(--border)] pt-4">
                {added ? (
                  <Link href={`/w/${slug}/a/${a.slug}`} className={`${BUTTON_BASE} ${BUTTON_SECONDARY} h-9`}>Open</Link>
                ) : manage ? (
                  <form action={installAppAction.bind(null, slug, a.slug)} className="flex flex-wrap items-center gap-3">
                    <button className={`${BUTTON_BASE} ${BUTTON_PRIMARY} h-9`}>Add app</button>
                    {a.kind ? <span className="text-xs text-[var(--muted)]">Free, uses your own AI key</span> : (
                      <label className="flex items-center gap-1.5 text-xs text-[var(--muted)]"><input type="checkbox" name="samples" defaultChecked className="accent-[var(--color-accent)]" /> with sample data</label>
                    )}
                  </form>
                ) : (
                  <p className="text-xs text-[var(--muted)]">Ask an owner or admin to add this app.</p>
                )}
              </div>
            </li>
          );
        })}
      </ul>
      {!apps.length && <p className="mt-10 text-center text-[var(--muted)]">No apps match. <Link href={`/w/${slug}/apps`} className="text-accent">Show all</Link></p>}
    </>
  );
}
