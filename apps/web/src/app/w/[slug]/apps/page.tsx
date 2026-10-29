import { APPS, CATEGORIES, canManageWorkspace, getSubscription, listInstalledApps } from "@mewe/core";
import Link from "next/link";
import { CategoryIcon } from "@/components/site/category-icon";
import { Alert } from "@/components/ui";
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
  const apps = APPS.filter((a) => (!sp.c || a.category === sp.c) && (!q || `${a.name} ${a.tagline} ${a.category}`.toLowerCase().includes(q)));
  const max = sub?.plan.limits.apps ?? 3;
  const cats = CATEGORIES.filter((c) => APPS.some((a) => a.category === c.slug));

  return (
    <>
      <div className="flex flex-wrap items-end justify-between gap-3">
        <div>
          <h1 className="text-2xl font-bold">App Store</h1>
          <p className="mt-1 text-sm text-[var(--muted)]">
            {APPS.length} apps. {installed.length} added to {workspace.name}{max >= 0 ? ` (your ${sub?.plan.name ?? "Free"} plan includes ${max})` : ""}.
          </p>
        </div>
        <form className="flex gap-2">
          {sp.c && <input type="hidden" name="c" value={sp.c} />}
          <input name="q" defaultValue={sp.q} placeholder="Search apps…" aria-label="Search apps" className="h-9 w-56 rounded-lg border border-[var(--border)] bg-transparent px-3 text-sm outline-none focus:border-accent" />
        </form>
      </div>
      {sp.error && <div className="mt-4"><Alert>{sp.error} {max >= 0 && <Link href={`/w/${slug}/billing`} className="font-semibold underline">See plans</Link>}</Alert></div>}
      {sp.app && !have.has(sp.app) && <div className="mt-4"><Alert tone="success">Add this app to your workspace to start using it.</Alert></div>}

      <nav className="mt-5 flex flex-wrap gap-2 text-sm" aria-label="Categories">
        <Link href={`/w/${slug}/apps`} className={`rounded-full border px-3 py-1 ${!sp.c ? "border-accent bg-accent text-white" : "border-[var(--border)]"}`}>All</Link>
        {cats.map((c) => (
          <Link key={c.slug} href={`/w/${slug}/apps?c=${c.slug}`} className={`rounded-full border px-3 py-1 ${sp.c === c.slug ? "border-accent bg-accent text-white" : "border-[var(--border)]"}`}>{c.name}</Link>
        ))}
      </nav>

      <ul className="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        {apps.map((a) => {
          const cat = CATEGORIES.find((c) => c.slug === a.category);
          const added = have.has(a.slug);
          return (
            <li key={a.slug} id={a.slug} className={`flex flex-col rounded-xl border p-5 ${sp.app === a.slug ? "border-accent ring-2 ring-accent/20" : "border-[var(--border)]"}`}>
              <div className="flex items-center gap-3">
                <span className="grid size-9 shrink-0 place-items-center rounded-lg bg-accent/10 text-accent"><CategoryIcon name={cat?.icon ?? "app-window"} className="size-5" /></span>
                <div className="min-w-0"><p className="truncate font-semibold">{a.name}</p><p className="text-xs text-[var(--muted)]">{cat?.name}</p></div>
              </div>
              <p className="mt-3 flex-1 text-sm text-[var(--muted)]">{a.tagline}</p>
              <div className="mt-4">
                {added ? (
                  <Link href={`/w/${slug}/a/${a.slug}`} className="inline-flex h-9 items-center rounded-lg border border-[var(--border)] px-4 text-sm font-semibold">Open</Link>
                ) : manage ? (
                  <form action={installAppAction.bind(null, slug, a.slug)} className="flex flex-wrap items-center gap-3">
                    <button className="h-9 rounded-lg bg-accent px-4 text-sm font-semibold text-white hover:bg-indigo-500">Add app</button>
                    <label className="flex items-center gap-1.5 text-xs text-[var(--muted)]"><input type="checkbox" name="samples" defaultChecked className="accent-[var(--color-accent)]" /> with sample data</label>
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
