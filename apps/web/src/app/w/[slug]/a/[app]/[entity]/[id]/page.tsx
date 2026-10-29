import { displayTitle, getRecord, listRecords, recordTitles, refOptions } from "@mewe/core";
import Link from "next/link";
import { notFound } from "next/navigation";
import { DeleteRecord } from "@/components/records/delete-record";
import { RecordForm } from "@/components/records/record-form";
import { Card } from "@/components/ui";
import { saveRecordAction } from "../../../actions";
import { appContext } from "../../../context";

export default async function RecordPage({ params }: { params: Promise<{ slug: string; app: string; entity: string; id: string }> }) {
  const { slug, app: appSlug, entity: entityKey, id } = await params;
  const { app, entity, workspace, fmt, canEdit } = await appContext(slug, appSlug, entityKey);
  const record = await getRecord(workspace.id, app.slug, entity.key, id);
  if (!record) notFound();
  const base = `/w/${slug}/a/${app.slug}/${entity.key}`;
  const refs = await refOptions(workspace.id, app.slug, entity.fields);
  const titles = await recordTitles(workspace.id, entity.fields.filter((f) => f.type === "ref").map((f) => String(record.data[f.key] ?? "")).filter(Boolean));
  const title = displayTitle(entity, record.data, titles);
  const hasLines = entity.fields.some((f) => f.type === "lines");
  // Records in this app that point at this one, e.g. a company's deals.
  const backlinks = await Promise.all(
    app.entities.flatMap((e) => e.fields.filter((f) => f.type === "ref" && f.ref === entity.key).map((f) => ({ e, f })))
      .map(async ({ e, f }) => ({ e, f, ...(await listRecords(workspace.id, app.slug, e.key, { filter: { [f.key]: id }, limit: 10 })) })),
  );

  return (
    <div className="max-w-3xl">
      <Link href={base} className="text-sm text-accent">← {entity.plural}</Link>
      <Card className="mt-3">
        <div className="mb-5 flex flex-wrap items-start justify-between gap-3">
          <div>
            <h1 className="text-lg font-semibold">{title}</h1>
            <p className="text-xs text-[var(--muted)]">Updated {record.updatedAt.toLocaleString(fmt.locale)}</p>
          </div>
          <div className="flex gap-2">
            {hasLines && <Link href={`${base}/${id}/print`} target="_blank" className="inline-flex h-9 items-center rounded-lg border border-[var(--border)] px-3 text-sm">Print / PDF</Link>}
            {canEdit && <DeleteRecord slug={slug} app={app.slug} entity={entity.key} id={id} back={base} name={entity.name.toLowerCase()} />}
          </div>
        </div>
        <RecordForm entity={entity} values={record.data} refs={refs} action={saveRecordAction.bind(null, slug, app.slug, entity.key, id)}
          cancelHref={base} currency={fmt.currency} locale={fmt.locale} isNew={false} readOnly={!canEdit} />
      </Card>
      {backlinks.filter((b) => b.total > 0).map(({ e, f, rows, total }) => (
        <Card key={`${e.key}.${f.key}`} className="mt-4">
          <h2 className="text-sm font-semibold">{e.plural} <span className="font-normal text-[var(--muted)]">({total}{f.label.toLowerCase() !== entity.name.toLowerCase() ? `, as ${f.label.toLowerCase()}` : ""})</span></h2>
          <ul className="mt-2 divide-y divide-[var(--border)] text-sm">
            {rows.map((r) => (
              <li key={r.id} className="py-1.5"><Link href={`/w/${slug}/a/${app.slug}/${e.key}/${r.id}`} className="text-accent hover:underline">{displayTitle(e, r.data, { [id]: title })}</Link></li>
            ))}
          </ul>
        </Card>
      ))}
    </div>
  );
}
