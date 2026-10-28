import { index, pgTable, text, timestamp } from "drizzle-orm/pg-core";

export const contactMessages = pgTable(
  "contact_messages",
  {
    id: text("id").primaryKey(),
    name: text("name").notNull(),
    email: text("email").notNull(),
    topic: text("topic").notNull(), // sales | support | partnership | other
    message: text("message").notNull(),
    ip: text("ip"),
    status: text("status").notNull().default("new"), // new | replied | closed | spam
    createdAt: timestamp("created_at", { withTimezone: true }).notNull().defaultNow(),
  },
  (t) => [index("contact_status_idx").on(t.status, t.createdAt)],
);
