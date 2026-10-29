"use server";
import { PLANS, canManageWorkspace, getSubscription, setStripeCustomer } from "@mewe/core";
import { redirect } from "next/navigation";
import { requireWorkspace } from "@/lib/session";
import { stripe } from "@/lib/stripe";

const appUrl = process.env.APP_URL ?? "http://localhost:3000";

async function owner(slug: string) {
  const ctx = await requireWorkspace(slug);
  if (!canManageWorkspace(ctx.role)) redirect(`/w/${slug}/billing?error=${encodeURIComponent("Only owners and admins can change the plan.")}`);
  if (!stripe) redirect(`/w/${slug}/billing?error=${encodeURIComponent("Online payments are not switched on yet.")}`);
  return { ...ctx, stripe };
}

export async function checkoutAction(slug: string, planId: string, interval: "month" | "year") {
  const { workspace, session, stripe } = await owner(slug);
  const plan = PLANS.find((p) => p.id === planId && p.priceMonthlyCents > 0);
  if (!plan) redirect(`/w/${slug}/billing`);
  const sub = await getSubscription(workspace.id);
  let customer = sub?.sub.stripeCustomerId ?? undefined;
  if (!customer) {
    customer = (await stripe.customers.create({ name: workspace.name, email: session.user.email, metadata: { workspaceId: workspace.id } })).id;
    await setStripeCustomer(workspace.id, customer);
  }
  // Already paying: plan changes go through the portal so proration is handled by Stripe.
  if (sub?.sub.stripeSubscriptionId && sub.sub.status !== "canceled") return portalAction(slug);
  const checkout = await stripe.checkout.sessions.create({
    mode: "subscription",
    customer,
    client_reference_id: workspace.id,
    line_items: [{
      quantity: 1,
      price_data: {
        currency: "usd",
        unit_amount: interval === "year" ? plan.priceYearlyCents : plan.priceMonthlyCents,
        recurring: { interval },
        product_data: { name: `MeweMarket ${plan.name}` },
      },
    }],
    subscription_data: { metadata: { workspaceId: workspace.id, planId: plan.id } },
    metadata: { workspaceId: workspace.id, planId: plan.id },
    allow_promotion_codes: true,
    success_url: `${appUrl}/w/${slug}/billing?success=1`,
    cancel_url: `${appUrl}/w/${slug}/billing`,
  });
  redirect(checkout.url!);
}

export async function portalAction(slug: string) {
  const { workspace, stripe } = await owner(slug);
  const sub = await getSubscription(workspace.id);
  if (!sub?.sub.stripeCustomerId) redirect(`/w/${slug}/billing`);
  const portal = await stripe.billingPortal.sessions.create({ customer: sub.sub.stripeCustomerId, return_url: `${appUrl}/w/${slug}/billing` });
  redirect(portal.url);
}
