import { AI_APPS } from "./ai";
import { BATCH_A } from "./batch-a";
import { BATCH_B } from "./batch-b";
import { CORE_SUITE } from "./core-suite";
import { HOSTED_APPS } from "./hosted";
import type { AppDef } from "./define";

export * from "./define";

export const APPS: AppDef[] = [...HOSTED_APPS, ...CORE_SUITE, ...BATCH_A, ...BATCH_B, ...AI_APPS];

const bySlug = new Map(APPS.map((a) => [a.slug, a]));

export const getAppDef = (slug: string) => bySlug.get(slug) ?? null;
export const getEntityDef = (app: string, entity: string) => getAppDef(app)?.entities.find((e) => e.key === entity) ?? null;
// The featured six: the hosted CRM leads, and the simple Contacts & Deals app stays in the catalogue.
export const CORE_SUITE_SLUGS = [...HOSTED_APPS, ...CORE_SUITE].map((a) => a.slug).filter((s) => !["contacts", "quick-invoices", "simple-projects"].includes(s));
