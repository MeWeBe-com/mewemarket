# MASTER PROMPT — MeweMarket 2.0 · PHASE 1 (≈3 days of agent work)

> Paste everything below the line into Claude Code (Opus 5.5) or Antigravity (Gemini). Put `BRIEF.md` in the repo root first, because this prompt refers to it.

---

You are the lead engineer building **MeweMarket 2.0**, an agent-ready business app suite. Users get CRM, invoicing, projects, inventory, HR and bookings in one multi-tenant workspace. AI agents can run the workspace through MCP and a REST API. The product also has an AI App Builder, a template marketplace, and free SEO tools. `BRIEF.md` in the repo root is the product source of truth. Read it fully before you start.

## Operating rules
1. Work autonomously and do not stop to ask questions. When a decision is ambiguous, choose the option that best fits BRIEF.md, record it in `docs/DECISIONS.md`, and keep going.
2. Plan first. Write `docs/PLAN.md` with the milestones below broken into checkbox tasks. Tick each task as you finish it. Commit after every milestone using Conventional Commits.
3. Build vertical slices. A feature counts as done only when it has a DB migration, a core service, its UI, its REST endpoint, its MCP tool, permission checks, zod validation, tests, and seed data.
4. **One source of business logic.** All domain logic lives in `packages/core`. The UI (server actions), the REST API, the MCP tools and the AI copilot tools call the same service functions. Each of those functions takes a `ctx` with `{ userId, workspaceId, role, via: 'ui'|'api'|'mcp'|'ai' }` as its first argument.
5. Every query is scoped by `workspace_id`. A test must prove that cross-tenant access fails.
6. No placeholders, TODO stubs or lorem ipsum in shipped UI. Seed realistic demo data instead.
7. Keep secrets in `.env` only. Ship `.env.example` with every variable documented.
8. Run `pnpm typecheck && pnpm lint && pnpm test` before every commit. Fix every failure.

## Tech stack (do not substitute without writing a DECISIONS.md entry)
- pnpm workspaces + Turborepo, TypeScript strict, Node 22 LTS.
- `apps/web`: Next.js 15 App Router, React 19, Tailwind v4, shadcn/ui (Radix), lucide-react, Framer Motion, TanStack Table, dnd-kit, react-hook-form + zod, next-themes, cmdk, Recharts.
- `apps/worker`: BullMQ worker and scheduler for automations, AI jobs, emails, webhooks, backups and the insights pipeline. Bull Board is mounted behind admin auth at `/admin/queues`.
- `packages/db`: Drizzle ORM and drizzle-kit migrations on PostgreSQL 16 with the `pgvector` and `pg_trgm` extensions.
- `packages/core`: domain services, permissions (RBAC: owner, admin, member, guest) and plan limits.
- `packages/ai`: provider abstraction over the Anthropic SDK and Google Gen AI SDK. Model routing: `claude-haiku-5-5` for classification and extraction, `claude-sonnet-5-5` for the copilot and drafting, `claude-opus-5-5` for the App Builder. The fallback provider is Gemini. Use the Vercel AI SDK for streaming. Every call is metered into `ai_credits_ledger`. Use prompt caching for system prompts and tool schemas.
- `packages/mcp`: an MCP server built on `@modelcontextprotocol/sdk` using Streamable HTTP, mounted at `/mcp`.
- `packages/ui`, `packages/email` (React Email), `packages/config` (eslint, tsconfig).
- Auth: Better Auth with email/password, magic link, Google and GitHub OAuth, the organization plugin and TOTP 2FA.
- Payments: Stripe (Checkout, Billing, Customer Portal, webhooks, Payment Links).
- Storage: MinIO through the S3 SDK. Email: Resend through an adapter, with SMTP as the fallback.
- Tests: Vitest for unit and service tests against a real Postgres test DB, and Playwright for e2e on the critical flows.
- Infra: Ubuntu 24.04, Caddy, PM2, and Docker Compose only for postgres, redis, minio, umami and glitchtip.

## Milestones

### M0: Repo, infrastructure and git deployment (do this first)
- Scaffold the monorepo, shared configs, and `docker-compose.yml` for local and production services (Postgres with pgvector, Redis, MinIO, Umami, GlitchTip). Bind every service to localhost only and give each one a healthcheck.
- `infra/server-setup.sh` is an idempotent bootstrap script for a fresh Ubuntu 24.04 server. It must:
  - create a `deploy` user, set up the UFW firewall (22, 80, 443) and fail2ban, and enable unattended-upgrades;
  - install Node 22 via corepack/pnpm, Docker, Caddy and PM2 (with the PM2 startup hook);
  - create a bare repo `/srv/git/mewemarket.git`, the release layout `/srv/mewemarket/{releases,shared,current}`, and a shared `.env`.
- `infra/post-receive` hook runs on each push. It checks out to `releases/<timestamp>`, symlinks shared `.env` and uploads, runs `pnpm install --frozen-lockfile`, runs `pnpm db:migrate`, builds, switches the `current` symlink, runs `pm2 reload ecosystem.config.cjs`, hits `/api/health`, and rolls back automatically on failure. It keeps the last 5 releases.
- `ecosystem.config.cjs` defines `web` (cluster, 2 instances) and `worker` (fork).
- The `Caddyfile` covers `mewemarket.com` and `www` (redirect), proxies to web, routes `/mcp` to web with streaming enabled, adds security headers, and enables compression.
- `infra/backup.sh` runs nightly `pg_dump` plus a MinIO mirror with 14-day rotation and an optional rclone off-site copy. It is scheduled as a BullMQ repeatable job, with a cron fallback documented.
- `docs/DEPLOY.md` explains the one-time server setup, `git remote add production deploy@SERVER:/srv/git/mewemarket.git`, `git push production main`, rollback, logs, and restoring from backup.
- `/api/health` checks the DB, Redis and MinIO.

### M1: Auth, workspaces and roles
Cover sign up and sign in (password, magic link, OAuth), email verification, password reset and 2FA. Build workspace creation, invitations by email, roles, and a workspace switcher. Add profile and workspace settings with logo, currency, timezone, locale and fiscal settings. Add active session management. Rate-limit auth routes.

### M2: Billing, plans and AI credits
- Plans come from BRIEF.md §4: Free, Starter, Business and Scale, each monthly and annual, plus add-ons for extra users and AI credit packs.
- `scripts/stripe-seed.ts` creates the Stripe products and prices idempotently and writes their IDs to the DB.
- Build Checkout, the Customer Portal, and the webhook handler for subscription created/updated/deleted, invoice paid/failed, and checkout completed for credit packs. The handler must be idempotent through a `stripe_events` table.
- A 14-day Business trial starts without a card. Show trial-ending banners and send dunning emails.
- `core/limits.ts` enforces users, apps, records, automations and AI credits. When a limit is hit, show an upgrade modal that explains exactly why.
- The credit ledger records a monthly grant, consumption with the model and token cost, and purchases. Show usage charts in Settings → Billing.

### M3: App shell and design system
- Build a polished, responsive shell: a collapsible sidebar listing installed apps, the workspace switcher, a ⌘K command palette that can navigate, create a record, run an AI command or search everything, a ⌘J copilot panel, a notifications inbox, dark and light themes, keyboard shortcuts with a help sheet (`?`), toasts, skeletons, empty states with clear CTAs, and error boundaries.
- Visual target is Linear/Attio quality: generous spacing, one accent colour, subtle borders, fast transitions. Lighthouse must score ≥ 90 on public pages.

### M4: Records and views engine (the foundation for all apps)
- The generic object and field system supports these field types: text, long text, number, currency, date, datetime, select, multi-select, checkbox, email, phone, URL, relation, user, file, formula (safe expression evaluator), rollup, AI field (filled by a prompt), rating and status.
- Records are stored as typed tables for built-in apps and as a JSONB `records` table with GIN indexes for custom apps. Both are exposed through one `RecordService` interface.
- View types are table (inline edit, column resize, reorder, hide, sort, group), kanban (drag between statuses), calendar, gallery, list and chart. Users can save filters and sort per view and share views.
- Every record has a detail drawer with fields, a comments thread with @mentions, an activity timeline that also serves as the audit trail, and attachments.
- Support bulk select/edit/delete, CSV import with column mapping and preview, CSV and XLSX export, undo for destructive actions, and global search using FTS plus trigram matching.

### M5: The six built-in apps (all complete and production quality)
1. **CRM**: contacts, companies, deals, multiple pipelines with stages, kanban, activities (call, email, meeting, note), follow-up reminders, and a deal forecast chart.
2. **Invoices & Quotes**: line items, taxes, discounts, multi-currency display, a branded PDF (rendered server-side with `@react-pdf/renderer`), email sending, a Stripe Payment Link per invoice with automatic paid status via webhook, recurring invoices, overdue reminders, convert quote → invoice, and a public invoice view page.
3. **Projects & Tasks**: projects, a task board and list, assignees, due dates, priorities, subtasks, a time tracker that bills hours to an invoice, and a my-tasks view.
4. **Inventory & Orders**: products and SKUs, stock locations, stock movements, low-stock alerts, purchase and sales orders, and barcode/QR labels.
5. **Team / HR**: an employee directory, leave requests with approval, a leave calendar, timesheets, and a holidays calendar.
6. **Bookings**: services, staff availability, a public booking page per workspace (`/b/<slug>`), confirmation and reminder emails, an ICS attachment, and optional Stripe deposit.

Each app ships with an app manifest (permissions, objects, default views and dashboard widgets), a dashboard widget for the workspace home, and seed demo data.

### M5b: App Catalog (many apps, see BRIEF.md §3a)
- **Catalogue model:** `catalog_apps` with tier (native | schema | hosted), category, licence, source URL, version, status (draft | review | published), icon, screenshots, an SEO landing copy and an install count. The in-app **App Store** at `/apps` has categories, search, featured apps and an "Install" button. Installed apps appear in the sidebar.
- **Tier 2: 60+ schema apps at launch.** Create `catalog/apps/<slug>/app.json` (objects, fields, relations, views, dashboard widgets, automations, seed rows) for every category listed in BRIEF.md §3a. Generate drafts with the App Builder pipeline and then review each one by hand for sensible fields, working views and realistic seed data. Each app must install cleanly into a fresh workspace (CI test installs every app) and must automatically link to shared Contacts, Companies and Users where relevant.
- **App Research pipeline (admin):** input a category or competitor name → AI drafts the feature list, `app.json`, seed data and landing copy → review queue → publish. It is a BullMQ job with progress shown in the UI.
- **Tier 3: hosted open-source apps.** Build `apps/orchestrator`, which provisions vetted Docker images per workspace through the Docker Engine API. Each app gets its own subdomain `<app>-<ws>.apps.mewemarket.com` routed by Caddy, resource limits (CPU and RAM), a dedicated database or schema, nightly backups, and start/stop/upgrade/remove controls. Sign-in uses OIDC from our auth server where the app supports it, otherwise an auto-generated credential vault. A **bridge** exposes each hosted app's API as MCP tools and syncs key entities (contacts, invoices, events) into the core records through polling and webhooks.
  - Ship 10 hosted apps in Phase 1, chosen from BRIEF.md §3a. Prefer ones with OIDC support and a good API.
  - Before adding each app, record its licence check in `catalog/hosted/<slug>/LICENSE-CHECK.md`. Exclude any app whose licence forbids commercial hosting.
  - Plan limits: Free 0 hosted apps, Starter 1, Business 3, Scale 10. Hosted apps are a paid add-on beyond that.
- **App requests:** users submit and vote on requested apps, and the admin can send a request straight into the research pipeline.
- **SEO:** every published app gets `/apps/<slug>` with features, screenshots, an FAQ and schema.org SoftwareApplication markup.

### M6: AI features
- **Copilot (⌘J)**: streaming chat with tool calling over every core service the user is permitted to use (search, create, update, summarise, report). Any write action is first shown as a preview card the user confirms or cancels, and confirmed actions can be undone. Conversations are saved per user, and the copilot is aware of the current page context.
- **AI command bar**: natural-language actions from ⌘K, for example "add a deal for Acme £5k closing next Friday".
- **App Builder**: the user describes a tool. Opus returns an app schema (objects, fields, relations, views, sample automations, seed rows) validated by zod. The user sees a live preview and installs it, and can then edit it in a visual schema editor. A manual builder is also available without AI.
- **Onboarding wizard**: the user answers "what does your business do?". AI recommends apps and generates sample data, and the user lands in a populated workspace in under 2 minutes.
- **Document intelligence**: dropping a PDF, image or pasted email extracts structured data into a chosen object, for example a receipt becomes an expense or a business card becomes a contact. Show a confidence score and review before saving.
- **AI fields and AI actions on records**: summarise, draft email, score lead, categorise.
- Semantic search embeds records and attachments with pgvector, re-embeds them in a background job, and combines the results with keyword search (hybrid).
- Every AI action is metered, and a hard stop at the credit limit shows a friendly upsell.

### M7: Automations v1
A visual builder with a trigger, conditions and actions.
- Triggers: record created, record updated, field changed, schedule, form submitted, invoice paid, booking made.
- Actions: create or update a record, send an email, send an in-app notification, call a webhook, run an AI step (classify, extract, generate text into a field), or create a task.
- Each automation keeps a run history with logs and supports retries. Jobs run in the BullMQ worker. The builder includes ten prebuilt recipes.

### M8: REST API, webhooks and the MCP server
- REST `/api/v1/*` covers every object (CRUD, list with filter/sort/pagination, search) and app-specific actions (send invoice, approve leave, and so on). Generate an OpenAPI 3.1 spec and render the docs at `/docs/api` with Scalar.
- API keys are created per workspace with scopes (read/write per app) and shown only once, then stored hashed. Rate limiting per key uses Redis.
- Outbound webhooks are signed with HMAC, retried with backoff, and logged with a delivery log.
- MCP server at `https://mewemarket.com/mcp`:
  - Streamable HTTP transport. Auth with OAuth 2.1 (authorization code + PKCE, with a consent screen) and also with a Bearer API key.
  - Tools are generated from the core services and the installed apps' manifests, including custom apps. Examples: `search_records`, `get_record`, `create_record`, `update_record`, `list_objects`, `run_report`, `send_invoice`, `create_task`, `book_slot`, `run_automation`, `ask_workspace`.
  - Resources are the workspace schema and saved views. Prompts are templates such as "weekly sales summary".
  - Every call goes through the same permission and limit checks and is logged to the activity log with `via:'mcp'`.
  - Free plan workspaces get read-only access.
- `/docs/mcp` gives copy-paste setup for Claude Desktop/Code, ChatGPT, Gemini and Cursor.
- Settings → Integrations shows connected agents and keys and lets the user revoke them.

### M9: Marketplace v1
- Listing types: app template (schema JSON), automation recipe, industry pack (a bundle), and developer kit (downloadable zip plus a link to the repo).
- Public pages `/marketplace` and `/marketplace/<slug>` include screenshots, a description, what is included, a version, and a one-click "Install to workspace" button.
- Free listings install immediately. Paid listings go through Stripe Checkout as a one-time payment, then grant an entitlement and allow download or installation.
- Creators submit through `/marketplace/sell` (an admin approves). Record the 20% platform fee on each purchase; payouts are tracked manually in admin and Connect arrives in Phase 2.
- Seed at least 12 quality listings mapped to the legacy catalogue: Clinic/Hospital pack, Hotel pack, Agency pack, Retail/POS pack, Payroll & Attendance, Event management, Expense tracker, Purchase orders, Client portal, Asset management, MCP server starter kit, and Stripe SaaS boilerplate.

### M10: Public website, SEO and free tools
- Pages: landing (hero with product video/animated demo, "works with your AI agent" section showing MCP, app grid, testimonials placeholder replaced by real-looking-but-generic use-cases, pricing teaser, FAQ, CTA), `/pricing` (monthly/annual toggle, comparison table), `/apps/<app>` landing per built-in app, `/industries/<industry>`, `/marketplace`, `/docs` (MDX: getting started, apps, automations, API, MCP), `/insights` blog (MDX/DB posts, migrate the 8 existing `old/insights/*.html` articles with 301s from old URLs), `/about`, `/contact`, legal pages (terms, privacy, cookies, DPA, AUP).
- Free tools (no signup, rate-limited, each with an SEO landing, a soft CTA to sign up, and an ad/affiliate slot component that admin toggles): **Invoice Generator** (PDF download), **QR Code Generator**, **Timestamp Converter**, and **DB Diagram** (DBML → diagram, export PNG/SQL).
- SEO: metadata API, dynamic OG images, `sitemap.xml`, `robots.txt`, `llms.txt` and `llms-full.txt`, schema.org (SoftwareApplication, Product, FAQ, Article, BreadcrumbList), canonical URLs, and 301 redirects from legacy CodeIgniter URLs (`/products/*`, `/category/*`, `/pricing`, `/apps/*`).
- A cookie consent banner gates Umami (cookie-less) and ads.

### M11: Admin panel (`/admin`, superadmin only)
Covers users, workspaces (impersonate with an audit trail, change plan, extend trial), subscriptions and revenue (MRR, churn, trials, plan mix charts), AI usage and cost per workspace and model, marketplace moderation and payouts ledger, insights post editor with an AI draft step and a quality-gate checklist (originality, length, internal links, no thin content) before publishing, feature flags, site settings (ad slots, affiliate links, announcement bar), email templates preview, queue dashboard, and system health.

### M12: Notifications and email
Covers in-app notifications, an email digest (daily or weekly, per user preference), and transactional emails built with React Email: welcome, verify, invite, password reset, trial ending, payment failed, invoice to client, booking confirmation and reminders, leave approval, and automation emails.

### M13: Quality, security and launch checklist
- Security: Zod on every input, CSRF protection on server actions, a CSP header, rate limits, hashed API keys, encrypted OAuth tokens (AES-GCM with a key from env), upload type and size checks, SSRF guard on webhooks, and no secrets in the client.
- Tests: service unit tests for every app, tenant isolation tests, a Stripe webhook test with fixtures, an MCP tool contract test, and Playwright e2e for: sign up → onboarding → create a deal → create and send an invoice → mark it paid via webhook; upgrade plan; connect via API key and call an MCP tool.
- Performance: RSC by default, pagination everywhere, DB indexes on (workspace_id, …), and Redis caching for hot reads.
- Accessibility: keyboard navigation, focus rings, ARIA attributes on Radix components, and WCAG AA contrast.
- Write `README.md` covering local development (`docker compose up -d && pnpm dev`), the scripts, and the architecture diagram.
- `scripts/seed-demo.ts` creates a full demo workspace with a `demo@mewemarket.com` login and a nightly reset that powers a public "Try the live demo" link.

## Definition of done for Phase 1
- `git push production main` on a fresh Ubuntu server, after running `infra/server-setup.sh` and filling in `.env`, results in a live HTTPS site.
- A new visitor can sign up, finish onboarding, use all 6 apps, build a custom app with AI, run an automation, upgrade through Stripe, create an API key, and connect Claude to `/mcp` to create a record.
- The admin panel shows the signup and revenue.
- All checks pass and `docs/PLAN.md` is fully ticked.

Finish by printing a summary of what was built, every environment variable the owner must set, and the exact commands to deploy.
