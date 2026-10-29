"use client";
import type { PLANS } from "@mewe/core";
import { Check } from "lucide-react";
import Link from "next/link";
import { useState } from "react";

const HIGHLIGHTS: Record<string, string[]> = {
  free: ["3 users", "3 apps", "1,000 records", "All free tools"],
  starter: ["5 users", "All 100+ apps", "25,000 records", "CSV import and export"],
  business: ["20 users", "All 100+ apps", "250,000 records", "Roles and guest access"],
  scale: ["50 users", "All 100+ apps", "Unlimited records", "Priority support"],
};

export function PricingCards({ plans }: { plans: typeof PLANS }) {
  const [yearly, setYearly] = useState(false);
  return (
    <>
      <div className="mt-10 flex justify-center">
        <div role="group" aria-label="Billing period" className="inline-flex rounded-lg border border-[var(--border)] p-1 text-sm">
          {[false, true].map((y) => (
            <button key={String(y)} type="button" aria-pressed={yearly === y} onClick={() => setYearly(y)}
              className={`rounded-md px-4 py-1.5 font-medium ${yearly === y ? "bg-accent text-white" : "text-[var(--muted)]"}`}>
              {y ? "Yearly · 2 months free" : "Monthly"}
            </button>
          ))}
        </div>
      </div>
      <div className="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        {plans.map((p) => {
          const popular = p.id === "business";
          const cents = yearly ? p.priceYearlyCents / 12 : p.priceMonthlyCents;
          return (
            <div key={p.id} className={`relative flex flex-col rounded-2xl border p-6 ${popular ? "border-accent shadow-xl shadow-accent/10" : "border-[var(--border)]"}`}>
              {popular && <span className="absolute -top-3 left-6 rounded-full bg-accent px-3 py-0.5 text-xs font-semibold text-white">Most popular</span>}
              <h3 className="font-semibold">{p.name}</h3>
              <p className="mt-4">
                <span className="text-4xl font-bold">${Number.isInteger(cents / 100) ? cents / 100 : (cents / 100).toFixed(2)}</span>
                <span className="text-sm text-[var(--muted)]"> / month</span>
              </p>
              <p className="mt-1 h-5 text-xs text-[var(--muted)]">{p.priceMonthlyCents && yearly ? `$${p.priceYearlyCents / 100} billed yearly` : p.priceMonthlyCents ? "billed monthly" : "free forever"}</p>
              <ul className="mt-6 flex-1 space-y-2 text-sm">
                {HIGHLIGHTS[p.id]?.map((h) => <li key={h} className="flex gap-2"><Check className="mt-0.5 size-4 shrink-0 text-emerald-500" />{h}</li>)}
              </ul>
              <Link href={`/sign-up?plan=${p.id}&interval=${yearly ? "year" : "month"}`}
                className={`mt-8 rounded-lg px-4 py-2.5 text-center font-semibold ${popular ? "bg-accent text-white hover:bg-accent-strong" : "border border-[var(--border)] hover:border-accent"}`}>
                {p.id === "free" ? "Start free" : "Start 14-day trial"}
              </Link>
            </div>
          );
        })}
      </div>
    </>
  );
}
