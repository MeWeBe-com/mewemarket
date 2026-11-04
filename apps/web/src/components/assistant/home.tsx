import { AI_PROVIDERS, canManageWorkspace, getAiSettings, listInstalledApps, type Role } from "@mewe/core";
import { KeyRound } from "lucide-react";
import { uninstallAppAction } from "@/app/w/[slug]/a/actions";
import { Card } from "@/components/ui";
import { AssistantChat } from "./chat";
import { AssistantSettingsForm } from "./settings-form";

// Starter questions picked from the apps the workspace actually uses.
const SUGGEST: Record<string, string> = {
  crm: "Which deals are most likely to close this month?",
  invoices: "Which invoices are overdue, and how much is owed?",
  projects: "What tasks are due this week?",
  inventory: "Which products are running low?",
  "team-hr": "Who is on the team and what are their roles?",
  bookings: "What bookings do we have coming up?",
};

export async function AssistantHome({ slug, workspaceId, role }: { slug: string; workspaceId: string; role: Role }) {
  const [settings, installed] = await Promise.all([getAiSettings(workspaceId), listInstalledApps(workspaceId)]);
  const apps = installed.filter((a) => !a.kind);
  const suggestions = [...apps.map((a) => SUGGEST[a.slug]).filter((s): s is string => !!s), "Give me a quick summary of my workspace"].slice(0, 4);
  const manage = canManageWorkspace(role);

  return (
    <div className="grid gap-6 lg:grid-cols-[1fr_340px]">
      <div className="min-w-0 space-y-4">
        {!settings.hasKey && (
          <Card className="flex items-start gap-3 border-amber-500/40 bg-amber-500/5 p-4 text-sm">
            <KeyRound className="mt-0.5 size-5 shrink-0 text-amber-600" />
            <p>{manage ? "Add your Claude or OpenAI API key in the settings to switch the assistant on." : "An owner or admin needs to add an AI API key before the assistant can answer."}</p>
          </Card>
        )}
        <AssistantChat slug={slug} name={settings.name} suggestions={suggestions} ready={settings.hasKey} />
        {!apps.length && <p className="text-sm text-[var(--muted)]">Tip: add apps such as CRM or Invoices from the App Store so the assistant has data to work with.</p>}
      </div>
      <aside className="space-y-4">
        <Card className="p-5">
          <h2 className="font-bold">Assistant settings</h2>
          <p className="mt-1 text-xs text-[var(--muted)]">
            {settings.hasKey ? `Using ${AI_PROVIDERS[settings.provider].name}, model ${settings.model}.` : "Not switched on yet."}
          </p>
          <div className="mt-4">
            {manage ? (
              <AssistantSettingsForm
                slug={slug}
                providers={Object.entries(AI_PROVIDERS).map(([id, p]) => ({ id, ...p }))}
                current={{ provider: settings.provider, model: settings.model, name: settings.name, instructions: settings.instructions, hasKey: settings.hasKey, keyEnd: settings.keyEnd }}
              />
            ) : <p className="text-sm text-[var(--muted)]">Only owners and admins can change these.</p>}
          </div>
        </Card>
        <Card className="p-5 text-sm text-[var(--muted)]">
          <p className="font-semibold text-[var(--fg)]">Your data</p>
          <p className="mt-1">Only the records needed for each question are sent to your AI provider, using your key. The assistant can read records in installed apps but can't change or delete anything.</p>
        </Card>
        {manage && (
          <details className="text-sm">
            <summary className="cursor-pointer text-[var(--muted)]">Remove app</summary>
            <form action={uninstallAppAction.bind(null, slug, "ai-assistant")} className="mt-3 space-y-3 rounded-lg border border-red-500/30 p-4">
              <p>Removes the AI Assistant from your workspace. Your records aren't affected.</p>
              <button className="h-9 rounded-lg bg-red-600 px-4 font-semibold text-white hover:bg-red-500">Remove AI Assistant</button>
            </form>
          </details>
        )}
      </aside>
    </div>
  );
}
