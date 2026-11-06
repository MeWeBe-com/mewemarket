import { db, schema } from "@mewe/db";
import { eq } from "drizzle-orm";
import { PLANS } from "./plans";
import { getSubscription } from "./workspaces";

const FREE = PLANS.find((p) => p.id === "free")!;

/** The plan whose limits apply now: an expired trial or ended subscription falls back to Free. */
export async function currentPlan(workspaceId: string) {
  const s = await getSubscription(workspaceId);
  if (!s) return { ...FREE, status: "none" as const, sub: null };
  const now = Date.now();
  const trialOver = s.sub.status === "trialing" && (!s.sub.trialEndsAt || s.sub.trialEndsAt.getTime() < now);
  // Only these statuses grant the paid plan; anything else (canceled, unpaid, incomplete, paused) gets Free limits.
  const ended = !["active", "trialing", "past_due"].includes(s.sub.status);
  if (trialOver || ended) return { ...FREE, status: trialOver ? ("trial_expired" as const) : ("canceled" as const), sub: s.sub };
  const plan = PLANS.find((p) => p.id === s.plan.id) ?? FREE;
  return { ...plan, status: s.sub.status as "trialing" | "active" | "past_due", sub: s.sub };
}

/** Applied from verified Stripe webhooks only. */
export async function applyStripeSubscription(input: {
  workspaceId: string; planId: string; status: string; interval: string; customerId: string; subscriptionId: string;
  periodEnd: Date | null; trialEnd: Date | null;
}) {
  if (!PLANS.some((p) => p.id === input.planId)) throw new Error(`Unknown plan ${input.planId}`);
  // A late event about an old, ended subscription must not overwrite the workspace's newer live one.
  const [cur] = await db.select().from(schema.subscriptions).where(eq(schema.subscriptions.workspaceId, input.workspaceId)).limit(1);
  const live = (st: string) => ["active", "trialing", "past_due"].includes(st);
  if (cur?.stripeSubscriptionId && cur.stripeSubscriptionId !== input.subscriptionId && live(cur.status) && !live(input.status)) return;
  const values = {
    planId: input.planId, status: input.status, interval: input.interval, stripeCustomerId: input.customerId,
    stripeSubscriptionId: input.subscriptionId, currentPeriodEnd: input.periodEnd, updatedAt: new Date(),
    ...(input.status === "trialing" ? { trialEndsAt: input.trialEnd } : {}),
  };
  await db.insert(schema.subscriptions).values({ workspaceId: input.workspaceId, ...values })
    .onConflictDoUpdate({ target: schema.subscriptions.workspaceId, set: values });
}

/** Records a webhook event id; false means it was already handled. */
export async function claimStripeEvent(id: string, type: string) {
  const res = await db.insert(schema.stripeEvents).values({ id, type }).onConflictDoNothing().returning({ id: schema.stripeEvents.id });
  return res.length > 0;
}

export async function setStripeCustomer(workspaceId: string, customerId: string) {
  await db.update(schema.subscriptions).set({ stripeCustomerId: customerId }).where(eq(schema.subscriptions.workspaceId, workspaceId));
}

/** Undoes claimStripeEvent when processing failed, so Stripe's retry is handled. */
export async function releaseStripeEvent(id: string) {
  await db.delete(schema.stripeEvents).where(eq(schema.stripeEvents.id, id));
}
