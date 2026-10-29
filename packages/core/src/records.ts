import { randomUUID } from "node:crypto";
import { db, schema } from "@mewe/db";
import { and, asc, count, desc, eq, ilike, inArray, sql } from "drizzle-orm";
import { getAppDef, getEntityDef, type EntityDef, type FieldDef } from "./apps";
import { currentPlan } from "./billing";

export type Line = { description: string; qty: number; price: number };
export type RecordRow = typeof schema.records.$inferSelect;
export type Values = Record<string, unknown>;

const r = schema.records;

export const linesTotal = (v: unknown) =>
  Array.isArray(v) ? (v as Line[]).reduce((s, l) => s + (Number(l.qty) || 0) * (Number(l.price) || 0), 0) : 0;

export class LimitError extends Error {}

// --- Validation -----------------------------------------------------------

const EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

/** Turns raw form/CSV strings into typed values. Unknown keys are dropped. */
export function coerce(entity: EntityDef, raw: Record<string, unknown>) {
  const data: Values = {};
  const errors: Record<string, string> = {};
  for (const f of entity.fields) {
    const v = raw[f.key];
    const s = typeof v === "string" ? v.trim() : v;
    const empty = s === undefined || s === null || s === "" || (f.type === "lines" && Array.isArray(s) && !s.length);
    if (empty) {
      if (f.type === "bool") data[f.key] = false;
      else if (f.required) errors[f.key] = `${f.label} is required`;
      continue;
    }
    const err = (m: string) => (errors[f.key] = m);
    switch (f.type) {
      case "number": case "money": case "percent": case "rating": {
        const t = String(s).replace(/[,\s$£€¥₹%]/g, "");
        const n = t === "" ? NaN : Number(t);
        if (!Number.isFinite(n)) err(`${f.label} must be a number`);
        else if (f.type === "rating" && (n < 0 || n > 5)) err(`${f.label} must be 0–5`);
        else data[f.key] = n;
        break;
      }
      case "bool":
        data[f.key] = s === true || ["true", "on", "yes", "1"].includes(String(s).toLowerCase());
        break;
      case "date":
        if (!/^\d{4}-\d{2}-\d{2}$/.test(String(s)) || Number.isNaN(Date.parse(String(s)))) err(`${f.label} must be a date`);
        else data[f.key] = String(s);
        break;
      case "datetime":
        if (Number.isNaN(Date.parse(String(s)))) err(`${f.label} must be a date and time`);
        else data[f.key] = String(s).slice(0, 16);
        break;
      case "time":
        if (!/^\d{2}:\d{2}/.test(String(s))) err(`${f.label} must be a time`);
        else data[f.key] = String(s).slice(0, 5);
        break;
      case "email":
        if (!EMAIL.test(String(s))) err(`${f.label} must be an email address`);
        else data[f.key] = String(s).toLowerCase();
        break;
      case "url": {
        const u = /^https?:\/\//i.test(String(s)) ? String(s) : `https://${s}`;
        try { new URL(u); data[f.key] = u; } catch { err(`${f.label} must be a web address`); }
        break;
      }
      case "select": {
        const opt = f.options!.find((o) => o.toLowerCase() === String(s).toLowerCase());
        if (!opt) err(`${f.label} must be one of: ${f.options!.join(", ")}`);
        else data[f.key] = opt;
        break;
      }
      case "lines": {
        const arr = typeof s === "string" ? safeJson(s) : s;
        if (!Array.isArray(arr)) { err(`${f.label} is invalid`); break; }
        data[f.key] = arr
          .map((l: Partial<Line>) => ({ description: String(l.description ?? "").slice(0, 500), qty: Number(l.qty) || 0, price: Number(l.price) || 0 }))
          .filter((l) => l.description || l.qty || l.price)
          .slice(0, 200);
        break;
      }
      default:
        data[f.key] = String(s).slice(0, f.type === "long" ? 20_000 : 1_000);
    }
  }
  return { data, errors };
}

const safeJson = (s: string) => { try { return JSON.parse(s); } catch { return null; } };

const searchText = (data: Values) =>
  Object.values(data)
    .map((v) => (Array.isArray(v) ? v.map((l) => (l as Line).description).join(" ") : String(v ?? "")))
    .join(" ")
    .toLowerCase()
    .slice(0, 10_000);

function mustEntity(app: string, entity: string) {
  const e = getEntityDef(app, entity);
  if (!e) throw new Error(`Unknown entity ${app}.${entity}`);
  return e;
}

// --- Reads -------------------------------------------------------------------

export type ListOpts = { q?: string; sort?: string; dir?: "asc" | "desc"; filter?: Record<string, string>; limit?: number; offset?: number };

export async function listRecords(workspaceId: string, app: string, entity: string, o: ListOpts = {}) {
  const e = mustEntity(app, entity);
  const where = [eq(r.workspaceId, workspaceId), eq(r.app, app), eq(r.entity, entity)];
  if (o.q?.trim()) where.push(ilike(r.search, `%${o.q.trim().toLowerCase().replace(/[%_\\]/g, "\\$&")}%`));
  for (const [k, v] of Object.entries(o.filter ?? {})) {
    if (v && e.fields.some((f) => f.key === k)) where.push(sql`${r.data}->>${k} = ${v}`);
  }
  const sortField = e.fields.find((f) => f.key === o.sort);
  const dirFn = o.dir === "asc" ? asc : desc;
  const numeric = sortField && ["number", "money", "percent", "rating"].includes(sortField.type);
  const order = sortField
    ? numeric ? dirFn(sql`(${r.data}->>${sortField.key})::numeric`) : dirFn(sql`lower(${r.data}->>${sortField.key})`)
    : desc(r.createdAt);
  const [rows, [totalRow]] = await Promise.all([
    db.select().from(r).where(and(...where)).orderBy(order, desc(r.id)).limit(o.limit ?? 50).offset(o.offset ?? 0),
    db.select({ total: count() }).from(r).where(and(...where)),
  ]);
  return { rows, total: totalRow?.total ?? 0 };
}

export async function getRecord(workspaceId: string, app: string, entity: string, id: string) {
  const [row] = await db.select().from(r)
    .where(and(eq(r.id, id), eq(r.workspaceId, workspaceId), eq(r.app, app), eq(r.entity, entity))).limit(1);
  return row ?? null;
}

/** Sums of each entity's `totals` fields, over all its records. */
export async function entityTotals(workspaceId: string, app: string, entity: EntityDef) {
  const out: Record<string, number> = {};
  for (const key of entity.totals ?? []) {
    const f = entity.fields.find((x) => x.key === key)!;
    const expr = f.type === "lines"
      ? sql<string>`coalesce(sum((select sum(coalesce((l->>'qty')::numeric,0) * coalesce((l->>'price')::numeric,0)) from jsonb_array_elements(case when jsonb_typeof(${r.data}->${key}) = 'array' then ${r.data}->${key} else '[]'::jsonb end) l)),0)`
      : sql<string>`coalesce(sum((${r.data}->>${key})::numeric),0)`;
    const [row] = await db.select({ v: expr }).from(r).where(and(eq(r.workspaceId, workspaceId), eq(r.app, app), eq(r.entity, entity.key)));
    out[key] = Number(row?.v ?? 0);
  }
  return out;
}

export async function entityCounts(workspaceId: string, app: string) {
  const rows = await db.select({ entity: r.entity, n: count() }).from(r)
    .where(and(eq(r.workspaceId, workspaceId), eq(r.app, app))).groupBy(r.entity);
  return Object.fromEntries(rows.map((x) => [x.entity, x.n]));
}

/** Records grouped by a select field's value, for kanban boards. */
export async function boardCounts(workspaceId: string, app: string, entity: string, field: string) {
  const rows = await db.select({ v: sql<string>`${r.data}->>${field}`, n: count() }).from(r)
    .where(and(eq(r.workspaceId, workspaceId), eq(r.app, app), eq(r.entity, entity))).groupBy(sql`${r.data}->>${field}`);
  return Object.fromEntries(rows.map((x) => [x.v ?? "", x.n]));
}

/** id → display title for every record of the ref'd entities, used to show and pick references. */
export async function refOptions(workspaceId: string, app: string, fields: FieldDef[]) {
  const out: Record<string, { id: string; title: string }[]> = {};
  for (const f of fields) {
    if (f.type !== "ref" || out[f.ref!]) continue;
    const target = mustEntity(app, f.ref!);
    const rows = await db.select({ id: r.id, data: r.data }).from(r)
      .where(and(eq(r.workspaceId, workspaceId), eq(r.app, app), eq(r.entity, target.key)))
      .orderBy(sql`lower(${r.data}->>${target.title})`).limit(1000);
    out[f.ref!] = rows.map((x) => ({ id: x.id, title: String(x.data[target.title] ?? "Untitled") }));
  }
  return out;
}

export async function recordTitles(workspaceId: string, ids: string[]) {
  if (!ids.length) return {};
  const rows = await db.select({ id: r.id, app: r.app, entity: r.entity, data: r.data }).from(r)
    .where(and(eq(r.workspaceId, workspaceId), inArray(r.id, ids)));
  return Object.fromEntries(rows.map((x) => [x.id, displayTitle(getEntityDef(x.app, x.entity), x.data)]));
}

export function displayTitle(e: EntityDef | null, data: Values, refTitles: Record<string, string> = {}) {
  if (!e) return "Untitled";
  const v = data[e.title];
  const f = e.fields.find((x) => x.key === e.title);
  if (f?.type === "ref") return refTitles[String(v)] ?? "Untitled";
  return v === undefined || v === "" ? "Untitled" : String(v);
}

// --- Writes ------------------------------------------------------------------

async function assertRecordQuota(workspaceId: string, adding: number) {
  const plan = await currentPlan(workspaceId);
  const max = plan.limits.records;
  if (max < 0) return;
  const [row] = await db.select({ n: count() }).from(r).where(eq(r.workspaceId, workspaceId));
  if ((row?.n ?? 0) + adding > max) throw new LimitError(`Your plan allows ${max.toLocaleString()} records. Upgrade to add more.`);
}

async function assertInstalled(workspaceId: string, app: string) {
  if (!(await isInstalled(workspaceId, app))) throw new Error(`App ${app} is not installed`);
}

/** Keeps ref values pointing at records of the right entity in this workspace. */
async function checkRefs(workspaceId: string, app: string, e: EntityDef, data: Values) {
  const errors: Record<string, string> = {};
  for (const f of e.fields) {
    if (f.type !== "ref" || !data[f.key]) continue;
    const ok = await getRecord(workspaceId, app, f.ref!, String(data[f.key]));
    if (!ok) errors[f.key] = `${f.label} not found`;
  }
  return errors;
}

export async function createRecord(workspaceId: string, app: string, entity: string, raw: Values, userId: string) {
  const e = mustEntity(app, entity);
  await assertInstalled(workspaceId, app);
  const { data, errors } = coerce(e, raw);
  Object.assign(errors, await checkRefs(workspaceId, app, e, data));
  if (Object.keys(errors).length) return { errors };
  await assertRecordQuota(workspaceId, 1);
  const id = randomUUID();
  await db.insert(r).values({ id, workspaceId, app, entity, data, search: searchText(data), createdBy: userId, updatedBy: userId });
  return { id };
}

export async function updateRecord(workspaceId: string, app: string, entity: string, id: string, raw: Values, userId: string) {
  const e = mustEntity(app, entity);
  const { data, errors } = coerce(e, raw);
  Object.assign(errors, await checkRefs(workspaceId, app, e, data));
  if (Object.keys(errors).length) return { errors };
  const res = await db.update(r).set({ data, search: searchText(data), updatedBy: userId, updatedAt: new Date() })
    .where(and(eq(r.id, id), eq(r.workspaceId, workspaceId), eq(r.app, app), eq(r.entity, entity))).returning({ id: r.id });
  return res.length ? { id } : { errors: { _: "Record not found" } };
}

/** Moves a card on a board: sets one select field. */
export async function setRecordField(workspaceId: string, app: string, entity: string, id: string, key: string, value: string, userId: string) {
  const row = await getRecord(workspaceId, app, entity, id);
  if (!row) return { errors: { _: "Record not found" } };
  return updateRecord(workspaceId, app, entity, id, { ...row.data, [key]: value }, userId);
}

export async function deleteRecords(workspaceId: string, app: string, entity: string, ids: string[]) {
  if (!ids.length) return 0;
  const res = await db.delete(r)
    .where(and(eq(r.workspaceId, workspaceId), eq(r.app, app), eq(r.entity, entity), inArray(r.id, ids))).returning({ id: r.id });
  return res.length;
}

/** CSV import: rows are header → string maps. Refs may be given by title. */
export async function importRecords(workspaceId: string, app: string, entity: string, rows: Record<string, string>[], userId: string) {
  const e = mustEntity(app, entity);
  await assertInstalled(workspaceId, app);
  await assertRecordQuota(workspaceId, rows.length);
  const refs = await refOptions(workspaceId, app, e.fields);
  const byLabel = new Map(e.fields.flatMap((f) => [[f.key.toLowerCase(), f], [f.label.toLowerCase(), f]] as const));
  const values: (typeof r.$inferInsert)[] = [];
  const failed: { row: number; error: string }[] = [];
  rows.slice(0, 5_000).forEach((row, i) => {
    const mapped: Values = {};
    for (const [h, v] of Object.entries(row)) {
      const f = byLabel.get(h.trim().toLowerCase());
      if (!f) continue;
      if (f.type === "ref" && v) {
        const hit = refs[f.ref!]?.find((o) => o.id === v || o.title.toLowerCase() === v.trim().toLowerCase());
        mapped[f.key] = hit?.id ?? "";
      } else mapped[f.key] = v;
    }
    const { data, errors } = coerce(e, mapped);
    if (Object.keys(errors).length) failed.push({ row: i + 2, error: Object.values(errors)[0] ?? "Invalid row" });
    else values.push({ id: randomUUID(), workspaceId, app, entity, data, search: searchText(data), createdBy: userId, updatedBy: userId });
  });
  for (let i = 0; i < values.length; i += 500) await db.insert(r).values(values.slice(i, i + 500));
  return { imported: values.length, failed };
}

// --- Installs ----------------------------------------------------------------

export async function listInstalledApps(workspaceId: string) {
  const rows = await db.select({ app: schema.installedApps.catalogAppId, createdAt: schema.installedApps.createdAt })
    .from(schema.installedApps).where(eq(schema.installedApps.workspaceId, workspaceId)).orderBy(asc(schema.installedApps.createdAt));
  return rows.map((x) => getAppDef(x.app)).filter((a) => a !== null);
}

export async function isInstalled(workspaceId: string, app: string) {
  const [row] = await db.select({ id: schema.installedApps.id }).from(schema.installedApps)
    .where(and(eq(schema.installedApps.workspaceId, workspaceId), eq(schema.installedApps.catalogAppId, app))).limit(1);
  return !!row;
}

export async function installApp(workspaceId: string, app: string, userId: string, withSamples = false) {
  const def = getAppDef(app);
  if (!def) throw new Error(`Unknown app ${app}`);
  if (await isInstalled(workspaceId, app)) return;
  const plan = await currentPlan(workspaceId);
  const max = plan.limits.apps;
  if (max >= 0) {
    const [row] = await db.select({ n: count() }).from(schema.installedApps).where(eq(schema.installedApps.workspaceId, workspaceId));
    if ((row?.n ?? 0) >= max) throw new LimitError(`Your ${plan.name} plan includes ${max} apps. Upgrade to add more.`);
  }
  await db.transaction(async (tx) => {
    await tx.insert(schema.installedApps).values({ id: randomUUID(), workspaceId, catalogAppId: app, installedBy: userId });
    await tx.update(schema.catalogApps).set({ installCount: sql`${schema.catalogApps.installCount} + 1` }).where(eq(schema.catalogApps.id, app));
  });
  if (withSamples) await addSampleData(workspaceId, app, userId);
}

/** Removes the app and, when asked, its records. Records are kept by default so a reinstall restores them. */
export async function uninstallApp(workspaceId: string, app: string, deleteData = false) {
  await db.delete(schema.installedApps)
    .where(and(eq(schema.installedApps.workspaceId, workspaceId), eq(schema.installedApps.catalogAppId, app)));
  if (deleteData) await db.delete(r).where(and(eq(r.workspaceId, workspaceId), eq(r.app, app)));
}

// --- Sample data -------------------------------------------------------------

const NAMES = ["Alex Morgan", "Sam Patel", "Jordan Lee", "Taylor Brooks", "Casey Kim", "Riley Chen", "Jamie Fox", "Morgan Diaz"];
const WORDS = ["Northwind", "Bluebird", "Summit", "Harbor", "Maple", "Atlas", "Orchid", "Granite"];

function sample(f: FieldDef, i: number, title: boolean): unknown {
  const name = NAMES[i % NAMES.length]!, word = WORDS[i % WORDS.length]!;
  const day = (d: number) => new Date(Date.now() + d * 86_400_000).toISOString().slice(0, 10);
  switch (f.type) {
    case "number": return (i + 1) * 3;
    case "money": return (i + 1) * 125;
    case "percent": return [5, 10, 20][i % 3];
    case "rating": return (i % 5) + 1;
    case "date": return day(i * 3 - 4);
    case "datetime": return `${day(i * 2 - 2)}T${String(9 + i).padStart(2, "0")}:00`;
    case "time": return `${String(9 + i).padStart(2, "0")}:30`;
    case "bool": return i % 2 === 0;
    case "email": return `${name.split(" ")[0]!.toLowerCase()}@example.com`;
    case "phone": return `+1 555 010${i}`;
    case "url": return `https://example.com/${word.toLowerCase()}`;
    case "select": return f.options![i % f.options!.length];
    case "lines": return [{ description: `${word} service`, qty: i + 1, price: 50 }, { description: "Materials", qty: 1, price: 30 + i * 10 }];
    case "long": return `Sample notes for ${word}.`;
    case "ref": return undefined;
    default:
      if (/(^|_)(number|no|ref|reference|code|sku)$/.test(f.key)) return `${f.key === "sku" ? "SKU" : "NO"}-${1001 + i}`;
      if (/name|contact|customer|person|owner|assignee|employee|staff|guest|patient|student|member|donor|tenant|volunteer/i.test(f.key)) return name;
      return title ? `${word} ${f.label.toLowerCase()}`.replace(/^./, (c) => c.toUpperCase()) : word;
  }
}

/** Three example records per entity, with refs linked, so a new app isn't empty. */
export async function addSampleData(workspaceId: string, app: string, userId: string) {
  const def = getAppDef(app)!;
  const ids: Record<string, string[]> = {};
  // Entities without refs first, so refs can point at them.
  const ordered = [...def.entities].sort((a, b) => a.fields.filter((f) => f.type === "ref").length - b.fields.filter((f) => f.type === "ref").length);
  await assertRecordQuota(workspaceId, ordered.length * 3);
  for (const e of ordered) {
    const list: string[] = (ids[e.key] = []);
    for (let i = 0; i < 3; i++) {
      const data: Values = {};
      for (const f of e.fields) {
        const v = f.type === "ref" ? ids[f.ref!]?.[i % (ids[f.ref!]?.length || 1)] : sample(f, i, f.key === e.title);
        if (v !== undefined) data[f.key] = v;
      }
      const id = randomUUID();
      await db.insert(r).values({ id, workspaceId, app, entity: e.key, data, search: searchText(data), createdBy: userId, updatedBy: userId });
      list.push(id);
    }
  }
}
