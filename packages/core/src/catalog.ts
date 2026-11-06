import { db, schema } from "@mewe/db";
import { and, asc, eq, notInArray } from "drizzle-orm";
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

// Old products with no app definition of their own (ids from the old site's category pages).
const LEGACY_PRODUCT_PATHS: Record<number, string> = {
  16: "/apps/payroll-attendance", 24: "/apps/clinic", 44: "/apps/clinic", 25: "/apps/expense-tracker",
  28: "/apps/wiki", 41: "/apps/projects", 42: "/apps/leave-management",
  31: "/tools/video-meeting", 32: "/tools/video-meeting", 33: "/tools/video-meeting", 40: "/tools/video-meeting",
  35: "/tools/whiteboard", 38: "/tools/whiteboard", 34: "/tools", 27: "/apps",
};

/** Old CodeIgniter product id → new page path, for 301 redirects; null when there is no match. */
export function legacyProductPath(id: number) {
  const a = CATALOG.find((x) => x.legacyProductIds?.includes(id));
  return a ? `/${a.tier === "tool" ? "tools" : "apps"}/${a.slug}` : (LEGACY_PRODUCT_PATHS[id] ?? null);
}

export async function seedCatalog() {
  for (const a of CATALOG) {
    const row = {
      id: a.slug, slug: a.slug, name: a.name, tagline: a.tagline, description: a.description, tier: a.tier,
      category: a.category, license: null, sourceUrl: null, poweredBy: null, status: "published",
      definition: { features: a.features, legacyProductIds: a.legacyProductIds ?? [], ...(a.pro ? { pro: true } : {}) },
    };
    const { id, ...update } = row;
    await db.insert(schema.catalogApps).values(row).onConflictDoUpdate({ target: schema.catalogApps.id, set: { ...update, updatedAt: new Date() } });
  }
  // Retired entries (e.g. the old hosted tier) stay for install history but leave the catalogue.
  await db.update(schema.catalogApps).set({ status: "unpublished" })
    .where(notInArray(schema.catalogApps.id, CATALOG.map((a) => a.slug)));
  return CATALOG.length;
}

/** Slugs from earlier catalogue versions → current slug. */
export const RENAMED_APPS: Record<string, string> = {
  kanboard: "kanban-board", jorani: "leave-management", kimai: "time-tracking", "cal-com": "bookings", chatwoot: "helpdesk",
  "jitsi-meet": "video-meeting", excalidraw: "whiteboard", "snipe-it": "asset-register", bookstack: "wiki",
  documenso: "contracts", listmonk: "mailing-lists", "uptime-kuma": "projects",
};

// Old hosted demo folders (mewemarket.com/apps/<dir>/...) → new app slug.
const LEGACY_APP_DIRS: Record<string, string> = {
  kanboard: "kanban-board", jorani: "leave-management", "inventory-management-system": "inventory", "client-management-system": "crm",
  "inventory-system": "inventory", companyexpense: "expense-tracker", hms: "clinic", visiopath: "clinic", "hotel-management-system": "hotel",
  "logic-invoice": "invoices", invoicesystem: "invoices", wis: "inventory", snaptime: "time-tracking", phpqrcode: "qr-code-generator",
  dbdiagram: "db-diagram", draw: "whiteboard", wireframer: "whiteboard", "video-conferencing": "video-meeting", videochat: "video-meeting",
  "screen-sharing": "video-meeting", "web broadcasting": "video-meeting", timestampconverter: "timestamp-converter", crmsystem: "crm",
  payrollsystem: "payroll-attendance", "employee_management_system": "team-hr", "ems-system": "team-hr", "task-management-system": "projects",
  "task_management_system": "projects", "asset-management-system": "asset-register", pos: "inventory", "inventory-system-2": "inventory",
  frontaccounting: "invoices", hmis: "clinic", "hotel-management": "hotel",
};

export function legacyAppDirSlug(dir: string) {
  return LEGACY_APP_DIRS[decodeURIComponent(dir).toLowerCase()] ?? null;
}
