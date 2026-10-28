import { getSubscription, listUserWorkspaces } from "@mewe/core";
import Link from "next/link";
import { UserMenu } from "@/components/shell/user-menu";
import { WorkspaceSwitcher } from "@/components/shell/workspace-switcher";
import { requireWorkspace } from "@/lib/session";

export default async function WorkspaceLayout({ children, params }: { children: React.ReactNode; params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const { session, workspace } = await requireWorkspace(slug);
  const [workspaces, sub] = await Promise.all([listUserWorkspaces(session.user.id), getSubscription(workspace.id)]);
  const trialDaysLeft =
    sub?.sub.status === "trialing" && sub.sub.trialEndsAt
      ? Math.max(0, Math.ceil((sub.sub.trialEndsAt.getTime() - Date.now()) / 86_400_000))
      : null;

  const nav = [
    { href: `/w/${slug}`, label: "Home" },
    { href: `/w/${slug}/settings`, label: "Settings" },
    { href: `/w/${slug}/settings/members`, label: "Members" },
  ];

  return (
    <div className="flex min-h-dvh">
      <aside className="hidden w-60 shrink-0 flex-col gap-4 border-r border-[var(--border)] p-3 md:flex">
        <WorkspaceSwitcher current={workspace} workspaces={workspaces} />
        <nav className="flex-1 space-y-0.5 text-sm">
          {nav.map((n) => (
            <Link key={n.href} href={n.href} className="block rounded-lg px-2 py-1.5 hover:bg-black/5 dark:hover:bg-white/5">{n.label}</Link>
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
        <header className="flex items-center justify-between border-b border-[var(--border)] px-4 py-3 md:hidden">
          <span className="font-semibold">{workspace.name}</span>
          <Link href={`/w/${slug}/settings`} className="text-sm text-accent">Settings</Link>
        </header>
        <main className="mx-auto max-w-5xl px-4 py-8 md:px-8">{children}</main>
      </div>
    </div>
  );
}
