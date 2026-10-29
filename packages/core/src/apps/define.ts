// App definitions for the records engine. Every catalogue app is data: entities with typed fields.
// Field shorthand: "key", "key*" (required), "key:type", "key*:select=A|B|C", "key:ref=entity".
// Types: text (default) long number money percent date datetime time select bool email phone url rating ref lines.
// "lines" is an invoice-style table of { description, qty, price }; its total shows in lists.

export type FieldType =
  | "text" | "long" | "number" | "money" | "percent" | "date" | "datetime" | "time"
  | "select" | "bool" | "email" | "phone" | "url" | "rating" | "ref" | "lines";

export type FieldDef = { key: string; label: string; type: FieldType; required: boolean; options?: string[]; ref?: string };

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

export type AppDef = {
  slug: string;
  name: string;
  category: string;
  tagline: string;
  description: string;
  features: string[];
  entities: EntityDef[];
  legacyProductIds?: number[];
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
    ...(type === "ref" ? { ref: arg } : {}),
  };
}

export function entity(
  key: string, name: string, plural: string, fields: string[],
  opts: { title?: string; board?: string; calendar?: string; totals?: string[] } = {},
): EntityDef {
  const defs = fields.map(field);
  return { key, name, plural, fields: defs, title: opts.title ?? defs[0]!.key, board: opts.board, calendar: opts.calendar, totals: opts.totals };
}

export const app = (a: AppDef) => a;

/** Throws on broken definitions; run from the seed and the test suite. */
export function validateApps(apps: AppDef[]) {
  const slugs = new Set<string>();
  for (const a of apps) {
    if (!/^[a-z0-9-]+$/.test(a.slug)) throw new Error(`Bad slug ${a.slug}`);
    if (slugs.has(a.slug)) throw new Error(`Duplicate app slug ${a.slug}`);
    slugs.add(a.slug);
    if (!a.entities.length) throw new Error(`${a.slug}: no entities`);
    const ents = new Map(a.entities.map((e) => [e.key, e]));
    if (ents.size !== a.entities.length) throw new Error(`${a.slug}: duplicate entity key`);
    for (const e of a.entities) {
      const fields = new Map(e.fields.map((f) => [f.key, f]));
      if (fields.size !== e.fields.length) throw new Error(`${a.slug}.${e.key}: duplicate field key`);
      if (!fields.has(e.title)) throw new Error(`${a.slug}.${e.key}: title field ${e.title} missing`);
      for (const f of e.fields) {
        if (f.type === "ref" && !ents.has(f.ref ?? "")) throw new Error(`${a.slug}.${e.key}.${f.key}: ref to unknown entity ${f.ref}`);
        if (f.type === "select" && !f.options?.length) throw new Error(`${a.slug}.${e.key}.${f.key}: select without options`);
      }
      if (e.board && fields.get(e.board)?.type !== "select") throw new Error(`${a.slug}.${e.key}: board must be a select field`);
      if (e.calendar && !["date", "datetime"].includes(fields.get(e.calendar)?.type ?? "")) throw new Error(`${a.slug}.${e.key}: calendar must be a date field`);
      for (const t of e.totals ?? []) if (!["number", "money", "lines"].includes(fields.get(t)?.type ?? "")) throw new Error(`${a.slug}.${e.key}: total ${t} must be number/money/lines`);
    }
  }
}
