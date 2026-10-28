import { canManageWorkspace, listMembers, listPendingInvitations } from "@mewe/core";
import { Card } from "@/components/ui";
import { requireWorkspace } from "@/lib/session";
import { InviteForm, MemberRow, RevokeInvite } from "./client";

export default async function MembersPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const { session, workspace, role } = await requireWorkspace(slug);
  const [members, invites] = await Promise.all([listMembers(workspace.id), listPendingInvitations(workspace.id)]);
  const manage = canManageWorkspace(role);

  return (
    <>
      <h1 className="text-2xl font-bold">Members</h1>
      {manage && <Card className="mt-8"><InviteForm workspaceId={workspace.id} /></Card>}
      <Card className="mt-6 p-0">
        <ul className="divide-y divide-[var(--border)]">
          {members.map((m) => (
            <MemberRow key={m.id} workspaceId={workspace.id} member={m} canManage={manage && m.role !== "owner" && m.userId !== session.user.id} />
          ))}
        </ul>
      </Card>
      {invites.length > 0 && (
        <>
          <h2 className="mt-8 font-semibold">Pending invitations</h2>
          <Card className="mt-3 p-0">
            <ul className="divide-y divide-[var(--border)]">
              {invites.map((i) => (
                <li key={i.id} className="flex items-center justify-between gap-4 px-4 py-3 text-sm">
                  <span className="truncate">{i.email} <span className="text-[var(--muted)]">· {i.role}</span></span>
                  {manage && <RevokeInvite id={i.id} />}
                </li>
              ))}
            </ul>
          </Card>
        </>
      )}
    </>
  );
}
