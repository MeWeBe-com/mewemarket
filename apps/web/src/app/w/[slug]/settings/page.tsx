import { canManageWorkspace, getSubscription } from "@mewe/core";
import { ArrowRight } from "lucide-react";
import Link from "next/link";
import { Card } from "@/components/ui";
import { requireWorkspace } from "@/lib/session";
import { WorkspaceSettingsForm } from "./form";

function Section({ title, body, children }: { title: string; body: string; children: React.ReactNode }) {
  return (
    <section className="grid gap-4 border-t border-[var(--border)] py-8 first:border-t-0 first:pt-0 lg:grid-cols-[260px_1fr] lg:gap-10">
      <div><h2 className="font-bold">{title}</h2><p className="mt-1 text-sm text-[var(--muted)]">{body}</p></div>
      {children}
    </section>
  );
}

export default async function SettingsPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const { workspace, role } = await requireWorkspace(slug);
  const sub = await getSubscription(workspace.id);
  const manage = canManageWorkspace(role);
  return (
    <>
      <h1 className="text-3xl font-extrabold">Workspace settings</h1>
      <p className="mt-1 text-[var(--muted)]">{manage ? "Changes apply to everyone in the workspace." : "Only owners and admins can change these settings."}</p>
      <div className="mt-8">
        <Section title="General" body="Your workspace name, and how money, dates and times are shown in every app.">
          <Card className="p-6">
            <WorkspaceSettingsForm slug={slug} disabled={!manage}
              values={{ name: workspace.name, currency: workspace.currency, timezone: workspace.timezone, locale: workspace.locale }} />
          </Card>
        </Section>
        <Section title="Plan" body="Your subscription and what it includes.">
          <Card className="flex flex-wrap items-center justify-between gap-4 p-6">
            <div>
              <p className="font-display text-xl font-extrabold">{sub?.plan.name ?? "Free"}</p>
              <p className="text-sm capitalize text-[var(--muted)]">{sub ? sub.sub.status.replace(/_/g, " ") : "No subscription"}</p>
            </div>
            <Link href={`/w/${slug}/billing`} className="inline-flex items-center gap-1 text-sm font-semibold text-accent hover:underline">Plan & billing <ArrowRight className="size-4" /></Link>
          </Card>
        </Section>
        <Section title="Members" body="Invite your team and choose what each person can do.">
          <Card className="flex flex-wrap items-center justify-between gap-4 p-6">
            <p className="text-sm text-[var(--muted)]">Owner, admin, member and read-only guest roles.</p>
            <Link href={`/w/${slug}/settings/members`} className="inline-flex items-center gap-1 text-sm font-semibold text-accent hover:underline">Manage members <ArrowRight className="size-4" /></Link>
          </Card>
        </Section>
      </div>
    </>
  );
}
