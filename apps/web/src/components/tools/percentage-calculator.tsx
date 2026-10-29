"use client";
import { useState } from "react";
import { Input } from "@/components/ui";
import { fmt, num } from "./shared";

function Row({ children, result }: { children: React.ReactNode; result: string }) {
  return (
    <div className="rounded-lg border border-[var(--border)] p-4">
      <div className="flex flex-wrap items-center gap-2 text-sm">{children}</div>
      <p className="mt-3 text-xl font-semibold" aria-live="polite">{result}</p>
    </div>
  );
}
const N = (p: { label: string; value: string; set: (v: string) => void }) => <Input aria-label={p.label} type="number" className="w-28" value={p.value} onChange={(e) => p.set(e.target.value)} />;

export default function PercentageCalculator() {
  const [a, setA] = useState("15"), [b, setB] = useState("200");
  const [c, setC] = useState("30"), [d, setD] = useState("120");
  const [e, setE] = useState("80"), [f, setF] = useState("100");
  const change = ((num(f) - num(e)) / num(e)) * 100;
  return (
    <div className="space-y-4">
      <Row result={fmt((num(a) / 100) * num(b), 4)}>What is <N label="Percent" value={a} set={setA} /> % of <N label="Number" value={b} set={setB} /> ?</Row>
      <Row result={`${fmt((num(c) / num(d)) * 100, 4)}%`}><N label="Part" value={c} set={setC} /> is what percent of <N label="Whole" value={d} set={setD} /> ?</Row>
      <Row result={`${change > 0 ? "+" : ""}${fmt(change, 4)}% ${change > 0 ? "increase" : change < 0 ? "decrease" : ""}`}>Change from <N label="Old value" value={e} set={setE} /> to <N label="New value" value={f} set={setF} /></Row>
    </div>
  );
}
