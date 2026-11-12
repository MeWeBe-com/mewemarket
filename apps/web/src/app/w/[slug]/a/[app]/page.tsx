import { canManageWorkspace, entityCounts, entityTotals } from "@mewe/core";
import { ArrowRight, Plus } from "lucide-react";
import Link from "next/link";
import { tone } from "@/components/app-icon";
import { AssistantHome } from "@/components/assistant/home";
import { HostedHome } from "@/components/hosted/hosted-home";
import { Card } from "@/components/ui";
import { formatValue } from "@/lib/format";
import { uninstallAppAction } from "../actions";
import { appContext } from "../context";

export default async function AppHome({ params }: { params: Promise<{ slug: string; app: string }> }) {
  const { slug, app: appSlug } = await params;
  const { app, workspace, role, fmt, canEdit } = await appContext(slug, appSlug);
  if (app.kind === "assistant") return <AssistantHome slug={slug} workspaceId={workspace.id} role={role} />;
  if (app.kind === "hosted") return <HostedHome slug={slug} app={app} />;
  const counts = await entityCounts(workspace.id, app.slug);
  const totals = await Promise.all(app.entities.map((e) => entityTotals(workspace.id, app.slug, e)));
  const base = `/${slug}/${app.slug}`;
  const empty = Object.values(counts).every((n) => !n);
  const t = tone(app.category);

  return (
    <>
      <p className="max-w-2xl text-[var(--muted)]">{app.description}</p>
      <div className="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        {app.entities.map((e, i) => (
          <Card key={e.key} className="relative flex flex-col gap-3 overflow-hidden p-5">
            <div aria-hidden className="absolute inset-x-0 top-0 h-1" style={{ background: `linear-gradient(90deg, ${t.from}, ${t.to})` }} />
            <Link href={`${base}/${e.key}`} className="text-sm font-bold text-[var(--muted)] hover:text-accent">{e.plural}</Link>
            <p className="-mt-1 font-display text-4xl font-extrabold tabular-nums">{counts[e.key] ?? 0}</p>
            {(e.totals ?? []).map((k) => {
              const f = e.fields.find((x) => x.key === k)!;
              const n = totals[i]?.[k] ?? 0;
              return (
                <p key={k} className="flex justify-between rounded-lg bg-[var(--bg-subtle)] px-3 py-2 text-sm">
                  <span className="text-[var(--muted)]">Total {f.label.toLowerCase()}</span>
                  <span className="font-bold tabular-nums">{f.type === "number" ? n.toLocaleString(fmt.locale) : formatValue({ ...f, type: "money" }, n, fmt)}</span>
                </p>
              );
            })}
            <div className="mt-auto flex gap-2 border-t border-[var(--border)] pt-3 text-sm font-semibold">
              <Link href={`${base}/${e.key}`} className="inline-flex items-center gap-1 rounded-lg px-2 py-1 hover:bg-[var(--bg-subtle)]">Open <ArrowRight className="size-3.5" /></Link>
              {canEdit && <Link href={`${base}/${e.key}/new`} className="ml-auto inline-flex items-center gap-1 rounded-lg px-2 py-1 hover:bg-[var(--bg-subtle)]" style={{ color: t.text }}><Plus className="size-3.5" />New {e.name.toLowerCase()}</Link>}
            </div>
          </Card>
        ))}
      </div>
      {empty && canEdit && (
        <Card className="mt-6 text-sm">
          <p className="font-medium">This app is empty.</p>
          <p className="mt-1 text-[var(--muted)]">Add your first record above, or import a CSV file from any list page.</p>
        </Card>
      )}
      <details className="mt-10 text-sm">
        <summary className="cursor-pointer text-[var(--muted)]">What this app does</summary>
        <ul className="mt-3 list-disc space-y-1 pl-5 text-[var(--muted)]">{app.features.map((f) => <li key={f}>{f}</li>)}</ul>
      </details>
      {canManageWorkspace(role) && (
        <details className="mt-4 text-sm">
          <summary className="cursor-pointer text-[var(--muted)]">Remove app</summary>
          <form action={uninstallAppAction.bind(null, slug, app.slug)} className="mt-3 space-y-3 rounded-lg border border-red-500/30 p-4">
            <p>Removing {app.name} hides it from your workspace. Your records are kept unless you choose to delete them.</p>
            <label className="flex items-center gap-2"><input type="checkbox" name="delete_data" className="accent-red-600" /> Also delete all {app.name} records permanently</label>
            <button className="h-9 rounded-lg bg-red-600 px-4 font-semibold text-white hover:bg-red-500">Remove {app.name}</button>
          </form>
        </details>
      )}
    </>
  );
}
