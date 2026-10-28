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
- [ ] Verify against a live Postgres/Redis (Docker isn't installed on the dev Mac)
- [ ] ESLint config and Vitest harness

## M1: Auth, workspaces and roles
- [ ] Better Auth (password, magic link, Google/GitHub, organization, 2FA) wired to Drizzle
- [ ] Sign up, sign in, verify, reset pages
- [ ] Workspace create, switch, invite and roles
- [ ] Settings: profile, workspace, sessions

## M2–M13
Not started. See MASTERPROMPT_PHASE1.md.
