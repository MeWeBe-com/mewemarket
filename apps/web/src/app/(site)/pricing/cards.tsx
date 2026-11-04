"use client";
import type { PLANS } from "@mewe/core";
import { Check } from "lucide-react";
import Link from "next/link";
import { useState } from "react";
import { BUTTON_BASE, BUTTON_PRIMARY, BUTTON_SECONDARY } from "@/components/ui";

const HIGHLIGHTS: Record<string, string[]> = {
  free: ["3 users", "3 apps", "1,000 records", "All free tools"],
  starter: ["5 users", "All 100+ apps", "25,000 records", "Pro tools: PDF, bulk images, bulk QR, CSV cleaner"],
  business: ["20 users", "All 100+ apps", "250,000 records", "All Pro tools", "Roles and guest access"],
  scale: ["50 users", "All 100+ apps", "Unlimited records", "All Pro tools", "Priority support"],
};

export function PricingCards({ plans }: { plans: typeof PLANS }) {
  const [yearly, setYearly] = useState(false);
  return (
    <>
      <div className="mt-10 flex justify-center">
        <div role="group" aria-label="Billing period" className="inline-flex rounded-xl border border-[var(--border)] bg-[var(--card)] p-1 text-sm shadow-[var(--shadow-sm)]">
          {[false, true].map((y) => (
            <button key={String(y)} type="button" aria-pressed={yearly === y} onClick={() => setYearly(y)}
              className={`rounded-lg px-4 py-1.5 font-semibold transition ${yearly === y ? "bg-accent text-white shadow-sm" : "text-[var(--muted)] hover:text-[var(--fg)]"}`}>
              {y ? <>Yearly <span className={`ml-1 rounded-full px-1.5 py-0.5 text-[10px] ${yearly ? "bg-white/20" : "bg-emerald-500/15 text-emerald-600"}`}>2 months free</span></> : "Monthly"}
            </button>
          ))}
        </div>
      </div>
      <div className="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        {plans.map((p) => {
          const popular = p.id === "business";
          const cents = yearly ? p.priceYearlyCents / 12 : p.priceMonthlyCents;
          return (
            <div key={p.id} className={`relative flex flex-col rounded-2xl p-6 ${popular ? "bg-[#0b0f24] text-white shadow-[0_30px_60px_-20px_rgb(91_91_246/0.55)] ring-2 ring-accent lg:-my-3 lg:py-9" : "surface"}`}>
              {popular && <span className="absolute -top-3 left-6 rounded-full bg-gradient-to-r from-accent to-fuchsia-500 px-3 py-0.5 text-xs font-bold text-white shadow">Most popular</span>}
              <h3 className="text-lg font-bold">{p.name}</h3>
              <p className="mt-4">
                <span className="font-display text-5xl font-extrabold tracking-tight">${Number.isInteger(cents / 100) ? cents / 100 : (cents / 100).toFixed(2)}</span>
                <span className={`text-sm ${popular ? "text-white/60" : "text-[var(--muted)]"}`}> / month</span>
              </p>
              <p className={`mt-1 h-5 text-xs ${popular ? "text-white/60" : "text-[var(--muted)]"}`}>{p.priceMonthlyCents && yearly ? `$${p.priceYearlyCents / 100} billed yearly` : p.priceMonthlyCents ? "billed monthly" : "free forever"}</p>
              <ul className="mt-6 flex-1 space-y-2 text-sm">
                {HIGHLIGHTS[p.id]?.map((h) => <li key={h} className="flex gap-2"><Check className={`mt-0.5 size-4 shrink-0 ${popular ? "text-emerald-400" : "text-emerald-500"}`} strokeWidth={3} />{h}</li>)}
              </ul>
              <Link href={`/sign-up?plan=${p.id}&interval=${yearly ? "year" : "month"}`}
                className={`${BUTTON_BASE} mt-8 h-11 ${popular ? BUTTON_PRIMARY : BUTTON_SECONDARY}`}>
                {p.id === "free" ? "Start free" : "Start 14-day trial"}
              </Link>
            </div>
          );
        })}
      </div>
    </>
  );
}
