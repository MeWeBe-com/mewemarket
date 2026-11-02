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
Until the keys are set, the billing page says online payments are not switched on, and everything else works.
1. In the Stripe dashboard, copy the secret and publishable keys into `.env` (`STRIPE_SECRET_KEY`, `STRIPE_PUBLISHABLE_KEY`).
2. Add a webhook endpoint at `https://mewemarket.com/api/stripe/webhook` for these events: `checkout.session.completed`, `customer.subscription.created`, `customer.subscription.updated`, `customer.subscription.deleted`. Copy its signing secret into `STRIPE_WEBHOOK_SECRET`.
3. Deploy again so the new values are picked up.
4. Test with a Stripe test card (4242 4242 4242 4242) from the workspace's **Plan & billing** page.
