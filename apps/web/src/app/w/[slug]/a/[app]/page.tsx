import { canManageWorkspace, entityCounts, entityTotals } from "@mewe/core";
import Link from "next/link";
import { Card } from "@/components/ui";
import { formatValue } from "@/lib/format";
import { uninstallAppAction } from "../actions";
import { appContext } from "../context";

export default async function AppHome({ params }: { params: Promise<{ slug: string; app: string }> }) {
  const { slug, app: appSlug } = await params;
  const { app, workspace, role, fmt, canEdit } = await appContext(slug, appSlug);
  const counts = await entityCounts(workspace.id, app.slug);
  const totals = await Promise.all(app.entities.map((e) => entityTotals(workspace.id, app.slug, e)));
  const base = `/w/${slug}/a/${app.slug}`;
  const empty = Object.values(counts).every((n) => !n);

  return (
    <>
      <p className="max-w-2xl text-[var(--muted)]">{app.description}</p>
      <div className="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        {app.entities.map((e, i) => (
          <Card key={e.key} className="flex flex-col gap-3">
            <div className="flex items-baseline justify-between">
              <Link href={`${base}/${e.key}`} className="font-semibold hover:underline">{e.plural}</Link>
              <span className="text-2xl font-bold tabular-nums">{counts[e.key] ?? 0}</span>
            </div>
            {(e.totals ?? []).map((k) => {
              const f = e.fields.find((x) => x.key === k)!;
              const n = totals[i]?.[k] ?? 0;
              return (
                <p key={k} className="flex justify-between text-sm text-[var(--muted)]">
                  <span>Total {f.label.toLowerCase()}</span>
                  <span className="tabular-nums">{f.type === "number" ? n.toLocaleString(fmt.locale) : formatValue({ ...f, type: "money" }, n, fmt)}</span>
                </p>
              );
            })}
            <div className="mt-auto flex gap-3 text-sm">
              <Link href={`${base}/${e.key}`} className="text-accent hover:underline">Open</Link>
              {canEdit && <Link href={`${base}/${e.key}/new`} className="text-accent hover:underline">+ New {e.name.toLowerCase()}</Link>}
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
