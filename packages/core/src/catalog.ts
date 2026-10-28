import { db, schema } from "@mewe/db";
import { and, asc, eq } from "drizzle-orm";
import { CATALOG, CATEGORIES } from "./catalog-data";

export type CatalogApp = typeof schema.catalogApps.$inferSelect & { features: string[] };

const withFeatures = (a: typeof schema.catalogApps.$inferSelect): CatalogApp => ({
  ...a,
  features: (a.definition.features as string[] | undefined) ?? [],
});

const published = eq(schema.catalogApps.status, "published");

export async function listCatalogApps(category?: string) {
  const rows = await db
    .select()
    .from(schema.catalogApps)
    .where(category ? and(published, eq(schema.catalogApps.category, category)) : published)
    .orderBy(asc(schema.catalogApps.name));
  return rows.map(withFeatures);
}

export async function getCatalogApp(slug: string) {
  const [a] = await db.select().from(schema.catalogApps).where(and(published, eq(schema.catalogApps.slug, slug))).limit(1);
  return a ? withFeatures(a) : null;
}

export function getCategory(slug: string) {
  return CATEGORIES.find((c) => c.slug === slug) ?? null;
}

/** Old CodeIgniter product id → new app slug, for 301 redirects. */
export function legacyProductSlug(id: number) {
  return CATALOG.find((a) => a.legacyProductIds?.includes(id))?.slug ?? null;
}

export async function seedCatalog() {
  for (const a of CATALOG) {
    const row = {
      id: a.slug, slug: a.slug, name: a.name, tagline: a.tagline, description: a.description, tier: a.tier,
      category: a.category, license: a.license ?? null, sourceUrl: a.sourceUrl ?? null, poweredBy: a.poweredBy ?? null,
      status: "published",
      definition: { features: a.features, legacyProductIds: a.legacyProductIds ?? [] },
    };
    const { id, ...update } = row;
    await db.insert(schema.catalogApps).values(row).onConflictDoUpdate({ target: schema.catalogApps.id, set: { ...update, updatedAt: new Date() } });
  }
  return CATALOG.length;
}

// Old hosted demo folders (mewemarket.com/apps/<dir>/...) → new app slug.
const LEGACY_APP_DIRS: Record<string, string> = {
  kanboard: "kanboard", jorani: "jorani", "inventory-management-system": "inventory", "client-management-system": "crm",
  "inventory-system": "inventory", companyexpense: "expense-tracker", hms: "clinic", visiopath: "clinic", "hotel-management-system": "hotel",
  "logic-invoice": "invoices", invoicesystem: "invoices", wis: "inventory", snaptime: "kimai", phpqrcode: "qr-code-generator",
  dbdiagram: "db-diagram", draw: "excalidraw", wireframer: "excalidraw", "video-conferencing": "jitsi-meet", videochat: "jitsi-meet",
  "screen-sharing": "jitsi-meet", "web broadcasting": "jitsi-meet", timestampconverter: "timestamp-converter", crmsystem: "crm",
  payrollsystem: "payroll-attendance", "employee_management_system": "team-hr", "ems-system": "team-hr", "task-management-system": "projects",
  "task_management_system": "projects", "asset-management-system": "asset-register", pos: "inventory", "inventory-system-2": "inventory",
  server: "uptime-kuma", frontaccounting: "invoices", hmis: "clinic", "hotel-management": "hotel",
};

export function legacyAppDirSlug(dir: string) {
  return LEGACY_APP_DIRS[dir.toLowerCase()] ?? null;
}
