// App definitions for the records engine. Every catalogue app is data: entities with typed fields.
// Field shorthand: "key", "key*" (required), "key:type", "key*:select=A|B|C", "key:ref=entity",
// "key:ref=app.entity" (links to another app; only usable once that app is installed, so never required).
// Types: text (default) long number money percent date datetime time select bool email phone url rating ref lines.
// "lines" is an invoice-style table of { description, qty, price }; its total shows in lists.
// Entity option calc: { field: "expression" } makes a number/money field computed on save (see calc.ts).

import { calcInputs } from "./calc";
import { PUBLIC_COMPANY_PATHS, WORKSPACE_PAGES } from "../urls";

export type FieldType =
  | "text" | "long" | "number" | "money" | "percent" | "date" | "datetime" | "time"
  | "select" | "bool" | "email" | "phone" | "url" | "rating" | "ref" | "lines";

export type FieldDef = { key: string; label: string; type: FieldType; required: boolean; options?: string[]; ref?: string; refApp?: string; calc?: string };

export type EntityDef = {
  key: string;
  name: string;
  plural: string;
  fields: FieldDef[];
  title: string; // field used as the record's name
  board?: string; // select field for a kanban view
  calendar?: string; // date field for a calendar view
  totals?: string[]; // number/money fields summed in the list footer and on the app home
};

export type HostedDef = { provider: "twenty" | "invoiceshelf" | "chatwoot" | "plane" | "documenso" | "easyappointments" | "openwebui"; poweredBy: string; license: string; sourceUrl: string };

export type AppDef = {
  slug: string;
  name: string;
  category: string;
  tagline: string;
  description: string;
  features: string[];
  entities: EntityDef[];
  legacyProductIds?: number[];
  /** Apps with their own screen instead of records: the AI assistant, or a hosted open-source product. */
  kind?: "assistant" | "hosted";
  /** For kind "hosted": which product runs it and whose work it is (shown on the app page). */
  hosted?: HostedDef;
};

const TYPES = new Set<FieldType>(["text", "long", "number", "money", "percent", "date", "datetime", "time", "select", "bool", "email", "phone", "url", "rating", "ref", "lines"]);

const labelOf = (key: string) => key.replace(/_/g, " ").replace(/^\w/, (c) => c.toUpperCase());

export function field(spec: string): FieldDef {
  const [head = "", typeSpec = "text"] = spec.split(/:(.*)/s);
  const required = head.endsWith("*");
  const key = required ? head.slice(0, -1) : head;
  const [type, arg] = typeSpec.split(/=(.*)/s) as [FieldType, string | undefined];
  if (!TYPES.has(type)) throw new Error(`Unknown field type "${type}" in "${spec}"`);
  return {
    key, label: labelOf(key), type, required,
    ...(type === "select" ? { options: (arg ?? "").split("|").map((o) => o.trim()).filter(Boolean) } : {}),
    ...(type === "ref" ? (arg?.includes(".") ? { refApp: arg.split(".")[0], ref: arg.split(".")[1] } : { ref: arg }) : {}),
  };
}

export function entity(
  key: string, name: string, plural: string, fields: string[],
  opts: { title?: string; board?: string; calendar?: string; totals?: string[]; calc?: Record<string, string> } = {},
): EntityDef {
  const defs = fields.map(field);
  for (const [k, expr] of Object.entries(opts.calc ?? {})) {
    const f = defs.find((d) => d.key === k);
    if (!f) throw new Error(`calc for unknown field ${key}.${k}`);
    f.calc = expr;
    f.required = false;
  }
  return { key, name, plural, fields: defs, title: opts.title ?? defs[0]!.key, board: opts.board, calendar: opts.calendar, totals: opts.totals };
}

export const app = (a: AppDef) => a;

/** Where a ref field points: its own app unless it names another. */
export const refTarget = (app: string, f: FieldDef) => ({ app: f.refApp ?? app, entity: f.ref! });
/** Key for a ref field's options; "app.entity" for cross-app refs so they can't clash with local ones. */
export const refKey = (f: FieldDef) => (f.refApp ? `${f.refApp}.${f.ref}` : f.ref!);

/** Throws on broken definitions; run from the seed and the test suite. */
export function validateApps(apps: AppDef[]) {
  const slugs = new Set<string>();
  for (const a of apps) {
    if (!/^[a-z0-9-]+$/.test(a.slug)) throw new Error(`Bad slug ${a.slug}`);
    if ((PUBLIC_COMPANY_PATHS as readonly string[]).includes(a.slug)) throw new Error(`App slug ${a.slug} is a public company page`);
    if ((WORKSPACE_PAGES as readonly string[]).includes(a.slug)) throw new Error(`App slug ${a.slug} clashes with a workspace page`);
    if (slugs.has(a.slug)) throw new Error(`Duplicate app slug ${a.slug}`);
    slugs.add(a.slug);
    if (!a.entities.length && !a.kind) throw new Error(`${a.slug}: no entities`);
    if ((a.kind === "hosted") !== !!a.hosted) throw new Error(`${a.slug}: kind hosted needs a hosted definition`);
    const ents = new Map(a.entities.map((e) => [e.key, e]));
    if (ents.size !== a.entities.length) throw new Error(`${a.slug}: duplicate entity key`);
    for (const e of a.entities) {
      const fields = new Map(e.fields.map((f) => [f.key, f]));
      if (fields.size !== e.fields.length) throw new Error(`${a.slug}.${e.key}: duplicate field key`);
      if (!fields.has(e.title)) throw new Error(`${a.slug}.${e.key}: title field ${e.title} missing`);
      for (const f of e.fields) {
        if (f.type === "ref" && f.refApp) {
          const target = apps.find((x) => x.slug === f.refApp);
          if (!target?.entities.some((x) => x.key === f.ref)) throw new Error(`${a.slug}.${e.key}.${f.key}: ref to unknown ${f.refApp}.${f.ref}`);
          if (f.required) throw new Error(`${a.slug}.${e.key}.${f.key}: cross-app refs can't be required`);
        } else if (f.type === "ref" && !ents.has(f.ref ?? "")) throw new Error(`${a.slug}.${e.key}.${f.key}: ref to unknown entity ${f.ref}`);
        if (f.calc) {
          if (!["number", "money"].includes(f.type)) throw new Error(`${a.slug}.${e.key}.${f.key}: calc field must be number/money`);
          for (const k of calcInputs(f.calc)) if (!fields.has(k) || k === f.key) throw new Error(`${a.slug}.${e.key}.${f.key}: calc reads unknown field ${k}`);
        }
        if (f.type === "select" && !f.options?.length) throw new Error(`${a.slug}.${e.key}.${f.key}: select without options`);
      }
      if (e.board && fields.get(e.board)?.type !== "select") throw new Error(`${a.slug}.${e.key}: board must be a select field`);
      if (e.calendar && !["date", "datetime"].includes(fields.get(e.calendar)?.type ?? "")) throw new Error(`${a.slug}.${e.key}: calendar must be a date field`);
      for (const t of e.totals ?? []) if (!["number", "money", "lines"].includes(fields.get(t)?.type ?? "")) throw new Error(`${a.slug}.${e.key}: total ${t} must be number/money/lines`);
    }
  }
}
