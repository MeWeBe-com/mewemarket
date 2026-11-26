import { APP_FAQ } from "@/lib/app-faq";
import { SITE_ORIGIN, canonical } from "@/lib/canonical";
import { PLANS, RENAMED_APPS, getAppDef, getCatalogApp, getCategory, legacyAppDirSlug, listCatalogApps } from "@mewe/core";
import { ArrowRight, CalendarDays, Check, Columns3, Sigma, Table2 } from "lucide-react";
import type { Metadata } from "next";
import Link from "next/link";
import { notFound, permanentRedirect } from "next/navigation";
import { AppIcon, tone } from "@/components/app-icon";
import { AppCard } from "@/components/site/app-card";
import { BUTTON_BASE, BUTTON_PRIMARY } from "@/components/ui";

export const revalidate = 3600;

// Search-led titles for the vertical apps people look for by name (charter growth lane 1).
// Every claim must match the app's live feature list. "Free" only on catalog apps the Free plan includes
// (invoices and crm are hosted apps: Free has hostedApps 0, so no "free" there).
const SEARCH_TITLES: Record<string, string> = {
  church: "Free Church Management Software: Members, Services & Giving",
  "driving-school": "Driving School Software: Pupils, Lessons & Test Dates",
  donations: "Free Donor Management Software for Small Charities",
  "care-home": "Care Home Records Software: Residents, Care Notes & Incidents",
  catering: "Catering Management Software: Jobs, Quotes & Staffing",
  salon: "Free Salon Appointment Software & Client Records",
  dental: "Dental Practice Software: Patients, Recalls & Treatment Plans",
  clinic: "Clinic Management Software: Patients, Appointments & Notes",
  invoices: "Invoicing Software for Small Businesses: Invoices, Estimates & Reports",
  crm: "CRM for Small Business: Contacts, Deals & Pipeline",
  "gym-membership": "Free Gym Membership Software: Members, Classes & Renewals",
  hotel: "Free Hotel & Guesthouse Software: Rooms, Reservations & Housekeeping",
  tutoring: "Free Tutoring Software: Students, Lessons & Packages",
  school: "School Records Software: Students, Attendance & Grades",
  "music-lessons": "Free Music Teacher Software: Students, Lessons & Exams",
  volunteers: "Free Volunteer Management Software: Shifts & Hours",
};

export async function generateMetadata({ params }: { params: Promise<{ slug: string }> }): Promise<Metadata> {
  const app = await getCatalogApp((await params).slug);
  if (!app) return {};
  const title = SEARCH_TITLES[app.slug];
  return {
    alternates: canonical(`/apps/${app.slug}`),
    title: title ? { absolute: `${title} | MeweMarket` } : app.name,
    description: `${app.tagline} ${app.description}`.slice(0, 300),
    openGraph: { title: title ?? app.name, url: `${SITE_ORIGIN}/apps/${app.slug}` },
  };
}

export default async function AppPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const app = await getCatalogApp(slug);
  if (!app) {
    const moved = RENAMED_APPS[slug] ?? legacyAppDirSlug(slug);
    if (moved) permanentRedirect(`/apps/${moved}`);
    notFound();
  }
  const category = getCategory(app.category);
  const related = (await listCatalogApps(app.category)).filter((a) => a.slug !== slug).slice(0, 3);
  if (app.tier === "tool") permanentRedirect(`/tools/${app.slug}`);
  const def = getAppDef(app.slug);

  const t = tone(app.category);
  const faq = APP_FAQ[app.slug] ?? [];
  // Hosted apps are not on the Free plan (hostedApps: 0), so only paid plans may be offered or called "included".
  const plansForApp = def?.hosted ? PLANS.filter((p) => p.limits.hostedApps !== 0) : PLANS;
  const includedLabel = def?.hosted ? `Included from the ${plansForApp[0]?.name ?? "Starter"} plan` : "Included in every plan";
  return (
    <div>
      <section className="relative overflow-hidden border-b border-[var(--border)]">
        <div aria-hidden className="bg-grid pointer-events-none absolute inset-0 [mask-image:linear-gradient(to_bottom,black,transparent)]" />
        <div aria-hidden className="pointer-events-none absolute -top-32 right-0 h-96 w-[700px] rounded-full blur-3xl" style={{ background: `${t.from}30` }} />
        <div className="relative mx-auto grid max-w-6xl gap-10 px-4 pb-14 pt-10 lg:grid-cols-[1fr_340px] lg:items-end">
          <div>
            <nav className="text-sm text-[var(--muted)]">
              <Link href="/apps" className="hover:text-[var(--fg)]">Apps</Link>
              {category && <> / <Link href={`/apps/category/${category.slug}`} className="hover:text-[var(--fg)]">{category.name}</Link></>}
            </nav>
            <AppIcon slug={app.slug} name={app.name} category={app.category} size="xl" className="mt-8" />
            <h1 className="mt-6 text-4xl font-extrabold sm:text-5xl">{app.name}</h1>
            <p className="mt-3 text-xl text-[var(--muted)]">{app.tagline}</p>
          </div>
          <aside className="surface p-6 shadow-[var(--shadow-lg)]">
            <p className="text-sm font-semibold" style={{ color: t.text }}>{includedLabel}</p>
            <p className="mt-1 text-sm text-[var(--muted)]">Add it to your workspace in one click, with optional sample data.</p>
            <Link href={`/sign-up?app=${app.slug}`} className={`${BUTTON_BASE} ${BUTTON_PRIMARY} mt-5 h-12 w-full text-base`}>
              Start using {app.name} <ArrowRight className="size-4" />
            </Link>
            <p className="mt-3 text-center text-xs text-[var(--muted)]">Free plan available · 14-day Business trial</p>
            <Link href="/sign-in" className="mt-2 block text-center text-sm font-medium text-accent hover:underline">Already have an account? Sign in</Link>
          </aside>
        </div>
      </section>

      <div className="mx-auto max-w-6xl px-4 py-14">
        <p className="max-w-3xl text-lg leading-relaxed">{app.description}</p>
        <h2 className="mt-12 text-2xl font-bold">Features</h2>
        <ul className="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
          {app.features.map((f) => (
            <li key={f} className="surface flex gap-3 p-4">
              <span className="grid size-6 shrink-0 place-items-center rounded-full" style={{ background: `${t.from}1f`, color: t.from }}><Check className="size-3.5" strokeWidth={3} /></span>{f}
            </li>
          ))}
        </ul>
        {def?.hosted && (
          <div className="surface mt-14 flex flex-wrap items-center gap-x-6 gap-y-2 p-5 text-sm">
            <p className="font-semibold">Powered by {def.hosted.poweredBy}, open source under {def.hosted.license}.</p>
            <a href={def.hosted.sourceUrl} target="_blank" rel="noreferrer" className="font-semibold text-accent hover:underline">Source code</a>
            <p className="w-full text-[var(--muted)]">MeweMarket runs it for you: every company gets its own private space, and your team signs in once through MeweMarket.</p>
          </div>
        )}
        {def && def.entities.length > 0 && (
          <>
            <h2 className="mt-14 text-2xl font-bold">What's inside</h2>
            <p className="mt-2 text-[var(--muted)]">Each section is a list you can view as a table, and where it fits, a board or a calendar.</p>
            <div className="mt-6 grid gap-4 sm:grid-cols-2">
              {def.entities.map((e) => (
                <div key={e.key} className="surface p-5">
                  <div className="flex items-center justify-between gap-3">
                    <p className="text-lg font-bold">{e.plural}</p>
                    <span className="flex gap-1.5 text-[var(--muted)]">
                      <span title="Table"><Table2 className="size-4" /></span>
                      {e.board && <span title="Board"><Columns3 className="size-4" /></span>}
                      {e.calendar && <span title="Calendar"><CalendarDays className="size-4" /></span>}
                      {!!e.totals?.length && <span title="Totals"><Sigma className="size-4" /></span>}
                    </span>
                  </div>
                  <div className="mt-3 flex flex-wrap gap-1.5">
                    {e.fields.map((f) => <span key={f.key} className="rounded-md bg-[var(--bg-subtle)] px-2 py-0.5 text-xs text-[var(--muted)] ring-1 ring-[var(--border)]">{f.label}</span>)}
                  </div>
                </div>
              ))}
            </div>
          </>
        )}
        {faq.length > 0 && (
          <section className="mt-14 max-w-3xl">
            <h2 className="text-2xl font-bold">Questions about {app.name}</h2>
            <div className="mt-5 divide-y divide-[var(--border)] border-y border-[var(--border)]">
              {faq.map((f) => (
                <details key={f.q} className="group py-4">
                  <summary className="cursor-pointer list-none font-semibold">{f.q}</summary>
                  <p className="mt-2 leading-relaxed text-[var(--muted)]">{f.a}</p>
                </details>
              ))}
            </div>
          </section>
        )}
        {related.length > 0 && (
          <section className="mt-20">
            <h2 className="text-2xl font-bold">More {category?.name.toLowerCase()} apps</h2>
            <div className="mt-6 grid gap-4 sm:grid-cols-3">{related.map((a) => <AppCard key={a.slug} app={a} />)}</div>
          </section>
        )}
      </div>
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify({
        "@context": "https://schema.org", "@type": "SoftwareApplication", name: app.name, description: app.description,
        applicationCategory: "BusinessApplication", operatingSystem: "Web",
        url: `${SITE_ORIGIN}/apps/${app.slug}`,
        offers: plansForApp.map((p) => ({ "@type": "Offer", name: `${p.name} plan`, price: (p.priceMonthlyCents / 100).toFixed(2), priceCurrency: "USD", url: `${SITE_ORIGIN}/pricing` })),
      }) }} />
      {faq.length > 0 && (
        <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify({
          "@context": "https://schema.org", "@type": "FAQPage",
          mainEntity: faq.map((f) => ({ "@type": "Question", name: f.q, acceptedAnswer: { "@type": "Answer", text: f.a } })),
        }) }} />
      )}
    </div>
  );
}
