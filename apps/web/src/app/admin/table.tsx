import type { ReactNode } from "react";

export function Table({ head, rows, empty = "Nothing here yet." }: { head: string[]; rows: ReactNode[][]; empty?: string }) {
  return (
    <div className="overflow-x-auto rounded-xl border border-[var(--border)] bg-[var(--bg)]">
      <table className="w-full text-left text-sm">
        <thead className="border-b border-[var(--border)] text-xs uppercase text-[var(--muted)]">
          <tr>{head.map((h) => <th key={h} className="whitespace-nowrap px-4 py-3 font-semibold">{h}</th>)}</tr>
        </thead>
        <tbody>
          {rows.length ? rows.map((r, i) => (
            <tr key={i} className="border-b border-[var(--border)] last:border-0">{r.map((c, j) => <td key={j} className="whitespace-nowrap px-4 py-3">{c}</td>)}</tr>
          )) : <tr><td colSpan={head.length} className="px-4 py-8 text-center text-[var(--muted)]">{empty}</td></tr>}
        </tbody>
      </table>
    </div>
  );
}

export function Stat({ label, value, hint }: { label: string; value: ReactNode; hint?: ReactNode }) {
  return (
    <div className="rounded-xl border border-[var(--border)] bg-[var(--bg)] p-4">
      <p className="text-xs font-semibold uppercase text-[var(--muted)]">{label}</p>
      <p className="mt-1 text-2xl font-extrabold tabular-nums">{value}</p>
      {hint && <p className="mt-1 text-xs text-[var(--muted)]">{hint}</p>}
    </div>
  );
}

export function Search({ q, placeholder }: { q?: string; placeholder: string }) {
  return (
    <form className="mb-4">
      <input name="q" defaultValue={q} placeholder={placeholder} className="w-full max-w-sm rounded-lg border border-[var(--border)] bg-[var(--bg)] px-3 py-2 text-sm" />
    </form>
  );
}
