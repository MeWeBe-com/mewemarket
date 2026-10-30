import { CATEGORIES } from "@mewe/core";
import Link from "next/link";
import { Logo } from "@/components/ui";

const COLS = [
  { title: "Product", links: [["/apps", "All apps"], ["/tools", "Free tools"], ["/pricing", "Pricing"]] },
  { title: "Company", links: [["/about", "About"], ["/contact", "Contact & support"], ["https://mewebe.com", "MeWeBe Studio Network"], ["/pricing#supporter", "Become a supporter"]] },
  { title: "Legal", links: [["/terms", "Terms of service"], ["/privacy", "Privacy policy"], ["/cookies", "Cookie policy"]] },
] as const;

export function SiteFooter() {
  return (
    <footer className="mt-28 border-t border-[var(--border)] bg-[var(--bg-subtle)]">
      <div className="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:grid-cols-2 lg:grid-cols-5">
        <div className="lg:col-span-2">
          <Logo />
          <p className="mt-2 max-w-xs text-sm text-[var(--muted)]">
            Every business app your company runs on, in one workspace, on one subscription.
          </p>
          <p className="mt-6 text-xs font-semibold uppercase tracking-wide text-[var(--muted)]">Categories</p>
          <p className="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-sm">
            {CATEGORIES.map((c) => <Link key={c.slug} href={`/apps/category/${c.slug}`} className="text-[var(--muted)] hover:text-[var(--fg)]">{c.name}</Link>)}
          </p>
        </div>
        {COLS.map((col) => (
          <div key={col.title}>
            <p className="text-sm font-semibold">{col.title}</p>
            <ul className="mt-3 space-y-2 text-sm">
              {col.links.map(([href, label]) => (
                <li key={href}><Link href={href} className="text-[var(--muted)] hover:text-[var(--fg)]">{label}</Link></li>
              ))}
            </ul>
          </div>
        ))}
      </div>
      <div className="border-t border-[var(--border)] py-6 text-center text-xs text-[var(--muted)]">
        © {new Date().getFullYear()} MeweMarket · Part of the <a href="https://mewebe.com" className="hover:text-[var(--fg)]">MeWeBe Studio Network</a>
      </div>
    </footer>
  );
}
