import { CATEGORIES, CORE_SUITE_SLUGS, listCatalogApps } from "@mewe/core";
import { ArrowRight, Boxes, Check, FileSpreadsheet, LayoutGrid, Plus, ShieldCheck, Sparkles, Wrench, Zap } from "lucide-react";
import Link from "next/link";
import { AppIcon, CategoryIcon, tone } from "@/components/app-icon";
import { BUTTON_BASE, BUTTON_PRIMARY, BUTTON_SECONDARY } from "@/components/ui";
import { HeroMock } from "@/components/site/hero-mock";

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
  const tools = apps.filter((a) => a.tier === "tool");
  const marquee = apps.filter((a) => a.tier === "app" && !CORE_SUITE_SLUGS.includes(a.slug)).slice(0, 28);

  return (
    <>
      {/* Hero */}
      <section className="relative overflow-hidden">
        <div aria-hidden className="bg-grid pointer-events-none absolute inset-0 [mask-image:radial-gradient(ellipse_at_top,black_30%,transparent_70%)]" />
        <div aria-hidden className="pointer-events-none absolute left-1/2 top-[-220px] h-[620px] w-[1100px] -translate-x-1/2 rounded-full bg-[conic-gradient(from_180deg_at_50%_50%,#5b5bf633,#a855f733,#ec489926,#06b6d426,#5b5bf633)] blur-3xl" />
        <div className="relative mx-auto max-w-6xl px-4 pt-16 text-center sm:pt-24">
          <Link href="/apps" className="group mx-auto inline-flex items-center gap-2 rounded-full border border-[var(--border)] bg-[var(--card)]/80 py-1 pl-1 pr-3 text-xs font-semibold shadow-[var(--shadow-sm)] backdrop-blur">
            <span className="rounded-full bg-accent px-2 py-0.5 text-white">New</span>
            <Sparkles className="size-3.5 text-accent" /> {appCount} business apps · {toolCount} free tools
            <ArrowRight className="size-3.5 transition group-hover:translate-x-0.5" />
          </Link>
          <h1 className="mx-auto mt-7 max-w-4xl text-[2.6rem] font-extrabold leading-[1.05] sm:text-7xl">
            Every app your business runs on. <span className="text-gradient">One workspace.</span>
          </h1>
          <p className="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-[var(--muted)] sm:text-xl">
            CRM, invoicing, projects, inventory, HR, bookings and {appCount - featured.length} more apps for every kind of business.
            One subscription, one login, all in your browser.
          </p>
          <div className="mt-9 flex flex-col justify-center gap-3 sm:flex-row">
            <Link href="/sign-up" className={`${BUTTON_BASE} ${BUTTON_PRIMARY} h-12 px-7 text-base`}>Start free <ArrowRight className="size-4" /></Link>
            <Link href="/apps" className={`${BUTTON_BASE} ${BUTTON_SECONDARY} h-12 px-7 text-base`}>Browse {appCount} apps</Link>
          </div>
          <p className="mt-5 flex flex-wrap items-center justify-center gap-x-5 gap-y-1 text-sm text-[var(--muted)]">
            {["Free plan forever", "14-day Business trial", "No card needed"].map((t) => <span key={t} className="inline-flex items-center gap-1.5"><Check className="size-4 text-emerald-500" />{t}</span>)}
          </p>
          <HeroMock />
        </div>
      </section>

      {/* App marquee */}
      <section aria-label="Some of the apps" className="mt-16 overflow-hidden border-y border-[var(--border)] bg-[var(--bg-subtle)] py-5 [mask-image:linear-gradient(90deg,transparent,black_10%,black_90%,transparent)]">
        <div className="flex w-max animate-[marquee_60s_linear_infinite] gap-3 hover:[animation-play-state:paused]">
          {[...marquee, ...marquee].map((a, i) => (
            <Link key={`${a.slug}-${i}`} href={`/apps/${a.slug}`} prefetch={false} aria-hidden={i >= marquee.length} tabIndex={i >= marquee.length ? -1 : undefined}
              className="flex shrink-0 items-center gap-2.5 rounded-full border border-[var(--border)] bg-[var(--card)] py-1.5 pl-1.5 pr-4 text-sm font-semibold shadow-[var(--shadow-sm)]">
              <AppIcon slug={a.slug} name={a.name} category={a.category} size="sm" />{a.name}
            </Link>
          ))}
        </div>
      </section>

      {/* Core suite bento */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <SectionHead kicker="The core suite" title="Six apps every business needs, ready on day one"
          body="Start with the essentials, then add specialist apps for your industry from the App Store." />
        <div className="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          {featured.map((a, i) => {
            const t = tone(a.category);
            return (
              <Link key={a.slug} href={`/apps/${a.slug}`}
                className={`surface surface-hover group relative overflow-hidden p-6 ${i === 0 ? "lg:col-span-2 lg:row-span-2 lg:p-8" : ""}`}>
                <div aria-hidden className="absolute -right-16 -top-16 size-56 rounded-full opacity-60 blur-3xl transition group-hover:opacity-90" style={{ background: `${t.from}22` }} />
                <AppIcon slug={a.slug} name={a.name} category={a.category} size={i === 0 ? "lg" : "md"} />
                <h3 className={`relative mt-5 font-bold ${i === 0 ? "text-2xl" : "text-lg"}`}>{a.name}</h3>
                <p className="relative mt-2 text-[var(--muted)]">{a.tagline}</p>
                {i === 0 && (
                  <ul className="relative mt-6 grid gap-2 text-sm sm:grid-cols-2">
                    {a.features.slice(0, 6).map((f) => <li key={f} className="flex gap-2"><Check className="mt-0.5 size-4 shrink-0" style={{ color: t.from }} />{f}</li>)}
                  </ul>
                )}
                <span className="relative mt-5 inline-flex items-center gap-1 text-sm font-semibold" style={{ color: t.text }}>
                  See what's inside <ArrowRight className="size-4 transition group-hover:translate-x-0.5" />
                </span>
              </Link>
            );
          })}
        </div>
      </section>

      {/* How it works */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <div className="relative overflow-hidden rounded-[2rem] bg-[#0b0f24] p-8 text-white sm:p-14">
          <div aria-hidden className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,#5b5bf655,transparent_55%),radial-gradient(ellipse_at_bottom_left,#ec489933,transparent_50%)]" />
          <div className="relative">
            <p className="text-sm font-semibold uppercase tracking-widest text-indigo-300">How it works</p>
            <h2 className="mt-3 max-w-xl text-3xl font-extrabold sm:text-4xl">Up and running in minutes</h2>
            <ol className="mt-12 grid gap-6 md:grid-cols-3">
              {STEPS.map(([title, body], i) => (
                <li key={title} className="rounded-2xl border border-white/10 bg-white/[0.04] p-6 backdrop-blur">
                  <span className="font-display text-5xl font-extrabold text-white/15">0{i + 1}</span>
                  <h3 className="mt-3 text-lg font-bold">{title}</h3>
                  <p className="mt-2 text-sm leading-relaxed text-white/65">{body}</p>
                </li>
              ))}
            </ol>
            <ul className="mt-10 flex flex-wrap gap-2 text-sm">
              {["Tables, boards and calendars", "Search, filters and totals", "Printable invoices and quotes", "CSV import and export", "Calculated fields", "Links between apps"].map((t) => (
                <li key={t} className="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5"><Check className="size-4 text-emerald-400" />{t}</li>
              ))}
            </ul>
          </div>
        </div>
      </section>

      {/* Why */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <SectionHead kicker="Why MeweMarket" title="Replace a stack of subscriptions" />
        <div className="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
          {[
            [LayoutGrid, "One subscription", "Over 100 apps for one price per workspace, instead of a separate bill for every tool.", "#5b5bf6"],
            [Boxes, "Add apps in one click", "Add the apps you need from the App Store as you grow. Remove the ones you don't.", "#a855f7"],
            [FileSpreadsheet, "Leave spreadsheets behind", "Import your spreadsheets in one go and get real forms, search, boards and totals.", "#10b981"],
            [ShieldCheck, "Secure by default", "Roles and permissions, two-factor sign-in and nightly backups.", "#0ea5e9"],
            [Zap, "Fast everywhere", "Works on phone, tablet and desktop, in light or dark mode.", "#f59e0b"],
          ].map(([Icon, title, body, color]) => {
            const I = Icon as typeof Zap;
            return (
              <div key={title as string} className="surface p-5">
                <span className="grid size-10 place-items-center rounded-xl" style={{ background: `${color}1a`, color: color as string }}><I className="size-5" /></span>
                <h3 className="mt-4 font-bold">{title as string}</h3>
                <p className="mt-2 text-sm leading-relaxed text-[var(--muted)]">{body as string}</p>
              </div>
            );
          })}
        </div>
      </section>

      {/* Categories */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <SectionHead kicker="Every industry" title="Apps for every part of your business" link={["/apps", "See all apps"]} />
        <div className="mt-10 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
          {CATEGORIES.map((c) => {
            const list = apps.filter((a) => a.category === c.slug);
            const t = tone(c.slug);
            return (
              <Link key={c.slug} href={`/apps/category/${c.slug}`} className="surface surface-hover group flex min-w-0 items-center gap-4 p-4">
                <span className="grid size-11 shrink-0 place-items-center rounded-xl" style={{ background: `${t.from}1a`, color: t.from }}><CategoryIcon category={c.slug} className="size-5" /></span>
                <span className="min-w-0 flex-1">
                  <span className="block font-bold">{c.name}</span>
                  <span className="block truncate text-xs text-[var(--muted)]">{list.slice(0, 3).map((a) => a.name).join(", ")}</span>
                </span>
                <span className="rounded-full bg-[var(--bg-subtle)] px-2 py-0.5 text-xs font-semibold text-[var(--muted)]">{list.length}</span>
              </Link>
            );
          })}
        </div>
      </section>

      {/* Free tools */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <SectionHead kicker={<><Wrench className="size-4" /> Free, no sign-up</>} title={`${toolCount} free online tools`} link={["/tools", "All tools"]} />
        <div className="mt-10 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
          {tools.slice(0, 15).map((t) => (
            <Link key={t.slug} href={`/tools/${t.slug}`} className="surface surface-hover flex items-center gap-3 p-3 text-sm font-semibold">
              <AppIcon slug={t.slug} name={t.name} category={t.category} size="sm" /><span className="min-w-0 truncate">{t.name}</span>
            </Link>
          ))}
        </div>
      </section>

      {/* FAQ */}
      <section className="mx-auto mt-28 max-w-3xl px-4">
        <SectionHead kicker="FAQ" title="Questions" />
        <div className="mt-10 space-y-3">
          {FAQ.map(([q, a]) => (
            <details key={q} className="surface group px-5 py-4 open:shadow-[var(--shadow-lg)]">
              <summary className="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold">
                {q}<span className="grid size-7 shrink-0 place-items-center rounded-full bg-[var(--bg-subtle)] transition group-open:rotate-45 group-open:bg-accent group-open:text-white"><Plus className="size-4" /></span>
              </summary>
              <p className="mt-3 leading-relaxed text-[var(--muted)]">{a}</p>
            </details>
          ))}
        </div>
      </section>

      {/* CTA */}
      <section className="mx-auto mt-28 max-w-6xl px-4">
        <div className="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#5b5bf6] via-[#7c3aed] to-[#db2777] px-8 py-16 text-center text-white shadow-[0_30px_60px_-20px_rgb(91_91_246/0.6)]">
          <div aria-hidden className="bg-grid absolute inset-0 opacity-30 [mask-image:radial-gradient(ellipse,black,transparent_70%)]" />
          <h2 className="relative text-3xl font-extrabold sm:text-5xl">Set up your workspace in two minutes</h2>
          <p className="relative mx-auto mt-4 max-w-xl text-lg text-white/80">Start on the Free plan or try Business free for 14 days.</p>
          <Link href="/sign-up" className="relative mt-9 inline-flex h-12 items-center gap-2 rounded-xl bg-white px-7 font-semibold text-[#4338ca] shadow-lg transition hover:-translate-y-0.5">
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

function SectionHead({ kicker, title, body, link }: { kicker: React.ReactNode; title: string; body?: string; link?: [string, string] }) {
  return (
    <div className={link ? "flex flex-wrap items-end justify-between gap-4" : "text-center"}>
      <div className={link ? "" : "mx-auto max-w-2xl"}>
        <p className="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-accent">{kicker}</p>
        <h2 className="mt-3 text-3xl font-extrabold sm:text-[2.6rem] sm:leading-tight">{title}</h2>
        {body && <p className="mt-4 text-lg text-[var(--muted)]">{body}</p>}
      </div>
      {link && <Link href={link[0]} className="inline-flex items-center gap-1 font-semibold text-accent hover:underline">{link[1]} <ArrowRight className="size-4" /></Link>}
    </div>
  );
}
