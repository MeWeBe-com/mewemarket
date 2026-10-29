import { CATEGORIES, CORE_SUITE_SLUGS, listCatalogApps } from "@mewe/core";
import { ArrowRight, Boxes, Check, FileSpreadsheet, LayoutGrid, ShieldCheck, Sparkles, Wrench, Zap } from "lucide-react";
import Link from "next/link";
import { AppCard } from "@/components/site/app-card";
import { CategoryIcon } from "@/components/site/category-icon";

export const revalidate = 3600;

const STEPS = [
  ["Pick your apps", "Browse the App Store and add the apps your business needs. Each one is ready in a second, with optional sample data."],
  ["Bring your data", "Type it in, or import a CSV from your spreadsheet. Export everything back to CSV whenever you like."],
  ["Work as a team", "Invite your team with owner, admin, member or read-only guest roles. Everyone sees the same up-to-date records."],
];

const FAQ = [
  ["What is MeweMarket?", "One workspace with the business apps a small company needs: CRM, invoicing, projects, inventory, HR, bookings and a growing catalogue of more. Everything shares the same customers, team and data."],
  ["How many apps are there?", "Over 100 business apps across sales, finance, HR, healthcare, hospitality, education, property, logistics, legal, marketing and community groups, plus 30 free online tools. We add more every month."],
  ["Is there a free plan?", "Yes. The Free plan includes 3 users and 3 apps, forever. Every new workspace also gets a 14-day trial of the Business plan, with no card needed."],
  ["Can I bring my existing data?", "Yes. Import contacts, products and other records from CSV or Excel, by matching column names. You can export any list back to CSV at any time."],
  ["Do the free tools need an account?", "No. Tools such as the invoice generator, QR code generator and whiteboard work in your browser with no sign-up, and your data never leaves your device."],
];

export default async function HomePage() {
  const apps = await listCatalogApps();
  const featured = CORE_SUITE_SLUGS.map((s) => apps.find((a) => a.slug === s)).filter((a) => a !== undefined);
  const appCount = apps.filter((a) => a.tier === "app").length;
  const toolCount = apps.length - appCount;

  return (
    <>
      {/* Hero */}
      <section className="relative overflow-hidden">
        <div aria-hidden className="pointer-events-none absolute inset-x-0 -top-40 h-[480px] bg-[radial-gradient(ellipse_at_top,color-mix(in_srgb,var(--color-accent)_22%,transparent),transparent_65%)]" />
        <div className="relative mx-auto max-w-6xl px-4 pb-20 pt-20 text-center sm:pt-28">
          <p className="mx-auto inline-flex items-center gap-2 rounded-full border border-[var(--border)] bg-[var(--card)] px-3 py-1 text-xs font-medium">
            <Sparkles className="size-3.5 text-accent" /> {appCount} business apps · {toolCount} free tools
          </p>
          <h1 className="mx-auto mt-6 max-w-4xl text-4xl font-bold tracking-tight sm:text-6xl">
            Every app your business runs on. <span className="text-accent">One workspace.</span>
          </h1>
          <p className="mx-auto mt-6 max-w-2xl text-lg text-[var(--muted)]">
            CRM, invoicing, projects, inventory, HR, bookings and {appCount - featured.length} more apps for every kind of business.
            One subscription, one login, all in your browser.
          </p>
          <div className="mt-10 flex flex-col justify-center gap-3 sm:flex-row">
            <Link href="/sign-up" className="inline-flex items-center justify-center gap-2 rounded-lg bg-accent px-6 py-3 font-semibold text-white hover:bg-accent-strong">
              Start free <ArrowRight className="size-4" />
            </Link>
            <Link href="/apps" className="inline-flex items-center justify-center rounded-lg border border-[var(--border)] px-6 py-3 font-semibold hover:bg-black/5 dark:hover:bg-white/5">
              Browse {appCount} apps
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

      {/* How it works */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <div className="rounded-2xl border border-[var(--border)] bg-[var(--bg-subtle)] p-8 sm:p-12">
          <h2 className="text-3xl font-bold tracking-tight">Up and running in minutes</h2>
          <ol className="mt-10 grid gap-8 md:grid-cols-3">
            {STEPS.map(([title, body], i) => (
              <li key={title}>
                <span className="grid size-9 place-items-center rounded-full bg-accent font-bold text-white">{i + 1}</span>
                <h3 className="mt-4 font-semibold">{title}</h3>
                <p className="mt-2 text-sm text-[var(--muted)]">{body}</p>
              </li>
            ))}
          </ol>
          <ul className="mt-10 grid gap-2 text-sm sm:grid-cols-2 lg:grid-cols-4">
            {["Tables, boards and calendars", "Search, filters and totals", "Printable invoices and quotes", "CSV import and export"].map((t) => (
              <li key={t} className="flex gap-2"><Check className="mt-0.5 size-4 shrink-0 text-emerald-500" />{t}</li>
            ))}
          </ul>
        </div>
      </section>

      {/* Free tools */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <div className="flex items-end justify-between gap-4">
          <div>
            <p className="inline-flex items-center gap-2 text-sm font-semibold text-accent"><Wrench className="size-4" /> Free, no sign-up</p>
            <h2 className="mt-2 text-3xl font-bold tracking-tight">{toolCount} free online tools</h2>
          </div>
          <Link href="/tools" className="hidden shrink-0 font-semibold text-accent hover:underline sm:block">All tools</Link>
        </div>
        <div className="mt-8 flex flex-wrap gap-2">
          {apps.filter((a) => a.tier === "tool").map((t) => (
            <Link key={t.slug} href={`/tools/${t.slug}`} className="rounded-full border border-[var(--border)] px-4 py-2 text-sm hover:border-accent/50 hover:text-accent">{t.name}</Link>
          ))}
        </div>
      </section>

      {/* Why */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <h2 className="text-center text-3xl font-bold tracking-tight">Replace a stack of subscriptions</h2>
        <div className="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-5">
          {[
            [LayoutGrid, "One subscription", "Over 100 apps for one price per workspace, instead of a separate bill for every tool."],
            [Boxes, "Add apps in one click", "Add the apps you need from the App Store as you grow. Remove the ones you don't."],
            [FileSpreadsheet, "Leave spreadsheets behind", "Import your spreadsheets in one go and get real forms, search, boards and totals."],
            [ShieldCheck, "Secure by default", "Roles and permissions, two-factor sign-in and nightly backups."], [Zap, "Fast everywhere", "Works on phone, tablet and desktop, in light or dark mode."],
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
