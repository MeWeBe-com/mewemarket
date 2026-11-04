import { FREE_TOOLS, PRO_TOOLS, currentPlan } from "@mewe/core";
import { Crown, Lock } from "lucide-react";
import Link from "next/link";
import { AppIcon } from "@/components/app-icon";
import { requireWorkspace } from "@/lib/session";

export default async function WorkspaceTools({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const { workspace } = await requireWorkspace(slug);
  const plan = await currentPlan(workspace.id);
  const unlocked = plan.id !== "free";
  return (
    <>
      <h1 className="text-3xl font-extrabold">Tools</h1>
      <p className="mt-1 text-sm text-[var(--muted)]">Pro tools are included in every paid plan and the free trial. They run in your browser, so your files stay on your device.</p>
      {!unlocked && (
        <p className="mt-4 rounded-xl bg-accent/10 px-4 py-3 text-sm ring-1 ring-accent/20">
          Your workspace is on the Free plan. <Link href={`/w/${slug}/billing`} className="font-semibold text-accent underline">Upgrade</Link> to unlock the Pro tools.
        </p>
      )}
      <h2 className="mt-8 inline-flex items-center gap-1.5 text-lg font-bold"><Crown className="size-4 text-accent" />Pro tools</h2>
      <ul className="mt-4 grid gap-3 sm:grid-cols-2">
        {PRO_TOOLS.map((t) => (
          <li key={t.slug}>
            <Link href={`/w/${slug}/tools/${t.slug}`} className="surface surface-hover flex h-full items-start gap-4 p-4">
              <AppIcon slug={t.slug} name={t.name} category={t.category} />
              <span className="min-w-0 flex-1">
                <span className="block font-bold">{t.name}</span>
                <span className="mt-0.5 block text-sm leading-relaxed text-[var(--muted)]">{t.tagline}</span>
              </span>
              {!unlocked && <Lock className="size-4 shrink-0 text-[var(--muted)]" />}
            </Link>
          </li>
        ))}
      </ul>
      <h2 className="mt-10 text-lg font-bold">Free tools</h2>
      <ul className="mt-4 grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
        {FREE_TOOLS.map((t) => (
          <li key={t.slug}>
            <Link href={`/tools/${t.slug}`} className="flex items-center gap-3 rounded-xl p-2 text-sm font-semibold hover:bg-[var(--bg-subtle)]">
              <AppIcon slug={t.slug} name={t.name} category={t.category} size="sm" />{t.name}
            </Link>
          </li>
        ))}
      </ul>
    </>
  );
}
