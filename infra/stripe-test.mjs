// Stripe TEST-MODE helper for the deploy workflow ("stripe-test" task). Refuses to run with a live key.
//   node infra/stripe-test.mjs verify <email>   mark a test sign-up's e-mail as verified
//   node infra/stripe-test.mjs report <slug>    show the workspace's subscription and recent stripe_events
//   node infra/stripe-test.mjs event <slug>     send one test event: update the workspace's test subscription
//                                              in Stripe (-> customer.subscription.updated to the webhook)
// Run from the app folder; reads .env itself so no secret is on a command line.
import { readFileSync } from "node:fs";
import { createRequire } from "node:module";

const env = {};
for (const raw of readFileSync(".env", "utf8").split(/\r?\n/)) {
  const m = raw.match(/^\s*(?:export\s+)?([A-Za-z_][A-Za-z0-9_]*)\s*=\s*(.*)$/);
  if (m) env[m[1]] = m[2].trim().replace(/^(["'])(.*)\1$/, "$2");
}
const key = env.STRIPE_SECRET_KEY ?? "";
if (!key.startsWith("sk_test_")) { console.error("Refusing: STRIPE_SECRET_KEY is not a test-mode key."); process.exit(1); }

const req = createRequire(new URL("../apps/web/package.json", import.meta.url));
const postgres = req("postgres");
const Stripe = req("stripe");
const sql = postgres(env.DATABASE_URL, { max: 1 });
const stripe = new Stripe(key);
const [cmd, arg] = process.argv.slice(2);

async function sub(slug) {
  const [row] = await sql`select w.id, w.name, w.slug, s.plan_id, s.status, s.stripe_customer_id, s.stripe_subscription_id, s.trial_ends_at, s.current_period_end, s.updated_at
    from workspaces w left join subscriptions s on s.workspace_id = w.id where w.slug = ${slug}`;
  if (!row) throw new Error(`No workspace ${slug}`);
  return row;
}
const events = () => sql`select id, type, processed_at from stripe_events order by processed_at desc limit 8`;

try {
  if (cmd === "verify") {
    if (!/^stripe-test[^@]*@mewemarket\.com$/.test(arg ?? "")) throw new Error("Only stripe-test…@mewemarket.com addresses can be verified here.");
    const r = await sql`update users set email_verified = true where email = ${arg} returning email`;
    console.log(r.length ? `verified ${arg}` : `no user ${arg}`);
  } else if (cmd === "report") {
    console.log("subscription:", await sub(arg));
    console.log("stripe_events:", await events());
  } else if (cmd === "event") {
    const s = await sub(arg);
    if (!s.stripe_subscription_id) throw new Error("Workspace has no Stripe subscription yet.");
    const before = (await events()).length;
    const t0 = Date.now();
    await stripe.subscriptions.update(s.stripe_subscription_id, { metadata: { workspaceId: s.id, planId: s.plan_id, webhookTest: new Date().toISOString() } });
    console.log(`updated ${s.stripe_subscription_id}; waiting for the webhook…`);
    let row;
    for (let i = 0; i < 30 && !row; i++) {
      await new Promise((r) => setTimeout(r, 2000));
      [row] = await sql`select id, type, processed_at from stripe_events where type = 'customer.subscription.updated' and processed_at > to_timestamp(${t0 / 1000}) order by processed_at desc limit 1`;
    }
    console.log(row ? `webhook OK: ${row.type} ${row.id} recorded at ${row.processed_at.toISOString()} (${((+row.processed_at - t0) / 1000).toFixed(1)}s)` : "no event recorded within 60s");
    const [e] = await stripe.events.list({ type: "customer.subscription.updated", limit: 1 }).then((r) => r.data);
    if (e) console.log(`Stripe: event ${e.id}, pending webhooks ${e.pending_webhooks}`);
    void before;
    if (!row) process.exitCode = 1;
  } else {
    throw new Error("usage: verify <email> | report <slug> | event <slug>");
  }
} catch (e) {
  console.error(e.message); process.exitCode = 1;
} finally {
  await sql.end();
}
