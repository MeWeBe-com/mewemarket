import { refOptions } from "@mewe/core";
import { redirect } from "next/navigation";
import { RecordForm } from "@/components/records/record-form";
import { Alert, Card } from "@/components/ui";
import { saveRecordAction } from "../../../actions";
import { appContext } from "../../../context";

export default async function NewRecord({ params, searchParams }: { params: Promise<{ slug: string; app: string; entity: string }>; searchParams: Promise<{ saved?: string }> }) {
  const { slug, app: appSlug, entity: entityKey } = await params;
  const { saved } = await searchParams;
  const { app, entity, workspace, fmt, canEdit } = await appContext(slug, appSlug, entityKey);
  const base = `/${slug}/${app.slug}/${entity.key}`;
  if (!canEdit) redirect(base);
  const refs = await refOptions(workspace.id, app.slug, entity.fields);
  const defaults = Object.fromEntries(entity.fields.filter((f) => f.type === "select" && f.required).map((f) => [f.key, f.options![0]]));
  return (
    <Card className="max-w-3xl p-6 sm:p-8">
      <h1 className="mb-6 text-2xl font-extrabold">New {entity.name.toLowerCase()}</h1>
      {saved && <div className="mb-4"><Alert tone="success">Saved. Add another below.</Alert></div>}
      <RecordForm entity={entity} values={defaults} refs={refs} action={saveRecordAction.bind(null, slug, app.slug, entity.key, null)}
        cancelHref={base} currency={fmt.currency} locale={fmt.locale} isNew readOnly={false} slug={slug} />
    </Card>
  );
}
