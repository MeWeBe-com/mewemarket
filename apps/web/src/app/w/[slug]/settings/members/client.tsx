"use client";
import { useRouter } from "next/navigation";
import { useState } from "react";
import { Alert, Button, Input } from "@/components/ui";
import { authClient } from "@/lib/auth-client";

const ROLES = ["admin", "member", "guest"] as const;

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
      <h2 className="font-semibold">Invite people</h2>
      {msg && <Alert tone={msg.tone}>{msg.text}</Alert>}
      <div className="flex flex-col gap-2 sm:flex-row">
        <Input name="email" type="email" placeholder="colleague@company.com" required />
        <select name="role" defaultValue="member" className="h-10 rounded-lg border border-[var(--border)] bg-transparent px-2 text-sm">
          {ROLES.map((r) => <option key={r} value={r}>{r}</option>)}
        </select>
        <Button type="submit" disabled={pending}>Send invite</Button>
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
    <li className="flex flex-col gap-2 px-4 py-3 text-sm sm:flex-row sm:items-center sm:justify-between">
      <span className="min-w-0">
        <span className="block truncate font-medium">{member.name}</span>
        <span className="block truncate text-[var(--muted)]">{member.email}</span>
        {error && <span className="text-red-500">{error}</span>}
      </span>
      {canManage ? (
        <span className="flex items-center gap-2">
          <select defaultValue={member.role} aria-label={`Role for ${member.name}`}
            className="h-9 rounded-lg border border-[var(--border)] bg-transparent px-2"
            onChange={(e) => run(authClient.organization.updateMemberRole({ memberId: member.id, role: e.target.value as (typeof ROLES)[number], organizationId: workspaceId }))}>
            {ROLES.map((r) => <option key={r} value={r}>{r}</option>)}
          </select>
          <Button variant="ghost" className="h-9 text-red-600"
            onClick={() => confirm(`Remove ${member.name} from this workspace?`) && run(authClient.organization.removeMember({ memberIdOrEmail: member.id, organizationId: workspaceId }))}>
            Remove
          </Button>
        </span>
      ) : (
        <span className="text-[var(--muted)]">{member.role}</span>
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
