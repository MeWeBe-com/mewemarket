import type { Metadata } from "next";
import Link from "next/link";
import { notFound } from "next/navigation";
import { TOOLS } from "@mewe/core";
import { Check } from "lucide-react";
import { AppIcon } from "@/components/app-icon";
import { Card } from "@/components/ui";
import ToolMount from "@/components/tools/mount";

type Props = { params: Promise<{ slug: string }> };

export function generateStaticParams() {
  return TOOLS.map((t) => ({ slug: t.slug }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const tool = TOOLS.find((t) => t.slug === slug);
  if (!tool) return {};
  return { title: `${tool.name} - free online tool`, description: `${tool.tagline} ${tool.description}` };
}

export default async function ToolPage({ params }: Props) {
  const { slug } = await params;
  const tool = TOOLS.find((t) => t.slug === slug);
  if (!tool) notFound();
  return (
    <div className="mx-auto max-w-5xl px-4 py-10">
      <nav className="text-sm text-[var(--muted)] print:hidden"><Link href="/tools" className="hover:text-accent">Free tools</Link> / {tool.name}</nav>
      <div className="mt-5 flex items-center gap-4 print:hidden">
        <AppIcon slug={tool.slug} name={tool.name} category={tool.category} size="lg" />
        <div>
          <h1 className="text-3xl font-extrabold sm:text-4xl">{tool.name}</h1>
          <p className="mt-1 text-lg text-[var(--muted)]">{tool.tagline}</p>
        </div>
        <span className="ml-auto hidden rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-bold text-emerald-700 sm:inline dark:text-emerald-400">Free · no sign-up</span>
      </div>
      <Card className="mt-8 p-4 shadow-[var(--shadow-lg)] sm:p-6 print:border-0 print:p-0 print:shadow-none">
        <ToolMount slug={tool.slug} />
      </Card>
      <section className="mt-10 grid gap-4 md:grid-cols-2 print:hidden">
        <Card>
          <h2 className="text-lg font-bold">About this tool</h2>
          <p className="mt-3 leading-relaxed text-[var(--muted)]">{tool.description}</p>
        </Card>
        <Card>
          <h2 className="text-lg font-bold">Features</h2>
          <ul className="mt-3 space-y-2">{tool.features.map((f) => <li key={f} className="flex gap-2"><Check className="mt-0.5 size-4 shrink-0 text-emerald-500" />{f}</li>)}</ul>
        </Card>
      </section>
      <p className="mt-10 text-sm text-[var(--muted)] print:hidden">Need more? <Link href="/apps" className="font-medium text-accent hover:underline">Browse business apps</Link></p>
    </div>
  );
}
