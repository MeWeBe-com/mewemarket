// Catalogue = every records-engine app (apps/) plus every free browser tool (tools.ts).
// Seeded idempotently by seed.ts; entries no longer listed here are unpublished.
import { APPS } from "./apps";
import { TOOLS } from "./tools";

export type Tier = "app" | "tool";

export type CatalogCategory = { slug: string; name: string; icon: string; blurb: string };

// The first eight keep the legacy site's categories (and their URLs) alive.
export const CATEGORIES: CatalogCategory[] = [
  { slug: "business", name: "Business", icon: "briefcase", blurb: "Run day-to-day operations, projects and admin." },
  { slug: "application", name: "Application", icon: "app-window", blurb: "Utilities and productivity apps for any team." },
  { slug: "customer-service", name: "Customer Service", icon: "headset", blurb: "Bookings, support desks and customer communication." },
  { slug: "education", name: "Education", icon: "graduation-cap", blurb: "Courses, students, attendance and training." },
  { slug: "finance", name: "Finance", icon: "chart-line", blurb: "Invoicing, expenses, payroll and purchasing." },
  { slug: "legal", name: "Legal", icon: "scale", blurb: "Contracts, matters and e-signatures." },
  { slug: "logistics", name: "Logistics", icon: "truck", blurb: "Inventory, warehouses and shipments." },
  { slug: "marketing", name: "Marketing", icon: "megaphone", blurb: "Campaigns, events, newsletters and surveys." },
  { slug: "sales", name: "Sales", icon: "handshake", blurb: "CRM, pipelines and deal tracking." },
  { slug: "hr", name: "HR & Team", icon: "users", blurb: "People, leave, time tracking and hiring." },
  { slug: "healthcare", name: "Healthcare", icon: "stethoscope", blurb: "Clinics, patients and appointments." },
  { slug: "hospitality", name: "Hospitality", icon: "bed", blurb: "Hotels, rooms and reservations." },
  { slug: "property", name: "Property", icon: "building", blurb: "Listings, tenants, leases and maintenance." },
  { slug: "community", name: "Community & Nonprofit", icon: "heart-handshake", blurb: "Members, donors, volunteers and events." },
  { slug: "developer", name: "Developer & Free Tools", icon: "code", blurb: "Free tools for builders. No sign-up needed." },
];

export type CatalogEntry = {
  slug: string;
  name: string;
  tagline: string;
  description: string;
  tier: Tier;
  category: string;
  features: string[];
  legacyProductIds?: number[];
};

export const CATALOG: CatalogEntry[] = [
  ...APPS.map(({ entities: _e, ...a }) => ({ ...a, tier: "app" as const })),
  ...TOOLS.map((t) => ({ ...t, tier: "tool" as const })),
];
