import { CATEGORIES, listCatalogApps } from "@mewe/core";
import { ArrowRight, Bot, Boxes, Check, LayoutGrid, ShieldCheck, Sparkles, Zap } from "lucide-react";
import Link from "next/link";
import { AppCard } from "@/components/site/app-card";
import { CategoryIcon } from "@/components/site/category-icon";

export const revalidate = 3600;

const PROMPTS = [
  "Create an invoice for Acme Ltd for 10 hours at £80 and email it to them.",
  "Which customers haven't paid this month?",
  "Book John in for a consultation on Thursday at 3pm.",
  "Add these 20 contacts from my spreadsheet to the CRM.",
];

const FAQ = [
  ["What is MeweMarket?", "One workspace with the business apps a small company needs: CRM, invoicing, projects, inventory, HR, bookings and a growing catalogue of more. Everything shares the same customers, team and data."],
  ["What does \"works with your AI assistant\" mean?", "Each workspace has a secure MCP connection. Add it to Claude, ChatGPT or Gemini once, and you can ask the assistant to create invoices, look up customers or book appointments. It only does what your account is allowed to do, and every action is logged."],
  ["Is there a free plan?", "Yes. The Free plan includes 3 users and 3 apps, forever. Every new workspace also gets a 14-day trial of the Business plan, with no card needed."],
  ["Can I bring my existing data?", "Yes. Import contacts, products and other records from CSV or Excel, with column mapping and a preview before anything is saved."],
  ["What are the open-source apps?", "Well-known open-source tools such as Kanboard, Kimai and Jitsi, set up for you in one click with the same login. We credit every project and link to its source code."],
];

export default async function HomePage() {
  const apps = await listCatalogApps();
  const featured = apps.filter((a) => a.tier === "native");

  return (
    <>
      {/* Hero */}
      <section className="relative overflow-hidden">
        <div aria-hidden className="pointer-events-none absolute inset-x-0 -top-40 h-[480px] bg-[radial-gradient(ellipse_at_top,color-mix(in_srgb,var(--color-accent)_22%,transparent),transparent_65%)]" />
        <div className="relative mx-auto max-w-6xl px-4 pb-20 pt-20 text-center sm:pt-28">
          <p className="mx-auto inline-flex items-center gap-2 rounded-full border border-[var(--border)] bg-[var(--card)] px-3 py-1 text-xs font-medium">
            <Sparkles className="size-3.5 text-accent" /> Works with Claude, ChatGPT and Gemini
          </p>
          <h1 className="mx-auto mt-6 max-w-4xl text-4xl font-bold tracking-tight sm:text-6xl">
            Every app your business runs on. <span className="text-accent">One workspace.</span>
          </h1>
          <p className="mx-auto mt-6 max-w-2xl text-lg text-[var(--muted)]">
            CRM, invoicing, projects, inventory, HR, bookings and {apps.length - featured.length}+ more apps that share your data.
            Use it in your browser, or just ask your AI assistant to do the work for you.
          </p>
          <div className="mt-10 flex flex-col justify-center gap-3 sm:flex-row">
            <Link href="/sign-up" className="inline-flex items-center justify-center gap-2 rounded-lg bg-accent px-6 py-3 font-semibold text-white hover:bg-accent-strong">
              Start free <ArrowRight className="size-4" />
            </Link>
            <Link href="/apps" className="inline-flex items-center justify-center rounded-lg border border-[var(--border)] px-6 py-3 font-semibold hover:bg-black/5 dark:hover:bg-white/5">
              Browse {apps.length} apps
            </Link>
          </div>
          <p className="mt-4 text-sm text-[var(--muted)]">Free plan forever · 14-day Business trial · No card needed</p>
        </div>
      </section>

      {/* Flagship apps */}
      <section className="mx-auto max-w-6xl px-4">
        <h2 className="text-center text-sm font-semibold uppercase tracking-wide text-[var(--muted)]">The core suite</h2>
        <div className="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          {featured.map((a) => <AppCard key={a.slug} app={a} />)}
        </div>
      </section>

      {/* AI section */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <div className="grid items-center gap-12 rounded-2xl border border-[var(--border)] bg-[var(--bg-subtle)] p-8 sm:p-12 lg:grid-cols-2">
          <div>
            <p className="inline-flex items-center gap-2 text-sm font-semibold text-accent"><Bot className="size-4" /> Built for AI assistants</p>
            <h2 className="mt-3 text-3xl font-bold tracking-tight">Just ask. Your assistant does the work.</h2>
            <p className="mt-4 text-[var(--muted)]">
              Connect your workspace to Claude, ChatGPT or Gemini in a minute. Your assistant can then create invoices,
              update deals and book appointments for real, inside MeweMarket, with the same permissions as your account.
            </p>
            <ul className="mt-6 space-y-2 text-sm">
              {["Secure connection you can revoke at any time", "Every action logged in your activity history", "Also available as a REST API for developers"].map((t) => (
                <li key={t} className="flex gap-2"><Check className="mt-0.5 size-4 shrink-0 text-emerald-500" />{t}</li>
              ))}
            </ul>
            <Link href="/ai" className="mt-8 inline-flex items-center gap-1 font-semibold text-accent hover:underline">How it works <ArrowRight className="size-4" /></Link>
          </div>
          <div className="space-y-3">
            {PROMPTS.map((p, i) => (
              <div key={p} className={`rounded-xl border border-[var(--border)] bg-[var(--card)] p-4 text-sm shadow-sm ${i % 2 ? "sm:ml-10" : "sm:mr-10"}`}>
                <span className="mr-2 font-semibold text-accent">You:</span>{p}
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Why */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <h2 className="text-center text-3xl font-bold tracking-tight">Replace a stack of subscriptions</h2>
        <div className="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
          {[
            [LayoutGrid, "One shared database", "Customers, products and people are shared across every app. No more copying data between tools."],
            [Boxes, "Install apps in one click", "Add the apps you need from the catalogue as you grow. Remove the ones you don't."],
            [Zap, "Automations", "When an invoice is paid, update the deal and thank the customer, automatically."],
            [ShieldCheck, "Secure by default", "Roles and permissions, two-factor sign-in, and nightly backups."],
          ].map(([Icon, title, body]) => {
            const I = Icon as typeof Zap;
            return (
              <div key={title as string}>
                <I className="size-6 text-accent" />
                <h3 className="mt-3 font-semibold">{title as string}</h3>
                <p className="mt-2 text-sm text-[var(--muted)]">{body as string}</p>
              </div>
            );
          })}
        </div>
      </section>

      {/* Categories */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <div className="flex items-end justify-between gap-4">
          <h2 className="text-3xl font-bold tracking-tight">Apps for every part of your business</h2>
          <Link href="/apps" className="hidden shrink-0 font-semibold text-accent hover:underline sm:block">See all apps</Link>
        </div>
        <div className="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
          {CATEGORIES.map((c) => {
            const count = apps.filter((a) => a.category === c.slug).length;
            return (
              <Link key={c.slug} href={`/apps/category/${c.slug}`}
                className="flex items-center gap-3 rounded-xl border border-[var(--border)] p-4 hover:border-accent/50">
                <CategoryIcon name={c.icon} className="size-5 text-accent" />
                <span className="flex-1 font-medium">{c.name}</span>
                <span className="text-xs text-[var(--muted)]">{count}</span>
              </Link>
            );
          })}
        </div>
      </section>

      {/* FAQ */}
      <section className="mx-auto mt-28 max-w-3xl px-4">
        <h2 className="text-center text-3xl font-bold tracking-tight">Questions</h2>
        <div className="mt-10 divide-y divide-[var(--border)] border-y border-[var(--border)]">
          {FAQ.map(([q, a]) => (
            <details key={q} className="group py-4">
              <summary className="flex cursor-pointer list-none items-center justify-between font-medium">
                {q}<span className="text-[var(--muted)] transition group-open:rotate-45">+</span>
              </summary>
              <p className="mt-3 text-[var(--muted)]">{a}</p>
            </details>
          ))}
        </div>
      </section>

      {/* CTA */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <div className="rounded-2xl bg-accent px-8 py-14 text-center text-white">
          <h2 className="text-3xl font-bold tracking-tight">Set up your workspace in two minutes</h2>
          <p className="mx-auto mt-3 max-w-xl text-white/80">Start on the Free plan or try Business free for 14 days.</p>
          <Link href="/sign-up" className="mt-8 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 font-semibold text-accent hover:bg-white/90">
            Start free <ArrowRight className="size-4" />
          </Link>
        </div>
      </section>

      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify({
        "@context": "https://schema.org", "@type": "FAQPage",
        mainEntity: FAQ.map(([q, a]) => ({ "@type": "Question", name: q, acceptedAnswer: { "@type": "Answer", text: a } })),
      }) }} />
    </>
  );
}
