// Hosted apps: open-source products (e.g. Twenty CRM) run as their own service and shown inside a workspace.
// Each MeweMarket workspace gets its own tenant in the product; each person gets an account there that only
// MeweMarket signs in to (the password is random and stored encrypted), so they never log in twice.
import { pgTable, primaryKey, text, timestamp, uniqueIndex } from "drizzle-orm/pg-core";
import { users } from "./auth";
import { workspaces } from "./workspaces";

/** A workspace's tenant inside a hosted product. Kept when the app is removed, so adding it back restores the data. */
export const hostedTenants = pgTable(
  "hosted_tenants",
  {
    id: text("id").primaryKey(),
    workspaceId: text("workspace_id").notNull().references(() => workspaces.id, { onDelete: "cascade" }),
    provider: text("provider").notNull(), // twenty
    externalId: text("external_id").notNull(),
    subdomain: text("subdomain").notNull(),
    url: text("url").notNull(),
    createdAt: timestamp("created_at", { withTimezone: true }).notNull().defaultNow(),
  },
  (t) => [uniqueIndex("hosted_tenant_ws_provider_uq").on(t.workspaceId, t.provider)],
);

/**
 * A person's sign-in for a hosted product. Products that keep each company apart per user (Twenty) share one
 * account across the person's workspaces (scope ""); products where one account would see every company it
 * belongs to (InvoiceShelf) get one account per tenant (scope = tenant id).
 */
export const hostedAccounts = pgTable(
  "hosted_accounts",
  {
    id: text("id").primaryKey(),
    provider: text("provider").notNull(),
    userId: text("user_id").notNull().references(() => users.id, { onDelete: "cascade" }),
    scope: text("scope").notNull().default(""),
    login: text("login").notNull(),
    passwordEnc: text("password_enc").notNull(),
    createdAt: timestamp("created_at", { withTimezone: true }).notNull().defaultNow(),
  },
  (t) => [uniqueIndex("hosted_account_provider_user_uq").on(t.provider, t.userId, t.scope)],
);

/** A person's membership in a tenant, so it can be removed or re-roled when the workspace changes. */
export const hostedMembers = pgTable(
  "hosted_members",
  {
    tenantId: text("tenant_id").notNull().references(() => hostedTenants.id, { onDelete: "cascade" }),
    userId: text("user_id").notNull().references(() => users.id, { onDelete: "cascade" }),
    externalMemberId: text("external_member_id").notNull(),
    role: text("role").notNull(), // admin | member
    createdAt: timestamp("created_at", { withTimezone: true }).notNull().defaultNow(),
  },
  (t) => [primaryKey({ columns: [t.tenantId, t.userId] })],
);
