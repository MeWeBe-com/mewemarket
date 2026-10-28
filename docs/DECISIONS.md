# Decisions

- **2026-10-28 Process model:** the app processes (Next.js and the worker) run under PM2 on the host. Docker is used only for stateful services. This keeps deploys fast and simple, and the logs and restarts go through PM2.
- **2026-10-28 Workspaces = Better Auth organizations:** the `workspaces`, `members` and `invitations` tables follow the organization plugin's field names. The tables are renamed through the adapter's modelName mapping.
- **2026-10-28 Deploy installs dev deps:** `pnpm install --prod=false`, because `.env` sets `NODE_ENV=production` and the build needs TypeScript and Tailwind.
- **2026-10-28 Backups via BullMQ scheduler:** the backup job runs from the worker instead of a system cron, so it shows up in the queue dashboard. A cron fallback is documented in DEPLOY.md.
