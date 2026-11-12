"use server";
import { AiError, aiChat, canManageWorkspace, isInstalled, saveAiSettings, type AiProvider, type ChatMessage } from "@mewe/core";
import { revalidatePath } from "next/cache";
import { requireWorkspace } from "@/lib/session";

export async function askAssistantAction(slug: string, history: ChatMessage[]): Promise<{ reply?: string; error?: string }> {
  const { workspace, session } = await requireWorkspace(slug);
  if (!(await isInstalled(workspace.id, "ai-assistant"))) return { error: "The AI Assistant isn't added to this workspace." };
  try {
    return { reply: await aiChat(workspace, session.user.name || session.user.email, Array.isArray(history) ? history : []) };
  } catch (e) {
    if (e instanceof AiError) return { error: e.message };
    console.error("ai chat failed", e);
    return { error: "Something went wrong reaching the AI provider. Try again in a moment." };
  }
}

export type AiFormState = { ok?: boolean; error?: string } | null;

export async function saveAiSettingsAction(slug: string, _prev: AiFormState, form: FormData): Promise<AiFormState> {
  const { workspace, role } = await requireWorkspace(slug);
  if (!canManageWorkspace(role)) return { error: "Only owners and admins can change the assistant settings." };
  try {
    await saveAiSettings(workspace.id, {
      provider: String(form.get("provider")) as AiProvider,
      model: String(form.get("model") ?? ""),
      apiKey: String(form.get("api_key") ?? ""),
      name: String(form.get("name") ?? ""),
      instructions: String(form.get("instructions") ?? ""),
      removeKey: form.get("remove_key") === "on",
    });
  } catch (e) {
    if (e instanceof AiError) return { error: e.message };
    throw e;
  }
  revalidatePath(`/w/${slug}/a/ai-assistant`);
  revalidatePath(`/w/${slug}/a/ai-chat`, "layout");
  return { ok: true };
}
