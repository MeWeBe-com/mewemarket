"use client";
import { Menu, X } from "lucide-react";
import Link from "next/link";
import { useState } from "react";

export function MobileNav({ items }: { items: { href: string; label: string }[] }) {
  const [open, setOpen] = useState(false);
  return (
    <div className="md:hidden">
      <button type="button" aria-label="Menu" aria-expanded={open} onClick={() => setOpen(!open)}
        className="grid size-9 place-items-center rounded-lg hover:bg-black/5 dark:hover:bg-white/5">
        {open ? <X className="size-5" /> : <Menu className="size-5" />}
      </button>
      {open && (
        <nav className="absolute inset-x-0 top-16 border-b border-[var(--border)] bg-[var(--bg)] px-4 py-3">
          {[...items, { href: "/sign-in", label: "Sign in" }].map((n) => (
            <Link key={n.href} href={n.href} onClick={() => setOpen(false)} className="block rounded-lg px-3 py-2.5 font-medium hover:bg-black/5 dark:hover:bg-white/5">
              {n.label}
            </Link>
          ))}
        </nav>
      )}
    </div>
  );
}
