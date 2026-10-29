"use client";
import { useState } from "react";
import { Field, Input } from "@/components/ui";
import { Stat, fmt, num } from "./shared";

export default function ProfitMarginCalculator() {
  const [cost, setCost] = useState("60");
  const [price, setPrice] = useState("100");
  const [target, setTarget] = useState("40");
  const c = num(cost), p = num(price), profit = p - c;
  const t = num(target);
  return (
    <div className="space-y-6">
      <div className="grid gap-4 sm:grid-cols-2">
        <Field label="Cost"><Input type="number" min={0} value={cost} onChange={(e) => setCost(e.target.value)} /></Field>
        <Field label="Selling price"><Input type="number" min={0} value={price} onChange={(e) => setPrice(e.target.value)} /></Field>
      </div>
      <div className="grid gap-3 sm:grid-cols-3" aria-live="polite">
        <Stat label="Profit" value={fmt(profit)} />
        <Stat label="Margin" value={p ? `${fmt((profit / p) * 100)}%` : "-"} />
        <Stat label="Markup" value={c ? `${fmt((profit / c) * 100)}%` : "-"} />
      </div>
      <div className="space-y-3 border-t border-[var(--border)] pt-5">
        <div className="max-w-xs"><Field label="Target margin (%)"><Input type="number" min={0} max={99.99} value={target} onChange={(e) => setTarget(e.target.value)} /></Field></div>
        <p className="text-sm">To make a {fmt(t)}% margin on a cost of {fmt(c)}, sell for <strong className="text-lg">{t < 100 ? fmt(c / (1 - t / 100)) : "-"}</strong>.</p>
      </div>
    </div>
  );
}
