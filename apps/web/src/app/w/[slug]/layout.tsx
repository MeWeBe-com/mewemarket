import { getSubscription, listInstalledApps, listUserWorkspaces } from "@mewe/core";
import { CreditCard, Home, LayoutGrid, Plus, Settings, Sparkles, Users, Wrench } from "lucide-react";
import Link from "next/link";
import { AppIcon } from "@/components/app-icon";
import { NavLink } from "@/components/shell/nav-link";
import { UserMenu } from "@/components/shell/user-menu";
import { WorkspaceSwitcher } from "@/components/shell/workspace-switcher";
import { requireWorkspace } from "@/lib/session";

export default async function WorkspaceLayout({ children, params }: { children: React.ReactNode; params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const { session, workspace } = await requireWorkspace(slug);
  const [workspaces, sub, installed] = await Promise.all([listUserWorkspaces(session.user.id), getSubscription(workspace.id), listInstalledApps(workspace.id)]);
  const trialDaysLeft =
    sub?.sub.status === "trialing" && sub.sub.trialEndsAt
      ? Math.max(0, Math.ceil((sub.sub.trialEndsAt.getTime() - Date.now()) / 86_400_000))
      : null;

  const nav = [
    { href: `/w/${slug}`, label: "Home", icon: Home, exact: true },
    { href: `/w/${slug}/apps`, label: "App Store", icon: LayoutGrid },
    { href: `/w/${slug}/tools`, label: "Tools", icon: Wrench },
    { href: `/w/${slug}/billing`, label: "Plan & billing", icon: CreditCard },
    { href: `/w/${slug}/settings`, label: "Settings", icon: Settings, exact: true },
    { href: `/w/${slug}/settings/members`, label: "Members", icon: Users },
  ];

  return (
    <div className="flex min-h-dvh">
      <aside className="sticky top-0 hidden h-dvh w-64 shrink-0 flex-col gap-4 overflow-y-auto border-r border-[var(--border)] bg-[var(--bg-subtle)] p-3 md:flex print:hidden">
        <WorkspaceSwitcher current={workspace} workspaces={workspaces} />
        <nav className="flex-1 space-y-0.5">
          {nav.map((n) => (
            <NavLink key={n.href} href={n.href} exact={n.exact}><n.icon className="size-4 shrink-0" />{n.label}</NavLink>
          ))}
          <div className="flex items-center justify-between px-2 pb-1 pt-5">
            <p className="text-[11px] font-bold uppercase tracking-wider text-[var(--muted)]">Your apps</p>
            <Link href={`/w/${slug}/apps`} aria-label="Add an app" className="grid size-5 place-items-center rounded-md text-[var(--muted)] hover:bg-[var(--card)] hover:text-accent"><Plus className="size-3.5" /></Link>
          </div>
          {installed.map((a) => (
            <NavLink key={a.slug} href={`/w/${slug}/a/${a.slug}`}>
              <AppIcon slug={a.slug} name={a.name} category={a.category} size="sm" className="!size-6 !rounded-md [&>svg]:size-3.5" /><span className="truncate">{a.name}</span>
            </NavLink>
          ))}
          {installed.length === 0 && <Link href={`/w/${slug}/apps`} className="block rounded-lg border border-dashed border-[var(--border)] px-3 py-3 text-center text-xs text-[var(--muted)] hover:border-accent hover:text-accent">Add your first app</Link>}
        </nav>
        {trialDaysLeft !== null && (
          <div className="relative overflow-hidden rounded-xl bg-gradient-to-br from-accent to-fuchsia-500 p-3.5 text-xs text-white shadow-[0_8px_20px_-8px_rgb(91_91_246/0.7)]">
            <Sparkles className="absolute -right-1 -top-1 size-12 text-white/15" />
            <p className="font-bold">{trialDaysLeft} days left</p>
            <p className="mt-0.5 text-white/80">in your {sub!.plan.name} trial.</p>
            <Link href={`/w/${slug}/billing`} className="mt-2.5 inline-block rounded-lg bg-white/20 px-2.5 py-1 font-semibold hover:bg-white/30">Choose a plan</Link>
          </div>
        )}
        <UserMenu name={session.user.name} email={session.user.email} />
      </aside>
      <div className="min-w-0 flex-1">
        <header className="sticky top-0 z-30 flex items-center justify-between border-b border-[var(--border)] bg-[var(--bg)]/80 px-4 py-3 backdrop-blur md:hidden print:hidden">
          <span className="font-display font-bold">{workspace.name}</span>
          <details className="relative">
            <summary className="cursor-pointer list-none rounded-lg border border-[var(--border)] px-3 py-1.5 text-sm">Menu</summary>
            <nav className="absolute right-0 z-20 mt-2 max-h-[70dvh] w-64 overflow-y-auto rounded-xl border border-[var(--border)] bg-[var(--card)] p-2 text-sm shadow-xl">
              {[...nav, { href: "/account", label: "Your account" }].map((n) => (
                <Link key={n.href} href={n.href} className="block rounded-lg px-2 py-1.5 hover:bg-black/5 dark:hover:bg-white/5">{n.label}</Link>
              ))}
              {installed.length > 0 && <p className="px-2 pt-3 pb-1 text-xs font-semibold uppercase tracking-wide text-[var(--muted)]">Your apps</p>}
              {installed.map((a) => (
                <Link key={a.slug} href={`/w/${slug}/a/${a.slug}`} className="block truncate rounded-lg px-2 py-1.5 hover:bg-black/5 dark:hover:bg-white/5">{a.name}</Link>
              ))}
            </nav>
          </details>
        </header>
        <main className="mx-auto max-w-6xl px-4 py-8 md:px-10 md:py-10 print:p-0">{children}</main>
      </div>
    </div>
  );
}
