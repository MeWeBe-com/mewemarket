import { drizzle } from "drizzle-orm/postgres-js";
import postgres from "postgres";
import * as schema from "./schema/index";

const url = process.env.DATABASE_URL;
if (!url) throw new Error("DATABASE_URL is not set");

// Reuse the client across hot reloads in dev.
const g = globalThis as unknown as { __pg?: ReturnType<typeof postgres> };
export const sql = g.__pg ?? postgres(url, { max: 10 });
if (process.env.NODE_ENV !== "production") g.__pg = sql;

export const db = drizzle(sql, { schema });
export type DB = typeof db;
export { schema };
