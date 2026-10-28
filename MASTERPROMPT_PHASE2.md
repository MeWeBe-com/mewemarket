# MASTER PROMPT — MeweMarket 2.0 · PHASE 2 (≈2 weeks, enterprise-ready)

> Paste this into Claude Code (Opus 5.5) or Antigravity (Gemini) **in the Phase 1 repo, after Phase 1 is live**.

---

You are continuing **MeweMarket 2.0**. Phase 1 is in production. Before changing anything, read `BRIEF.md`, `docs/PLAN.md`, `docs/DECISIONS.md`, `README.md` and the codebase so you know what already exists. Your job is to turn the product into an enterprise-ready platform without breaking production.

## Operating rules
- All the Phase 1 rules still apply: autonomous, plan-first, vertical slices, one core service layer shared by UI, API, MCP and AI, workspace isolation, no placeholders, and tests before every commit.
- Write `docs/PLAN-PHASE2.md` organised into the workstreams below, with day estimates. Ship in order. Each workstream lands on its own branch, gets merged to `main`, and is deployed with `git push production main`.
- **Production safety:**
  - Migrations must be backwards-compatible (expand → migrate → contract).
  - Every new feature sits behind a feature flag until it is verified.
  - Take a backup before any destructive migration.
  - Keep zero-downtime reloads.
- Add a `CHANGELOG.md` entry and an in-app "What's new" entry for every user-facing change.

## Workstreams

### W1: Hardened multi-tenancy and security (do first)
- Turn on Postgres Row-Level Security on every tenant table, using `app.workspace_id` set per transaction. Keep the app-level checks as defence in depth. Write tests that bypass the app layer and prove that RLS blocks cross-tenant access.
- Add field-level permissions, custom roles with a permission matrix per app, object and action, guest/client roles, and record-level sharing.
- Make the audit log immutable (append-only, hash-chained). Add an audit viewer with filters and CSV/JSON export, and a configurable retention period per plan.
- Add an encryption-at-rest option for sensitive fields, secrets rotation tooling, configurable session policies (idle timeout, enforce 2FA), and IP allowlists for the Scale plan.
- Write a security review document covering an OWASP ASVS L2 checklist and a dependency audit in CI. Add automated `pnpm audit` and Semgrep checks to the pre-deploy hook.

### W2: Enterprise identity
- Support SAML 2.0 and OIDC SSO per workspace with domain verification and just-in-time provisioning, plus a SCIM 2.0 endpoint for user and group provisioning.
- Enforce SSO, enforce 2FA, and add passkeys (WebAuthn).

### W3: AI agents platform
- **Workspace agents** are long-running agents with a goal, tools (the MCP/core tools), a schedule or trigger, memory (summarised plus vector), and a budget. Examples: "Chase overdue invoices every Monday", "Qualify new leads and draft replies", "Weekly ops report to Slack". Each agent has a run timeline with step-by-step traces, human approval gates for risky actions, and a kill switch.
- **Knowledge base (RAG):** upload documents or sync Google Drive, chunk and embed them, and use hybrid retrieval with citations. The copilot and agents answer from it.
- **AI reports:** natural language → a chart or dashboard widget (generate SQL against a safe, read-only semantic layer, never raw SQL on tenant tables).
- **App Builder v2:** iterative chat editing of an existing app ("add a status field and a kanban by owner"), plus generating automations and dashboards alongside the app.
- **Model governance:** admin chooses the models allowed per workspace, an optional "bring your own key" for Anthropic, Gemini or OpenAI, PII redaction before prompts, and opt-out from logging prompts.
- **Evals:** a regression suite of copilot and App Builder tasks with a pass-rate gate in CI. Track cost and latency dashboards per model.

### W4: Automations v2
Add branching (if/else and switch), loops over lists, delays, scheduled cron triggers, inbound webhooks with a signed URL, human-approval steps (shown in an approvals inbox), sub-workflows, error handlers, version history with rollback, a test-run mode with sample data, and a template gallery.

### W5: Integrations
- Email inbox sync for Gmail and Outlook (OAuth). Emails link to contacts and deals, users can send from the CRM, and open tracking is optional.
- Two-way calendar sync with Google and Microsoft for bookings and tasks.
- Slack: notifications and slash commands to query or create records.
- Google Drive and Dropbox attachments.
- Accounting export/sync for QuickBooks and Xero (invoices, payments, contacts).
- Zapier, Make and n8n: publish an app or integration definition backed by the REST API and webhooks.
- A generic "Connect any MCP server" client so workspace agents can use external MCP tools the admin approves.
- An integrations directory page for each integration, for SEO.

### W6: Billing and marketplace v2
- **Stripe Connect Express** for creators: onboarding, automatic 80/20 split, payout dashboard, tax forms, and refunds handling.
- Marketplace: versioned listings with changelogs, an update flow for installed templates (diff preview), ratings and reviews (with verified purchase), moderation queue, creator profiles, collections, featured placements (paid), and search with facets. Add marketplace **subscriptions** for templates that receive updates.
- **Stripe Tax** and multi-currency prices, VAT ID collection, usage-based metered billing for AI credit overage (Stripe Meters), seat-based add-ons, coupons and promo codes, a referral program (20% recurring for agencies) with a referral dashboard, and annual invoicing (pay by invoice) for Scale.

### W7: Client portals, white-label and custom domains
- **Client portal:** external clients log in to see their invoices, quotes, projects and bookings and to pay, approve, comment and upload.
- **Custom domains** for the portal and booking pages, with automatic TLS through Caddy on-demand TLS and an ask endpoint that verifies the domain belongs to a workspace.
- **White-label** for the Scale and agency tiers: logo, colours, email-from domain (DKIM setup wizard) and removal of branding.
- **Agency mode:** manage many client workspaces from one account and clone a workspace as a template.

### W8: Collaboration and real-time
Add real-time updates and presence (who is viewing a record) using WebSockets through a small `apps/realtime` service (Socket.IO with a Redis adapter) or Postgres LISTEN/NOTIFY with SSE; pick one and record it in DECISIONS. Also add live cursors on boards, a collaborative rich-text docs object (TipTap + Yjs) for notes and wikis inside the workspace, and threaded discussions with reactions.

### W9: Reporting and dashboards
A dashboard builder with drag-and-drop widgets (KPI, line, bar, pie, funnel, table, leaderboard, goal). Widgets read from objects, filters and date ranges. Dashboards can be scheduled for delivery by email or Slack as PDF, shared through a public link, and used as role-based home dashboards. Ship prebuilt dashboards per app: sales, cashflow/AR ageing, project utilisation, inventory valuation and HR.

### W10: Mobile, offline and i18n
- PWA polish: installable, offline read cache with queued writes, push notifications (Web Push), mobile-optimised views for tasks, CRM, bookings and timesheets, and camera capture for document intelligence (receipts).
- i18n with next-intl: English, Spanish, French, German, Portuguese and Arabic (with RTL support). Locale-aware currency, date and number formatting.

### W11: Compliance and data
- GDPR tooling: full workspace export as JSON, CSV and attachments zip; account and workspace deletion with a grace period; a DPA acceptance flow; consent records; a sub-processor list page.
- Data retention policies, a sandbox workspace (copy production to sandbox), and workspace import from CSV bundles and from popular tools (HubSpot, Trello, Airtable CSV).
- SOC2-style controls documentation in `docs/compliance/`, and a public `/trust` page.

### W12: Growth, analytics and support
- Product analytics events through self-hosted Umami custom events or PostHog self-hosted (choose and record in DECISIONS), an activation funnel in admin, an onboarding checklist, in-app NPS and feedback, and changelog/announcement modals.
- Lifecycle emails: activation nudges, trial conversion sequence, win-back, and usage milestone emails.
- A help centre in docs with AI search (RAG over docs), and an AI support widget on the public site that escalates to an admin inbox.
- Programmatic SEO done carefully: pages for each integration, industry, template and "X alternative" comparison. Every page needs unique, useful content generated with human-review gates in admin. Never publish thin pages.
- An affiliate/ads manager in admin with placements, A/B tests and click/RPM reporting (free tools and blog only).

### W13: Scale, reliability and operations
- Load test with k6 (target 500 RPS reads, p95 < 300 ms) and fix the hot spots: indexes, caching, query plans, and connection pooling with PgBouncer.
- Postgres tuning, PITR backups (WAL archiving with pgBackRest), a restore drill script, and documented RPO and RTO targets.
- Monitoring with self-hosted Uptime Kuma and a public status page at `status.mewemarket.com`, Prometheus node exporter plus Grafana (optional, Docker), alerting to email and Slack, and log rotation.
- Blue/green-safe deploys with a canary health check, feature-flag kill switches, and graceful worker shutdown.
- Document horizontal scale-out in `docs/SCALING.md`: a second app server, managed Postgres, and an S3/R2 migration path.

### W13b: App Catalog expansion
- Grow Tier 2 schema apps from 60 to **150+**, focusing on the industry packs and the most-voted requests. Keep the CI install test for every app.
- Grow Tier 3 hosted apps to **40+**. Add per-app upgrade channels, a vulnerability scan of each image with Trivy before rollout, automatic security updates, usage metering and add-on billing per hosted app.
- Deepen the bridges so hosted-app data syncs both ways with core records, and so their actions are available to agents and automations.
- Add app bundles ("Clinic in a box", "Agency OS"), app dependency handling, and cross-app dashboards.
- Opening the catalogue to developers means an App SDK and CLI (`mewe app init/dev/publish`), app review guidelines, and revenue share through Connect.

### W13c: App Discovery Crawler (BRIEF.md §3b)
- Build `apps/crawler` as BullMQ scheduled jobs that discover candidates from the GitHub API, awesome-selfhosted, Docker Hub and other configured sources (polite, rate-limited, using APIs where they exist). Store results in `crawl_sources`, `app_candidates` and `candidate_scores`.
- Score candidates on licence (from an allowlist), activity, stars, Docker image, OIDC support, API and CVEs. Use AI to categorise them into the catalogue taxonomy, deduplicate, and generate the description, the hosted definition or schema app, and the landing page.
- The sandbox step installs each candidate automatically, then runs a health check, a Trivy scan and Playwright screenshots. Candidates that pass go to the admin review queue, and only an admin can publish one.
- A recheck job runs nightly over published apps for licence changes, archival and new CVEs. It alerts the admin and unpublishes apps automatically when a hard rule fails.
- The admin UI covers sources, crawl runs, candidates with scores, bulk approve or reject, and per-category stats.

### W14: Final polish
- A full UX audit: consistency pass across every screen, empty, loading and error states, micro-interactions, a keyboard-navigation audit, an accessibility audit with axe (no serious issues), and a dark mode check.
- Lighthouse ≥ 95 on public pages, Core Web Vitals in the green.
- Docs complete for every feature. API v1 frozen with deprecation policy, SDKs generated (TypeScript and Python) from OpenAPI, and an MCP server listed in public registries with complete metadata.
- Expand the e2e suite to every workstream, and fix every flaky test.

## Definition of done for Phase 2
- Every workstream is merged, flag-verified and deployed.
- RLS isolation is proven by tests, SSO and SCIM work with Okta and Entra test tenants, agents run on a schedule with approvals, Connect payouts work in Stripe test mode, client portals run on custom domains with TLS, and dashboards are scheduled.
- The restore drill passes, the load test meets its targets, the security checklist is complete, and all docs are updated.

Finish with a release report covering what shipped, the migration notes, new environment variables, the operator runbook changes, and a recommended Phase 3 backlog ranked by expected revenue impact.
