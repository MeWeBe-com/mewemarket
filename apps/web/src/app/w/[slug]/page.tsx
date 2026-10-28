import { listMembers } from "@mewe/core";
import Link from "next/link";
import { Card } from "@/components/ui";
import { requireWorkspace } from "@/lib/session";

export default async function WorkspaceHome({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const { session, workspace } = await requireWorkspace(slug);
  const members = await listMembers(workspace.id);

  const steps = [
    { done: true, label: "Create your workspace", href: null },
    { done: members.length > 1, label: "Invite your team", href: `/w/${slug}/settings/members` },
    { done: session.user.twoFactorEnabled === true, label: "Turn on two-factor authentication", href: "/account" },
  ];

  return (
    <>
      <h1 className="text-2xl font-bold">Good to see you, {session.user.name.split(" ")[0]}</h1>
      <p className="mt-1 text-[var(--muted)]">{workspace.name}</p>
      <Card className="mt-8">
        <h2 className="font-semibold">Get set up</h2>
        <ul className="mt-4 space-y-2 text-sm">
          {steps.map((s) => (
            <li key={s.label} className="flex items-center gap-3">
              <span aria-hidden className={s.done ? "text-emerald-500" : "text-[var(--muted)]"}>{s.done ? "✓" : "○"}</span>
              {s.href && !s.done ? <Link href={s.href} className="text-accent hover:underline">{s.label}</Link> : <span className={s.done ? "text-[var(--muted)] line-through" : ""}>{s.label}</span>}
            </li>
          ))}
        </ul>
      </Card>
    </>
  );
}
