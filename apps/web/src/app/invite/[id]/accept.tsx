"use client";
import { useRouter } from "next/navigation";
import { useState } from "react";
import { Alert, Button } from "@/components/ui";
import { authClient } from "@/lib/auth-client";

export function AcceptInvite({ id, slug }: { id: string; slug: string }) {
  const router = useRouter();
  const [error, setError] = useState<string | null>(null);
  const [pending, setPending] = useState(false);

  async function respond(accept: boolean) {
    setPending(true);
    const { error } = accept
      ? await authClient.organization.acceptInvitation({ invitationId: id })
      : await authClient.organization.rejectInvitation({ invitationId: id });
    if (error) {
      setPending(false);
      return setError(error.message ?? "Something went wrong");
    }
    router.push(accept ? `/${slug}` : "/dashboard");
    router.refresh();
  }

  return (
    <div className="space-y-3">
      {error && <Alert>{error}</Alert>}
      <Button className="w-full" disabled={pending} onClick={() => respond(true)}>Accept and join</Button>
      <Button variant="ghost" className="w-full" disabled={pending} onClick={() => respond(false)}>Decline</Button>
    </div>
  );
}
