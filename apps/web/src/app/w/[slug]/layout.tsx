import { getSubscription, listInstalledApps, listUserWorkspaces } from "@mewe/core";
import Link from "next/link";
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
    { href: `/w/${slug}`, label: "Home" },
    { href: `/w/${slug}/apps`, label: "App Store" },
    { href: `/w/${slug}/billing`, label: "Plan & billing" },
    { href: `/w/${slug}/settings`, label: "Settings" },
    { href: `/w/${slug}/settings/members`, label: "Members" },
  ];

  return (
    <div className="flex min-h-dvh">
      <aside className="sticky top-0 hidden h-dvh w-60 shrink-0 flex-col gap-4 overflow-y-auto border-r border-[var(--border)] p-3 md:flex print:hidden">
        <WorkspaceSwitcher current={workspace} workspaces={workspaces} />
        <nav className="flex-1 space-y-0.5 text-sm">
          {nav.map((n) => (
            <Link key={n.href} href={n.href} className="block rounded-lg px-2 py-1.5 hover:bg-black/5 dark:hover:bg-white/5">{n.label}</Link>
          ))}
          {installed.length > 0 && <p className="px-2 pt-4 pb-1 text-xs font-semibold uppercase tracking-wide text-[var(--muted)]">Your apps</p>}
          {installed.map((a) => (
            <Link key={a.slug} href={`/w/${slug}/a/${a.slug}`} className="block truncate rounded-lg px-2 py-1.5 hover:bg-black/5 dark:hover:bg-white/5">{a.name}</Link>
          ))}
        </nav>
        {trialDaysLeft !== null && (
          <p className="rounded-lg bg-accent/10 p-3 text-xs">
            <strong>{trialDaysLeft} days</strong> left in your {sub!.plan.name} trial.
          </p>
        )}
        <UserMenu name={session.user.name} email={session.user.email} />
      </aside>
      <div className="min-w-0 flex-1">
        <header className="flex items-center justify-between border-b border-[var(--border)] px-4 py-3 md:hidden print:hidden">
          <span className="font-semibold">{workspace.name}</span>
          <nav className="flex gap-3 text-sm text-accent"><Link href={`/w/${slug}/apps`}>Apps</Link><Link href={`/w/${slug}/settings`}>Settings</Link></nav>
        </header>
        <main className="mx-auto max-w-6xl px-4 py-8 md:px-8 print:p-0">{children}</main>
      </div>
    </div>
  );
}
