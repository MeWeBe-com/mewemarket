import Link from "next/link";
import { getSession } from "@/lib/session";
import { MobileNav } from "./mobile-nav";
import { ThemeToggle } from "./theme-toggle";

export const NAV = [
  { href: "/apps", label: "Apps" },
  { href: "/tools", label: "Free tools" },
  { href: "/pricing", label: "Pricing" },
  { href: "/about", label: "About" },
];

export async function SiteHeader() {
  const session = await getSession();
  return (
    <header className="sticky top-0 z-40 border-b border-[var(--border)] bg-[var(--bg)]/80 backdrop-blur">
      <div className="mx-auto flex h-16 max-w-6xl items-center gap-6 px-4">
        <Link href="/" className="flex items-center gap-2 font-bold tracking-tight">
          <span className="grid size-7 place-items-center rounded-lg bg-accent text-sm text-white">M</span>
          MeweMarket
        </Link>
        <nav className="hidden flex-1 items-center gap-1 text-sm md:flex">
          {NAV.map((n) => (
            <Link key={n.href} href={n.href} className="rounded-lg px-3 py-2 text-[var(--muted)] hover:text-[var(--fg)]">{n.label}</Link>
          ))}
        </nav>
        <div className="ml-auto flex items-center gap-2">
          <ThemeToggle />
          {session ? (
            <Link href="/dashboard" className="rounded-lg bg-accent px-4 py-2 text-sm font-semibold text-white hover:bg-accent-strong">Open app</Link>
          ) : (
            <>
              <Link href="/sign-in" className="hidden rounded-lg px-3 py-2 text-sm font-medium sm:block">Sign in</Link>
              <Link href="/sign-up" className="rounded-lg bg-accent px-4 py-2 text-sm font-semibold text-white hover:bg-accent-strong">Start free</Link>
            </>
          )}
          <MobileNav items={NAV} />
        </div>
      </div>
    </header>
  );
}
