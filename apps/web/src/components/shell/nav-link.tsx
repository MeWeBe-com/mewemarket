"use client";
import Link from "next/link";
import { usePathname } from "next/navigation";
import type { ReactNode } from "react";

/** Link that marks itself current. `exact` for parents like Home whose path prefixes everything. */
export function NavLink({ href, exact = false, variant = "side", children }: { href: string; exact?: boolean; variant?: "side" | "tab"; children: ReactNode }) {
  const path = usePathname();
  const on = exact ? path === href : path === href || path.startsWith(`${href}/`);
  if (variant === "tab") {
    return (
      <Link href={href} aria-current={on ? "page" : undefined}
        className={`relative whitespace-nowrap px-3 py-2.5 text-sm font-semibold transition ${on ? "text-[var(--fg)] after:absolute after:inset-x-2 after:-bottom-px after:h-0.5 after:rounded-full after:bg-accent" : "text-[var(--muted)] hover:text-[var(--fg)]"}`}>
        {children}
      </Link>
    );
  }
  return (
    <Link href={href} aria-current={on ? "page" : undefined}
      className={`flex items-center gap-2.5 truncate rounded-lg px-2 py-1.5 text-sm font-medium transition ${on ? "bg-[var(--card)] text-[var(--fg)] shadow-[var(--shadow-sm)] ring-1 ring-[var(--border)]" : "text-[var(--muted)] hover:bg-black/[0.04] hover:text-[var(--fg)] dark:hover:bg-white/[0.04]"}`}>
      {children}
    </Link>
  );
}
