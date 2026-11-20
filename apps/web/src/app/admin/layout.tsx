import type { Metadata } from "next";
import Link from "next/link";
import { ShieldAlert } from "lucide-react";
import { Logo } from "@/components/ui";
import { requireSuperadmin } from "@/lib/admin";

export const metadata: Metadata = { title: "Super admin", robots: { index: false, follow: false } };
export const dynamic = "force-dynamic";

const NAV = [
  ["/admin", "Overview"],
  ["/admin/companies", "Companies"],
  ["/admin/users", "Users"],
  ["/admin/messages", "Messages"],
] as const;

export default async function AdminLayout({ children }: { children: React.ReactNode }) {
  const { user } = await requireSuperadmin();
  return (
    <div className="min-h-dvh bg-[var(--bg-subtle)]">
      <header className="border-b border-[var(--border)] bg-[var(--bg)]">
        <div className="mx-auto flex h-16 max-w-6xl items-center gap-6 px-4">
          <Link href="/admin" aria-label="Admin home" className="flex items-center gap-2"><Logo /><span className="rounded bg-red-500/10 px-2 py-0.5 text-xs font-bold text-red-600">SUPER ADMIN</span></Link>
          <nav className="flex flex-1 gap-4 overflow-x-auto text-sm font-semibold">
            {NAV.map(([href, label]) => <Link key={href} href={href} className="text-[var(--muted)] hover:text-[var(--fg)]">{label}</Link>)}
          </nav>
          <Link href="/dashboard" className="text-sm text-[var(--muted)] hover:text-[var(--fg)]">Exit</Link>
        </div>
      </header>
      {!user.twoFactorEnabled && (
        <div className="mx-auto mt-4 max-w-6xl px-4">
          <p className="flex items-center gap-2 rounded-lg bg-amber-500/10 px-4 py-2 text-sm text-amber-700"><ShieldAlert className="size-4" />
            This account can see every company. Turn on two-factor sign-in in <Link href="/account" className="underline">Account</Link>.</p>
        </div>
      )}
      <main className="mx-auto max-w-6xl px-4 py-8">{children}</main>
    </div>
  );
}
