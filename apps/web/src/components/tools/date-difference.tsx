"use client";
import { useEffect, useState } from "react";
import { Field, Input } from "@/components/ui";
import { Stat, fmt, num } from "./shared";

const iso = (d: Date) => `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, "0")}-${String(d.getDate()).padStart(2, "0")}`;
const parse = (s: string) => { const [y = 1970, m = 1, d = 1] = s.split("-").map(Number); return new Date(y, m - 1, d); };
const dayDiff = (a: Date, b: Date) => Math.round((Date.UTC(b.getFullYear(), b.getMonth(), b.getDate()) - Date.UTC(a.getFullYear(), a.getMonth(), a.getDate())) / 864e5);

export default function DateDifference() {
  const [start, setStart] = useState("");
  const [end, setEnd] = useState("");
  const [base, setBase] = useState("");
  const [add, setAdd] = useState("30");
  useEffect(() => { const t = new Date(); setStart(iso(t)); setBase(iso(t)); const e = new Date(t); e.setMonth(e.getMonth() + 3); setEnd(iso(e)); }, []);
  const a = start && parse(start), b = end && parse(end);
  const days = a && b ? dayDiff(a, b) : NaN;
  let work = 0;
  if (a && b && Math.abs(days) < 100000) { const [s, e] = days >= 0 ? [a, b] : [b, a]; const d = new Date(s); while (d < e) { const w = d.getDay(); if (w !== 0 && w !== 6) work++; d.setDate(d.getDate() + 1); } }
  const res = base ? (() => { const d = parse(base); d.setDate(d.getDate() + Math.trunc(num(add))); return d; })() : null;
  return (
    <div className="space-y-8">
      <section className="space-y-4">
        <div className="grid gap-4 sm:grid-cols-2">
          <Field label="Start date"><Input type="date" value={start} onChange={(e) => setStart(e.target.value)} /></Field>
          <Field label="End date"><Input type="date" value={end} onChange={(e) => setEnd(e.target.value)} /></Field>
        </div>
        {Number.isFinite(days) && (
          <div className="grid gap-3 sm:grid-cols-4" aria-live="polite">
            <Stat label="Days" value={fmt(days, 0)} />
            <Stat label="Weeks" value={fmt(days / 7, 1)} />
            <Stat label="Working days (Mon to Fri)" value={fmt(work, 0)} />
            <Stat label="Months (approx.)" value={fmt(days / 30.4375, 1)} />
          </div>
        )}
      </section>
      <section className="space-y-4 border-t border-[var(--border)] pt-6">
        <h2 className="font-semibold">Add or subtract days</h2>
        <div className="grid gap-4 sm:grid-cols-2">
          <Field label="From date"><Input type="date" value={base} onChange={(e) => setBase(e.target.value)} /></Field>
          <Field label="Days to add (use minus to subtract)"><Input type="number" value={add} onChange={(e) => setAdd(e.target.value)} /></Field>
        </div>
        {res && !isNaN(res.getTime()) && <Stat label="Result" value={res.toLocaleDateString(undefined, { weekday: "long", year: "numeric", month: "long", day: "numeric" })} />}
      </section>
    </div>
  );
}
