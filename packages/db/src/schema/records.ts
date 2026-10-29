// Records engine storage: one row per record of any app entity (packages/core/src/apps).
import { index, jsonb, pgTable, text, timestamp } from "drizzle-orm/pg-core";
import { workspaces } from "./workspaces";

export const records = pgTable(
  "records",
  {
    id: text("id").primaryKey(),
    workspaceId: text("workspace_id").notNull().references(() => workspaces.id, { onDelete: "cascade" }),
    app: text("app").notNull(),
    entity: text("entity").notNull(),
    data: jsonb("data").$type<Record<string, unknown>>().notNull().default({}),
    // Lower-cased text of all values, for search.
    search: text("search").notNull().default(""),
    createdBy: text("created_by"),
    updatedBy: text("updated_by"),
    createdAt: timestamp("created_at", { withTimezone: true }).notNull().defaultNow(),
    updatedAt: timestamp("updated_at", { withTimezone: true }).notNull().defaultNow(),
  },
  (t) => [index("records_ws_app_entity_idx").on(t.workspaceId, t.app, t.entity, t.createdAt)],
);
