#!/usr/bin/env bash
# Nightly backup: Postgres dump + MinIO data mirror, 14-day retention.
# Optional off-site copy: set RCLONE_REMOTE (e.g. "b2:mewemarket-backups").
set -euo pipefail
APP_ROOT=/srv/mewemarket
DEST="$APP_ROOT/backups"
STAMP=$(date +%Y%m%d-%H%M%S)
RETAIN_DAYS=${RETAIN_DAYS:-14}

cd "$APP_ROOT/current"
set -a; . ./.env; set +a

mkdir -p "$DEST"
docker compose exec -T postgres pg_dump -U mewe -Fc mewemarket > "$DEST/db-$STAMP.dump"
docker compose exec -T minio sh -c 'tar -C /data -cf - .' | gzip > "$DEST/files-$STAMP.tar.gz"

find "$DEST" -type f -mtime +"$RETAIN_DAYS" -delete

if [ -n "${RCLONE_REMOTE:-}" ] && command -v rclone >/dev/null; then
  rclone copy "$DEST" "$RCLONE_REMOTE" --max-age 25h
fi
echo "Backup $STAMP complete"
