import { listUserWorkspaces } from "@mewe/core";
import { redirect } from "next/navigation";
import { requireUser } from "@/lib/session";

// Entry point after sign-in: go to the active workspace, else the first one, else onboarding.
export default async function DashboardRedirect() {
  const { user, session } = await requireUser();
  const workspaces = await listUserWorkspaces(user.id);
  if (!workspaces.length) redirect("/onboarding");
  const active = workspaces.find((w) => w.id === session.activeOrganizationId) ?? workspaces[0]!;
  redirect(`/w/${active.slug}`);
}
