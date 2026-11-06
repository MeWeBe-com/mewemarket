"use server";
import { canManageWorkspace, updateWorkspaceSettings } from "@mewe/core";
import { revalidatePath } from "next/cache";
import { z } from "zod";
import { requireWorkspace } from "@/lib/session";

const SettingsInput = z.object({
  name: z.string().trim().min(2).max(80),
  // Bad values here would break money and date formatting on every page, so check them against Intl.
  currency: z.string().trim().toUpperCase().refine((c) => Intl.supportedValuesOf("currency").includes(c), "Use a 3-letter currency code such as USD, EUR or GBP."),
  timezone: z.string().trim().refine((t) => t === "UTC" || Intl.supportedValuesOf("timeZone").includes(t), "Pick a time zone such as Europe/London or America/New_York."),
  locale: z.string().trim().refine((l) => { try { return Intl.NumberFormat.supportedLocalesOf(l).length > 0; } catch { return false; } }, "Unknown language code."),
});

export async function saveWorkspaceSettings(slug: string, _prev: unknown, form: FormData) {
  const { workspace, role } = await requireWorkspace(slug);
  if (!canManageWorkspace(role)) return { ok: false, error: "Only owners and admins can change workspace settings." };
  const parsed = SettingsInput.safeParse(Object.fromEntries(form));
  if (!parsed.success) return { ok: false, error: parsed.error.issues[0]?.message ?? "Invalid input" };
  await updateWorkspaceSettings(workspace.id, parsed.data);
  revalidatePath(`/w/${slug}`, "layout");
  return { ok: true, error: null };
}
