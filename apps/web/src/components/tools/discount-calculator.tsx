"use client";
import { useState } from "react";
import { Button, Field, Input } from "@/components/ui";
import { Stat, fmt, num } from "./shared";

export default function DiscountCalculator() {
  const [mode, setMode] = useState<"discount" | "reverse">("discount");
  const [price, setPrice] = useState("100");
  const [pct, setPct] = useState("20");
  const [pct2, setPct2] = useState("");
  const [tax, setTax] = useState("");
  const [from, setFrom] = useState("80");
  const [to, setTo] = useState("60");

  const p = num(price);
  const afterFirst = p * (1 - num(pct) / 100);
  const afterDiscounts = afterFirst * (1 - num(pct2) / 100);
  const saved = p - afterDiscounts;
  const taxAmt = afterDiscounts * num(tax) / 100;
  const final = afterDiscounts + taxAmt;
  const effective = p > 0 ? (saved / p) * 100 : 0;

  const a = num(from), b = num(to);
  const revPct = a > 0 ? ((a - b) / a) * 100 : NaN;

  return (
    <div className="space-y-5">
      <div className="flex flex-wrap gap-2">
        <Button type="button" variant={mode === "discount" ? "primary" : "secondary"} aria-pressed={mode === "discount"} onClick={() => setMode("discount")}>Apply a discount</Button>
        <Button type="button" variant={mode === "reverse" ? "primary" : "secondary"} aria-pressed={mode === "reverse"} onClick={() => setMode("reverse")}>Find % off</Button>
      </div>
      {mode === "discount" ? (
        <>
          <div className="grid gap-4 sm:grid-cols-2">
            <Field label="Original price"><Input type="number" min={0} step="0.01" value={price} onChange={(e) => setPrice(e.target.value)} /></Field>
            <Field label="Discount (%)"><Input type="number" min={0} max={100} value={pct} onChange={(e) => setPct(e.target.value)} /></Field>
          </div>
          <div className="flex flex-wrap gap-2">{[5, 10, 15, 20, 25, 30, 40, 50, 70].map((x) => <Button key={x} type="button" variant="ghost" className="h-8 px-3 text-xs" onClick={() => setPct(String(x))}>{x}%</Button>)}</div>
          <div className="grid gap-4 sm:grid-cols-2">
            <Field label="Extra discount (%)" hint="Optional. Applied after the first discount."><Input type="number" min={0} max={100} value={pct2} placeholder="0" onChange={(e) => setPct2(e.target.value)} /></Field>
            <Field label="Sales tax (%)" hint="Optional. Added to the discounted price."><Input type="number" min={0} value={tax} placeholder="0" onChange={(e) => setTax(e.target.value)} /></Field>
          </div>
          <div className="grid gap-3 sm:grid-cols-3" aria-live="polite">
            <Stat label="You save" value={`${fmt(saved)} (${fmt(effective)}%)`} />
            {num(tax) > 0 && <Stat label="Tax" value={fmt(taxAmt)} />}
            <Stat label="Final price" value={fmt(final)} />
          </div>
        </>
      ) : (
        <>
          <div className="grid gap-4 sm:grid-cols-2">
            <Field label="Original price"><Input type="number" min={0} step="0.01" value={from} onChange={(e) => setFrom(e.target.value)} /></Field>
            <Field label="Sale price"><Input type="number" min={0} step="0.01" value={to} onChange={(e) => setTo(e.target.value)} /></Field>
          </div>
          <div className="grid gap-3 sm:grid-cols-2" aria-live="polite">
            <Stat label={revPct < 0 ? "Price increase" : "Discount"} value={Number.isFinite(revPct) ? `${fmt(Math.abs(revPct))}%` : "-"} />
            <Stat label="You save" value={fmt(a - b)} />
          </div>
        </>
      )}
    </div>
  );
}
