import { BATCH_A } from "./batch-a";
import { BATCH_B } from "./batch-b";
import { CORE_SUITE } from "./core-suite";
import type { AppDef } from "./define";

export * from "./define";

export const APPS: AppDef[] = [...CORE_SUITE, ...BATCH_A, ...BATCH_B];

const bySlug = new Map(APPS.map((a) => [a.slug, a]));

export const getAppDef = (slug: string) => bySlug.get(slug) ?? null;
export const getEntityDef = (app: string, entity: string) => getAppDef(app)?.entities.find((e) => e.key === entity) ?? null;
export const CORE_SUITE_SLUGS = CORE_SUITE.map((a) => a.slug);
