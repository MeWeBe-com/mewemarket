"use client";
import { useState } from "react";
import { Button, Field, Input } from "@/components/ui";
import { Stat, fmt, num } from "./shared";

export default function VatCalculator() {
  const [amount, setAmount] = useState("100");
  const [rate, setRate] = useState("20");
  const [mode, setMode] = useState<"add" | "remove">("add");
  const a = num(amount), r = num(rate) / 100;
  const net = mode === "add" ? a : a / (1 + r), gross = mode === "add" ? a * (1 + r) : a;
  return (
    <div className="space-y-5">
      <div className="flex gap-2">
        <Button type="button" variant={mode === "add" ? "primary" : "secondary"} aria-pressed={mode === "add"} onClick={() => setMode("add")}>Add tax</Button>
        <Button type="button" variant={mode === "remove" ? "primary" : "secondary"} aria-pressed={mode === "remove"} onClick={() => setMode("remove")}>Remove tax</Button>
      </div>
      <div className="grid gap-4 sm:grid-cols-2">
        <Field label={mode === "add" ? "Price without tax" : "Price with tax"}><Input type="number" min={0} value={amount} onChange={(e) => setAmount(e.target.value)} /></Field>
        <Field label="Tax rate (%)"><Input type="number" min={0} step="0.01" value={rate} onChange={(e) => setRate(e.target.value)} /></Field>
      </div>
      <div className="flex flex-wrap gap-2">{[5, 7.5, 10, 15, 19, 20, 21, 25].map((x) => <Button key={x} type="button" variant="ghost" className="h-8 px-3 text-xs" onClick={() => setRate(String(x))}>{x}%</Button>)}</div>
      <div className="grid gap-3 sm:grid-cols-3" aria-live="polite">
        <Stat label="Net (without tax)" value={fmt(net)} />
        <Stat label="Tax" value={fmt(gross - net)} />
        <Stat label="Gross (with tax)" value={fmt(gross)} />
      </div>
    </div>
  );
}
