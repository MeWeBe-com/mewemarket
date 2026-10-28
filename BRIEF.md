# MeweMarket 2.0 — Product & Build Brief

*Prepared 2026-10-28 from the legacy codebase (`old/`), the DB dump (`saasthemes_mewemarket.sql`) and the live positioning in `old/llms.txt` / `old/insights/`.*

---

## 1. What exists today

| Area | Finding |
|---|---|
| Stack | CodeIgniter 3 (PHP), MySQL/MariaDB, jQuery theme. Controllers: Home, Products, Category, Pricing, Billing, Payment, Users, Admin, Search, Page. |
| Product | A marketplace of ~37 bundled PHP business apps (`old/apps/`): CRM, invoicing, inventory/POS, payroll, HR/leave, hotel/hospital management, task/project mgmt, expense tracker, video conferencing, screen recorder/sharing, whiteboard, wireframer, DB diagram, QR generator, etc. Each has a demo link and a "register_from_sass" API hook. |
| Pricing | Demo (free), Basic $1/mo, Plus $3/mo, Pro $5/mo — sold "per tool / users per tool". Far underpriced; no usage or AI value. |
| Current positioning | `llms.txt` repositions it as an **"Open-Source SaaS & AI Agent Template Hub"** in the MeWeBe Startup Studio network, with daily auto-generated SEO "Insights" (MCP server templates, Stripe webhooks, multi-tenant blueprints, agent orchestration). |
| Data | 1 real user table entry set, 9 categories, 4 packages. Effectively no user base to migrate. |
| Risks found | `users.original_password` stores **plaintext passwords** next to unsalted MD5 hashes; legacy apps are unmaintained PHP 7-era code (security liability if left publicly hosted). Retire both. |

**Takeaway:** the brand has two half-ideas — (a) "a bundle of cheap business apps for small companies" and (b) "a template hub for builders". Neither wins alone in 2026: generic CRUD apps are commoditised by AI app-builders (Lovable, Bolt, v0, Replit), and template marketplaces are saturated and SEO-dependent (ThemeForest, ShipFast-style boilerplates, free GitHub kits).

## 2. Market read (Oct 2026)

*This is my assessment from general market knowledge, not fresh sourced research — validate the price points and competitor list with a quick check before launch.*

- **AI saturation:** "Chat with X" and "AI generates an app" are commodities. Prompt-to-app builders produce code, but SMBs don't want code — they want working tools with their data in them.
- **Agents are now the user:** owners increasingly run work through Claude, ChatGPT, Gemini and their own agents. Products that expose **MCP servers + clean APIs** get used *from inside* those assistants; products that don't become invisible.
- **SMB tool sprawl:** a 5–30 person company pays for 6–12 separate SaaS seats (CRM, invoicing, projects, HR, inventory, booking). Consolidated suites (Zoho, Odoo) are powerful but heavy and unfriendly.
- **Pricing that works:** flat workspace pricing + included AI credits + metered overage beats per-seat for SMBs; marketplaces monetise via commission; free tiers drive SEO/word-of-mouth.

## 3. The decision — what to build

### **MeweMarket 2.0: the agent-ready business app suite.**
> *"Every tool your company runs on — CRM, invoicing, projects, inventory, HR, bookings — in one workspace your team **and your AI agents** can operate. Install apps in one click, or describe one and AI builds it."*

It is a direct descendant of the original (a market of business apps for companies, priced per workspace), rebuilt as:

1. **The Suite (core SaaS, primary revenue).** One multi-tenant workspace with a shared data layer (contacts, companies, products, documents, people) and installable **Apps**. Phase 1 ships 6 first-party apps rebuilt properly — the six with the best demand from the legacy catalogue:
   CRM & Pipeline · Invoices & Quotes (Stripe payment links) · Projects & Tasks (kanban) · Inventory & Orders · Team/HR (leave, timesheets) · Bookings & Scheduling.
2. **AI layer (the differentiator, not a gimmick).**
   - **Workspace Copilot** — command bar + chat that reads and *acts* across all installed apps with tool-calling ("invoice Acme for last week's hours", "which deals stalled?").
   - **App Builder** — describe a tool → AI generates a *custom app* as a schema (tables, fields, views, forms, automations) running on the same engine. No code to host; it is data + config, so it's safe and instantly usable.
   - **Automations** — trigger → conditions → actions (incl. AI steps: classify, extract, draft, summarise).
   - **Document intelligence** — drop a PDF/receipt/email → extracted into records.
3. **MCP + API (distribution channel).** Every workspace gets a hosted **MCP server** endpoint and REST API with scoped keys. Users connect it to Claude/ChatGPT/Gemini/Cursor, so the product is used even when nobody opens the UI. Marketing angle: *"The first business suite built for your AI agent."*
4. **Marketplace (secondary revenue + SEO).** Keeps the "Market" in the name: app templates, automation recipes, industry packs (clinic, hotel, agency, retail — mapping to legacy apps), and the existing builder boilerplates/AI agent kits. Free + paid listings; creators earn 80%, platform 20% via Stripe Connect.
5. **Insights + free tools (traffic engine).** Keep the daily Insights pipeline but move it in-app with real quality gates, plus free no-signup micro-tools (invoice generator, QR generator, timestamp converter, DB diagram — legacy apps reborn) that rank, convert, and carry affiliate links (hosting, domains, Stripe Atlas-style offers) and soft ads only on free tools/content.

### 3a. The App Catalog — many apps, not six
The six flagship apps are only the polished core. The product promise is **"every business app you need, in one place"**, so the catalogue must be large from launch and keep growing. It is built in three tiers:

| Tier | What it is | How apps get in | Launch target |
|---|---|---|---|
| **1. Flagship native apps** | Hand-built, deepest features (CRM, Invoices, Projects, Inventory, HR, Bookings) | Built in code | 6 |
| **2. Native catalogue apps** | Apps built as schemas (objects, fields, views, automations, dashboards) on the records engine. They are fully integrated with shared contacts, AI, MCP and API automatically | Researched from popular open-source and SaaS apps (features copied, not code), generated by the App Builder, then reviewed by a human | **60+ in Phase 1, 150+ in Phase 2** |
| **3. Hosted open-source apps** | Popular self-hostable OSS apps (Docker) deployed per workspace on our server with single sign-on, a launcher tile and an MCP/API bridge | One-click "Install" provisions a container from a vetted registry | **10–15 in Phase 1, 40+ in Phase 2** |

**Tier 2 categories (examples):** Sales (CRM, lead capture, proposals, commissions) · Finance (expenses, receipts, budgets, purchase orders, subscriptions tracker, petty cash, AR/AP) · Operations (assets, equipment maintenance, fleet, field service jobs, work orders, quality checks) · HR (recruiting/ATS, onboarding, payroll records, attendance, performance reviews, training, shift rota) · Customer (helpdesk tickets, knowledge base, feedback, surveys, NPS, loyalty) · Marketing (content calendar, campaigns, events, social planner, affiliate tracking) · Industry packs (clinic/patients, hotel/rooms, restaurant, salon, gym memberships, school/courses, real estate listings, property management, legal matters, construction projects, agency retainers, nonprofit donors, car rental, logistics/shipments, warehouse, e-commerce orders) · IT (IT assets, licences, incidents, change requests) · Productivity (OKRs, meeting notes, wiki, forms, contracts, document approvals).

**Tier 3 candidates (verify licence, maintenance and security before each is added):** Invoice Ninja, Kimai (time tracking), Cal.com (scheduling), Plane or Kanboard (projects), Twenty (CRM), Chatwoot (support inbox), Mautic (marketing automation), Snipe-IT (assets), Documenso (e-signature), Metabase (BI), Outline or BookStack (wiki), Excalidraw (whiteboard), Jitsi Meet (video calls, replacing the legacy conferencing app), Uptime Kuma (monitoring), Formbricks (surveys), Listmonk (newsletters), Akaunting (accounting), OrangeHRM or Jorani (HR/leave, Jorani is already in `old/apps`), OpenCart (shop, already in `old/apps`).

**Licensing rule (non-negotiable):** every Tier 3 app needs a licence check recorded in the catalogue. MIT, Apache and BSD are fine. AGPL/GPL are fine when we host the app unmodified and link to its source. Anything under "fair-code" or sustainable-use terms (for example n8n) or with commercial-hosting restrictions is excluded unless we hold a licence. Never pass off another product's brand as ours; show "Powered by <project>" with credit.

**Catalogue mechanics:**
- An in-admin **App Research pipeline**: the admin enters a category or a competitor product. AI researches common feature sets, drafts an app schema, generates seed data and a landing page, and puts it in a review queue. One click publishes it.
- Each app gets its own public SEO page `/apps/<slug>`, which multiplies indexable pages.
- Requests: users vote on missing apps, and the top requests feed the pipeline.
- Third-party developers publish apps through the Marketplace.

### 3b. App Discovery Crawler (later phase)
An automated pipeline that keeps the catalogue growing without manual work:
1. **Discover:** crawl sources such as GitHub (topics, stars, recent activity), awesome-selfhosted, Docker Hub, and the public OSS directories. Use their official APIs and respect `robots.txt` and rate limits.
2. **Qualify:** score each candidate on licence (allowlist only), maintenance (recent commits and releases), popularity, an official Docker image, SSO/OIDC support, API availability and known CVEs.
3. **Categorise:** AI assigns a catalogue category and tags, writes the description and landing copy, and detects duplicates of existing apps.
4. **Package:** automatically generate the hosted-app definition (image, env, volumes, DB, healthcheck, SSO config) or a Tier 2 schema app that reproduces its features.
5. **Test:** install it in a sandbox automatically, run a health check and a Trivy scan, and take screenshots.
6. **Review and publish:** the app goes to the admin review queue, and approved apps appear in the App Store under their category, available to subscribers on our domain within their plan limits.

Guardrails: only allowlisted licences are accepted, nothing is published without human approval, every app carries the original project's credit and source link, and a monitor rechecks published apps for licence changes, abandonment and vulnerabilities and unpublishes them if needed.

### Why this has the best chance
- Reuses the brand, domain, legacy catalogue and SEO content instead of starting cold.
- The MCP angle is timely and defensible for a small team; incumbents bolt it on slowly.
- Revenue from four streams (subscriptions, AI usage, marketplace commission, free-tool affiliate/ads) with the subscription as the anchor.
- Phase 1 is buildable in days because all apps share one engine (records + schema + views), and AI-built custom apps are the same engine.

## 4. Pricing (Stripe)

| Plan | Price | Includes |
|---|---|---|
| Free | $0 | 1 workspace, 3 users, 3 apps, 1,000 records, 50 AI credits/mo, MCP read-only, branding on invoices |
| Starter | $19/mo ($190/yr) | 5 users, all apps, 25k records, 1,000 AI credits, full MCP + API, 10 automations |
| Business | $49/mo ($490/yr) | 20 users, unlimited apps & automations, 5,000 AI credits, custom domain portal, roles, audit log |
| Scale | $129/mo | 50 users, 20k AI credits, SSO (Phase 2), priority support, sandbox workspace |
| Add-ons | | Extra users $5/user; AI credit packs ($10 = 1,000); marketplace purchases |

14-day Business trial, no card. Annual = 2 months free. Legacy $1–$5 plans are discontinued (no paying base to grandfather).

## 5. Target users
1. **SMB owner/operator (5–50 staff)** — replaces 4–8 tools; buys Starter/Business.
2. **Agency/consultant** — sets up workspaces for clients; buys Business/Scale; sells templates.
3. **AI-forward power user/indie hacker** — buys for the MCP + API; seeds marketplace.

## 6. UX principles & visual direction
- Feel: Linear/Attio-grade — fast, keyboard-first (⌘K everywhere), calm dark + light themes, dense-but-airy tables, optimistic updates, <100 ms interactions.
- Onboarding in under 2 minutes: "What does your company do?" → AI proposes an app set + sample data → user lands in a populated, working workspace.
- Every list is a view (table / kanban / calendar / gallery / chart) with saved filters, inline edit, bulk actions, CSV import/export.
- AI is visible but never in the way: a ⌘J copilot panel, inline "✨" suggestions, every AI action previewed with confirm/undo.
- Mobile-responsive PWA from day one.
- Design system: Tailwind v4 + shadcn/ui (Radix), Inter / Geist, one accent colour, lucide icons, Framer Motion micro-interactions.

## 7. Technical architecture (preferred stack)

| Layer | Choice | Why |
|---|---|---|
| Language | TypeScript end-to-end | One language for web, worker, MCP |
| Web app | **Next.js 15 (App Router, RSC, Server Actions)** | SEO pages + app in one; huge ecosystem; both agents know it well |
| DB | **PostgreSQL 16** + **pgvector**, row-level `workspace_id` tenancy (+ Postgres RLS in Phase 2) | Single reliable store incl. embeddings and full-text search |
| ORM | **Drizzle ORM** + drizzle-kit migrations | Typed, SQL-close, fast |
| Auth | **Better Auth** (email+password, magic link, Google/GitHub OAuth, orgs, 2FA) | Self-hosted, no vendor lock |
| Jobs/cron | **BullMQ + Redis 7** worker process; repeatable jobs replace OS crons | Retries, schedules, dashboard (Bull Board) all in-app |
| Files | **MinIO** (S3-compatible) on the server | Self-hosted; swap to S3/R2 by env var |
| AI | Provider abstraction: **Anthropic** (default `claude-sonnet-5-5`, `claude-haiku-5-5` for cheap tasks, `claude-opus-5-5` for App Builder) + **Gemini** fallback; Vercel AI SDK for streaming UI | Model choice per task, metered |
| MCP | `@modelcontextprotocol/sdk`, Streamable HTTP transport at `/mcp`, OAuth 2.1 + API-key auth | Works with Claude, ChatGPT, Gemini, Cursor |
| API | REST `/api/v1` with OpenAPI 3.1 spec (zod-openapi), scoped API keys, webhooks out | |
| Payments | **Stripe** Billing + Checkout + Customer Portal + Connect (marketplace) + Payment Links (invoices) | |
| Email | Resend (or Postmark) via SMTP abstraction; React Email templates | |
| Search | Postgres FTS + pgvector hybrid | No extra service |
| Analytics | Self-hosted **Umami**; Sentry-compatible **GlitchTip** self-hosted for errors | Everything on our box |
| Server | Ubuntu 24.04, **Caddy** (auto-TLS, reverse proxy), **PM2** (web, worker), Docker Compose only for Postgres/Redis/MinIO/Umami/GlitchTip | Simple to operate |
| Deploy | `git push production main` → bare repo on server → `post-receive` hook → install, migrate, build, `pm2 reload` (zero downtime), health-check, auto-rollback | Matches "deploy via git to dedicated server" |
| Backups | Nightly `pg_dump` + MinIO mirror, 14-day retention, optional off-site (rclone) | |

Monorepo (pnpm + Turborepo): `apps/web`, `apps/worker`, `packages/db`, `packages/core` (domain logic shared by UI, API and MCP), `packages/ai`, `packages/ui`, `packages/email`, `infra/`.

**Key design rule:** all business logic lives in `packages/core` services; the UI, REST API, MCP tools and the AI copilot all call the same services with the same permission checks. This is what makes "every feature is agent-operable" cheap.

## 8. Data model (core)
`users, sessions, accounts, workspaces, memberships(role), invitations, api_keys(scopes), apps(installed, kind: builtin|custom|marketplace), app_schemas(json), objects/fields (custom app engine), records(jsonb + typed columns for builtins), views, comments, activities(audit/timeline), attachments, automations, automation_runs, ai_credits_ledger, ai_conversations, ai_messages, embeddings, notifications, webhooks, webhook_deliveries, plans, subscriptions, invoices (Stripe mirror), marketplace_listings, listing_versions, purchases, payouts, reviews, posts (insights/blog), free_tool_usage, feature_flags, settings`.
Built-in apps get first-class tables (contacts, companies, deals, pipelines, invoices, invoice_lines, quotes, projects, tasks, products, stock_movements, orders, employees, leave_requests, timesheets, booking_services, availability, bookings).

## 9. Phase plan

### Phase 1 — "Launchable product" (≈3 days of Claude Code sessions)
Infra + deploy pipeline · auth & workspaces & roles · billing & plans & credits · app shell, ⌘K, themes · 6 built-in apps · custom App Builder (AI + manual) · views engine · Copilot with tool-calling · automations v1 · document extraction · REST API + keys + OpenAPI docs · hosted MCP server · marketplace v1 (browse, install free templates, list paid ones) · public site (landing, pricing, apps, marketplace, docs, insights blog, 4 free tools) · admin panel · emails · SEO (sitemap, llms.txt, OG images, schema.org) · backups, monitoring, tests.

### Phase 2 — "Enterprise-ready" (≈2 weeks)
Postgres RLS + hardened tenancy · SSO (SAML/OIDC) + SCIM · granular permissions & field-level security · audit log exports · advanced automations (branching, loops, schedules, webhooks in, human approval steps) · AI agents (long-running, scheduled, per-app agents with memory) · RAG knowledge base over workspace docs · Stripe Connect payouts & creator dashboard · marketplace reviews/versioning/moderation · client portals & custom domains · email inbox sync (Gmail/Outlook) · calendar sync · integrations (Slack, Google Drive, Zapier/Make/n8n via webhooks, QuickBooks/Xero export) · multi-currency, tax (Stripe Tax), localisation (i18n) · mobile PWA offline · real-time collaboration (presence, live updates) · reporting/dashboard builder · data residency & GDPR tooling (export/delete) · white-label/reseller · usage analytics & in-app growth (referrals, NPS, onboarding checklists) · load testing, security review, SOC2-style controls · status page.

## 10. Go-to-market (first 90 days)
1. Launch week: Product Hunt + Hacker News "Show HN: a business suite your Claude can run via MCP"; list the MCP server in public MCP directories.
2. SEO: each free tool + each built-in app + each industry pack gets a landing page; Insights keeps publishing *but only articles that pass a quality gate* (original examples, screenshots, no thin content).
3. Templates as content: every marketplace template has a public, indexable page.
4. Agencies program: 20% recurring referral via Stripe-tracked referral codes.
5. Affiliate/ads only on free tools and blog, never inside the paid app.

## 11. Success metrics
Visitor→signup ≥ 4% · signup→activated (≥1 app + 10 records in 7 days) ≥ 40% · trial→paid ≥ 12% · MCP connected on ≥ 25% of paid workspaces · monthly logo churn < 4% · AI cost < 15% of revenue.

## 12. What you must provide before/while running the prompts
- Server: Ubuntu 24.04 dedicated server with SSH access (sudo user), domain DNS A/AAAA records for `mewemarket.com`, `app.` optional, `mcp.` optional.
- Stripe: secret + publishable keys, webhook secret (prompt creates products/prices via a seed script), Connect enabled for Phase 2.
- `ANTHROPIC_API_KEY`, optional `GEMINI_API_KEY`.
- Email provider key (Resend/Postmark) + verified sending domain (SPF/DKIM).
- Google/GitHub OAuth client IDs (optional at launch).

See `MASTERPROMPT_PHASE1.md` and `MASTERPROMPT_PHASE2.md`.
