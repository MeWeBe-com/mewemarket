# Deploying MeweMarket

Production runs on one Ubuntu 24.04 server:
- **Caddy** handles TLS and the reverse proxy.
- **PM2** runs the `web` and `worker` processes.
- **Docker Compose** runs Postgres (with pgvector), Redis, MinIO and Umami. These are bound to localhost only.

## One-time server setup
1. Copy `infra/server-setup.sh` to the server and run it as root:
   ```bash
   DOMAIN=mewemarket.com bash server-setup.sh
   ```
2. Fill in `/srv/mewemarket/shared/.env`, using `.env.example` for the variable names. Generate the secrets with `openssl rand -base64 32`.
3. Install the deploy hook:
   ```bash
   cp infra/post-receive /srv/git/mewemarket.git/hooks/post-receive
   chmod +x /srv/git/mewemarket.git/hooks/post-receive
   chown deploy: /srv/git/mewemarket.git/hooks/post-receive
   ```
4. Install the Caddy config:
   ```bash
   cp infra/Caddyfile /etc/caddy/Caddyfile && systemctl reload caddy
   ```
5. Point the DNS `A`/`AAAA` records for `mewemarket.com` and `www.mewemarket.com` at the server.

## Deploy
Add the server as a git remote once:
```bash
git remote add production deploy@<server-ip>:/srv/git/mewemarket.git
```

Then deploy with:
```bash
git push production main
```
The hook deploys the server's `main` branch. While the new platform lives on the GitHub branch `updated`, push that branch to the server's `main`:
```bash
git push production updated:main
```

The hook then:
1. checks out a new release in `/srv/mewemarket/releases/<timestamp>`;
2. starts the Docker services;
3. installs dependencies, runs migrations and builds;
4. switches the `current` symlink;
5. runs `pm2 reload`;
6. checks `/api/health`.

If the health check fails, the hook rolls back to the previous release automatically. It keeps the last 5 releases.

## Operate
| Task | Command (as `deploy`) |
|---|---|
| Logs | `pm2 logs web` / `pm2 logs worker` |
| Status | `pm2 status`, `curl localhost:3000/api/health` |
| Manual rollback | `ln -sfn /srv/mewemarket/releases/<older> /srv/mewemarket/current && cd /srv/mewemarket/current && pm2 reload ecosystem.config.cjs` |
| Backup now | `bash /srv/mewemarket/current/infra/backup.sh` |
| Restore DB | `docker compose exec -T postgres pg_restore -U mewe -d mewemarket --clean < /srv/mewemarket/backups/db-<stamp>.dump` |
| DB shell | `docker compose exec postgres psql -U mewe mewemarket` |

The worker runs the backups every night at 02:30 as a BullMQ scheduled job. If you'd rather use cron, add this to the `deploy` user's crontab:
```cron
30 2 * * * bash /srv/mewemarket/current/infra/backup.sh
```
For off-site copies, set `RCLONE_REMOTE` in `.env`.

## Video meetings
The meeting tool connects browsers directly over WebRTC; the server only relays the setup messages through `/api/meet/`.
- The Caddyfile streams `/api/meet/*` without buffering and allows camera, microphone and screen sharing. Keep both if you edit it.
- A few strict office or hotel networks block direct connections. If people report "Couldn't connect", run a TURN relay (for example coturn on this server) and set `NEXT_PUBLIC_TURN_URL`, `NEXT_PUBLIC_TURN_USER` and `NEXT_PUBLIC_TURN_PASS` in `.env`, then deploy again (they are baked in at build time).

## Turning on Stripe payments
Until the keys are set, the billing page says online payments are not switched on, and everything else works. Prices are created at checkout from `packages/core/src/plans.ts`, so no products or prices need to exist in Stripe.
1. Copy the **secret key** into `.env` as `STRIPE_SECRET_KEY` (`sk_test_…` in the sandbox, `sk_live_…` for real payments). The publishable key isn't used.
2. **Developers → Webhooks → Add endpoint**: URL `https://mewemarket.com/api/stripe/webhook`, events `checkout.session.completed`, `customer.subscription.created`, `customer.subscription.updated`, `customer.subscription.deleted`. Copy its signing secret (`whsec_…`) into `STRIPE_WEBHOOK_SECRET`.
3. **Settings → Billing → Customer portal**: activate it (allow cancelling and updating the payment method). "Manage billing" opens this portal.
4. Restart the app so the new values are read, then test from a workspace's **Plan & billing** page with the test card 4242 4242 4242 4242.

## Email
Mail is sent over SMTP: set `SMTP_HOST`, `SMTP_PORT` (587 for STARTTLS, 465 for TLS), `SMTP_USER`, `SMTP_PASS` and `EMAIL_FROM` (the sender should be the SMTP mailbox or a domain it may send for). Without `SMTP_HOST`, mail is only written to the app log.

## Insights articles
The separate mewebe-seo pipeline publishes the insights articles (plus `sitemap.xml`, `feed.json`, `widget.js`, `llms-full.txt` and the search-engine verification files) into a folder every day. Set `INSIGHTS_DIR` to that folder and the app serves it read-only at `/insights/`, with the verification files and `llms-full.txt` also at the site root. On the Hestia server this is `/home/saasthemes/web/mewemarket.com/public_html/insights`.

## AI Assistant
The AI Assistant app is free to add. Each workspace uses its own Claude or OpenAI API key, which an owner or admin enters on the assistant's page, so AI usage is billed to that workspace's provider account, not to MeweMarket.
- Saved keys are encrypted with `ENCRYPTION_KEY`. Set it once and keep it: if it changes, saved keys can't be read and workspaces must enter them again.
- The server must be able to reach `api.anthropic.com` and `api.openai.com`.
- The assistant can only read records in apps the workspace has installed. It can't create, change or delete anything.
