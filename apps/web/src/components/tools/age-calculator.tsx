"use client";
import { useEffect, useState } from "react";
import { Field, Input } from "@/components/ui";
import { Stat, fmt } from "./shared";

function ymd(a: Date, b: Date) {
  let y = b.getFullYear() - a.getFullYear(), m = b.getMonth() - a.getMonth(), d = b.getDate() - a.getDate();
  if (d < 0) { m--; d += new Date(b.getFullYear(), b.getMonth(), 0).getDate(); }
  if (m < 0) { y--; m += 12; }
  return { y, m, d };
}
const iso = (d: Date) => `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, "0")}-${String(d.getDate()).padStart(2, "0")}`;
const parse = (s: string) => { const [y = 1970, m = 1, d = 1] = s.split("-").map(Number); return new Date(y, m - 1, d); };

export default function AgeCalculator() {
  const [dob, setDob] = useState("1990-05-15");
  const [on, setOn] = useState("");
  useEffect(() => setOn(iso(new Date())), []);
  const a = dob ? parse(dob) : null, b = on ? parse(on) : null;
  const ok = a && b && !isNaN(a.getTime()) && !isNaN(b.getTime()) && b >= a;
  let next = 0;
  if (ok) { const n = new Date(b.getFullYear(), a.getMonth(), a.getDate()); if (n < b) n.setFullYear(n.getFullYear() + 1); next = Math.round((n.getTime() - b.getTime()) / 864e5); }
  const r = ok ? ymd(a, b) : null;
  return (
    <div className="space-y-5">
      <div className="grid gap-4 sm:grid-cols-2">
        <Field label="Date of birth"><Input type="date" value={dob} onChange={(e) => setDob(e.target.value)} /></Field>
        <Field label="Age on"><Input type="date" value={on} onChange={(e) => setOn(e.target.value)} /></Field>
      </div>
      {ok && r ? (
        <div className="grid gap-3 sm:grid-cols-3" aria-live="polite">
          <Stat label="Age" value={`${r.y} years, ${r.m} months, ${r.d} days`} />
          <Stat label="Total days" value={fmt(Math.round((b.getTime() - a.getTime()) / 864e5), 0)} />
          <Stat label="Next birthday" value={next === 0 ? "Today!" : `In ${next} days`} />
        </div>
      ) : <p className="text-sm text-[var(--muted)]">Pick a date of birth before the second date.</p>}
    </div>
  );
}
