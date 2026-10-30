import { PLANS } from "@mewe/core";
import { Check, Heart, Plus } from "lucide-react";
import type { Metadata } from "next";
import Link from "next/link";
import { PageHero } from "@/components/site/page-hero";
import { PricingCards } from "./cards";

export const metadata: Metadata = {
  title: "Pricing",
  description: "Simple workspace pricing. Free plan forever, Starter $19, Business $49, Scale $129 per month. Save two months with annual billing.",
};

const fmt = (n: number) => (n < 0 ? "Unlimited" : n.toLocaleString("en-US"));

const ROWS: [string, (l: (typeof PLANS)[number]["limits"]) => string][] = [
  ["Users", (l) => fmt(l.users)],
  ["Apps", (l) => (l.apps < 0 ? "All apps" : fmt(l.apps))],
  ["Records", (l) => fmt(l.records)],
  ["Automations", (l) => fmt(l.automations)],
];

const FAQ = [
  ["What counts as a user?", "Anyone you invite to your workspace. Guests (for example clients who only view their invoices) are free on paid plans."],
  ["Can I change plans later?", "Yes, upgrade or downgrade at any time. Changes are prorated automatically."],
  ["Do you offer annual billing?", "Yes. Pay yearly and get two months free."],
  ["What happens when my trial ends?", "Your workspace moves to the Free plan unless you choose a paid plan. Nothing is deleted."],
];

export default function PricingPage() {
  return (
    <>
    <PageHero center eyebrow="Pricing" title={<>Simple pricing for <span className="text-gradient">the whole workspace</span></>}
      intro="One price for all your apps, not per tool. Start free, upgrade when your team grows." />
    <div className="mx-auto max-w-6xl px-4 pb-14">
      <PricingCards plans={PLANS} />

      <section className="mt-24">
        <h2 className="text-2xl font-bold">Compare plans</h2>
        <div className="surface mt-6 overflow-x-auto">
        <table className="w-full min-w-[640px] text-sm [&_td]:px-5 [&_th]:px-5">
          <thead>
            <tr className="border-b border-[var(--border)] bg-[var(--bg-subtle)] text-left">
              <th className="py-3 font-medium text-[var(--muted)]">Feature</th>
              {PLANS.map((p) => <th key={p.id} className="py-3 font-semibold">{p.name}</th>)}
            </tr>
          </thead>
          <tbody>
            {ROWS.map(([label, get]) => (
              <tr key={label} className="border-b border-[var(--border)]">
                <td className="py-3 text-[var(--muted)]">{label}</td>
                {PLANS.map((p) => <td key={p.id} className="py-3">{get(p.limits)}</td>)}
              </tr>
            ))}
            {["REST API and webhooks", "Two-factor sign-in", "Nightly backups"].map((f) => (
              <tr key={f} className="border-b border-[var(--border)]">
                <td className="py-3 text-[var(--muted)]">{f}</td>
                {PLANS.map((p) => <td key={p.id} className="py-3"><Check className="size-4 text-emerald-500" /></td>)}
              </tr>
            ))}
          </tbody>
        </table>
        </div>
        <p className="mt-3 text-xs text-[var(--muted)]">Extra users $5 per month each.</p>
      </section>

      <section id="supporter" className="mt-20 scroll-mt-24 rounded-2xl border border-rose-500/20 bg-gradient-to-br from-rose-500/[0.07] to-fuchsia-500/[0.07] p-8 sm:flex sm:items-center sm:justify-between sm:gap-8">
        <div>
          <p className="inline-flex items-center gap-2 font-semibold"><Heart className="size-4 text-rose-500" /> Supporter · $1 per month</p>
          <p className="mt-2 max-w-xl text-sm text-[var(--muted)]">
            Not ready for a workspace? Support MeweMarket and the open-source projects in our catalogue, and get a supporter badge plus early access to new apps.
          </p>
        </div>
        <Link href="/sign-up?plan=supporter" className="mt-6 inline-flex shrink-0 rounded-xl border border-[var(--border)] bg-[var(--card)] px-5 py-2.5 font-semibold shadow-[var(--shadow-sm)] hover:border-rose-400 sm:mt-0">
          Become a supporter
        </Link>
      </section>

      <section className="mx-auto mt-20 max-w-3xl">
        <h2 className="text-center text-2xl font-bold">Pricing questions</h2>
        <div className="mt-8 space-y-3">
          {FAQ.map(([q, a]) => (
            <details key={q} className="surface group px-5 py-4">
              <summary className="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold">{q}<span className="grid size-7 shrink-0 place-items-center rounded-full bg-[var(--bg-subtle)] transition group-open:rotate-45 group-open:bg-accent group-open:text-white"><Plus className="size-4" /></span></summary>
              <p className="mt-3 text-[var(--muted)]">{a}</p>
            </details>
          ))}
        </div>
      </section>
    </div>
    </>
  );
}
