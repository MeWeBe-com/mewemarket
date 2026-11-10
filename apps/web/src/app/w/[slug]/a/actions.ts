"use server";
import {
  canManageWorkspace, createRecord, deleteRecords, getEntityDef, importRecords, installApp, LimitError,
  setRecordField, uninstallApp, updateRecord,
} from "@mewe/core";
import { revalidatePath } from "next/cache";
import { redirect } from "next/navigation";
import { parseCsv } from "@/lib/csv";
import { requireWorkspace } from "@/lib/session";

export type FormState = { errors?: Record<string, string>; message?: string } | null;

async function editor(slug: string) {
  const ctx = await requireWorkspace(slug);
  if (ctx.role === "guest") throw new Error("Guests have read-only access.");
  return ctx;
}

export async function installAppAction(slug: string, app: string, form: FormData) {
  const { workspace, role, session } = await requireWorkspace(slug);
  if (!canManageWorkspace(role)) redirect(`/${slug}/apps?error=${encodeURIComponent("Only owners and admins can add apps.")}`);
  try {
    await installApp(workspace.id, app, session.user.id, form.get("samples") === "on");
  } catch (e) {
    if (e instanceof LimitError) redirect(`/${slug}/apps?error=${encodeURIComponent(e.message)}`);
    throw e;
  }
  revalidatePath(`/w/${slug}`, "layout");
  redirect(`/${slug}/${app}`);
}

export async function uninstallAppAction(slug: string, app: string, form: FormData) {
  const { workspace, role } = await requireWorkspace(slug);
  if (!canManageWorkspace(role)) return;
  await uninstallApp(workspace.id, app, form.get("delete_data") === "on");
  revalidatePath(`/w/${slug}`, "layout");
  redirect(`/${slug}/apps`);
}

/** Reads typed values out of the record form. Lines arrive as JSON in a hidden input. */
function formValues(app: string, entity: string, form: FormData) {
  const e = getEntityDef(app, entity)!;
  const raw: Record<string, unknown> = {};
  for (const f of e.fields) {
    if (f.type === "bool") raw[f.key] = form.get(f.key) === "on";
    else raw[f.key] = form.get(f.key) ?? "";
  }
  return raw;
}

export async function saveRecordAction(slug: string, app: string, entity: string, id: string | null, _prev: FormState, form: FormData): Promise<FormState> {
  const { workspace, session } = await editor(slug);
  const raw = formValues(app, entity, form);
  let res;
  try {
    res = id
      ? await updateRecord(workspace.id, app, entity, id, raw, session.user.id)
      : await createRecord(workspace.id, app, entity, raw, session.user.id);
  } catch (e) {
    if (e instanceof LimitError) return { message: e.message };
    throw e;
  }
  if (res.errors) return { errors: res.errors, message: "Please fix the highlighted fields." };
  revalidatePath(`/w/${slug}/a/${app}`, "layout");
  redirect(form.get("_next") === "new" ? `/${slug}/${app}/${entity}/new?saved=1` : `/${slug}/${app}/${entity}`);
}

export async function deleteRecordAction(slug: string, app: string, entity: string, ids: string[]) {
  const { workspace } = await editor(slug);
  await deleteRecords(workspace.id, app, entity, ids.slice(0, 500));
  revalidatePath(`/w/${slug}/a/${app}`, "layout");
}

export async function moveCardAction(slug: string, app: string, entity: string, id: string, field: string, value: string) {
  const { workspace, session } = await editor(slug);
  const res = await setRecordField(workspace.id, app, entity, id, field, value, session.user.id);
  revalidatePath(`/w/${slug}/a/${app}/${entity}`);
  return res.errors ? Object.values(res.errors)[0] : null;
}

export async function importCsvAction(slug: string, app: string, entity: string, _prev: FormState, form: FormData): Promise<FormState> {
  const { workspace, session } = await editor(slug);
  const file = form.get("file");
  if (!(file instanceof File) || !file.size) return { message: "Choose a CSV file to import." };
  if (file.size > 5_000_000) return { message: "That file is over 5 MB. Split it into smaller files." };
  const rows = parseCsv(await file.text());
  if (!rows.length) return { message: "No rows found. The first line must be the column names." };
  try {
    const { imported, failed } = await importRecords(workspace.id, app, entity, rows, session.user.id);
    revalidatePath(`/w/${slug}/a/${app}`, "layout");
    const skipped = failed.length ? ` Skipped ${failed.length}: ${failed.slice(0, 3).map((f) => `row ${f.row} (${f.error})`).join("; ")}${failed.length > 3 ? "…" : ""}` : "";
    return { message: `Imported ${imported} records.${skipped}` };
  } catch (e) {
    if (e instanceof LimitError) return { message: e.message };
    throw e;
  }
}
