# Phase 1 plan

The source of truth is `MASTERPROMPT_PHASE1.md`. Tick each task when it's done.

## M0: Repo, infrastructure and git deployment
- [x] Monorepo (pnpm + Turborepo, TS strict)
- [x] docker-compose (Postgres + pgvector, Redis, MinIO, Umami) bound to localhost, with healthchecks
- [x] infra/server-setup.sh (idempotent Ubuntu bootstrap)
- [x] infra/post-receive (release, migrate, build, reload, health check, rollback, prune)
- [x] Caddyfile, ecosystem.config.cjs, backup.sh plus a BullMQ nightly scheduler
- [x] /api/health (DB, Redis, MinIO)
- [x] Initial Drizzle schema plus migration (auth, workspaces, billing, AI ledger, catalogue)
- [x] docs/DEPLOY.md
- [x] Verified against local Postgres 16 + pgvector + Redis (Homebrew)
- [ ] ESLint config and Vitest harness

## M1: Auth, workspaces and roles
- [x] Better Auth (password, magic link, Google/GitHub, organization, 2FA) wired to Drizzle, with Redis-backed rate limits
- [x] Sign up, sign in (password or magic link), verify email, forgot/reset password, 2FA challenge pages
- [x] Workspace create (onboarding), switcher, invites with accept/decline, role change, remove, revoke invite
- [x] Roles owner/admin/member/guest (lib/permissions.ts)
- [x] New workspace starts a 14-day Business trial plus an AI credit grant (core/startTrial); plans seeded on deploy
- [x] Settings: workspace (name, currency, timezone, locale), members; account (profile, password, 2FA with QR and backup codes, sessions)
- [x] Middleware guards app routes
- [x] Tested against a live DB: sign-up, verify, create workspace (trial + credits), pages, invite, rate limit
- [ ] Playwright e2e: sign up → verify → create workspace → invite

## Public website (parts of M3, M5b and M10, built early)
- [x] Design tokens with light and dark themes and a toggle (next-themes), Inter font, lucide icons
- [x] Site header (desktop and mobile nav), footer with categories, legal and MeWeBe links
- [x] Home: hero, core suite, AI/MCP section, benefits, categories, FAQ (with schema.org), CTA
- [x] App catalogue: 36 apps seeded (6 flagship, 14 catalogue, 12 hosted open source, 4 free tools) across 13 categories (the 8 legacy categories kept)
- [x] /apps, /apps/category/[slug], /apps/[slug] (features, licence and source credit, related apps, SoftwareApplication schema)
- [x] /pricing: monthly/annual toggle, comparison table, $1 Supporter tier, FAQ
- [x] /ai explainer, /about (rewritten), /contact (saved to DB, email notify, honeypot, rate limit), /terms, /privacy, /cookies
- [x] SEO: sitemap.xml, robots.txt, dynamic llms.txt
- [x] Legacy redirects: categories, product ids, old /apps/<dir> demo links, /users/*, /insights (temporary)
- [x] Facebook sign-in option (was on the old site)
- [ ] Legal pages: fill in company legal name, address and jurisdiction, then get a legal review
- [ ] Make public pages cacheable (move the header session check client-side)
- [ ] Sign-up should honour ?plan= and ?app= (needs M2 checkout and M5b install)

## Records engine and App Store (replaces M4, M5, M5b; AI/MCP dropped by owner decision 2026-10-29)
- [x] App definitions DSL (packages/core/src/apps/define.ts) with validation; 105 apps across 15 categories
- [x] records table (jsonb data + trigram search), migration 0003
- [x] Core: typed validation/coercion, refs checked, search, select filters, sort, totals (incl. line items), board moves, CSV import/export, sample data
- [x] Workspace App Store: add/remove apps (owner/admin), plan app limit
- [x] App UI: overview, table (sort, paginate, totals), board (drag and drop + select), calendar, record form (all field types, line items), related records, print/PDF view
- [x] Guests are read-only (no CSV export either)
- [x] Calculated fields (entity option `calc`, evaluator in apps/calc.ts): shift and attendance hours, net pay, mileage amount, leave days
- [x] Links between apps (`ref=app.entity`): project client → CRM, task assignee / deal owner / appointment staff → Team & HR, timesheet project → Projects; backlinks across apps
- [x] Plan limits serialised per workspace with an advisory lock (no overshoot under concurrent requests)
- [x] 31 free browser tools at /tools (no sign-up)
- [x] Public site: AI/MCP removed; app pages show what is inside each app; sign-up carries ?app= through onboarding
- [x] Playwright e2e (e2e/apps.spec.ts): app lifecycle, invoice totals and print, links between apps, public pages and tools, phone width

## M2 Billing
- [x] Stripe Checkout (inline prices), billing portal, signed webhook with idempotency, plan page
- [x] Limits enforced: apps, records, members (seat limit), expired trial falls back to Free
- [ ] Add Stripe keys to .env and test with Stripe CLI (`stripe listen --forward-to localhost:3000/api/stripe/webhook`)


## Hosted apps (full open-source products inside the workspace)
- [x] Company/product URLs: `mewemarket.com/{company}/{product}`, reserved names, redirects from `/w/...`
- [x] Twenty CRM at `/{company}/crm`: per-company Twenty workspace, one-time sign-in (no second login), Twenty onboarding skipped, roles mirrored, removal ends access, delete-with-data, Powered-by/source credit
- [x] Invoices (InvoiceShelf), Projects (Plane) and Helpdesk (Chatwoot) on the same provider interface; `/api/hosted-sso` sign-in bridge for products without a login-link API
- [x] docker-compose services, Hestia and Caddy proxy configs, `infra/hosted-setup.sh`, DEPLOY.md "Hosted apps", e2e (`e2e/hosted-apps.spec.ts`, runs with `E2E_HOSTED=crm,invoices,projects,helpdesk`)
- [ ] Production: DNS and certificates (`*.crm`, `invoices`, `plane`, `chat`), then the steps in DEPLOY.md "Hosted apps"
- [ ] Twenty Enterprise key once a 6th company adds the CRM
- [ ] Retry queue for hosted sync failures (today a failed removal is logged; MeweMarket stops issuing sign-ins at once, but an open CRM session would last until it expires)
- [ ] Server sizing: the four products add about 3.5 GB RAM idle
- [ ] Next hosted apps (each needs a multi-company check like Twenty's 5-workspace limit before choosing)
