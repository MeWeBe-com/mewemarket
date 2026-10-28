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

## M2–M13
Not started. See MASTERPROMPT_PHASE1.md.
