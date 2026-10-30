import { entityCounts, getSubscription, listInstalledApps, listMembers } from "@mewe/core";
import { ArrowRight, Check, Database, LayoutGrid, Plus, Sparkles, Users } from "lucide-react";
import Link from "next/link";
import { AppIcon } from "@/components/app-icon";
import { BUTTON_BASE, Card } from "@/components/ui";
import { requireWorkspace } from "@/lib/session";

export default async function WorkspaceHome({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const { session, workspace } = await requireWorkspace(slug);
  const [members, installed, sub] = await Promise.all([listMembers(workspace.id), listInstalledApps(workspace.id), getSubscription(workspace.id)]);
  const counts = await Promise.all(installed.map((a) => entityCounts(workspace.id, a.slug)));
  const perApp = counts.map((c) => Object.values(c).reduce((s, n) => s + (n ?? 0), 0));
  const records = perApp.reduce((s, n) => s + n, 0);

  const steps = [
    { done: true, label: "Create your workspace", href: null },
    { done: installed.length > 0, label: "Add your first app", href: `/w/${slug}/apps` },
    { done: members.length > 1, label: "Invite your team", href: `/w/${slug}/settings/members` },
    { done: session.user.twoFactorEnabled === true, label: "Turn on two-factor authentication", href: "/account" },
  ];
  const doneCount = steps.filter((s) => s.done).length;
  const hour = new Date().getHours();
  const greeting = hour < 12 ? "Good morning" : hour < 18 ? "Good afternoon" : "Good evening";

  const stats = [
    { label: "Apps", value: installed.length, icon: LayoutGrid, color: "#5b5bf6", href: `/w/${slug}/apps` },
    { label: "Records", value: records.toLocaleString(), icon: Database, color: "#10b981", href: null },
    { label: "Members", value: members.length, icon: Users, color: "#0ea5e9", href: `/w/${slug}/settings/members` },
    { label: "Plan", value: sub?.plan.name ?? "Free", icon: Sparkles, color: "#ec4899", href: `/w/${slug}/billing` },
  ];

  return (
    <>
      <section className="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#5b5bf6] via-[#7c3aed] to-[#c026d3] p-7 text-white shadow-[0_20px_50px_-20px_rgb(91_91_246/0.7)] sm:p-9">
        <div aria-hidden className="bg-grid absolute inset-0 opacity-25 [mask-image:linear-gradient(to_left,black,transparent)]" />
        <p className="relative text-sm font-semibold text-white/70">{workspace.name}</p>
        <h1 className="relative mt-1 text-3xl font-extrabold sm:text-4xl">{greeting}, {session.user.name.split(" ")[0]}</h1>
        <p className="relative mt-2 max-w-lg text-white/80">Everything your team works on, in one place. Pick an app below or add a new one from the App Store.</p>
        <Link href={`/w/${slug}/apps`} className={`${BUTTON_BASE} relative mt-6 bg-white text-[#4338ca] shadow-lg hover:bg-white/90`}><Plus className="size-4" />Add an app</Link>
      </section>

      <div className="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        {stats.map((s) => {
          const inner = (
            <>
              <span className="grid size-10 place-items-center rounded-xl" style={{ background: `${s.color}1a`, color: s.color }}><s.icon className="size-5" /></span>
              <p className="mt-4 font-display text-2xl font-extrabold">{s.value}</p>
              <p className="text-sm text-[var(--muted)]">{s.label}</p>
            </>
          );
          return s.href
            ? <Link key={s.label} href={s.href} className="surface surface-hover p-5">{inner}</Link>
            : <div key={s.label} className="surface p-5">{inner}</div>;
        })}
      </div>

      <div className="mt-10 grid gap-6 lg:grid-cols-[1fr_320px]">
        <section>
          <div className="flex items-center justify-between">
            <h2 className="text-lg font-bold">Your apps</h2>
            <Link href={`/w/${slug}/apps`} className="inline-flex items-center gap-1 text-sm font-semibold text-accent hover:underline">App Store <ArrowRight className="size-4" /></Link>
          </div>
          {installed.length === 0 ? (
            <Link href={`/w/${slug}/apps`} className="mt-4 block rounded-2xl border-2 border-dashed border-[var(--border)] p-10 text-center hover:border-accent">
              <span className="mx-auto grid size-12 place-items-center rounded-2xl bg-accent/10 text-accent"><Plus className="size-6" /></span>
              <p className="mt-3 font-bold">Add your first app</p>
              <p className="mt-1 text-sm text-[var(--muted)]">Choose from over 100 apps. Each one is ready in a second.</p>
            </Link>
          ) : (
            <div className="mt-4 grid gap-3 sm:grid-cols-2">
              {installed.map((a, i) => (
                <Link key={a.slug} href={`/w/${slug}/a/${a.slug}`} className="surface surface-hover group flex items-center gap-4 p-4">
                  <AppIcon slug={a.slug} name={a.name} category={a.category} />
                  <span className="min-w-0 flex-1">
                    <span className="block truncate font-bold group-hover:text-accent">{a.name}</span>
                    <span className="block text-xs text-[var(--muted)]">{perApp[i]} records · {a.entities.length} sections</span>
                  </span>
                  <ArrowRight className="size-4 text-[var(--muted)] transition group-hover:translate-x-0.5 group-hover:text-accent" />
                </Link>
              ))}
            </div>
          )}
        </section>

        <Card className="h-fit p-5">
          <div className="flex items-center justify-between">
            <h2 className="font-bold">Get set up</h2>
            <span className="text-xs font-semibold text-[var(--muted)]">{doneCount} of {steps.length}</span>
          </div>
          <div className="mt-3 h-1.5 overflow-hidden rounded-full bg-[var(--bg-subtle)]">
            <div className="h-full rounded-full bg-gradient-to-r from-accent to-fuchsia-500" style={{ width: `${(doneCount / steps.length) * 100}%` }} />
          </div>
          <ul className="mt-4 space-y-1 text-sm">
            {steps.map((s) => (
              <li key={s.label}>
                {s.href && !s.done ? (
                  <Link href={s.href} className="flex items-center gap-3 rounded-lg px-2 py-2 font-medium hover:bg-[var(--bg-subtle)]">
                    <span className="size-5 shrink-0 rounded-full border-2 border-[var(--border)]" />{s.label}<ArrowRight className="ml-auto size-4 text-[var(--muted)]" />
                  </Link>
                ) : (
                  <span className="flex items-center gap-3 px-2 py-2 text-[var(--muted)]">
                    <span className="grid size-5 shrink-0 place-items-center rounded-full bg-emerald-500 text-white"><Check className="size-3" strokeWidth={3} /></span><span className="line-through">{s.label}</span>
                  </span>
                )}
              </li>
            ))}
          </ul>
        </Card>
      </div>
    </>
  );
}
