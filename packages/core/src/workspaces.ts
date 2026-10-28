import { randomUUID } from "node:crypto";
import { db, schema } from "@mewe/db";
import { and, eq } from "drizzle-orm";
import { PLANS, TRIAL_DAYS, TRIAL_PLAN_ID } from "./plans";

export type Role = "owner" | "admin" | "member" | "guest";

/** Called once when a workspace is created: starts the Business trial and grants its AI credits. */
export async function startTrial(workspaceId: string) {
  const plan = PLANS.find((p) => p.id === TRIAL_PLAN_ID)!;
  const trialEndsAt = new Date(Date.now() + TRIAL_DAYS * 86_400_000);
  await db.transaction(async (tx) => {
    await tx
      .insert(schema.subscriptions)
      .values({ workspaceId, planId: plan.id, status: "trialing", trialEndsAt, currentPeriodEnd: trialEndsAt })
      .onConflictDoNothing();
    await tx.insert(schema.aiCreditsLedger).values({
      id: randomUUID(), workspaceId, delta: plan.limits.aiCreditsMonthly, reason: "monthly_grant",
    });
  });
}

export async function getMembership(workspaceId: string, userId: string) {
  const [m] = await db
    .select({ role: schema.members.role })
    .from(schema.members)
    .where(and(eq(schema.members.organizationId, workspaceId), eq(schema.members.userId, userId)))
    .limit(1);
  return m ? { role: m.role as Role } : null;
}

export async function listUserWorkspaces(userId: string) {
  return db
    .select({ id: schema.workspaces.id, name: schema.workspaces.name, slug: schema.workspaces.slug, logo: schema.workspaces.logo, role: schema.members.role })
    .from(schema.members)
    .innerJoin(schema.workspaces, eq(schema.members.organizationId, schema.workspaces.id))
    .where(eq(schema.members.userId, userId))
    .orderBy(schema.workspaces.name);
}

export async function getWorkspaceBySlug(slug: string) {
  const [w] = await db.select().from(schema.workspaces).where(eq(schema.workspaces.slug, slug)).limit(1);
  return w ?? null;
}

export async function getSubscription(workspaceId: string) {
  const [s] = await db
    .select({ sub: schema.subscriptions, plan: schema.plans })
    .from(schema.subscriptions)
    .innerJoin(schema.plans, eq(schema.subscriptions.planId, schema.plans.id))
    .where(eq(schema.subscriptions.workspaceId, workspaceId))
    .limit(1);
  return s ?? null;
}

export async function updateWorkspaceSettings(
  workspaceId: string,
  input: { name?: string; currency?: string; timezone?: string; locale?: string },
) {
  await db.update(schema.workspaces).set(input).where(eq(schema.workspaces.id, workspaceId));
}

export async function listMembers(workspaceId: string) {
  return db
    .select({ id: schema.members.id, userId: schema.users.id, name: schema.users.name, email: schema.users.email, image: schema.users.image, role: schema.members.role, joinedAt: schema.members.createdAt })
    .from(schema.members)
    .innerJoin(schema.users, eq(schema.members.userId, schema.users.id))
    .where(eq(schema.members.organizationId, workspaceId))
    .orderBy(schema.members.createdAt);
}

export async function listPendingInvitations(workspaceId: string) {
  return db
    .select({ id: schema.invitations.id, email: schema.invitations.email, role: schema.invitations.role, expiresAt: schema.invitations.expiresAt })
    .from(schema.invitations)
    .where(and(eq(schema.invitations.organizationId, workspaceId), eq(schema.invitations.status, "pending")))
    .orderBy(schema.invitations.createdAt);
}

export function canManageWorkspace(role: Role) {
  return role === "owner" || role === "admin";
}
