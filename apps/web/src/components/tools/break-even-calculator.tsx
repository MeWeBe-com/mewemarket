"use client";
import { useState } from "react";
import { Field, Input } from "@/components/ui";
import { Stat, fmt, num } from "./shared";

export default function BreakEvenCalculator() {
  const [fixed, setFixed] = useState("10000");
  const [price, setPrice] = useState("50");
  const [variable, setVariable] = useState("30");
  const f = num(fixed), p = num(price), v = num(variable);
  const margin = p - v;
  const ok = margin > 0;
  const units = ok ? f / margin : NaN;
  const rounded = Math.ceil(units);
  const volumes = ok ? [0.5, 0.75, 1, 1.25, 1.5, 2].map((m) => Math.max(0, Math.round(rounded * m))) : [];

  return (
    <div className="space-y-5">
      <div className="grid gap-4 sm:grid-cols-3">
        <Field label="Fixed costs" hint="Rent, salaries, etc."><Input type="number" min={0} value={fixed} onChange={(e) => setFixed(e.target.value)} /></Field>
        <Field label="Price per unit"><Input type="number" min={0} step="0.01" value={price} onChange={(e) => setPrice(e.target.value)} /></Field>
        <Field label="Variable cost per unit"><Input type="number" min={0} step="0.01" value={variable} onChange={(e) => setVariable(e.target.value)} /></Field>
      </div>
      {!ok ? (
        <p role="alert" className="rounded-xl bg-red-500/10 px-3 py-2 text-sm text-red-600 dark:text-red-400">Your price must be higher than the variable cost per unit, otherwise each sale loses money and you can never break even.</p>
      ) : (
        <>
          <div className="grid gap-3 sm:grid-cols-2" aria-live="polite">
            <Stat label="Break-even units" value={fmt(rounded, 0)} />
            <Stat label="Break-even revenue" value={fmt(rounded * p)} />
            <Stat label="Contribution margin per unit" value={fmt(margin)} />
            <Stat label="Contribution margin %" value={p > 0 ? `${fmt((margin / p) * 100)}%` : "-"} />
          </div>
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead><tr className="border-b border-[var(--border)] text-left"><th className="py-2">Units sold</th><th className="text-right">Revenue</th><th className="text-right">Profit / loss</th></tr></thead>
              <tbody>
                {volumes.map((u, i) => {
                  const profit = u * margin - f;
                  return (
                    <tr key={i} className="border-b border-[var(--border)]">
                      <td className="py-2">{fmt(u, 0)}</td>
                      <td className="text-right">{fmt(u * p)}</td>
                      <td className={`text-right font-medium ${profit < 0 ? "text-red-600 dark:text-red-400" : "text-emerald-600 dark:text-emerald-400"}`}>{fmt(profit)}</td>
                    </tr>
                  );
                })}
              </tbody>
            </table>
          </div>
        </>
      )}
    </div>
  );
}
