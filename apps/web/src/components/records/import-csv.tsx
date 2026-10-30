"use client";
import { useActionState, useState } from "react";
import { importCsvAction, type FormState } from "@/app/w/[slug]/a/actions";
import { Upload } from "lucide-react";
import { BUTTON_BASE, BUTTON_SECONDARY } from "@/components/ui";

export function ImportCsv({ slug, app, entity, columns }: { slug: string; app: string; entity: string; columns: string[] }) {
  const [open, setOpen] = useState(false);
  const [state, action, pending] = useActionState<FormState, FormData>(importCsvAction.bind(null, slug, app, entity), null);
  return (
    <>
      <button type="button" onClick={() => setOpen(!open)} aria-expanded={open}
        className={`${BUTTON_BASE} ${BUTTON_SECONDARY} h-9 px-3`}><Upload className="size-4" />Import CSV</button>
      {open && (
        <form action={action} className="surface w-full space-y-2 p-4 text-sm">
          <p className="text-[var(--muted)]">First row must be column names. Recognised columns: {columns.join(", ")}.</p>
          <input type="file" name="file" accept=".csv,text/csv" required className="block text-sm" />
          <button disabled={pending} className="h-9 rounded-lg bg-accent px-4 font-semibold text-white disabled:opacity-50">{pending ? "Importing…" : "Import"}</button>
          {state?.message && <p role="status">{state.message}</p>}
        </form>
      )}
    </>
  );
}
