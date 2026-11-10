import { listUserWorkspaces } from "@mewe/core";
import { redirect } from "next/navigation";
import { requireUser } from "@/lib/session";

// Entry point after sign-in: go to the active workspace, else the first one, else onboarding.
export default async function DashboardRedirect({ searchParams }: { searchParams: Promise<{ to?: string }> }) {
  const { to } = await searchParams;
  const { user, session } = await requireUser();
  const workspaces = await listUserWorkspaces(user.id);
  if (!workspaces.length) redirect("/onboarding");
  const active = workspaces.find((w) => w.id === session.activeOrganizationId) ?? workspaces[0]!;
  // `to` deep-links into the workspace, e.g. from a Pro tool's public page.
  redirect(`/${active.slug}${to && /^tools\/[a-z0-9-]+$/.test(to) ? `/${to}` : ""}`);
}
