// Idempotent base data. Run on every deploy (post-receive) after migrations.
import { db, schema, sql } from "@mewe/db";
import { seedCatalog } from "./catalog";
import { PLANS } from "./plans";

for (const p of PLANS) {
  await db
    .insert(schema.plans)
    .values(p)
    .onConflictDoUpdate({
      target: schema.plans.id,
      set: { name: p.name, priceMonthlyCents: p.priceMonthlyCents, priceYearlyCents: p.priceYearlyCents, limits: p.limits, sortOrder: p.sortOrder },
    });
}
console.log(`Seeded ${PLANS.length} plans`);
console.log(`Seeded ${await seedCatalog()} catalogue apps`);
await sql.end();
