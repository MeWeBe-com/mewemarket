import type { FieldDef } from "@mewe/core";

export type Fmt = { currency: string; locale: string; refs?: Record<string, string> };

const cents = (n: number) => Math.round(n * 100) / 100;
const linesSum = (v: unknown) =>
  Array.isArray(v) ? cents(v.reduce((s: number, l: { qty?: number; price?: number }) => s + cents((Number(l.qty) || 0) * (Number(l.price) || 0)), 0)) : 0;

export function money(n: number, f: Fmt) {
  try { return new Intl.NumberFormat(f.locale, { style: "currency", currency: f.currency }).format(n); }
  catch { return `${f.currency} ${n.toFixed(2)}`; }
}

/** Human-readable value for tables, cards and CSV. */
export function formatValue(field: FieldDef, v: unknown, f: Fmt): string {
  if (field.type === "lines") return Array.isArray(v) && v.length ? money(linesSum(v), f) : "";
  if (v === undefined || v === null || v === "") return "";
  switch (field.type) {
    case "money": return money(Number(v), f);
    case "number": return Number(v).toLocaleString(f.locale);
    case "percent": return `${v}%`;
    case "bool": return v ? "Yes" : "No";
    case "rating": return "★".repeat(Number(v)) + "☆".repeat(5 - Number(v));
    case "date": return new Date(`${v}T00:00:00`).toLocaleDateString(f.locale, { day: "numeric", month: "short", year: "numeric" });
    case "datetime": return new Date(String(v)).toLocaleString(f.locale, { day: "numeric", month: "short", year: "numeric", hour: "2-digit", minute: "2-digit" });
    case "ref": return f.refs?.[String(v)] ?? "";
    default: return String(v);
  }
}

export { cents, linesSum };
