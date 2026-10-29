"use client";
import { useState } from "react";
import { Field, Input } from "@/components/ui";
import { Stat, fmt, num } from "./shared";

export default function LoanCalculator() {
  const [amount, setAmount] = useState("20000");
  const [rate, setRate] = useState("6.5");
  const [years, setYears] = useState("5");
  const P = num(amount), r = num(rate) / 100 / 12, n = Math.round(num(years) * 12);
  const pay = n > 0 ? (r ? (P * r) / (1 - Math.pow(1 + r, -n)) : P / n) : 0;
  const rows: { y: number; interest: number; principal: number; balance: number }[] = [];
  let bal = P;
  for (let m = 1; m <= n && m <= 600; m++) {
    const int = bal * r, pr = pay - int; bal = Math.max(0, bal - pr);
    const y = Math.ceil(m / 12); const row = (rows[y - 1] ??= { y, interest: 0, principal: 0, balance: 0 });
    row.interest += int; row.principal += pr; row.balance = bal;
  }
  return (
    <div className="space-y-5">
      <div className="grid gap-4 sm:grid-cols-3">
        <Field label="Loan amount"><Input type="number" min={0} value={amount} onChange={(e) => setAmount(e.target.value)} /></Field>
        <Field label="Interest rate (% per year)"><Input type="number" min={0} step="0.01" value={rate} onChange={(e) => setRate(e.target.value)} /></Field>
        <Field label="Term (years)"><Input type="number" min={0} step="0.5" value={years} onChange={(e) => setYears(e.target.value)} /></Field>
      </div>
      <div className="grid gap-3 sm:grid-cols-3" aria-live="polite">
        <Stat label="Monthly payment" value={fmt(pay)} />
        <Stat label="Total paid" value={fmt(pay * n)} />
        <Stat label="Total interest" value={fmt(pay * n - P)} />
      </div>
      {rows.length > 0 && (
        <div className="overflow-x-auto"><table className="w-full text-right text-sm"><caption className="mb-2 text-left font-medium">Yearly schedule</caption>
          <thead><tr className="border-b border-[var(--border)]"><th className="py-1 text-left">Year</th><th>Principal</th><th>Interest</th><th>Balance</th></tr></thead>
          <tbody>{rows.map((x) => <tr key={x.y} className="border-b border-[var(--border)]"><td className="py-1 text-left">{x.y}</td><td>{fmt(x.principal)}</td><td>{fmt(x.interest)}</td><td>{fmt(x.balance)}</td></tr>)}</tbody></table></div>
      )}
    </div>
  );
}
