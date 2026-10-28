import { auth } from "@/lib/auth";
import { requireUser } from "@/lib/session";
import { headers } from "next/headers";
import { redirect } from "next/navigation";
import { Card, TextLink } from "@/components/ui";
import { AcceptInvite } from "./accept";

export default async function InvitePage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const session = await auth.api.getSession({ headers: await headers() });
  if (!session) redirect(`/sign-in?next=/invite/${id}`);
  await requireUser();

  const invitation = await auth.api.getInvitation({ query: { id }, headers: await headers() }).catch(() => null);

  return (
    <main className="flex min-h-dvh items-center justify-center px-4">
      <Card className="w-full max-w-md text-center">
        {invitation ? (
          <>
            <h1 className="text-2xl font-bold">Join {invitation.organizationName}</h1>
            <p className="mb-6 mt-2 text-[var(--muted)]">{invitation.inviterEmail} invited you as {invitation.role}.</p>
            <AcceptInvite id={id} slug={invitation.organizationSlug} />
          </>
        ) : (
          <>
            <h1 className="text-xl font-bold">Invitation not found</h1>
            <p className="mt-2 text-[var(--muted)]">
              This invitation has expired, was already used, or was sent to a different email than {session.user.email}.
            </p>
            <p className="mt-6"><TextLink href="/dashboard">Go to your dashboard</TextLink></p>
          </>
        )}
      </Card>
    </main>
  );
}
