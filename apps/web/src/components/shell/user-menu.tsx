"use client";
import Link from "next/link";
import { useRouter } from "next/navigation";
import { authClient } from "@/lib/auth-client";

export function UserMenu({ name, email }: { name: string; email: string }) {
  const router = useRouter();
  return (
    <div className="border-t border-[var(--border)] pt-3 text-sm">
      <Link href="/account" className="flex items-center gap-2.5 rounded-lg px-2 py-1.5 hover:bg-black/5 dark:hover:bg-white/5">
        <span className="grid size-8 shrink-0 place-items-center rounded-full bg-gradient-to-br from-sky-400 to-indigo-500 text-xs font-bold text-white">
          {name.split(/\s+/).map((w) => w[0]).slice(0, 2).join("").toUpperCase()}
        </span>
        <span className="min-w-0">
          <span className="block truncate font-semibold">{name}</span>
          <span className="block truncate text-xs text-[var(--muted)]">{email}</span>
        </span>
      </Link>
      <button className="mt-1 w-full rounded-lg px-2 py-1.5 text-left text-[var(--muted)] hover:bg-black/5 dark:hover:bg-white/5"
        onClick={async () => { await authClient.signOut(); router.push("/sign-in"); }}>
        Sign out
      </button>
    </div>
  );
}
