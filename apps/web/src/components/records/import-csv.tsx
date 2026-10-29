"use client";
import { useActionState, useState } from "react";
import { importCsvAction, type FormState } from "@/app/w/[slug]/a/actions";

export function ImportCsv({ slug, app, entity, columns }: { slug: string; app: string; entity: string; columns: string[] }) {
  const [open, setOpen] = useState(false);
  const [state, action, pending] = useActionState<FormState, FormData>(importCsvAction.bind(null, slug, app, entity), null);
  return (
    <>
      <button type="button" onClick={() => setOpen(!open)} aria-expanded={open}
        className="inline-flex h-9 items-center rounded-lg border border-[var(--border)] px-3 text-sm hover:bg-black/5 dark:hover:bg-white/5">Import CSV</button>
      {open && (
        <form action={action} className="w-full space-y-2 rounded-xl border border-[var(--border)] p-4 text-sm">
          <p className="text-[var(--muted)]">First row must be column names. Recognised columns: {columns.join(", ")}.</p>
          <input type="file" name="file" accept=".csv,text/csv" required className="block text-sm" />
          <button disabled={pending} className="h-9 rounded-lg bg-accent px-4 font-semibold text-white disabled:opacity-50">{pending ? "Importing…" : "Import"}</button>
          {state?.message && <p role="status">{state.message}</p>}
        </form>
      )}
    </>
  );
}
