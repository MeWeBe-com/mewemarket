import Link from "next/link";
import { BUTTON_BASE, BUTTON_PRIMARY, Logo } from "@/components/ui";
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
    <header className="sticky top-0 z-40 border-b border-[var(--border)]/70 bg-[var(--bg)]/75 backdrop-blur-xl backdrop-saturate-150">
      <div className="mx-auto flex h-16 max-w-6xl items-center gap-6 px-4">
        <Link href="/" aria-label="MeweMarket home"><Logo /></Link>
        <nav className="hidden flex-1 items-center gap-1 text-sm md:flex">
          {NAV.map((n) => (
            <Link key={n.href} href={n.href} className="rounded-lg px-3 py-2 font-medium text-[var(--muted)] transition hover:bg-[var(--bg-subtle)] hover:text-[var(--fg)]">{n.label}</Link>
          ))}
        </nav>
        <div className="ml-auto flex items-center gap-2">
          <ThemeToggle />
          {session ? (
            <Link href="/dashboard" className={`${BUTTON_BASE} ${BUTTON_PRIMARY} h-9`}>Open app</Link>
          ) : (
            <>
              <Link href="/sign-in" className="hidden rounded-lg px-3 py-2 text-sm font-semibold hover:bg-[var(--bg-subtle)] sm:block">Sign in</Link>
              <Link href="/sign-up" className={`${BUTTON_BASE} ${BUTTON_PRIMARY} h-9`}>Start free</Link>
            </>
          )}
          <MobileNav items={NAV} />
        </div>
      </div>
    </header>
  );
}
