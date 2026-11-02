import { PLANS, canManageWorkspace, currentPlan, listInstalledApps, listMembers, workspaceRecordCount } from "@mewe/core";
import { Check, CreditCard, Database, LayoutGrid, Sparkles, Users } from "lucide-react";
import { Alert, BUTTON_BASE, BUTTON_PRIMARY, BUTTON_SECONDARY, Card } from "@/components/ui";
import { requireWorkspace } from "@/lib/session";
import { billingEnabled } from "@/lib/stripe";
import { checkoutAction, portalAction } from "./actions";

export const metadata = { title: "Plan & billing" };

const usd = (c: number) => `$${(c / 100).toLocaleString("en-US")}`;
const lim = (n: number) => (n < 0 ? "Unlimited" : n.toLocaleString("en-US"));

function Usage({ icon: Icon, label, used, max, color }: { icon: typeof Users; label: string; used: number; max: number; color: string }) {
  const pct = max < 0 ? 0 : Math.min(100, Math.round((used / Math.max(max, 1)) * 100));
  const bar = pct >= 90 ? "#ef4444" : pct >= 75 ? "#f59e0b" : color;
  return (
    <div className="rounded-xl bg-[var(--bg-subtle)] p-4 ring-1 ring-[var(--border)]">
      <div className="flex items-center gap-2 text-sm text-[var(--muted)]"><Icon className="size-4" style={{ color }} />{label}</div>
      <p className="mt-2 font-display text-2xl font-extrabold">{used.toLocaleString("en-US")}<span className="text-sm font-semibold text-[var(--muted)]"> / {lim(max)}</span></p>
      <div className="mt-3 h-1.5 overflow-hidden rounded-full bg-[var(--border)]">
        <div className="h-full rounded-full transition-all" style={{ width: max < 0 ? "6%" : `${Math.max(pct, 2)}%`, background: bar }} />
      </div>
    </div>
  );
}

export default async function BillingPage({ params, searchParams }: { params: Promise<{ slug: string }>; searchParams: Promise<{ success?: string; error?: string }> }) {
  const { slug } = await params;
  const sp = await searchParams;
  const { workspace, role } = await requireWorkspace(slug);
  const [plan, apps, members, records] = await Promise.all([currentPlan(workspace.id), listInstalledApps(workspace.id), listMembers(workspace.id), workspaceRecordCount(workspace.id)]);
  const manage = canManageWorkspace(role);
  const paying = !!plan.sub?.stripeSubscriptionId && plan.status !== "canceled";
  const label = { trialing: "Free trial", active: "Active", past_due: "Payment overdue", canceled: "Cancelled", trial_expired: "Trial ended", none: "Free" }[plan.status];
  const statusColor = plan.status === "active" ? "#10b981" : plan.status === "past_due" || plan.status === "trial_expired" ? "#ef4444" : "#5b5bf6";

  return (
    <>
      <h1 className="text-3xl font-extrabold">Plan & billing</h1>
      <p className="mt-1 text-[var(--muted)]">Your plan, what you're using, and how to upgrade.</p>
      {sp.success && <div className="mt-4"><Alert tone="success">Thanks! Your plan is being updated. It can take a few seconds to show here.</Alert></div>}
      {sp.error && <div className="mt-4"><Alert>{sp.error}</Alert></div>}

      <Card className="mt-6 overflow-hidden p-0">
        <div className="relative flex flex-wrap items-center gap-4 bg-gradient-to-br from-[#5b5bf6] via-[#7c3aed] to-[#c026d3] p-6 text-white">
          <div aria-hidden className="bg-grid absolute inset-0 opacity-20 [mask-image:linear-gradient(to_left,black,transparent)]" />
          <span className="relative grid size-12 place-items-center rounded-2xl bg-white/15"><Sparkles className="size-6" /></span>
          <div className="relative">
            <p className="text-sm text-white/70">Current plan</p>
            <p className="font-display text-2xl font-extrabold">{plan.name}</p>
          </div>
          <span className="relative ml-auto inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1 text-xs font-bold" style={{ color: statusColor }}>
            <span className="size-1.5 rounded-full" style={{ background: statusColor }} />{label}
          </span>
        </div>
        <div className="p-6">
          {plan.status === "trialing" && plan.sub?.trialEndsAt && <p className="mb-4 text-sm text-[var(--muted)]">Trial ends <strong className="text-[var(--fg)]">{plan.sub.trialEndsAt.toLocaleDateString("en-US", { dateStyle: "long" })}</strong>. Choose a plan to keep all features.</p>}
          {plan.status === "trial_expired" && <p className="mb-4 text-sm text-[var(--muted)]">Your trial has ended, so Free plan limits apply. Your data is safe.</p>}
          <div className="grid gap-3 sm:grid-cols-3">
            <Usage icon={LayoutGrid} label="Apps" used={apps.length} max={plan.limits.apps} color="#5b5bf6" />
            <Usage icon={Users} label="Members" used={members.length} max={plan.limits.users} color="#0ea5e9" />
            <Usage icon={Database} label="Records" used={records} max={plan.limits.records} color="#10b981" />
          </div>
          {paying && manage && billingEnabled && (
            <form action={portalAction.bind(null, slug)} className="mt-5"><button className={`${BUTTON_BASE} ${BUTTON_SECONDARY}`}><CreditCard className="size-4" />Manage billing, invoices and payment method</button></form>
          )}
        </div>
      </Card>

      {!billingEnabled && <div className="mt-6"><Alert>Online payments are not switched on yet. Contact us to upgrade.</Alert></div>}

      <h2 className="mt-10 text-lg font-bold">Plans</h2>
      <div className="mt-4 grid gap-4 md:grid-cols-3">
        {PLANS.filter((p) => p.priceMonthlyCents > 0).map((p) => {
          const current = p.id === plan.id && plan.status !== "trial_expired";
          return (
            <Card key={p.id} className={`relative flex flex-col p-6 ${current ? "!border-accent ring-4 ring-accent/15" : ""}`}>
              {current && <span className="absolute -top-3 left-6 rounded-full bg-accent px-3 py-0.5 text-xs font-bold text-white">Your plan</span>}
              <p className="text-lg font-bold">{p.name}</p>
              <p className="mt-2"><span className="font-display text-4xl font-extrabold">{usd(p.priceMonthlyCents)}</span><span className="text-sm text-[var(--muted)]"> / month</span></p>
              <p className="text-xs text-[var(--muted)]">or {usd(p.priceYearlyCents)} a year (2 months free)</p>
              <ul className="mt-5 flex-1 space-y-2 text-sm">
                {[`${lim(p.limits.users)} members`, `${p.limits.apps < 0 ? "All" : lim(p.limits.apps)} apps`, `${lim(p.limits.records)} records`].map((t) => (
                  <li key={t} className="flex gap-2"><Check className="mt-0.5 size-4 shrink-0 text-emerald-500" strokeWidth={3} />{t}</li>
                ))}
              </ul>
              {manage && billingEnabled && (
                <div className="mt-6 grid grid-cols-2 gap-2">
                  <form action={checkoutAction.bind(null, slug, p.id, "month")}><button className={`${BUTTON_BASE} ${BUTTON_PRIMARY} w-full`}>Monthly</button></form>
                  <form action={checkoutAction.bind(null, slug, p.id, "year")}><button className={`${BUTTON_BASE} ${BUTTON_SECONDARY} w-full`}>Yearly</button></form>
                </div>
              )}
            </Card>
          );
        })}
      </div>
    </>
  );
}
