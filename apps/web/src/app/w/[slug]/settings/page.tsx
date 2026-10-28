import { canManageWorkspace, getSubscription } from "@mewe/core";
import { Card } from "@/components/ui";
import { requireWorkspace } from "@/lib/session";
import { WorkspaceSettingsForm } from "./form";

export default async function SettingsPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const { workspace, role } = await requireWorkspace(slug);
  const sub = await getSubscription(workspace.id);
  return (
    <>
      <h1 className="text-2xl font-bold">Workspace settings</h1>
      <Card className="mt-8">
        <WorkspaceSettingsForm slug={slug} disabled={!canManageWorkspace(role)}
          values={{ name: workspace.name, currency: workspace.currency, timezone: workspace.timezone, locale: workspace.locale }} />
      </Card>
      <Card className="mt-6">
        <h2 className="font-semibold">Plan</h2>
        <p className="mt-2 text-sm text-[var(--muted)]">
          {sub ? `${sub.plan.name} · ${sub.sub.status}` : "No plan"}. Billing management arrives with Stripe (M2).
        </p>
      </Card>
    </>
  );
}
