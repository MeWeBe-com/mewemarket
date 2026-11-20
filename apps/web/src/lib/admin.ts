import "server-only";
import { sql } from "@mewe/db";
import { notFound } from "next/navigation";
import { requireUser } from "./session";

/** Emails listed in SUPERADMIN_EMAILS (comma-separated) are always super admins; others need users.role = 'superadmin'. */
export function envSuperadmins() {
  return (process.env.SUPERADMIN_EMAILS ?? "").split(",").map((e) => e.trim().toLowerCase()).filter(Boolean);
}

export async function isSuperadmin(userId: string, email: string) {
  if (envSuperadmins().includes(email.toLowerCase())) return true;
  const [row] = await sql<{ role: string }[]>`select role from users where id = ${userId}`;
  return row?.role === "superadmin";
}

/** Anyone who isn't a super admin gets a 404, so the admin area isn't advertised. */
export async function requireSuperadmin() {
  const session = await requireUser();
  if (!(await isSuperadmin(session.user.id, session.user.email))) notFound();
  return session;
}

export const fmtDate = (d: Date | string | null) =>
  d ? new Date(d).toLocaleDateString("en-GB", { day: "numeric", month: "short", year: "numeric", timeZone: "UTC" }) : "—";
