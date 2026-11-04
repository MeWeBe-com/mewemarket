"use client";
import { useState } from "react";
import { Field, Input } from "@/components/ui";
import { Select, Stat, fmt, num } from "./shared";

type Period = "hourly" | "daily" | "weekly" | "monthly" | "yearly";
const LABELS: Record<Period, string> = { hourly: "Hourly", daily: "Daily", weekly: "Weekly", monthly: "Monthly", yearly: "Yearly" };

export default function SalaryConverter() {
  const [amount, setAmount] = useState("50000");
  const [period, setPeriod] = useState<Period>("yearly");
  const [hours, setHours] = useState("40");
  const [days, setDays] = useState("5");
  const [weeks, setWeeks] = useState("52");
  const h = num(hours), d = num(days), w = num(weeks);
  // Yearly multiplier for each period.
  const perYear: Record<Period, number> = { hourly: h * w, daily: d * w, weekly: w, monthly: 12, yearly: 1 };
  const yearly = perYear[period] > 0 ? num(amount) * perYear[period] : NaN;

  return (
    <div className="space-y-5">
      <div className="grid gap-4 sm:grid-cols-2">
        <Field label="Amount"><Input type="number" min={0} step="0.01" value={amount} onChange={(e) => setAmount(e.target.value)} /></Field>
        <Field label="Paid"><Select value={period} onChange={(e) => setPeriod(e.target.value as Period)}>{(Object.keys(LABELS) as Period[]).map((p) => <option key={p} value={p}>{LABELS[p]}</option>)}</Select></Field>
      </div>
      <div className="grid gap-4 sm:grid-cols-3">
        <Field label="Hours per week"><Input type="number" min={0} value={hours} onChange={(e) => setHours(e.target.value)} /></Field>
        <Field label="Days per week"><Input type="number" min={0} max={7} value={days} onChange={(e) => setDays(e.target.value)} /></Field>
        <Field label="Weeks per year"><Input type="number" min={0} max={53} value={weeks} onChange={(e) => setWeeks(e.target.value)} /></Field>
      </div>
      <div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-3" aria-live="polite">
        {(Object.keys(LABELS) as Period[]).map((p) => (
          <Stat key={p} label={LABELS[p]} value={perYear[p] > 0 ? fmt(yearly / perYear[p]) : "-"} />
        ))}
      </div>
    </div>
  );
}
