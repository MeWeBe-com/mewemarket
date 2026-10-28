import "server-only";
import { getMembership, getWorkspaceBySlug } from "@mewe/core";
import { headers } from "next/headers";
import { notFound, redirect } from "next/navigation";
import { cache } from "react";
import { auth } from "./auth";

export const getSession = cache(async () => auth.api.getSession({ headers: await headers() }));

export async function requireUser() {
  const session = await getSession();
  if (!session) redirect("/sign-in");
  return session;
}

/** Resolves the workspace from the URL slug and checks the user is a member. */
export const requireWorkspace = cache(async (slug: string) => {
  const session = await requireUser();
  const workspace = await getWorkspaceBySlug(slug);
  if (!workspace) notFound();
  const membership = await getMembership(workspace.id, session.user.id);
  if (!membership) notFound();
  return { session, workspace, role: membership.role };
});
