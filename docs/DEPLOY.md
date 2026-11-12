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

## Hosted apps (CRM, Invoices, Projects, Helpdesk, E-Signatures, Bookings, AI Chat)

Four apps are full open-source products, run as their own services and shown full-size inside the workspace at `mewemarket.com/{company}/{app}`:

| App | Product (licence) | Public host | Containers | Idle RAM |
|---|---|---|---|---|
| CRM | [Twenty](https://github.com/twentyhq/twenty) (AGPL-3.0) | `{company}.crm.mewemarket.com` | `twenty`, `twenty-worker` | ~1 GB |
| Invoices | [InvoiceShelf](https://github.com/InvoiceShelf/InvoiceShelf) (AGPL-3.0) | `invoices.mewemarket.com` | `invoiceshelf` | ~0.2 GB |
| Projects | [Plane](https://github.com/makeplane/plane) Community (AGPL-3.0) | `plane.mewemarket.com` | `plane-*` (8) | ~1.2 GB |
| Helpdesk | [Chatwoot](https://github.com/chatwoot/chatwoot) community image (MIT) | `chat.mewemarket.com` | `chatwoot`, `chatwoot-worker` | ~1 GB |
| E-Signatures | [Documenso](https://github.com/documenso/documenso) (AGPL-3.0, billing off) | `sign.mewemarket.com` | `documenso` | ~0.3 GB |
| AI Chat | [Open WebUI](https://github.com/open-webui/open-webui) (Open WebUI License: BSD-3 plus branding clause) | `ai.mewemarket.com` | `openwebui` | ~0.35 GB |
| Bookings | [Easy!Appointments](https://github.com/alextselegidis/easyappointments) (GPL-3.0) | `book.mewemarket.com/{company}/` (shown at `mewemarket.com/{company}/book`) | `easyappointments`, `easyappointments-db` | ~0.15 GB |

How it works (code: `packages/core/src/hosted/`): adding the app creates the company's own space in the product (a Twenty workspace, an InvoiceShelf company, a Plane workspace, a Chatwoot account, a Documenso organisation). The first time someone opens it, MeweMarket gives them their own account in that space (owners and admins as admins, members as members, guests not at all) with a random password stored encrypted, and signs them in with no second login: a one-time link for Twenty and Chatwoot, and for InvoiceShelf and Plane a server-side sign-in whose session cookie reaches the browser through `/api/hosted-sso`, a MeweMarket route the proxy serves on the product's host (so the cookie is set there and nowhere else). Role changes follow; removing someone, or them leaving, removes them and ends their open session in the product. Removing the app keeps its data unless "also delete all data" is ticked; deleting a workspace deletes its data in every product. An app appears in the App Store only once its settings are in `.env`.

One-time setup:

1. **DNS and certificates**: `crm.mewemarket.com` plus wildcard `*.crm.mewemarket.com`, and `invoices.`, `plane.`, `chat.`, `sign.`, `book.`, `ai.mewemarket.com`, all to the server. With Cloudflare's proxy on, the free certificate covers one level only, so either turn the proxy off (grey cloud) for `crm` and `*.crm` or add an Advanced Certificate for `*.crm.mewemarket.com`; the other three are covered. Let's Encrypt needs the DNS challenge for the wildcard.
2. **Databases**: `CREATE DATABASE twenty OWNER mewe; CREATE DATABASE invoiceshelf OWNER mewe; CREATE DATABASE chatwoot OWNER mewe; CREATE DATABASE plane OWNER mewe; CREATE DATABASE documenso OWNER mewe; CREATE DATABASE openwebui OWNER mewe;` (new installs get them from `infra/postgres/init.sql`). Chatwoot needs the `vector` extension, which the `pgvector/pgvector` Postgres image has.
3. **.env**: fill in the `TWENTY_*`, `INVOICESHELF_*`, `CHATWOOT_*`, `PLANE_*`, `DOCUMENSO_*`, `EA_*`, `OPENWEBUI_*` and `AI_GATEWAY_KEY` blocks from `.env.example`. The secrets (`TWENTY_APP_SECRET`, `INVOICESHELF_APP_KEY`, `CHATWOOT_SECRET_KEY_BASE`, `PLANE_SECRET_KEY`) must **never change** once set. Twenty's platform account must be Twenty's first user, so start Twenty on an empty `twenty` database.
   Documenso also needs its **signing certificate** at `infra/documenso/cert.p12` (git-ignored) with its passphrase in `DOCUMENSO_SIGNING_PASSPHRASE`. Use a certificate from a CA that PDF readers trust (a document-signing certificate); a self-signed one works for testing but readers show the signature as untrusted. Test one: `openssl req -x509 -newkey rsa:2048 -nodes -keyout k.pem -out c.pem -days 365 -subj "/CN=MeweMarket"` then `openssl pkcs12 -export -inkey k.pem -in c.pem -out infra/documenso/cert.p12 -certpbe AES-256-CBC -keypbe AES-256-CBC -macalg sha256`.
4. **Start them**: `docker compose up -d twenty twenty-worker invoiceshelf chatwoot chatwoot-worker plane-migrator plane-api plane-worker plane-beat plane-web plane-admin plane-space plane-live documenso easyappointments-db easyappointments openwebui`. First starts take a few minutes while they set up their databases.
5. **Platform accounts**: `bash infra/hosted-setup.sh` (InvoiceShelf owner, Chatwoot super admin, Plane instance admin with public sign-up off, Documenso instance admin plus the read-only `documenso_reader` database role, Open WebUI's only admin). It prints `CHATWOOT_PLATFORM_TOKEN`: add it to `.env`. Safe to run again.
6. **Proxy**: Hestia: copy `infra/hestia/mewemarket-maps.conf` to `/etc/nginx/conf.d/` (it rewrites Documenso's frame permission without touching the rest of its security policy); for each host add the web domain (`crm.mewemarket.com` with alias `*.crm.mewemarket.com`, then `invoices.`, `plane.`, `chat.`, `sign.`), copy `infra/hestia/mewemarket-{crm,invoices,projects,helpdesk,e-signatures,bookings,ai-chat}.tpl` and `.stpl` to `/usr/local/hestia/data/templates/web/nginx/`, and apply each with `v-change-web-domain-proxy-tpl saasthemes <host> mewemarket-<app>`. Caddy: the matching blocks in `infra/Caddyfile`. Twenty sets its own frame permission per workspace (to `APP_URL`); for the other three the proxy replaces their frame header with one allowing `https://mewemarket.com`, and Plane's proxy refuses public `POST /api/workspaces/` so only MeweMarket creates workspaces.
   Bookings runs on its own origin, `book.mewemarket.com` (template `mewemarket-bookings`), never on the main site: its pages must not share an origin with MeweMarket's session. Customers still use `mewemarket.com/{company}/book`, a MeweMarket page that shows it in a frame. Set the proxy's shared secret: `EA_PROXY_KEY` in `.env` and the same value in `mewemarket-maps.conf` (Hestia) or the environment (Caddy).
7. **Container firewall**: `ALLOW_HOST_PORTS="587" bash infra/egress-firewall.sh --install` (leave out ALLOW_HOST_PORTS unless the containers send mail through this server's own SMTP). The hosted apps can then reach each other and the internet, but not this server or any private or cloud-metadata address, so a webhook or URL feature in any product can't be turned against our own services.
8. **Restart the app** (`pm2 reload ecosystem.config.cjs`).

Things to know:

- **CRM hardening**: company owners and admins get a restricted Twenty role ("Company admin": records, fields, views, imports and exports, but no roles, members, security, API keys, webhooks or workflows), so they can't lock MeweMarket out or add people behind its back. Twenty's public invite link stays off except for the moment MeweMarket adds someone, and anyone in a company's CRM that MeweMarket doesn't know about is removed (checked whenever someone opens it, at most every 10 minutes). Each person can add the CRM to at most 2 companies. Deleted CRM data is purged by Twenty 21 days after deletion.
- **Twenty allows 5 companies** without an Enterprise key; the 6th sees "The CRM service is full right now" while everyone else carries on. Buy a key, set `TWENTY_ENTERPRISE_KEY`, `docker compose up -d twenty twenty-worker`. The other three have no company limit.
- **AI Chat specifics**: Open WebUI has one AI connection, MeweMarket's AI gateway (`/api/ai-gateway/v1`, OpenAI-compatible), with the shared secret `AI_GATEWAY_KEY`. Open WebUI's server tells the gateway who is asking; the gateway uses that person's company's own Claude or OpenAI key (saved encrypted in MeweMarket from the app's "AI key" page, shared with the AI Assistant), so no company key is ever stored in Open WebUI. Limits: the plan's monthly AI messages per company (`aiCreditsMonthly`) and 20 messages a minute per person. Open WebUI must reach `APP_URL` over the internet (the container firewall doesn't block public addresses). Code execution, local model downloads, web search, image generation, direct connections and community sharing are switched off; uploaded documents go to the model as text (no embeddings). Each company is two Open WebUI groups (everyone, admins); its user-directory endpoints are blocked at the proxy because they would list people from every company. **Licence**: free to host and charge for; with more than 50 users in 30 days the "Open WebUI" name and logo must stay visible (don't rebrand it) unless you buy their enterprise licence.
- **Documenso specifics**: Documenso has no API to create a user with a password, so MeweMarket reads new users' password-reset tokens through `DOCUMENSO_DATABASE_URL`, a role that can read only the `PasswordResetToken` table. It needs working SMTP: signing requests, reminders and completion emails go to the real outside signers. Admin-created users also get a welcome email at their generated address, which bounces; that is harmless. Its unlimited self-hosted mode comes from code in Documenso's commercial `packages/ee` folder that ships in the standard image with billing off; this needs a legal check (see docs/DECISIONS.md).
- **Bookings specifics**: Easy!Appointments is single-company software; `infra/easyappointments/config.php` (mounted as its config) picks the company from the path on `book.mewemarket.com` via the proxy's `X-Ea-Tenant` header, which it trusts only with `EA_PROXY_KEY` (or MeweMarket's `EA_PLATFORM_KEY`), gives each company its own database (`ea_t_{company}`), sessions and cookie path, and lets only MeweMarket run the installer. `start.sh` points the app's config at it. Its container port must stay private. **On every upgrade, check these two files still fit** the new version. Customers book at `mewemarket.com/{company}/book/` once the company has added a service and a bookable staff member (members are staff; owners and admins are administrators, who aren't bookable). Booking emails use one shared SMTP account.
- **Paid features not included**: Chatwoot's enterprise features (AI copilot, SLAs, custom roles, audit logs, SSO) and Plane's commercial features are not in these images.
- **Email**: Chatwoot uses the `SMTP_*` settings for notifications. People's product accounts use generated addresses (`u-…@accounts.mewemarket.com`), so the products never mail customers' real addresses.
- **Files**: Plane stores uploads in MinIO (bucket `plane-uploads`); InvoiceShelf and Chatwoot in their volumes (`invoiceshelfdata`, `chatwootdata`), Twenty in `twentydata`; Documenso keeps documents in its database. Back these up with the databases.
- **Upgrades**: images are pinned to the versions this was tested with (Twenty v2.57.1, InvoiceShelf 2.4.7, Plane v1.4.3, Chatwoot v4.19.1-ce, Documenso v2.21.1, Easy!Appointments 1.6.1, Open WebUI v0.13.3). Read each project's upgrade notes, back up its database, change the tag, `docker compose up -d <services>`; they migrate themselves on start (Plane through `plane-migrator`).
- **Source offer (AGPL)**: the app toolbar and the public app pages link to each product's source. If you modify a product, publish your changes and link to them instead.
- **If a sync fails** (product down when someone is removed), it is logged; MeweMarket stops signing them in at once, but an already-open product session can last until it expires. See the open item in `docs/PLAN.md`.

## Limits and the 150 GB storage cap

- **Storage: 150 GB, hard.** `bash infra/disk-cap.sh` (dry run) then `bash infra/disk-cap.sh --apply` as root. It reserves a 150 GB file system at `/srv/mewemarket` (a disk image), moves Docker's data (every hosted app, Postgres, Redis, MinIO, uploads, logs) and the app's releases and backups into it, gives the site's Hestia user a 150 GB quota for its web files, and installs a daily warning at 80% and 90%. When it's full, writes inside it fail and the rest of the server is unaffected. Change the size with `CAP_GB=…`. Docker is stopped while its data moves, so do it in a quiet hour after a backup. Hestia's quota only applies if Hestia disk quotas are on (`v-add-sys-quota`).
- **Per service**: every container has memory, CPU and process caps and rotating logs (`docker-compose.yml`), so one product, or one company abusing it, can't starve the server. MeweMarket itself restarts above 1 GB under PM2.
- **Per visitor** (`infra/hestia/mewemarket-maps.conf`, needed by every template): 30 requests/s with bursts of 300 and 60 connections on the hosted apps; 10 POSTs/minute to their sign-in endpoints (nobody signs in to them directly); 10 requests/s on public booking pages. Over the limit answers 429. Behind Cloudflare the visitor is taken from `CF-Connecting-IP`, so only accept web traffic from Cloudflare's addresses.
- **Sending**: e-signature recipient changes and sends, and public booking submissions, at most 20 a minute per visitor (`mewe_send`). Chatwoot's own per-IP throttling (Rack::Attack, 600 requests a minute) covers its public chat widget too. Also set sending limits at your SMTP provider: E-Signatures and Helpdesk send mail to outside addresses.
- **Opening apps**: at most 20 product sign-ins per person per minute.
- **Invoice PDFs** are served with a no-scripts security policy (their HTML preview echoes user text).
- **Uploads**: 50 MB per request on Invoices, Helpdesk and E-Signatures, 10 MB on Projects, 20 MB on Bookings (nginx `client_max_body_size`).
- **People per company** in every hosted app follow the company's MeweMarket members, so the plan's seat limit applies.
