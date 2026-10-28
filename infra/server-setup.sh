#!/usr/bin/env bash
# One-time, idempotent bootstrap for a fresh Ubuntu 24.04 server.
# Usage (as root): DOMAIN=mewemarket.com bash server-setup.sh
set -euo pipefail

DOMAIN="${DOMAIN:-mewemarket.com}"
APP_USER=deploy
APP_ROOT=/srv/mewemarket
GIT_ROOT=/srv/git/mewemarket.git

echo "==> Base packages"
apt-get update -y
apt-get install -y curl git ufw fail2ban unattended-upgrades ca-certificates gnupg debian-keyring debian-archive-keyring apt-transport-https
dpkg-reconfigure -f noninteractive unattended-upgrades

echo "==> Firewall"
ufw allow OpenSSH
ufw allow 80/tcp
ufw allow 443/tcp
ufw --force enable
systemctl enable --now fail2ban

echo "==> Deploy user"
id "$APP_USER" >/dev/null 2>&1 || adduser --disabled-password --gecos "" "$APP_USER"
mkdir -p /home/$APP_USER/.ssh
[ -f /root/.ssh/authorized_keys ] && cp -n /root/.ssh/authorized_keys /home/$APP_USER/.ssh/ || true
chown -R $APP_USER:$APP_USER /home/$APP_USER/.ssh
chmod 700 /home/$APP_USER/.ssh

echo "==> Node 22 + pnpm + PM2"
if ! command -v node >/dev/null || [[ "$(node -v)" != v22* ]]; then
  curl -fsSL https://deb.nodesource.com/setup_22.x | bash -
  apt-get install -y nodejs
fi
corepack enable
npm install -g pm2
sudo -u $APP_USER bash -lc 'pm2 ping >/dev/null'
env PATH=$PATH:/usr/bin pm2 startup systemd -u $APP_USER --hp /home/$APP_USER >/dev/null

echo "==> Docker"
if ! command -v docker >/dev/null; then
  curl -fsSL https://get.docker.com | sh
fi
usermod -aG docker $APP_USER

echo "==> Caddy"
if ! command -v caddy >/dev/null; then
  curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg
  curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' > /etc/apt/sources.list.d/caddy-stable.list
  apt-get update -y && apt-get install -y caddy
fi

echo "==> Directories and bare repo"
mkdir -p $APP_ROOT/{releases,shared/uploads,backups} /srv/git
[ -d "$GIT_ROOT" ] || git init --bare -b main "$GIT_ROOT"
[ -f $APP_ROOT/shared/.env ] || { echo "# fill from .env.example" > $APP_ROOT/shared/.env; chmod 600 $APP_ROOT/shared/.env; }
chown -R $APP_USER:$APP_USER $APP_ROOT /srv/git

echo
echo "Done. Next steps:"
echo "  1. Fill $APP_ROOT/shared/.env (see .env.example)"
echo "  2. Install the deploy hook: copy infra/post-receive to $GIT_ROOT/hooks/post-receive and chmod +x it"
echo "  3. Install Caddy config: copy infra/Caddyfile to /etc/caddy/Caddyfile && systemctl reload caddy"
echo "  4. Point DNS A/AAAA for $DOMAIN and www.$DOMAIN to this server"
echo "  5. Locally: git remote add production $APP_USER@<server-ip>:$GIT_ROOT && git push production main"
