import type { Metadata } from "next";
import { headers } from "next/headers";
import Link from "next/link";
import { Card } from "@/components/ui";
import { auth } from "@/lib/auth";
import { requireUser } from "@/lib/session";
import { PasswordForm, ProfileForm, SessionList, TwoFactorSetup } from "./client";

export const metadata: Metadata = { title: "Account" };

export default async function AccountPage() {
  const { user, session } = await requireUser();
  const sessions = await auth.api.listSessions({ headers: await headers() });

  return (
    <main className="mx-auto max-w-2xl px-4 py-10">
      <Link href="/dashboard" className="text-sm text-accent">← Back to workspace</Link>
      <h1 className="mt-4 text-2xl font-bold">Your account</h1>
      <Card className="mt-8"><ProfileForm name={user.name} email={user.email} /></Card>
      <Card className="mt-6"><PasswordForm /></Card>
      <Card className="mt-6"><TwoFactorSetup enabled={user.twoFactorEnabled === true} /></Card>
      <Card className="mt-6">
        <SessionList
          currentToken={session.token}
          sessions={sessions.map((s) => ({ token: s.token, userAgent: s.userAgent ?? "Unknown device", ipAddress: s.ipAddress ?? "", createdAt: new Date(s.createdAt).toISOString() }))}
        />
      </Card>
    </main>
  );
}
