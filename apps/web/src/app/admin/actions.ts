"use server";
import { sql } from "@mewe/db";
import { revalidatePath } from "next/cache";
import { requireSuperadmin } from "@/lib/admin";

export async function signOutEverywhere(userId: string) {
  await requireSuperadmin();
  await sql`delete from sessions where user_id = ${userId}`;
  revalidatePath(`/admin/users/${userId}`);
}

export async function setSuperadmin(userId: string, on: boolean) {
  const { user } = await requireSuperadmin();
  if (user.id === userId && !on) throw new Error("You can't remove your own super admin access.");
  await sql`update users set role = ${on ? "superadmin" : "user"}, updated_at = now() where id = ${userId}`;
  revalidatePath(`/admin/users/${userId}`);
}

const MESSAGE_STATUSES = ["new", "replied", "closed", "spam"];
export async function setMessageStatus(id: string, status: string) {
  await requireSuperadmin();
  if (!MESSAGE_STATUSES.includes(status)) return;
  await sql`update contact_messages set status = ${status} where id = ${id}`;
  revalidatePath("/admin/messages");
}
