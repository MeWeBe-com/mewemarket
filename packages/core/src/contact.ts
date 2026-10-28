import { randomUUID } from "node:crypto";
import { db, schema } from "@mewe/db";

export async function saveContactMessage(input: { name: string; email: string; topic: string; message: string; ip: string | null }) {
  const id = randomUUID();
  await db.insert(schema.contactMessages).values({ id, ...input });
  return id;
}
