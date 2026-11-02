import { canManageWorkspace, listMembers, listPendingInvitations } from "@mewe/core";
import { Mail, UserPlus } from "lucide-react";
import { Card } from "@/components/ui";
import { requireWorkspace } from "@/lib/session";
import { ROLE_COLOR } from "@/lib/roles";
import { InviteForm, MemberRow, RevokeInvite } from "./client";

const ROLES: [string, string][] = [
  ["owner", "Everything an admin can do. Owns the workspace and can't be removed."],
  ["admin", "Add and remove apps, manage members and billing."],
  ["member", "Create, edit and delete records in every app."],
  ["guest", "Read-only access. Can't edit or export."],
];

export default async function MembersPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const { session, workspace, role } = await requireWorkspace(slug);
  const [members, invites] = await Promise.all([listMembers(workspace.id), listPendingInvitations(workspace.id)]);
  const manage = canManageWorkspace(role);

  return (
    <>
      <h1 className="flex items-center gap-2 text-3xl font-extrabold">Members <span className="rounded-full bg-[var(--card)] px-2 py-0.5 text-sm font-bold text-[var(--muted)] ring-1 ring-[var(--border)]">{members.length}</span></h1>
      <p className="mt-1 text-[var(--muted)]">Everyone who can open {workspace.name}.</p>

      <div className="mt-8 grid gap-6 lg:grid-cols-[1fr_300px]">
        <div className="space-y-6">
          {manage && (
            <Card className="p-5">
              <h2 className="flex items-center gap-2 font-bold"><UserPlus className="size-4 text-accent" />Invite people</h2>
              <p className="mb-4 mt-1 text-sm text-[var(--muted)]">They'll get an email with a link to join.</p>
              <InviteForm workspaceId={workspace.id} />
            </Card>
          )}
          <Card className="p-0">
            <ul className="divide-y divide-[var(--border)]">
              {members.map((m) => (
                <MemberRow key={m.id} workspaceId={workspace.id} member={m} canManage={manage && m.role !== "owner" && m.userId !== session.user.id} />
              ))}
            </ul>
          </Card>
          {invites.length > 0 && (
            <section>
              <h2 className="font-bold">Pending invitations</h2>
              <Card className="mt-3 p-0">
                <ul className="divide-y divide-[var(--border)]">
                  {invites.map((i) => (
                    <li key={i.id} className="flex items-center justify-between gap-4 px-5 py-3 text-sm">
                      <span className="flex min-w-0 items-center gap-3">
                        <span className="grid size-9 shrink-0 place-items-center rounded-full bg-[var(--bg-subtle)] text-[var(--muted)] ring-1 ring-[var(--border)]"><Mail className="size-4" /></span>
                        <span className="truncate">{i.email} <span className="text-[var(--muted)]">· {i.role}</span></span>
                      </span>
                      {manage && <RevokeInvite id={i.id} />}
                    </li>
                  ))}
                </ul>
              </Card>
            </section>
          )}
        </div>
        <Card className="h-fit p-5">
          <h2 className="font-bold">Roles</h2>
          <ul className="mt-3 space-y-3 text-sm">
            {ROLES.map(([r, d]) => (
              <li key={r}>
                <span className="rounded-full px-2 py-0.5 text-xs font-bold capitalize" style={{ background: `${ROLE_COLOR[r]}1a`, color: ROLE_COLOR[r] }}>{r}</span>
                <p className="mt-1 text-[var(--muted)]">{d}</p>
              </li>
            ))}
          </ul>
        </Card>
      </div>
    </>
  );
}
