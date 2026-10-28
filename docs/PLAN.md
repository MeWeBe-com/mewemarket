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

## M2–M13
Not started. See MASTERPROMPT_PHASE1.md. M2 is blocked on Stripe test keys.
