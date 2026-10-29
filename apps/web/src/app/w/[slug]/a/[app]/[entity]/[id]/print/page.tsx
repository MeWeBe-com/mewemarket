import { getRecord, recordTitles } from "@mewe/core";
import { notFound } from "next/navigation";
import { formatValue, linesSum, money } from "@/lib/format";
import { PrintButton } from "@/components/records/print-button";
import { appContext } from "../../../../context";

type Line = { description: string; qty: number; price: number };

export default async function PrintRecord({ params }: { params: Promise<{ slug: string; app: string; entity: string; id: string }> }) {
  const { slug, app: appSlug, entity: entityKey, id } = await params;
  const { app, entity, workspace, fmt } = await appContext(slug, appSlug, entityKey);
  const record = await getRecord(workspace.id, app.slug, entity.key, id);
  if (!record) notFound();
  const refs = await recordTitles(workspace.id, entity.fields.filter((f) => f.type === "ref").map((f) => String(record.data[f.key] ?? "")).filter(Boolean));
  const f = { ...fmt, refs };
  const linesField = entity.fields.find((x) => x.type === "lines")!;
  const lines = (record.data[linesField.key] as Line[] | undefined) ?? [];
  const subtotal = linesSum(lines);
  const taxField = entity.fields.find((x) => x.type === "percent" && /tax|vat/i.test(x.key));
  const tax = taxField ? subtotal * (Number(record.data[taxField.key]) || 0) / 100 : 0;
  const details = entity.fields.filter((x) => !["lines", "long"].includes(x.type) && x !== taxField && record.data[x.key] !== undefined && record.data[x.key] !== "");
  const notes = entity.fields.filter((x) => x.type === "long" && record.data[x.key]);

  return (
    <div className="mx-auto max-w-3xl bg-white p-10 text-slate-900 print:p-0">
      <div className="mb-8 flex items-start justify-between">
        <div>
          <p className="text-2xl font-bold">{workspace.name}</p>
          <p className="mt-1 text-sm uppercase tracking-widest text-slate-500">{entity.name}</p>
        </div>
        <PrintButton />
      </div>
      <dl className="grid grid-cols-2 gap-x-8 gap-y-2 text-sm">
        {details.map((x) => (
          <div key={x.key} className="flex justify-between border-b border-slate-100 py-1"><dt className="text-slate-500">{x.label}</dt><dd className="font-medium">{formatValue(x, record.data[x.key], f)}</dd></div>
        ))}
      </dl>
      <table className="mt-8 w-full text-sm">
        <thead><tr className="border-b-2 border-slate-900 text-left"><th className="py-2">Description</th><th className="py-2 text-right">Qty</th><th className="py-2 text-right">Price</th><th className="py-2 text-right">Amount</th></tr></thead>
        <tbody>
          {lines.map((l, i) => (
            <tr key={i} className="border-b border-slate-100"><td className="py-2">{l.description}</td><td className="py-2 text-right">{l.qty}</td><td className="py-2 text-right">{money(l.price, f)}</td><td className="py-2 text-right">{money(l.qty * l.price, f)}</td></tr>
          ))}
        </tbody>
        <tfoot className="text-right">
          <tr><td colSpan={3} className="pt-4">Subtotal</td><td className="pt-4">{money(subtotal, f)}</td></tr>
          {taxField && <tr><td colSpan={3}>{taxField.label} ({Number(record.data[taxField.key]) || 0}%)</td><td>{money(tax, f)}</td></tr>}
          <tr className="text-lg font-bold"><td colSpan={3} className="pt-2">Total</td><td className="pt-2">{money(subtotal + tax, f)}</td></tr>
        </tfoot>
      </table>
      {notes.map((x) => <div key={x.key} className="mt-8 text-sm"><p className="font-semibold">{x.label}</p><p className="whitespace-pre-wrap text-slate-600">{String(record.data[x.key])}</p></div>)}
    </div>
  );
}
