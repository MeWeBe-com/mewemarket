import type { Metadata } from "next";
import Link from "next/link";
import { TOOLS } from "@mewe/core";

export const metadata: Metadata = {
  title: "Free online tools",
  description: "Free tools that run in your browser: invoice generator, QR codes, calculators, developer utilities, a whiteboard and video meetings. No sign-up needed.",
};

export default function ToolsPage() {
  return (
    <div className="mx-auto max-w-6xl px-4 py-14">
      <h1 className="text-4xl font-bold tracking-tight">Free online tools</h1>
      <p className="mt-4 max-w-2xl text-lg text-[var(--muted)]">Handy tools that run entirely in your browser. No sign-up, and your data never leaves your device.</p>
      <ul className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        {TOOLS.map((t) => (
          <li key={t.slug}>
            <Link href={`/tools/${t.slug}`} className="block h-full rounded-xl border border-[var(--border)] p-5 transition hover:border-accent">
              <span className="text-xs font-medium uppercase tracking-wide text-[var(--muted)]">{t.category}</span>
              <h2 className="mt-1 font-semibold">{t.name}</h2>
              <p className="mt-1 text-sm text-[var(--muted)]">{t.tagline}</p>
            </Link>
          </li>
        ))}
      </ul>
    </div>
  );
}
