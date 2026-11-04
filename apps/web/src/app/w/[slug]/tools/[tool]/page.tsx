import { currentPlan, getTool } from "@mewe/core";
import { Lock } from "lucide-react";
import Link from "next/link";
import { notFound } from "next/navigation";
import { AppIcon } from "@/components/app-icon";
import ToolMount from "@/components/tools/mount";
import { BUTTON_BASE, BUTTON_PRIMARY, Card } from "@/components/ui";
import { requireWorkspace } from "@/lib/session";

export default async function WorkspaceTool({ params }: { params: Promise<{ slug: string; tool: string }> }) {
  const { slug, tool: toolSlug } = await params;
  const { workspace } = await requireWorkspace(slug);
  const tool = getTool(toolSlug);
  if (!tool?.pro) notFound();
  const plan = await currentPlan(workspace.id);
  return (
    <>
      <nav className="text-sm text-[var(--muted)]"><Link href={`/w/${slug}/tools`} className="hover:text-accent">Tools</Link> / {tool.name}</nav>
      <div className="mt-4 flex items-center gap-3.5">
        <AppIcon slug={tool.slug} name={tool.name} category={tool.category} />
        <div>
          <h1 className="font-display text-xl font-extrabold tracking-tight">{tool.name}</h1>
          <p className="text-sm text-[var(--muted)]">{tool.tagline}</p>
        </div>
      </div>
      {plan.id === "free" ? (
        <Card className="mt-6 flex flex-col items-center p-10 text-center">
          <span className="grid size-12 place-items-center rounded-2xl bg-accent/10 text-accent"><Lock className="size-6" /></span>
          <p className="mt-4 text-lg font-bold">{tool.name} is a Pro tool</p>
          <p className="mt-1 max-w-md text-sm text-[var(--muted)]">It's included in every paid plan. Upgrade {workspace.name} to use it and the other Pro tools.</p>
          <Link href={`/w/${slug}/billing`} className={`${BUTTON_BASE} ${BUTTON_PRIMARY} mt-6 h-10 px-5`}>See plans</Link>
        </Card>
      ) : (
        <Card className="mt-6 p-4 sm:p-6"><ToolMount slug={tool.slug} /></Card>
      )}
    </>
  );
}
