#!/usr/bin/env bash
# Caps everything MeweMarket stores on this server at 150 GB (CAP_GB), as a hard limit.
#
# Where the data lives and how each part is capped:
#   * Docker (all hosted apps, Postgres, Redis, MinIO, their uploads and logs) and the app's releases/backups
#     move into ONE fixed-size file system, /srv/mewemarket (a 150 GB disk image, loop-mounted). Nothing inside
#     can grow past it: when it's full, writes fail there, and the rest of the server is untouched.
#   * Hestia: the site's Hestia user gets a 150 GB disk quota too (covers its web files and Hestia backups).
#   * A daily check warns at 80% and 90% full.
#
# Runs as root. Without --apply it only prints what it would do. Docker is stopped while its data is moved
# (minutes of downtime); take a backup first.
#   bash infra/disk-cap.sh                # show the plan
#   bash infra/disk-cap.sh --apply        # do it
set -euo pipefail
CAP_GB=${CAP_GB:-150}
IMG=${IMG:-/srv/mewemarket.img}
MNT=${MNT:-/srv/mewemarket}
HESTIA_USER=${HESTIA_USER:-saasthemes}
APP_DIR=${APP_DIR:-/var/www/mewemarket}           # where infra/post-receive deploys releases
ALERT_TO=${ALERT_TO:-}                            # optional email for the warnings
APPLY=0; [ "${1:-}" = "--apply" ] && APPLY=1

run() { echo "+ $*"; [ $APPLY = 1 ] && eval "$@" || true; }
say() { echo; echo "== $*"; }

[ $APPLY = 1 ] && [ "$(id -u)" != 0 ] && { echo "Run as root." >&2; exit 1; }
need=$((CAP_GB + 5))
free=$(df -BG --output=avail "$(dirname "$IMG")" | tail -1 | tr -dc 0-9)
echo "Cap: ${CAP_GB} GB in $IMG mounted at $MNT. Free on $(dirname "$IMG"): ${free} GB (needs ${need} GB)."
[ "$free" -lt "$need" ] && [ ! -f "$IMG" ] && { echo "Not enough free disk to reserve ${CAP_GB} GB." >&2; exit 1; }

say "1. Reserve the ${CAP_GB} GB file system (space is allocated up front, so the cap is guaranteed)"
if [ -f "$IMG" ]; then echo "exists: $IMG"; else
  run "fallocate -l ${CAP_GB}G '$IMG'"
  run "chmod 600 '$IMG'"
  run "mkfs.ext4 -q -m 1 -L mewemarket '$IMG'"
fi
run "mkdir -p '$MNT'"
grep -q " $MNT " /etc/fstab || run "echo '$IMG $MNT ext4 loop,defaults,nofail 0 2' >> /etc/fstab"
mountpoint -q "$MNT" || run "mount '$MNT'"

say "2. Move Docker's data inside it (all hosted apps, databases, volumes, logs)"
DATA_ROOT=$(docker info -f '{{.DockerRootDir}}' 2>/dev/null || echo /var/lib/docker)
if [ "$DATA_ROOT" = "$MNT/docker" ]; then echo "Docker already uses $MNT/docker"; else
  run "systemctl stop docker docker.socket"
  run "mkdir -p '$MNT/docker'"
  run "rsync -aHAX --numeric-ids '$DATA_ROOT/' '$MNT/docker/'"
  run "python3 - <<'PY'
import json, os
p = '/etc/docker/daemon.json'
c = json.load(open(p)) if os.path.exists(p) else {}
c['data-root'] = '$MNT/docker'
c.setdefault('log-driver', 'json-file')
c.setdefault('log-opts', {'max-size': '10m', 'max-file': '3'})
os.makedirs('/etc/docker', exist_ok=True); json.dump(c, open(p, 'w'), indent=2)
PY"
  run "systemctl start docker"
  run "mv '$DATA_ROOT' '${DATA_ROOT}.moved-$(date +%Y%m%d)'"   # delete after checking everything runs
fi

say "3. Releases, uploads and backups of the app itself"
if [ -d "$APP_DIR" ] && [ ! -L "$APP_DIR" ]; then
  run "mkdir -p '$MNT/app'"
  run "rsync -a '$APP_DIR/' '$MNT/app/'"
  run "mv '$APP_DIR' '${APP_DIR}.moved-$(date +%Y%m%d)'"
  run "ln -s '$MNT/app' '$APP_DIR'"
fi
run "mkdir -p '$MNT/backups'"

say "4. Hestia: ${CAP_GB} GB disk quota for user $HESTIA_USER"
if command -v v-list-user >/dev/null 2>&1 || [ -x /usr/local/hestia/bin/v-list-user ]; then
  H=/usr/local/hestia/bin
  pkg=mewemarket${CAP_GB}
  if ! $H/v-list-user-package "$pkg" >/dev/null 2>&1; then
    cur=$($H/v-list-user "$HESTIA_USER" json | python3 -c 'import json,sys; print(next(iter(json.load(sys.stdin).values()))["PACKAGE"])')
    tmp=$(mktemp -d)
    run "$H/v-list-user-package '$cur' shell | awk -F': *' '{print \$1\"=\x27\"\$2\"\x27\"}' | sed 's/^PACKAGE=.*//' > '$tmp/$pkg.pkg'"
    run "sed -i \"s/^DISK_QUOTA=.*/DISK_QUOTA='$((CAP_GB * 1024))'/\" '$tmp/$pkg.pkg'"
    run "$H/v-add-user-package '$tmp' '$pkg'"
  fi
  run "$H/v-change-user-package '$HESTIA_USER' '$pkg'"
  grep -q "^DISK_QUOTA='yes'" /usr/local/hestia/conf/hestia.conf || echo "Note: Hestia disk quotas are off (DISK_QUOTA in hestia.conf); turn them on with v-add-sys-quota for this to be enforced."
else
  echo "Hestia not found: skipping its quota."
fi

say "5. Daily warning at 80% and 90%"
run "cat > /etc/cron.daily/mewemarket-disk <<'CRON'
#!/bin/sh
use=\$(df --output=pcent '$MNT' | tail -1 | tr -dc 0-9)
[ \"\$use\" -ge 80 ] || exit 0
msg=\"MeweMarket storage is \${use}% full (cap ${CAP_GB} GB at $MNT).\"
logger -t mewemarket-disk \"\$msg\"
[ -n '$ALERT_TO' ] && command -v mail >/dev/null && echo \"\$msg\" | mail -s \"MeweMarket storage \${use}%\" '$ALERT_TO'
exit 0
CRON"
run "chmod +x /etc/cron.daily/mewemarket-disk"

echo; [ $APPLY = 1 ] && df -h "$MNT" || echo "Nothing changed (dry run). Re-run with --apply."
