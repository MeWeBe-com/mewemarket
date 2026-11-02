import type { Metadata } from "next";
import { headers } from "next/headers";
import { ArrowLeft, ShieldAlert, ShieldCheck } from "lucide-react";
import Link from "next/link";
import { Avatar } from "@/components/records/value";
import { Card, Logo } from "@/components/ui";
import { auth } from "@/lib/auth";
import { requireUser } from "@/lib/session";
import { PasswordForm, ProfileForm, SessionList, TwoFactorSetup } from "./client";

export const metadata: Metadata = { title: "Account" };

export default async function AccountPage() {
  const { user, session } = await requireUser();
  const all = (await auth.api.listSessions({ headers: await headers() }))
    .sort((a, b) => Number(b.token === session.token) - Number(a.token === session.token) || +new Date(b.createdAt) - +new Date(a.createdAt));
  const sessions = all.slice(0, 10);

  return (
    <div className="min-h-dvh bg-[var(--bg-subtle)]">
    <header className="border-b border-[var(--border)] bg-[var(--bg)]">
      <div className="mx-auto flex h-16 max-w-2xl items-center justify-between px-4">
        <Link href="/" aria-label="MeweMarket home"><Logo /></Link>
        <Link href="/dashboard" className="inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--muted)] hover:text-[var(--fg)]"><ArrowLeft className="size-4" />Back to workspace</Link>
      </div>
    </header>
    <main className="mx-auto max-w-2xl px-4 py-10">
      <div className="flex flex-wrap items-center gap-4">
        <Avatar name={user.name} size={64} />
        <div className="min-w-0 flex-1">
          <h1 className="truncate text-3xl font-extrabold">{user.name}</h1>
          <p className="truncate text-[var(--muted)]">{user.email}</p>
        </div>
        {user.twoFactorEnabled
          ? <span className="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-bold text-emerald-600"><ShieldCheck className="size-4" />Two-factor on</span>
          : <span className="inline-flex items-center gap-1.5 rounded-full bg-amber-500/10 px-3 py-1 text-xs font-bold text-amber-600"><ShieldAlert className="size-4" />Two-factor off</span>}
      </div>
      <Card className="mt-8"><ProfileForm name={user.name} email={user.email} /></Card>
      <Card className="mt-6"><PasswordForm /></Card>
      <Card className="mt-6"><TwoFactorSetup enabled={user.twoFactorEnabled === true} /></Card>
      <Card className="mt-6">
        <SessionList
          currentToken={session.token}
          more={all.length - sessions.length}
          sessions={sessions.map((s) => ({ token: s.token, userAgent: s.userAgent ?? "Unknown device", ipAddress: s.ipAddress ?? "",
            since: new Date(s.createdAt).toLocaleDateString("en-US", { day: "numeric", month: "short", year: "numeric", timeZone: "UTC" }) }))}
        />
      </Card>
    </main>
    </div>
  );
}
