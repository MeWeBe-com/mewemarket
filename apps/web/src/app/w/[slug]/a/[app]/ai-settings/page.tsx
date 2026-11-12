import { AI_PROVIDERS, canManageWorkspace, getAiSettings } from "@mewe/core";
import Link from "next/link";
import { notFound } from "next/navigation";
import { AssistantSettingsForm } from "@/components/assistant/settings-form";
import { Card } from "@/components/ui";
import { appContext } from "../../context";

// The company's Claude or OpenAI key and model for AI Chat (shared with the AI Assistant). Owners and admins only.
export default async function AiSettingsPage({ params }: { params: Promise<{ slug: string; app: string }> }) {
  const { slug, app: appSlug } = await params;
  const { app, workspace, role } = await appContext(slug, appSlug);
  if (app.hosted?.provider !== "openwebui") notFound();
  if (!canManageWorkspace(role)) notFound();
  const s = await getAiSettings(workspace.id);
  return (
    <div className="max-w-2xl space-y-4">
      <Link href={`/${slug}/${app.slug}`} className="text-sm text-[var(--muted)] hover:text-accent">← {app.name}</Link>
      <h1 className="text-2xl font-extrabold">{app.name} settings</h1>
      <p className="text-sm text-[var(--muted)]">{app.name} uses your company&apos;s own Claude or OpenAI key, saved encrypted in MeweMarket. The AI app never sees it. The same key is used by the AI Assistant.</p>
      <Card>
        <AssistantSettingsForm slug={slug} providers={Object.entries(AI_PROVIDERS).map(([id, p]) => ({ id, ...p }))}
          current={{ provider: s.provider, model: s.model, name: s.name, instructions: s.instructions, hasKey: s.hasKey, keyEnd: s.keyEnd }} />
      </Card>
    </div>
  );
}
