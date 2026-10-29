import { displayTitle, entityTotals, listRecords, recordTitles, type FieldDef, type RecordRow } from "@mewe/core";
import Link from "next/link";
import { Board } from "@/components/records/board";
import { ImportCsv } from "@/components/records/import-csv";
import { formatValue, type Fmt } from "@/lib/format";
import { appContext } from "../../context";

type SP = Record<string, string | undefined>;
const PAGE = 50;

export default async function EntityList({ params, searchParams }: { params: Promise<{ slug: string; app: string; entity: string }>; searchParams: Promise<SP> }) {
  const { slug, app: appSlug, entity: entityKey } = await params;
  const sp = await searchParams;
  const { app, entity, workspace, fmt, canEdit } = await appContext(slug, appSlug, entityKey);
  const base = `/w/${slug}/a/${app.slug}/${entity.key}`;
  const views = ["table", ...(entity.board ? ["board"] : []), ...(entity.calendar ? ["calendar"] : [])];
  const view = views.includes(sp.view ?? "") ? sp.view! : "table";
  const page = Math.max(1, Number(sp.page) || 1);
  const selects = entity.fields.filter((f) => f.type === "select");
  const filter = Object.fromEntries(selects.map((f) => [f.key, sp[`f_${f.key}`] ?? ""]).filter(([, v]) => v));

  let rows: RecordRow[], total: number;
  if (view === "table") {
    ({ rows, total } = await listRecords(workspace.id, app.slug, entity.key, {
      q: sp.q, sort: sp.sort, dir: sp.dir === "asc" ? "asc" : "desc", filter, limit: PAGE, offset: (page - 1) * PAGE,
    }));
  } else {
    ({ rows, total } = await listRecords(workspace.id, app.slug, entity.key, { q: sp.q, filter, limit: 1000 }));
  }
  const refIds = rows.flatMap((r) => entity.fields.filter((f) => f.type === "ref").map((f) => String(r.data[f.key] ?? ""))).filter(Boolean);
  const refs = await recordTitles(workspace.id, [...new Set(refIds)]);
  const f: Fmt = { ...fmt, refs };
  const totals = entity.totals?.length ? await entityTotals(workspace.id, app.slug, entity) : {};
  const qs = (patch: SP) => {
    const p = new URLSearchParams(Object.entries({ ...sp, ...patch }).filter(([, v]) => v) as [string, string][]);
    return `${base}?${p}`;
  };

  return (
    <>
      <div className="flex flex-wrap items-center justify-between gap-3">
        <h1 className="text-lg font-semibold">{entity.plural} <span className="font-normal text-[var(--muted)]">({total})</span></h1>
        <div className="flex flex-wrap items-center gap-2">
          {views.length > 1 && (
            <div className="flex rounded-lg border border-[var(--border)] p-0.5 text-sm" role="tablist">
              {views.map((v) => (
                <Link key={v} href={qs({ view: v, page: undefined })} role="tab" aria-selected={v === view}
                  className={`rounded-md px-3 py-1 capitalize ${v === view ? "bg-accent text-white" : "text-[var(--muted)] hover:text-[var(--fg)]"}`}>{v}</Link>
              ))}
            </div>
          )}
          <a href={`${base}/export`} className="inline-flex h-9 items-center rounded-lg border border-[var(--border)] px-3 text-sm hover:bg-black/5 dark:hover:bg-white/5">Export CSV</a>
          {canEdit && <ImportCsv slug={slug} app={app.slug} entity={entity.key} columns={entity.fields.map((x) => x.label)} />}
          {canEdit && <Link href={`${base}/new`} className="inline-flex h-9 items-center rounded-lg bg-accent px-4 text-sm font-semibold text-white hover:bg-indigo-500">+ New {entity.name.toLowerCase()}</Link>}
        </div>
      </div>

      <form className="mt-4 flex flex-wrap gap-2" action={base}>
        <input type="hidden" name="view" value={view} />
        <input name="q" defaultValue={sp.q} placeholder={`Search ${entity.plural.toLowerCase()}…`} aria-label="Search"
          className="h-9 min-w-48 flex-1 rounded-lg border border-[var(--border)] bg-transparent px-3 text-sm outline-none focus:border-accent" />
        {selects.filter((s) => s.key !== (view === "board" ? entity.board : "")).map((s) => (
          <select key={s.key} name={`f_${s.key}`} defaultValue={sp[`f_${s.key}`] ?? ""} aria-label={s.label}
            className="h-9 rounded-lg border border-[var(--border)] bg-transparent px-2 text-sm">
            <option value="">All {s.label.toLowerCase()}</option>
            {s.options!.map((o) => <option key={o}>{o}</option>)}
          </select>
        ))}
        <button className="h-9 rounded-lg border border-[var(--border)] px-3 text-sm hover:bg-black/5 dark:hover:bg-white/5">Apply</button>
        {(sp.q || Object.keys(filter).length > 0) && <Link href={`${base}?view=${view}`} className="inline-flex h-9 items-center px-2 text-sm text-[var(--muted)] hover:underline">Clear</Link>}
      </form>

      <div className="mt-4">
        {total === 0 ? (
          <Empty entity={entity.plural} base={base} canEdit={canEdit} searching={!!sp.q || Object.keys(filter).length > 0} />
        ) : view === "board" ? (
          <Board
            slug={slug} app={app.slug} entity={entity.key} field={entity.board!} canEdit={canEdit}
            columns={entity.fields.find((x) => x.key === entity.board)!.options!}
            cards={rows.map((r) => ({ id: r.id, column: String(r.data[entity.board!] ?? ""), title: displayTitle(entity, r.data, refs), meta: cardMeta(entity.fields, r, entity.title, entity.board!, f) }))}
            base={base}
          />
        ) : view === "calendar" ? (
          <Calendar rows={rows} field={entity.calendar!} month={sp.month} title={(r) => displayTitle(entity, r.data, refs)} base={base} qs={qs} />
        ) : (
          <Table rows={rows} fields={entity.fields} titleKey={entity.title} f={f} base={base} sp={sp} qs={qs} totals={totals} />
        )}
      </div>

      {view === "table" && total > PAGE && (
        <nav className="mt-4 flex items-center justify-between text-sm" aria-label="Pages">
          <span className="text-[var(--muted)]">{(page - 1) * PAGE + 1}–{Math.min(page * PAGE, total)} of {total}</span>
          <span className="flex gap-2">
            {page > 1 && <Link href={qs({ page: String(page - 1) })} className="text-accent hover:underline">← Previous</Link>}
            {page * PAGE < total && <Link href={qs({ page: String(page + 1) })} className="text-accent hover:underline">Next →</Link>}
          </span>
        </nav>
      )}
    </>
  );
}

function cardMeta(fields: FieldDef[], r: RecordRow, title: string, board: string, f: Fmt) {
  return fields
    .filter((x) => x.key !== title && x.key !== board && !["long", "bool"].includes(x.type) && r.data[x.key] !== undefined && r.data[x.key] !== "")
    .slice(0, 3)
    .map((x) => formatValue(x, r.data[x.key], f))
    .filter(Boolean);
}

function Empty({ entity, base, canEdit, searching }: { entity: string; base: string; canEdit: boolean; searching: boolean }) {
  return (
    <div className="rounded-xl border border-dashed border-[var(--border)] p-10 text-center">
      <p className="font-medium">{searching ? `No ${entity.toLowerCase()} match.` : `No ${entity.toLowerCase()} yet.`}</p>
      {!searching && canEdit && <Link href={`${base}/new`} className="mt-3 inline-block text-sm text-accent hover:underline">Add the first one</Link>}
    </div>
  );
}

function Table({ rows, fields, titleKey, f, base, sp, qs, totals }: {
  rows: RecordRow[]; fields: FieldDef[]; titleKey: string; f: Fmt; base: string; sp: SP; qs: (p: SP) => string; totals: Record<string, number>;
}) {
  const cols = [fields.find((x) => x.key === titleKey)!, ...fields.filter((x) => x.key !== titleKey && x.type !== "long")].slice(0, 7);
  const right = (x: FieldDef) => ["number", "money", "percent", "lines"].includes(x.type);
  return (
    <div className="overflow-x-auto rounded-xl border border-[var(--border)]">
      <table className="w-full text-sm">
        <thead className="bg-[var(--bg-subtle)] text-left text-xs text-[var(--muted)]">
          <tr>
            {cols.map((c) => {
              const active = sp.sort === c.key;
              const dir = active && sp.dir === "asc" ? "desc" : "asc";
              return (
                <th key={c.key} className={`whitespace-nowrap px-3 py-2 font-medium ${right(c) ? "text-right" : ""}`} aria-sort={active ? (sp.dir === "asc" ? "ascending" : "descending") : undefined}>
                  {c.type === "lines" ? `${c.label} (subtotal)` : <Link href={qs({ sort: c.key, dir, page: undefined })} className="hover:text-[var(--fg)]">{c.label}{active ? (sp.dir === "asc" ? " ↑" : " ↓") : ""}</Link>}
                </th>
              );
            })}
          </tr>
        </thead>
        <tbody className="divide-y divide-[var(--border)]">
          {rows.map((r) => (
            <tr key={r.id} className="hover:bg-black/[.02] dark:hover:bg-white/[.03]">
              {cols.map((c, i) => (
                <td key={c.key} className={`max-w-64 truncate px-3 py-2 ${right(c) ? "text-right tabular-nums" : ""}`}>
                  {i === 0 ? <Link href={`${base}/${r.id}`} className="font-medium text-accent hover:underline">{formatValue(c, r.data[c.key], f) || "Untitled"}</Link> : formatValue(c, r.data[c.key], f)}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
        {Object.keys(totals).length > 0 && (
          <tfoot className="border-t border-[var(--border)] bg-[var(--bg-subtle)] font-semibold">
            <tr>
              {cols.map((c, i) => (
                <td key={c.key} className={`px-3 py-2 ${right(c) ? "text-right tabular-nums" : ""}`}>
                  {i === 0 ? "Total (all)" : totals[c.key] !== undefined ? (c.type === "number" ? totals[c.key]!.toLocaleString(f.locale) : formatValue({ ...c, type: "money" }, totals[c.key], f)) : ""}
                </td>
              ))}
            </tr>
          </tfoot>
        )}
      </table>
    </div>
  );
}

function Calendar({ rows, field, month, title, base, qs }: {
  rows: RecordRow[]; field: string; month?: string; title: (r: RecordRow) => string; base: string; qs: (p: SP) => string;
}) {
  const m = /^\d{4}-\d{2}$/.test(month ?? "") ? month! : new Date().toISOString().slice(0, 7);
  const [y, mo] = m.split("-").map(Number) as [number, number];
  const first = new Date(Date.UTC(y, mo - 1, 1));
  const days = new Date(Date.UTC(y, mo, 0)).getUTCDate();
  const lead = (first.getUTCDay() + 6) % 7; // Monday first
  const shift = (d: number) => new Date(Date.UTC(y, mo - 1 + d, 1)).toISOString().slice(0, 7);
  const byDay = new Map<number, RecordRow[]>();
  for (const r of rows) {
    const v = String(r.data[field] ?? "");
    if (v.slice(0, 7) !== m) continue;
    const d = Number(v.slice(8, 10));
    byDay.set(d, [...(byDay.get(d) ?? []), r]);
  }
  const today = new Date().toISOString().slice(0, 10);
  return (
    <div>
      <div className="mb-3 flex items-center gap-3 text-sm">
        <Link href={qs({ month: shift(-1) })} className="rounded-lg border border-[var(--border)] px-2 py-1" aria-label="Previous month">←</Link>
        <span className="min-w-32 text-center font-semibold">{first.toLocaleDateString("en-US", { month: "long", year: "numeric", timeZone: "UTC" })}</span>
        <Link href={qs({ month: shift(1) })} className="rounded-lg border border-[var(--border)] px-2 py-1" aria-label="Next month">→</Link>
      </div>
      <div className="grid grid-cols-7 gap-px overflow-hidden rounded-xl border border-[var(--border)] bg-[var(--border)] text-xs">
        {["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"].map((d) => <div key={d} className="bg-[var(--bg-subtle)] px-2 py-1 font-medium text-[var(--muted)]">{d}</div>)}
        {Array.from({ length: lead }, (_, i) => <div key={`l${i}`} className="min-h-24 bg-[var(--bg-subtle)]" />)}
        {Array.from({ length: days }, (_, i) => {
          const d = i + 1;
          const iso = `${m}-${String(d).padStart(2, "0")}`;
          return (
            <div key={d} className="min-h-24 bg-[var(--bg)] p-1">
              <span className={`inline-grid size-5 place-items-center rounded-full ${iso === today ? "bg-accent text-white" : "text-[var(--muted)]"}`}>{d}</span>
              <ul className="mt-1 space-y-0.5">
                {(byDay.get(d) ?? []).slice(0, 4).map((r) => (
                  <li key={r.id}><Link href={`${base}/${r.id}`} className="block truncate rounded bg-accent/10 px-1 py-0.5 text-accent hover:bg-accent/20">{title(r)}</Link></li>
                ))}
                {(byDay.get(d)?.length ?? 0) > 4 && <li className="px-1 text-[var(--muted)]">+{byDay.get(d)!.length - 4} more</li>}
              </ul>
            </div>
          );
        })}
      </div>
    </div>
  );
}
