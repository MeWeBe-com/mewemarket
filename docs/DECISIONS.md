# Decisions

- **2026-10-28 Process model:** the app processes (Next.js and the worker) run under PM2 on the host. Docker is used only for stateful services. This keeps deploys fast and simple, and the logs and restarts go through PM2.
- **2026-10-28 Workspaces = Better Auth organizations:** the `workspaces`, `members` and `invitations` tables follow the organization plugin's field names. The tables are renamed through the adapter's modelName mapping.
- **2026-10-28 Deploy installs dev deps:** `pnpm install --prod=false`, because `.env` sets `NODE_ENV=production` and the build needs TypeScript and Tailwind.
- **2026-10-28 Backups via BullMQ scheduler:** the backup job runs from the worker instead of a system cron, so it shows up in the queue dashboard. A cron fallback is documented in DEPLOY.md.
- **2026-10-28 Roles:** Better Auth's default access control is extended with a `guest` role that has no organization permissions. Record-level rules live in @mewe/core (M4).
- **2026-10-28 Email before React Email:** `lib/email.ts` sends simple inline-HTML emails through Resend. When no API key is set, it logs to the console so local development works without an email provider. React Email templates replace these in M12.
- **2026-10-28 OAuth buttons are build-time:** the sign-in and sign-up pages are prerendered, so Google and GitHub buttons appear according to the env present at build time. The deploy hook sources `.env` before building, so this matches production.
- **2026-10-28 Built the public site before M2:** Stripe keys aren't available yet, so the website, catalogue and SEO work (normally M3, M5b and M10) was done first.
- **2026-10-28 Catalogue licence exclusions:** Invoice Ninja (Elastic License v2), Akaunting and Outline (BSL) and n8n (Sustainable Use) were dropped because their licences forbid selling hosted versions. Kanboard (MIT) and Jorani (AGPL-3.0, hosted unmodified with a source link) carry over from the old site.
- **2026-10-28 Legacy URL strategy:** old product ids and demo folders map to new app slugs in @mewe/core (`legacyProductSlug`, `legacyAppDirSlug`) and are served as 301/308 redirects. Old Insights URLs redirect temporarily to the homepage until quality-gated content exists.
- **2026-10-28 Theme:** class-based dark mode via next-themes (default: system), with CSS variables in globals.css.
