"use client";
import { useRouter } from "next/navigation";
import { useState } from "react";
import { Avatar } from "@/components/records/value";
import { Alert, Button, Input } from "@/components/ui";
import { authClient } from "@/lib/auth-client";
import { ROLE_COLOR } from "@/lib/roles";

const ROLES = ["admin", "member", "guest"] as const;
const cap = (r: string) => r[0]!.toUpperCase() + r.slice(1);

export function InviteForm({ workspaceId }: { workspaceId: string }) {
  const router = useRouter();
  const [msg, setMsg] = useState<{ tone: "error" | "success"; text: string } | null>(null);
  const [pending, setPending] = useState(false);

  async function onSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    const form = e.currentTarget;
    const f = new FormData(form);
    setPending(true);
    const email = String(f.get("email"));
    const { error } = await authClient.organization.inviteMember({
      email, role: f.get("role") as (typeof ROLES)[number], organizationId: workspaceId,
    });
    setPending(false);
    if (error) return setMsg({ tone: "error", text: error.message ?? "Invite failed" });
    setMsg({ tone: "success", text: `Invitation sent to ${email}.` });
    form.reset();
    router.refresh();
  }

  return (
    <form onSubmit={onSubmit} className="space-y-3">
      {msg && <Alert tone={msg.tone}>{msg.text}</Alert>}
      <div className="flex flex-col gap-2 sm:flex-row">
        <Input name="email" type="email" placeholder="colleague@company.com" required />
        <select name="role" defaultValue="member" aria-label="Role" className="h-10 rounded-xl border border-[var(--border)] bg-[var(--card)] px-2 text-sm shadow-[var(--shadow-sm)]">
          {ROLES.map((r) => <option key={r} value={r}>{cap(r)}</option>)}
        </select>
        <Button type="submit" disabled={pending} className="shrink-0 whitespace-nowrap">Send invite</Button>
      </div>
    </form>
  );
}

type Member = { id: string; name: string; email: string; role: string };

export function MemberRow({ workspaceId, member, canManage }: { workspaceId: string; member: Member; canManage: boolean }) {
  const router = useRouter();
  const [error, setError] = useState<string | null>(null);

  async function run(p: Promise<{ error: { message?: string } | null }>) {
    const { error } = await p;
    if (error) setError(error.message ?? "Action failed");
    else router.refresh();
  }

  return (
    <li className="flex flex-col gap-3 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
      <span className="flex min-w-0 items-center gap-3">
        <Avatar name={member.name} size={36} />
        <span className="min-w-0">
          <span className="block truncate font-semibold">{member.name}</span>
          <span className="block truncate text-[var(--muted)]">{member.email}</span>
          {error && <span className="text-red-500">{error}</span>}
        </span>
      </span>
      {canManage ? (
        <span className="flex items-center gap-2">
          <select defaultValue={member.role} aria-label={`Role for ${member.name}`}
            className="h-9 rounded-xl border border-[var(--border)] bg-[var(--card)] px-2 shadow-[var(--shadow-sm)]"
            onChange={(e) => run(authClient.organization.updateMemberRole({ memberId: member.id, role: e.target.value as (typeof ROLES)[number], organizationId: workspaceId }))}>
            {ROLES.map((r) => <option key={r} value={r}>{cap(r)}</option>)}
          </select>
          <Button variant="ghost" className="h-9 text-red-600"
            onClick={() => confirm(`Remove ${member.name} from this workspace?`) && run(authClient.organization.removeMember({ memberIdOrEmail: member.id, organizationId: workspaceId }))}>
            Remove
          </Button>
        </span>
      ) : (
        <span className="w-fit rounded-full px-2.5 py-0.5 text-xs font-bold" style={{ background: `${ROLE_COLOR[member.role] ?? "#64748b"}1a`, color: ROLE_COLOR[member.role] ?? "#64748b" }}>{cap(member.role)}</span>
      )}
    </li>
  );
}

export function RevokeInvite({ id }: { id: string }) {
  const router = useRouter();
  return (
    <Button variant="ghost" className="h-8 text-xs" onClick={async () => { await authClient.organization.cancelInvitation({ invitationId: id }); router.refresh(); }}>
      Revoke
    </Button>
  );
}
