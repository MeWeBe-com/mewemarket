import { PLANS, canManageWorkspace, currentPlan, listInstalledApps, listMembers } from "@mewe/core";
import { Alert, Card } from "@/components/ui";
import { requireWorkspace } from "@/lib/session";
import { billingEnabled } from "@/lib/stripe";
import { checkoutAction, portalAction } from "./actions";

export const metadata = { title: "Plan & billing" };

const usd = (c: number) => `$${(c / 100).toLocaleString("en-US")}`;
const lim = (n: number) => (n < 0 ? "Unlimited" : n.toLocaleString("en-US"));

export default async function BillingPage({ params, searchParams }: { params: Promise<{ slug: string }>; searchParams: Promise<{ success?: string; error?: string }> }) {
  const { slug } = await params;
  const sp = await searchParams;
  const { workspace, role } = await requireWorkspace(slug);
  const [plan, apps, members] = await Promise.all([currentPlan(workspace.id), listInstalledApps(workspace.id), listMembers(workspace.id)]);
  const manage = canManageWorkspace(role);
  const paying = !!plan.sub?.stripeSubscriptionId && plan.status !== "canceled";
  const label = { trialing: "Free trial", active: "Active", past_due: "Payment overdue", canceled: "Cancelled", trial_expired: "Trial ended", none: "Free" }[plan.status];

  return (
    <>
      <h1 className="text-2xl font-bold">Plan & billing</h1>
      {sp.success && <div className="mt-4"><Alert tone="success">Thanks! Your plan is being updated. It can take a few seconds to show here.</Alert></div>}
      {sp.error && <div className="mt-4"><Alert>{sp.error}</Alert></div>}
      <Card className="mt-6">
        <p className="text-sm text-[var(--muted)]">Current plan</p>
        <p className="mt-1 text-xl font-semibold">{plan.name} <span className="ml-2 rounded-full bg-accent/10 px-2 py-0.5 text-xs font-medium text-accent">{label}</span></p>
        {plan.status === "trialing" && plan.sub?.trialEndsAt && <p className="mt-1 text-sm text-[var(--muted)]">Trial ends {plan.sub.trialEndsAt.toLocaleDateString("en-US", { dateStyle: "long" })}. Choose a plan to keep all features.</p>}
        {plan.status === "trial_expired" && <p className="mt-1 text-sm text-[var(--muted)]">Your trial has ended, so Free plan limits apply. Your data is safe.</p>}
        <dl className="mt-4 grid grid-cols-3 gap-4 text-sm">
          <div><dt className="text-[var(--muted)]">Apps</dt><dd className="font-semibold">{apps.length} / {lim(plan.limits.apps)}</dd></div>
          <div><dt className="text-[var(--muted)]">Members</dt><dd className="font-semibold">{members.length} / {lim(plan.limits.users)}</dd></div>
          <div><dt className="text-[var(--muted)]">Records</dt><dd className="font-semibold">{lim(plan.limits.records)}</dd></div>
        </dl>
        {paying && manage && billingEnabled && (
          <form action={portalAction.bind(null, slug)} className="mt-4"><button className="h-9 rounded-lg border border-[var(--border)] px-4 text-sm font-semibold">Manage billing, invoices and payment method</button></form>
        )}
      </Card>

      {!billingEnabled && <div className="mt-6"><Alert>Online payments are not switched on yet. Contact us to upgrade.</Alert></div>}

      <div className="mt-6 grid gap-4 md:grid-cols-3">
        {PLANS.filter((p) => p.priceMonthlyCents > 0).map((p) => (
          <Card key={p.id} className={`flex flex-col ${p.id === plan.id && plan.status !== "trial_expired" ? "border-accent" : ""}`}>
            <p className="font-semibold">{p.name}</p>
            <p className="mt-1"><span className="text-2xl font-bold">{usd(p.priceMonthlyCents)}</span><span className="text-sm text-[var(--muted)]"> / month</span></p>
            <p className="text-xs text-[var(--muted)]">or {usd(p.priceYearlyCents)} a year (2 months free)</p>
            <ul className="mt-4 flex-1 space-y-1 text-sm">
              <li>{lim(p.limits.users)} members</li><li>{lim(p.limits.apps)} apps</li><li>{lim(p.limits.records)} records</li>
            </ul>
            {manage && billingEnabled && (
              <div className="mt-4 flex gap-2">
                <form action={checkoutAction.bind(null, slug, p.id, "month")}><button className="h-9 rounded-lg bg-accent px-3 text-sm font-semibold text-white hover:bg-indigo-500">Monthly</button></form>
                <form action={checkoutAction.bind(null, slug, p.id, "year")}><button className="h-9 rounded-lg border border-[var(--border)] px-3 text-sm font-semibold">Yearly</button></form>
              </div>
            )}
          </Card>
        ))}
      </div>
    </>
  );
}
