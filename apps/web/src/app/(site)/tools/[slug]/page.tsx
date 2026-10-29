import type { Metadata } from "next";
import Link from "next/link";
import { notFound } from "next/navigation";
import { TOOLS } from "@mewe/core";
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
      <h1 className="mt-3 text-3xl font-bold tracking-tight sm:text-4xl print:hidden">{tool.name}</h1>
      <p className="mt-2 text-lg text-[var(--muted)] print:hidden">{tool.tagline}</p>
      <Card className="mt-8 p-4 sm:p-6 print:border-0 print:p-0">
        <ToolMount slug={tool.slug} />
      </Card>
      <section className="mt-10 grid gap-8 md:grid-cols-2 print:hidden">
        <div>
          <h2 className="text-xl font-semibold">About this tool</h2>
          <p className="mt-3 text-[var(--muted)]">{tool.description}</p>
        </div>
        <div>
          <h2 className="text-xl font-semibold">Features</h2>
          <ul className="mt-3 list-disc space-y-1 pl-5 text-[var(--muted)]">{tool.features.map((f) => <li key={f}>{f}</li>)}</ul>
        </div>
      </section>
      <p className="mt-10 text-sm text-[var(--muted)] print:hidden">Need more? <Link href="/apps" className="font-medium text-accent hover:underline">Browse business apps</Link></p>
    </div>
  );
}
