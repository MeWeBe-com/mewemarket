import { PLANS } from "@mewe/core";

// A paid plan chosen on /pricing travels sign-up -> e-mail verification -> onboarding -> billing as
// ?plan=<id>&interval=<month|year>, so the visitor ends on the Stripe card form for that plan.
export type PlanIntent = { plan: (typeof PLANS)[number]; interval: "month" | "year" };

export function parsePlanIntent(plan?: string | null, interval?: string | null): PlanIntent | undefined {
  const p = PLANS.find((x) => x.id === plan && x.priceMonthlyCents > 0);
  if (!p) return undefined;
  return { plan: p, interval: interval === "year" ? "year" : "month" };
}

export function planQuery(intent?: PlanIntent): string {
  return intent ? `plan=${intent.plan.id}&interval=${intent.interval}` : "";
}
