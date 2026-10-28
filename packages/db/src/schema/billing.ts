import { integer, jsonb, pgTable, text, timestamp, index, boolean } from "drizzle-orm/pg-core";
import { workspaces } from "./workspaces";

export const plans = pgTable("plans", {
  id: text("id").primaryKey(), // free | starter | business | scale
  name: text("name").notNull(),
  priceMonthlyCents: integer("price_monthly_cents").notNull(),
  priceYearlyCents: integer("price_yearly_cents").notNull(),
  stripePriceMonthly: text("stripe_price_monthly"),
  stripePriceYearly: text("stripe_price_yearly"),
  limits: jsonb("limits").$type<PlanLimits>().notNull(),
  sortOrder: integer("sort_order").notNull().default(0),
  public: boolean("public").notNull().default(true),
});

export type PlanLimits = {
  users: number; apps: number; records: number; automations: number;
  aiCreditsMonthly: number; hostedApps: number; mcpWrite: boolean;
};

export const subscriptions = pgTable("subscriptions", {
  workspaceId: text("workspace_id").primaryKey().references(() => workspaces.id, { onDelete: "cascade" }),
  planId: text("plan_id").notNull().references(() => plans.id),
  status: text("status").notNull().default("trialing"), // trialing | active | past_due | canceled
  interval: text("interval").notNull().default("month"),
  stripeCustomerId: text("stripe_customer_id"),
  stripeSubscriptionId: text("stripe_subscription_id"),
  trialEndsAt: timestamp("trial_ends_at", { withTimezone: true }),
  currentPeriodEnd: timestamp("current_period_end", { withTimezone: true }),
  extraSeats: integer("extra_seats").notNull().default(0),
  updatedAt: timestamp("updated_at", { withTimezone: true }).notNull().defaultNow(),
});

// Idempotency for Stripe webhooks.
export const stripeEvents = pgTable("stripe_events", {
  id: text("id").primaryKey(),
  type: text("type").notNull(),
  processedAt: timestamp("processed_at", { withTimezone: true }).notNull().defaultNow(),
});

// Positive = grant/purchase, negative = consumption.
export const aiCreditsLedger = pgTable(
  "ai_credits_ledger",
  {
    id: text("id").primaryKey(),
    workspaceId: text("workspace_id").notNull().references(() => workspaces.id, { onDelete: "cascade" }),
    userId: text("user_id"),
    delta: integer("delta").notNull(),
    reason: text("reason").notNull(), // monthly_grant | purchase | usage
    model: text("model"),
    inputTokens: integer("input_tokens"),
    outputTokens: integer("output_tokens"),
    costMicros: integer("cost_micros"),
    createdAt: timestamp("created_at", { withTimezone: true }).notNull().defaultNow(),
  },
  (t) => [index("ai_ledger_ws_idx").on(t.workspaceId, t.createdAt)],
);
