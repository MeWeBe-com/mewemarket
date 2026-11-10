import "server-only";
import { getAppDef, isInstalled } from "@mewe/core";
import { notFound, redirect } from "next/navigation";
import { requireWorkspace } from "@/lib/session";

/** Workspace + installed app + (optional) entity from the URL. */
export async function appContext(slug: string, appSlug: string, entityKey?: string) {
  const ctx = await requireWorkspace(slug);
  const app = getAppDef(appSlug);
  if (!app) notFound();
  if (!(await isInstalled(ctx.workspace.id, app.slug))) redirect(`/${slug}/apps?app=${app.slug}`);
  const entity = entityKey ? app.entities.find((e) => e.key === entityKey) : undefined;
  if (entityKey && !entity) notFound();
  const fmt = { currency: ctx.workspace.currency, locale: ctx.workspace.locale === "en" ? "en-US" : ctx.workspace.locale };
  return { ...ctx, app, entity: entity!, fmt, canEdit: ctx.role !== "guest" };
}
