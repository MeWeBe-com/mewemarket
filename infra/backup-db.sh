#!/bin/bash
# Nightly MeweMarket database dump (custom format, restore with pg_restore); keeps 14 days.
# Installed at ~/web/mewemarket.com/private/backup-db.sh by the deploy workflow's "backup-install" task.
#
# The connection string is never passed on a command line (where ps would show it): it is read from
# app/.env here, the non-secret parts go into PG* environment variables and the password into a 0600
# PGPASSFILE that is removed on exit.
set -eo pipefail
umask 077
cd ~/web/mewemarket.com/private

PGPASSFILE=$(mktemp "${TMPDIR:-/tmp}/mewe-pgpass.XXXXXX")
export PGPASSFILE
trap 'rm -f "$PGPASSFILE"' EXIT

# python3 reads .env itself and writes the password file; only the non-secret settings come back.
eval "$(python3 - app/.env "$PGPASSFILE" <<'PY'
import shlex, sys
from urllib.parse import urlsplit, unquote
env_file, passfile = sys.argv[1], sys.argv[2]
url = None
for line in open(env_file):
    line = line.strip()
    if line.startswith("export "): line = line[7:].lstrip()
    if line.startswith("DATABASE_URL="):
        url = line.split("=", 1)[1].strip().strip('"').strip("'")
if not url: sys.exit("DATABASE_URL is not set in " + env_file)
u = urlsplit(url)
host, port = u.hostname or "127.0.0.1", str(u.port or 5432)
db, user, pw = unquote(u.path.lstrip("/")), unquote(u.username or ""), unquote(u.password or "")
esc = lambda s: s.replace("\\", "\\\\").replace(":", "\\:")
with open(passfile, "w") as f:
    f.write(":".join(esc(x) for x in (host, port, db, user, pw)) + "\n")
for k, v in (("PGHOST", host), ("PGPORT", port), ("PGDATABASE", db), ("PGUSER", user)):
    print(f"export {k}={shlex.quote(v)}")
PY
)"

out=backups/db-$(date +%Y-%m-%d_%H%M).dump
start=$(date +%s)
if ! pg_dump --format=custom --no-owner --no-password > "$out.tmp"; then rm -f "$out.tmp"; echo "$(date '+%F %T') pg_dump FAILED"; exit 1; fi
mv "$out.tmp" "$out"
chmod 600 "$out"
find backups -name "db-*.dump" -mtime +14 -delete
echo "$(date '+%F %T') $out $(stat -c %s "$out") bytes in $(( $(date +%s) - start ))s"
