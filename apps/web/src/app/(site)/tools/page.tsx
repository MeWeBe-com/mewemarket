import type { Metadata } from "next";
import Link from "next/link";
import { CATEGORIES, TOOLS } from "@mewe/core";
import { ShieldCheck, Sparkles, UserX } from "lucide-react";
import { AppIcon } from "@/components/app-icon";
import { PageHero } from "@/components/site/page-hero";

export const metadata: Metadata = {
  title: "Free online tools",
  description: "Free tools that run in your browser: invoice generator, QR codes, calculators, developer utilities, a whiteboard and video meetings. No sign-up needed.",
};

const GROUP_NAME: Record<string, string> = { developer: "Developer tools" };

export default function ToolsPage() {
  const groups = [...new Set(TOOLS.map((t) => t.category))].sort((a, b) => TOOLS.filter((t) => t.category === b).length - TOOLS.filter((t) => t.category === a).length);
  return (
    <>
      <PageHero tint="#10b981" eyebrow={<><Sparkles className="size-4" />Free forever</>} title={<>{TOOLS.length} free online tools</>}
        intro="Handy tools that run entirely in your browser. No sign-up, and your data never leaves your device.">
        <ul className="mt-6 flex flex-wrap gap-2 text-sm">
          {[[UserX, "No account needed"], [ShieldCheck, "Runs on your device"], [Sparkles, "No ads, no limits"]].map(([I, t]) => {
            const Icon = I as typeof Sparkles;
            return <li key={t as string} className="inline-flex items-center gap-1.5 rounded-full border border-[var(--border)] bg-[var(--card)] px-3 py-1.5 font-medium shadow-[var(--shadow-sm)]"><Icon className="size-4 text-emerald-500" />{t as string}</li>;
          })}
        </ul>
      </PageHero>
      <div className="mx-auto max-w-6xl space-y-14 px-4 py-12">
        {groups.map((g) => (
          <section key={g}>
            <h2 className="text-xl font-bold">{GROUP_NAME[g] ?? CATEGORIES.find((c) => c.slug === g)?.name ?? g}</h2>
            <ul className="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
              {TOOLS.filter((t) => t.category === g).map((t) => (
                <li key={t.slug}>
                  <Link href={`/tools/${t.slug}`} className="surface surface-hover flex h-full items-start gap-4 p-4">
                    <AppIcon slug={t.slug} name={t.name} category={t.category} />
                    <span className="min-w-0">
                      <span className="block font-bold">{t.name}</span>
                      <span className="mt-0.5 block text-sm leading-relaxed text-[var(--muted)]">{t.tagline}</span>
                    </span>
                  </Link>
                </li>
              ))}
            </ul>
          </section>
        ))}
      </div>
    </>
  );
}
