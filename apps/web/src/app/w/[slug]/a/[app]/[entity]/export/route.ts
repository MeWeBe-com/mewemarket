import { listRecords, recordTitles } from "@mewe/core";
import { toCsv } from "@/lib/csv";
import { formatValue } from "@/lib/format";
import { appContext } from "../../../context";

export async function GET(_req: Request, { params }: { params: Promise<{ slug: string; app: string; entity: string }> }) {
  const { slug, app: appSlug, entity: entityKey } = await params;
  const { app, entity, workspace, fmt, canEdit } = await appContext(slug, appSlug, entityKey);
  if (!canEdit) return new Response("Guests can't export data.", { status: 403 });
  const { rows } = await listRecords(workspace.id, app.slug, entity.key, { limit: 50_000 });
  const refIds = rows.flatMap((r) => entity.fields.filter((f) => f.type === "ref").map((f) => String(r.data[f.key] ?? ""))).filter(Boolean);
  const refs = await recordTitles(workspace.id, [...new Set(refIds)]);
  // Raw values (not localised) so the file re-imports cleanly; refs by title, lines by total.
  const cell = (f: (typeof entity.fields)[number], v: unknown) =>
    f.type === "ref" || f.type === "lines" ? formatValue(f, v, { ...fmt, refs }) : v === undefined || v === null ? "" : String(v);
  const csv = toCsv(entity.fields.map((f) => f.label), rows.map((r) => entity.fields.map((f) => cell(f, r.data[f.key]))));
  return new Response(csv, {
    headers: { "content-type": "text/csv; charset=utf-8", "content-disposition": `attachment; filename="${app.slug}-${entity.key}.csv"` },
  });
}
