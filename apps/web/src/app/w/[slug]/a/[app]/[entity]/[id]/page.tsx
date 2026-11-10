import { APPS, displayTitle, getRecord, listInstalledApps, listRecords, recordTitles, refOptions } from "@mewe/core";
import { ArrowLeft, Printer } from "lucide-react";
import Link from "next/link";
import { notFound } from "next/navigation";
import { DeleteRecord } from "@/components/records/delete-record";
import { RecordForm } from "@/components/records/record-form";
import { AppIcon } from "@/components/app-icon";
import { optionColor, Pill, Value } from "@/components/records/value";
import { BUTTON_BASE, BUTTON_SECONDARY, Card } from "@/components/ui";
import { saveRecordAction } from "../../../actions";
import { appContext } from "../../../context";

export default async function RecordPage({ params }: { params: Promise<{ slug: string; app: string; entity: string; id: string }> }) {
  const { slug, app: appSlug, entity: entityKey, id } = await params;
  const { app, entity, workspace, fmt, canEdit } = await appContext(slug, appSlug, entityKey);
  const record = await getRecord(workspace.id, app.slug, entity.key, id);
  if (!record) notFound();
  const base = `/${slug}/${app.slug}/${entity.key}`;
  const refs = await refOptions(workspace.id, app.slug, entity.fields);
  const titles = await recordTitles(workspace.id, entity.fields.filter((f) => f.type === "ref").map((f) => String(record.data[f.key] ?? "")).filter(Boolean));
  const title = displayTitle(entity, record.data, titles);
  const hasLines = entity.fields.some((f) => f.type === "lines");
  // Records that point at this one, e.g. a company's deals, or its projects in another installed app.
  const installed = new Set((await listInstalledApps(workspace.id)).map((a) => a.slug));
  const backlinks = await Promise.all(
    APPS.filter((a) => installed.has(a.slug)).flatMap((a) => a.entities.flatMap((e) => e.fields
      .filter((f) => f.type === "ref" && f.ref === entity.key && (f.refApp ?? a.slug) === app.slug).map((f) => ({ a, e, f }))))
      .map(async ({ a, e, f }) => ({ a, e, f, ...(await listRecords(workspace.id, a.slug, e.key, { filter: { [f.key]: id }, limit: 10 })) })),
  );

  const status = entity.board ? String(record.data[entity.board] ?? "") : "";
  const statusField = entity.fields.find((x) => x.key === entity.board);
  // A few headline values for the side panel: money, dates and links first.
  const rank = (t: string) => ["money", "lines", "date", "datetime", "ref", "number", "rating", "select"].indexOf(t);
  const summary = entity.fields
    .filter((x) => x.key !== entity.title && x.key !== entity.board && rank(x.type) >= 0 && record.data[x.key] !== undefined && record.data[x.key] !== "")
    .sort((a, b) => rank(a.type) - rank(b.type)).slice(0, 5);
  const f = { ...fmt, refs: titles };
  const when = (d: Date) => d.toLocaleDateString(fmt.locale, { day: "numeric", month: "short", year: "numeric" });
  const related = backlinks.filter((b) => b.total > 0);

  return (
    <div>
      <Link href={base} className="inline-flex items-center gap-1 text-sm font-semibold text-[var(--muted)] hover:text-accent"><ArrowLeft className="size-4" />{entity.plural}</Link>
      <div className="mt-3 flex flex-wrap items-center gap-3">
        <h1 className="text-2xl font-extrabold sm:text-3xl">{title}</h1>
        {status && <Pill value={status} color={optionColor(status, statusField?.options)} />}
        <div className="ml-auto flex gap-2">
          {hasLines && <Link href={`${base}/${id}/print`} target="_blank" className={`${BUTTON_BASE} ${BUTTON_SECONDARY} h-9 px-3`}><Printer className="size-4" />Print / PDF</Link>}
          {canEdit && <DeleteRecord slug={slug} app={app.slug} entity={entity.key} id={id} back={base} name={entity.name.toLowerCase()} />}
        </div>
      </div>

      <div className="mt-6 grid gap-6 lg:grid-cols-[1fr_300px]">
        <Card className="min-w-0">
          <RecordForm entity={entity} values={record.data} refs={refs} action={saveRecordAction.bind(null, slug, app.slug, entity.key, id)}
            cancelHref={base} currency={fmt.currency} locale={fmt.locale} isNew={false} readOnly={!canEdit} slug={slug} />
        </Card>

        <aside className="space-y-4">
          <Card className="p-5">
            <h2 className="text-xs font-bold uppercase tracking-wider text-[var(--muted)]">Summary</h2>
            <dl className="mt-3 space-y-3 text-sm">
              {summary.map((x) => (
                <div key={x.key} className="flex items-center justify-between gap-3">
                  <dt className="shrink-0 text-[var(--muted)]">{x.label}</dt>
                  <dd className="min-w-0 truncate text-right font-semibold"><Value field={x} value={record.data[x.key]} f={f} /></dd>
                </div>
              ))}
              <div className="flex justify-between gap-3 border-t border-[var(--border)] pt-3"><dt className="text-[var(--muted)]">Created</dt><dd>{when(record.createdAt)}</dd></div>
              <div className="flex justify-between gap-3"><dt className="text-[var(--muted)]">Updated</dt><dd>{when(record.updatedAt)}</dd></div>
            </dl>
          </Card>

          {related.map(({ a, e, f: rf, rows, total }) => (
            <Card key={`${a.slug}.${e.key}.${rf.key}`} className="p-5">
              <h2 className="flex items-center gap-2 text-sm font-bold">
                <AppIcon slug={a.slug} name={a.name} category={a.category} size="sm" className="!size-6 !rounded-md [&>svg]:size-3.5" />
                <span className="min-w-0 flex-1 truncate">{e.plural}{a.slug !== app.slug && <span className="font-normal text-[var(--muted)]"> in {a.name}</span>}</span>
                <span className="rounded-full bg-[var(--bg-subtle)] px-2 py-0.5 text-xs text-[var(--muted)] ring-1 ring-[var(--border)]">{total}</span>
              </h2>
              {rf.label.toLowerCase() !== entity.name.toLowerCase() && <p className="mt-1 text-xs text-[var(--muted)]">as {rf.label.toLowerCase()}</p>}
              <ul className="mt-3 space-y-1 text-sm">
                {rows.map((r) => (
                  <li key={r.id}><Link href={`/${slug}/${a.slug}/${e.key}/${r.id}`} className="block truncate rounded-lg px-2 py-1.5 font-medium hover:bg-[var(--bg-subtle)] hover:text-accent">{displayTitle(e, r.data, { [id]: title })}</Link></li>
                ))}
              </ul>
            </Card>
          ))}
        </aside>
      </div>
    </div>
  );
}
