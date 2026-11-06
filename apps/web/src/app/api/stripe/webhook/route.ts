import { applyStripeSubscription, claimStripeEvent, releaseStripeEvent } from "@mewe/core";
import type Stripe from "stripe";
import { stripe } from "@/lib/stripe";

const STATUS: Record<string, string> = {
  active: "active", trialing: "trialing", past_due: "past_due", unpaid: "unpaid", canceled: "canceled",
  incomplete: "incomplete", incomplete_expired: "canceled", paused: "paused",
};

// Always re-read the subscription: Stripe doesn't guarantee event order, so the payload may be stale.
async function sync(id: string) {
  const sub = await stripe!.subscriptions.retrieve(id);
  const workspaceId = sub.metadata.workspaceId;
  const planId = sub.metadata.planId;
  if (!workspaceId || !planId) return;
  const item = sub.items.data[0];
  await applyStripeSubscription({
    workspaceId, planId,
    status: STATUS[sub.status] ?? "past_due",
    interval: item?.price.recurring?.interval ?? "month",
    customerId: typeof sub.customer === "string" ? sub.customer : sub.customer.id,
    subscriptionId: sub.id,
    periodEnd: item?.current_period_end ? new Date(item.current_period_end * 1000) : null,
    trialEnd: sub.trial_end ? new Date(sub.trial_end * 1000) : null,
  });
}

export async function POST(req: Request) {
  const secret = process.env.STRIPE_WEBHOOK_SECRET;
  if (!stripe || !secret) return new Response("Billing disabled", { status: 503 });
  let event: Stripe.Event;
  try {
    event = stripe.webhooks.constructEvent(await req.text(), req.headers.get("stripe-signature") ?? "", secret);
  } catch {
    return new Response("Bad signature", { status: 400 });
  }
  if (!(await claimStripeEvent(event.id, event.type))) return Response.json({ duplicate: true });
  try {
    switch (event.type) {
      case "checkout.session.completed": {
        const s = event.data.object;
        if (s.subscription) await sync(String(s.subscription));
        break;
      }
      case "customer.subscription.created":
      case "customer.subscription.updated":
      case "customer.subscription.deleted":
        await sync(event.data.object.id);
        break;
    }
  } catch (e) {
    await releaseStripeEvent(event.id);
    throw e;
  }
  return Response.json({ received: true });
}
