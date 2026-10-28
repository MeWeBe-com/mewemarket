"use server";
import { canManageWorkspace, updateWorkspaceSettings } from "@mewe/core";
import { revalidatePath } from "next/cache";
import { z } from "zod";
import { requireWorkspace } from "@/lib/session";

const SettingsInput = z.object({
  name: z.string().trim().min(2).max(80),
  currency: z.string().length(3).toUpperCase(),
  timezone: z.string().min(1).max(64),
  locale: z.string().min(2).max(10),
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
