# MeweMarket 2.0

This is an agent-ready business app suite. See `BRIEF.md` for the product, `docs/PLAN.md` for progress and `docs/DEPLOY.md` for production.

## Local development
```bash
cp .env.example .env            # fill in the values
docker compose up -d            # Postgres, Redis, MinIO, Umami
pnpm install
pnpm db:migrate
pnpm dev                        # web on :3000, worker
```

## Layout
- `apps/web`: the Next.js app (public site, app, API, MCP)
- `apps/worker`: BullMQ jobs (automations, AI, email, backups)
- `packages/db`: the Drizzle schema and migrations
- `infra/`: server bootstrap, deploy hook, Caddy, backups
