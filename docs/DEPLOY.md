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

## Hosted CRM (Twenty)

The **CRM** app is [Twenty](https://github.com/twentyhq/twenty) (AGPL-3.0), run as its own service and shown inside the workspace at `mewemarket.com/{company}/crm`. Each company gets its own Twenty workspace at `{company}.crm.mewemarket.com`; MeweMarket creates it when the app is added, adds each person the first time they open it (owners and admins as Twenty Admins, members as Members, guests not at all), and signs them in with a one-time link, so nobody logs in twice. Removing someone from a workspace removes them from its CRM and ends their open CRM session. Code: `packages/core/src/hosted/`.

One-time setup:

1. **DNS**: an `A` record for `crm.mewemarket.com` and a wildcard `*.crm.mewemarket.com`, both to the server. With Cloudflare's proxy on, the free certificate only covers one level (`*.mewemarket.com`), so either turn the proxy off (grey cloud) for these two records or add an Advanced Certificate for `*.crm.mewemarket.com`.
2. **Certificate**: a wildcard certificate for `crm.mewemarket.com` and `*.crm.mewemarket.com` (Let's Encrypt needs the DNS challenge for wildcards).
3. **Database**: `CREATE DATABASE twenty OWNER mewe;` (new installs get it from `infra/postgres/init.sql`).
4. **.env**: set `TWENTY_URL`, `TWENTY_INTERNAL_URL`, `TWENTY_APP_SECRET` (`openssl rand -hex 32`, **never change it afterwards**: it encrypts Twenty's signing keys) and `TWENTY_PLATFORM_EMAIL` / `TWENTY_PLATFORM_PASSWORD` (MeweMarket's own admin account inside Twenty; it is created on first use and must be Twenty's first user, so start from an empty `twenty` database).
5. **Start it**: `docker compose up -d twenty twenty-worker`. The first start sets up its database and takes a few minutes; `curl -s 127.0.0.1:3200/healthz` answers when it's ready.
6. **Proxy**: Hestia: add the web domain `crm.mewemarket.com` with the alias `*.crm.mewemarket.com`, copy `infra/hestia/mewemarket-crm.tpl` and `.stpl` to `/usr/local/hestia/data/templates/web/nginx/`, then `v-change-web-domain-proxy-tpl saasthemes crm.mewemarket.com mewemarket-crm`. Caddy: the `crm.mewemarket.com, *.crm.mewemarket.com` block in `infra/Caddyfile`.
7. **Restart the app** (`pm2 reload ecosystem.config.cjs`). The CRM appears in the App Store only once `TWENTY_URL` and the platform account are set.

Things to know:

- **5 companies on the free version.** Twenty allows 5 workspaces per server without an Enterprise key. The 6th company that adds the CRM sees "The CRM service is full right now"; nothing breaks for the others. To lift it, buy a key from Twenty, set `TWENTY_ENTERPRISE_KEY` in `.env` and `docker compose up -d twenty twenty-worker`.
- **Embedding** is Twenty's own per-workspace setting (`allowedEmbeddingOrigins`), set to `APP_URL` when each CRM is created; the proxy passes Twenty's headers through untouched. If `APP_URL` ever changes, existing CRMs need the new address added.
- **Removing the CRM** from a workspace keeps its data (adding it back restores it) unless "also delete all data" is ticked, which deletes the company's Twenty workspace. Deleting a MeweMarket workspace deletes its CRM too.
- **Upgrades**: the image is pinned (`twentycrm/twenty:v2.57.1`, the version this was tested with). Read Twenty's upgrade notes, back up the `twenty` database, change both image tags, and `docker compose up -d twenty twenty-worker`; it migrates itself on start.
- **Backups**: the `twenty` database (same Postgres) and the `twentydata` volume (uploaded files).
- **Source offer (AGPL)**: the CRM toolbar and the public app page link to Twenty's source. If you ever modify Twenty, publish your changes and link to them instead.
