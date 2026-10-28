import type { PlanLimits } from "@mewe/db/schema";

// Source: BRIEF.md §4. Stripe price IDs are filled in by scripts/stripe-seed.ts (M2).
export const PLANS: {
  id: string; name: string; priceMonthlyCents: number; priceYearlyCents: number; sortOrder: number; limits: PlanLimits;
}[] = [
  { id: "free", name: "Free", priceMonthlyCents: 0, priceYearlyCents: 0, sortOrder: 0,
    limits: { users: 3, apps: 3, records: 1_000, automations: 2, aiCreditsMonthly: 50, hostedApps: 0, mcpWrite: false } },
  { id: "starter", name: "Starter", priceMonthlyCents: 1900, priceYearlyCents: 19000, sortOrder: 1,
    limits: { users: 5, apps: -1, records: 25_000, automations: 10, aiCreditsMonthly: 1_000, hostedApps: 1, mcpWrite: true } },
  { id: "business", name: "Business", priceMonthlyCents: 4900, priceYearlyCents: 49000, sortOrder: 2,
    limits: { users: 20, apps: -1, records: 250_000, automations: -1, aiCreditsMonthly: 5_000, hostedApps: 3, mcpWrite: true } },
  { id: "scale", name: "Scale", priceMonthlyCents: 12900, priceYearlyCents: 129000, sortOrder: 3,
    limits: { users: 50, apps: -1, records: -1, automations: -1, aiCreditsMonthly: 20_000, hostedApps: 10, mcpWrite: true } },
];

export const TRIAL_PLAN_ID = "business";
export const TRIAL_DAYS = 14;
