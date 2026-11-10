import { displayTitle, entityTotals, listRecords, recordTitles, type FieldDef, type RecordRow } from "@mewe/core";
import { CalendarDays, ChevronLeft, ChevronRight, Columns3, Download, Plus, Search, Table2 } from "lucide-react";
import Link from "next/link";
import { Board } from "@/components/records/board";
import { ImportCsv } from "@/components/records/import-csv";
import { optionColor, Value } from "@/components/records/value";
import { BUTTON_BASE, BUTTON_PRIMARY, BUTTON_SECONDARY } from "@/components/ui";
import { formatValue, type Fmt } from "@/lib/format";
import { appContext } from "../../context";

type SP = Record<string, string | undefined>;
const PAGE = 50;

export default async function EntityList({ params, searchParams }: { params: Promise<{ slug: string; app: string; entity: string }>; searchParams: Promise<SP> }) {
  const { slug, app: appSlug, entity: entityKey } = await params;
  const sp = await searchParams;
  const { app, entity, workspace, fmt, canEdit } = await appContext(slug, appSlug, entityKey);
  const base = `/${slug}/${app.slug}/${entity.key}`;
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
        <h1 className="flex items-center gap-2 text-2xl font-extrabold">{entity.plural} <span className="rounded-full bg-[var(--card)] px-2 py-0.5 text-xs font-bold text-[var(--muted)] ring-1 ring-[var(--border)]">{total}</span></h1>
        <div className="flex flex-wrap items-center gap-2">
          {views.length > 1 && (
            <div className="flex rounded-xl border border-[var(--border)] bg-[var(--card)] p-0.5 text-sm shadow-[var(--shadow-sm)]" role="tablist">
              {views.map((v) => {
                const Icon = v === "board" ? Columns3 : v === "calendar" ? CalendarDays : Table2;
                return (
                  <Link key={v} href={qs({ view: v, page: undefined })} role="tab" aria-selected={v === view}
                    className={`inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 font-semibold capitalize transition ${v === view ? "bg-[var(--bg-subtle)] text-[var(--fg)] shadow-sm ring-1 ring-[var(--border)]" : "text-[var(--muted)] hover:text-[var(--fg)]"}`}><Icon className="size-4" />{v}</Link>
                );
              })}
            </div>
          )}
          {canEdit && <a href={`${base}/export`} className={`${BUTTON_BASE} ${BUTTON_SECONDARY} h-9 px-3`}><Download className="size-4" />Export CSV</a>}
          {canEdit && <ImportCsv slug={slug} app={app.slug} entity={entity.key} columns={entity.fields.map((x) => x.label)} />}
          {canEdit && <Link href={`${base}/new`} className={`${BUTTON_BASE} ${BUTTON_PRIMARY} h-9`}><Plus className="size-4" />New {entity.name.toLowerCase()}</Link>}
        </div>
      </div>

      <form className="mt-5 flex flex-wrap gap-2" action={base}>
        <input type="hidden" name="view" value={view} />
        <span className="relative min-w-48 flex-1">
          <Search className="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-[var(--muted)]" />
          <input name="q" defaultValue={sp.q} placeholder={`Search ${entity.plural.toLowerCase()}…`} aria-label="Search"
            className="h-9 w-full rounded-xl border border-[var(--border)] bg-[var(--card)] pl-9 pr-3 text-sm shadow-[var(--shadow-sm)] outline-none focus:border-accent focus:ring-4 focus:ring-accent/15" />
        </span>
        {selects.filter((s) => s.key !== (view === "board" ? entity.board : "")).map((s) => (
          <select key={s.key} name={`f_${s.key}`} defaultValue={sp[`f_${s.key}`] ?? ""} aria-label={s.label}
            className="h-9 rounded-xl border border-[var(--border)] bg-[var(--card)] px-2 text-sm shadow-[var(--shadow-sm)]">
            <option value="">All {s.label.toLowerCase()}</option>
            {s.options!.map((o) => <option key={o}>{o}</option>)}
          </select>
        ))}
        <button className={`${BUTTON_BASE} ${BUTTON_SECONDARY} h-9 px-3`}>Apply</button>
        {(sp.q || Object.keys(filter).length > 0) && <Link href={`${base}?view=${view}`} className="inline-flex h-9 items-center px-2 text-sm text-[var(--muted)] hover:underline">Clear</Link>}
      </form>

      <div className="mt-4">
        {total === 0 ? (
          <Empty entity={entity.plural} base={base} canEdit={canEdit} searching={!!sp.q || Object.keys(filter).length > 0} />
        ) : view === "board" ? (
          <Board
            slug={slug} app={app.slug} entity={entity.key} field={entity.board!} canEdit={canEdit}
            columns={entity.fields.find((x) => x.key === entity.board)!.options!}
            colors={Object.fromEntries(entity.fields.find((x) => x.key === entity.board)!.options!.map((o, _i, all) => [o, optionColor(o, all)]))}
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
            {page > 1 && <Link href={qs({ page: String(page - 1) })} className={`${BUTTON_BASE} ${BUTTON_SECONDARY} h-8 px-3`}><ChevronLeft className="size-4" />Previous</Link>}
            {page * PAGE < total && <Link href={qs({ page: String(page + 1) })} className={`${BUTTON_BASE} ${BUTTON_SECONDARY} h-8 px-3`}>Next<ChevronRight className="size-4" /></Link>}
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
    <div className="rounded-2xl border-2 border-dashed border-[var(--border)] bg-[var(--card)] p-14 text-center">
      <span className="mx-auto grid size-12 place-items-center rounded-2xl bg-accent/10 text-accent">{searching ? <Search className="size-6" /> : <Plus className="size-6" />}</span>
      <p className="mt-4 text-lg font-bold">{searching ? `No ${entity.toLowerCase()} match.` : `No ${entity.toLowerCase()} yet.`}</p>
      <p className="mt-1 text-sm text-[var(--muted)]">{searching ? "Try a different search or clear the filters." : "Add one by hand or import a CSV file."}</p>
      {!searching && canEdit && <Link href={`${base}/new`} className={`${BUTTON_BASE} ${BUTTON_PRIMARY} mt-5`}><Plus className="size-4" />Add the first one</Link>}
    </div>
  );
}

function Table({ rows, fields, titleKey, f, base, sp, qs, totals }: {
  rows: RecordRow[]; fields: FieldDef[]; titleKey: string; f: Fmt; base: string; sp: SP; qs: (p: SP) => string; totals: Record<string, number>;
}) {
  const cols = [fields.find((x) => x.key === titleKey)!, ...fields.filter((x) => x.key !== titleKey && x.type !== "long")].slice(0, 7);
  const right = (x: FieldDef) => ["number", "money", "percent", "lines"].includes(x.type);
  return (
    <div className="surface overflow-x-auto">
      <table className="w-full text-sm">
        <thead className="border-b border-[var(--border)] bg-[var(--bg-subtle)] text-left text-[11px] uppercase tracking-wider text-[var(--muted)]">
          <tr>
            {cols.map((c) => {
              const active = sp.sort === c.key;
              const dir = active && sp.dir === "asc" ? "desc" : "asc";
              return (
                <th key={c.key} className={`whitespace-nowrap px-4 py-3 font-bold ${right(c) ? "text-right" : ""}`} aria-sort={active ? (sp.dir === "asc" ? "ascending" : "descending") : undefined}>
                  {c.type === "lines" ? `${c.label} (subtotal)` : <Link href={qs({ sort: c.key, dir, page: undefined })} className="hover:text-[var(--fg)]">{c.label}{active ? (sp.dir === "asc" ? " ↑" : " ↓") : ""}</Link>}
                </th>
              );
            })}
          </tr>
        </thead>
        <tbody className="divide-y divide-[var(--border)]">
          {rows.map((r) => (
            <tr key={r.id} className="group transition hover:bg-accent/[0.03]">
              {cols.map((c, i) => (
                <td key={c.key} className={`max-w-64 truncate px-4 py-3 ${right(c) ? "text-right font-medium tabular-nums" : ""}`}>
                  {i === 0 ? <Link href={`${base}/${r.id}`} className="font-semibold text-[var(--fg)] group-hover:text-accent">{formatValue(c, r.data[c.key], f) || "Untitled"}</Link> : <Value field={c} value={r.data[c.key]} f={f} />}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
        {Object.keys(totals).length > 0 && (
          <tfoot className="border-t border-[var(--border)] bg-[var(--bg-subtle)] font-bold">
            <tr>
              {cols.map((c, i) => (
                <td key={c.key} className={`px-4 py-3 ${right(c) ? "text-right tabular-nums" : ""}`}>
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
        <Link href={qs({ month: shift(-1) })} className={`${BUTTON_BASE} ${BUTTON_SECONDARY} size-8 px-0`} aria-label="Previous month"><ChevronLeft className="size-4" /></Link>
        <span className="min-w-36 text-center font-display text-base font-bold">{first.toLocaleDateString("en-US", { month: "long", year: "numeric", timeZone: "UTC" })}</span>
        <Link href={qs({ month: shift(1) })} className={`${BUTTON_BASE} ${BUTTON_SECONDARY} size-8 px-0`} aria-label="Next month"><ChevronRight className="size-4" /></Link>
      </div>
      <div className="grid grid-cols-7 gap-px overflow-hidden rounded-2xl border border-[var(--border)] bg-[var(--border)] text-xs shadow-[var(--shadow)]">
        {["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"].map((d) => <div key={d} className="bg-[var(--bg-subtle)] px-2 py-2 text-[11px] font-bold uppercase tracking-wider text-[var(--muted)]">{d}</div>)}
        {Array.from({ length: lead }, (_, i) => <div key={`l${i}`} className="min-h-24 bg-[var(--bg-subtle)]" />)}
        {Array.from({ length: days }, (_, i) => {
          const d = i + 1;
          const iso = `${m}-${String(d).padStart(2, "0")}`;
          return (
            <div key={d} className={`min-h-28 p-1.5 ${iso === today ? "bg-accent/[0.04]" : "bg-[var(--card)]"}`}>
              <span className={`inline-grid size-6 place-items-center rounded-full font-semibold ${iso === today ? "bg-accent text-white" : "text-[var(--muted)]"}`}>{d}</span>
              <ul className="mt-1 space-y-0.5">
                {(byDay.get(d) ?? []).slice(0, 4).map((r) => (
                  <li key={r.id}><Link href={`${base}/${r.id}`} className="block truncate rounded-md border-l-2 border-accent bg-accent/10 px-1.5 py-1 font-medium text-accent hover:bg-accent/20">{title(r)}</Link></li>
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
