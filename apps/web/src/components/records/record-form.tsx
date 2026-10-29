"use client";
import type { EntityDef, FieldDef } from "@mewe/core";
import Link from "next/link";
import { useActionState, useState } from "react";
import type { FormState } from "@/app/w/[slug]/a/actions";
import { Alert, Button, Input } from "@/components/ui";
import { money } from "@/lib/format";

type Line = { description: string; qty: number; price: number };
type Props = {
  entity: EntityDef;
  values: Record<string, unknown>;
  refs: Record<string, { id: string; title: string }[]>;
  action: (prev: FormState, form: FormData) => Promise<FormState>;
  cancelHref: string;
  currency: string;
  locale: string;
  isNew: boolean;
  readOnly: boolean;
};

const box = "w-full rounded-lg border border-[var(--border)] bg-transparent px-3 text-sm outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 disabled:opacity-70";

export function RecordForm({ entity, values, refs, action, cancelHref, currency, locale, isNew, readOnly }: Props) {
  const [state, formAction, pending] = useActionState(action, null);
  return (
    <form action={formAction} className="space-y-5">
      {state?.message && <Alert tone={state.errors ? "error" : "error"}>{state.message}</Alert>}
      <fieldset disabled={readOnly} className="grid gap-5 sm:grid-cols-2">
        {entity.fields.map((f) => (
          <div key={f.key} className={f.type === "long" || f.type === "lines" ? "sm:col-span-2" : ""}>
            <label htmlFor={`f-${f.key}`} className="mb-1.5 block text-sm font-medium">
              {f.label}{f.required && <span className="text-red-500"> *</span>}
            </label>
            <Control field={f} value={values[f.key]} refs={refs[f.ref ?? ""] ?? []} currency={currency} locale={locale} />
            {state?.errors?.[f.key] && <p className="mt-1 text-xs text-red-600 dark:text-red-400">{state.errors[f.key]}</p>}
          </div>
        ))}
      </fieldset>
      {!readOnly && (
        <div className="flex flex-wrap gap-2 border-t border-[var(--border)] pt-5">
          <Button type="submit" disabled={pending}>{pending ? "Saving…" : isNew ? `Create ${entity.name.toLowerCase()}` : "Save changes"}</Button>
          {isNew && <Button type="submit" name="_next" value="new" variant="secondary" disabled={pending}>Save and add another</Button>}
          <Link href={cancelHref} className="inline-flex h-10 items-center px-3 text-sm text-[var(--muted)] hover:underline">Cancel</Link>
        </div>
      )}
    </form>
  );
}

function Control({ field: f, value, refs, currency, locale }: { field: FieldDef; value: unknown; refs: { id: string; title: string }[]; currency: string; locale: string }) {
  const id = `f-${f.key}`;
  const v = value === undefined || value === null ? "" : String(value);
  const common = { id, name: f.key, required: f.required, defaultValue: v };
  switch (f.type) {
    case "long": return <textarea {...common} rows={4} className={`${box} py-2`} />;
    case "number": return <Input {...common} type="number" step="any" />;
    case "money": return <Input {...common} type="number" step="0.01" placeholder={currency} />;
    case "percent": return <Input {...common} type="number" step="0.01" min={0} max={100} placeholder="%" />;
    case "rating": return (
      <select {...common} className={`${box} h-10`}>
        <option value="">No rating</option>
        {[1, 2, 3, 4, 5].map((n) => <option key={n} value={n}>{"★".repeat(n)}</option>)}
      </select>
    );
    case "date": return <Input {...common} type="date" />;
    case "datetime": return <Input {...common} type="datetime-local" />;
    case "time": return <Input {...common} type="time" />;
    case "email": return <Input {...common} type="email" autoComplete="off" />;
    case "phone": return <Input {...common} type="tel" />;
    case "url": return <Input {...common} type="text" inputMode="url" placeholder="https://" />;
    case "bool": return (
      <label className="flex h-10 items-center gap-2 text-sm">
        <input id={id} name={f.key} type="checkbox" defaultChecked={value === true} className="size-4 accent-[var(--color-accent)]" /> Yes
      </label>
    );
    case "select": return (
      <select {...common} className={`${box} h-10`}>
        {!f.required && <option value="">—</option>}
        {f.options!.map((o) => <option key={o}>{o}</option>)}
      </select>
    );
    case "ref": return (
      <select {...common} className={`${box} h-10`}>
        <option value="">{refs.length ? "— Choose —" : "Nothing to choose yet"}</option>
        {refs.map((o) => <option key={o.id} value={o.id}>{o.title}</option>)}
      </select>
    );
    case "lines": return <LinesEditor name={f.key} initial={Array.isArray(value) ? (value as Line[]) : []} currency={currency} locale={locale} />;
    default: return <Input {...common} type="text" />;
  }
}

function LinesEditor({ name, initial, currency, locale }: { name: string; initial: Line[]; currency: string; locale: string }) {
  const [lines, setLines] = useState<Line[]>(initial.length ? initial : [{ description: "", qty: 1, price: 0 }]);
  const set = (i: number, patch: Partial<Line>) => setLines(lines.map((l, j) => (j === i ? { ...l, ...patch } : l)));
  const total = lines.reduce((s, l) => s + (Number(l.qty) || 0) * (Number(l.price) || 0), 0);
  const fmt = { currency, locale };
  return (
    <div className="rounded-lg border border-[var(--border)]">
      <input type="hidden" name={name} value={JSON.stringify(lines)} />
      <div className="hidden grid-cols-[1fr_5rem_7rem_7rem_2rem] gap-2 border-b border-[var(--border)] px-3 py-2 text-xs font-medium text-[var(--muted)] sm:grid">
        <span>Description</span><span>Qty</span><span>Price</span><span className="text-right">Amount</span><span />
      </div>
      {lines.map((l, i) => (
        <div key={i} className="grid grid-cols-[1fr_4rem_6rem_2rem] gap-2 border-b border-[var(--border)] px-3 py-2 sm:grid-cols-[1fr_5rem_7rem_7rem_2rem]">
          <Input aria-label="Description" value={l.description} onChange={(e) => set(i, { description: e.target.value })} className="col-span-4 sm:col-span-1" />
          <Input aria-label="Quantity" type="number" step="any" value={l.qty} onChange={(e) => set(i, { qty: Number(e.target.value) })} />
          <Input aria-label="Price" type="number" step="0.01" value={l.price} onChange={(e) => set(i, { price: Number(e.target.value) })} />
          <span className="hidden self-center text-right text-sm tabular-nums sm:block">{money((Number(l.qty) || 0) * (Number(l.price) || 0), fmt)}</span>
          <button type="button" aria-label="Remove line" onClick={() => setLines(lines.filter((_, j) => j !== i))} className="self-center text-[var(--muted)] hover:text-red-500">×</button>
        </div>
      ))}
      <div className="flex items-center justify-between px-3 py-2">
        <button type="button" onClick={() => setLines([...lines, { description: "", qty: 1, price: 0 }])} className="text-sm font-medium text-accent hover:underline">+ Add line</button>
        <span className="text-sm font-semibold tabular-nums">Subtotal {money(total, fmt)}</span>
      </div>
    </div>
  );
}
