// App Catalog (BRIEF.md §3a). Tier: native | schema | hosted.
import { index, integer, jsonb, pgTable, text, timestamp, uniqueIndex } from "drizzle-orm/pg-core";
import { workspaces } from "./workspaces";

export const catalogApps = pgTable(
  "catalog_apps",
  {
    id: text("id").primaryKey(),
    slug: text("slug").notNull().unique(),
    name: text("name").notNull(),
    tagline: text("tagline").notNull(),
    description: text("description").notNull().default(""),
    tier: text("tier").notNull(), // native | schema | hosted
    category: text("category").notNull(),
    tags: jsonb("tags").$type<string[]>().notNull().default([]),
    icon: text("icon"),
    screenshots: jsonb("screenshots").$type<string[]>().notNull().default([]),
    status: text("status").notNull().default("draft"), // draft | review | published | unpublished
    // Tier 2: app schema. Tier 3: hosted definition (image, env, volumes, sso...).
    definition: jsonb("definition").$type<Record<string, unknown>>().notNull().default({}),
    license: text("license"),
    sourceUrl: text("source_url"),
    poweredBy: text("powered_by"),
    version: text("version").notNull().default("1.0.0"),
    installCount: integer("install_count").notNull().default(0),
    createdAt: timestamp("created_at", { withTimezone: true }).notNull().defaultNow(),
    updatedAt: timestamp("updated_at", { withTimezone: true }).notNull().defaultNow(),
  },
  (t) => [index("catalog_category_idx").on(t.category, t.status)],
);

export const installedApps = pgTable(
  "installed_apps",
  {
    id: text("id").primaryKey(),
    workspaceId: text("workspace_id").notNull().references(() => workspaces.id, { onDelete: "cascade" }),
    catalogAppId: text("catalog_app_id").notNull().references(() => catalogApps.id),
    status: text("status").notNull().default("active"), // provisioning | active | stopped | failed
    config: jsonb("config").$type<Record<string, unknown>>().notNull().default({}),
    installedBy: text("installed_by"),
    createdAt: timestamp("created_at", { withTimezone: true }).notNull().defaultNow(),
  },
  (t) => [uniqueIndex("installed_ws_app_uq").on(t.workspaceId, t.catalogAppId)],
);

export const appRequests = pgTable("app_requests", {
  id: text("id").primaryKey(),
  title: text("title").notNull(),
  details: text("details"),
  category: text("category"),
  votes: integer("votes").notNull().default(1),
  status: text("status").notNull().default("open"), // open | researching | built | declined
  createdBy: text("created_by"),
  createdAt: timestamp("created_at", { withTimezone: true }).notNull().defaultNow(),
});
