#!/usr/bin/env python3
"""Rotate the MeweMarket Postgres password (run from the app folder by the deploy workflow).

1. Back up every .env under the app folder that holds DATABASE_URL (0700 folder next to the app).
2. ALTER ROLE current_user with a new random password. SQL goes to psql on stdin and the old password
   through a 0600 PGPASSFILE, so nothing secret is on a command line or in the output.
3. Write the new URL into those .env files (same mode), check the new password connects,
   reload PM2 and check health. Any failure puts the old password and files back.
"""
import os, re, secrets, shutil, subprocess, sys, tempfile, time, urllib.request
from urllib.parse import quote, unquote, urlsplit

app = os.getcwd()
root_env = os.path.join(app, ".env")

def read_url(path):
    for line in open(path):
        m = re.match(r'^\s*(?:export\s+)?DATABASE_URL\s*=\s*(.*)$', line.rstrip("\n"))
        if m:
            return m.group(1).strip().strip('"').strip("'")
    return None

old_url = read_url(root_env)
if not old_url:
    sys.exit("DATABASE_URL not found in .env")
u = urlsplit(old_url)
user, old_pw = unquote(u.username or ""), unquote(u.password or "")
host, port, db = u.hostname or "127.0.0.1", str(u.port or 5432), u.path.lstrip("/")

# .env files that contain this exact URL (skips folders the deploy never owns)
targets = []
for d, dirs, files in os.walk(app):
    dirs[:] = [x for x in dirs if x not in ("node_modules", ".next", ".deploy-previous", ".git", ".turbo")]
    for f in files:
        if f == ".env" or (f.startswith(".env.") and f not in (".env.example",) and not f.startswith(".env.bak")):
            p = os.path.join(d, f)
            try:
                if old_url in open(p).read():
                    targets.append(p)
            except PermissionError:
                pass
print(f"files to update: {len(targets)} ({', '.join(os.path.relpath(t, app) for t in targets)})")

backup = os.path.join(os.path.dirname(app), "env-backups", time.strftime("%Y%m%d-%H%M%S"))
os.makedirs(backup, mode=0o700)
os.chmod(os.path.dirname(backup), 0o700)
for t in targets:
    dst = os.path.join(backup, os.path.relpath(t, app).replace("/", "__"))
    shutil.copy2(t, dst); os.chmod(dst, 0o600)
print(f"backed up to {os.path.relpath(backup, os.path.dirname(app))}/")

def psql(password, sql):
    esc = lambda s: s.replace("\\", "\\\\").replace(":", "\\:")
    fd, pf = tempfile.mkstemp(prefix="mewe-pgpass.")
    try:
        os.write(fd, (":".join(esc(x) for x in (host, port, db, user, password)) + "\n").encode()); os.close(fd)
        env = dict(os.environ, PGHOST=host, PGPORT=port, PGDATABASE=db, PGUSER=user, PGPASSFILE=pf)
        env.pop("PGPASSWORD", None)
        r = subprocess.run(["psql", "-X", "-q", "-v", "ON_ERROR_STOP=1", "-tA", "--no-password"], input=sql, env=env, capture_output=True, text=True)
        return r.returncode == 0, (r.stdout + r.stderr).strip()
    finally:
        os.path.exists(pf) and os.unlink(pf)

def set_pw(current, new):
    lit = new.replace("'", "''")
    return psql(current, f"ALTER ROLE CURRENT_USER PASSWORD '{lit}';\n")

def write_all(new_url):
    for t in targets:
        st = os.stat(t)
        s = open(t).read().replace(old_url, new_url)
        fd, tmp = tempfile.mkstemp(dir=os.path.dirname(t)); os.write(fd, s.encode()); os.close(fd)
        os.chmod(tmp, st.st_mode & 0o777); os.replace(tmp, t)

def restore():
    for t in targets:
        src = os.path.join(backup, os.path.relpath(t, app).replace("/", "__"))
        shutil.copy2(src, t)

def reload_and_health():
    subprocess.run(["pm2", "startOrReload", "ecosystem.config.cjs", "--update-env"], capture_output=True)
    port_ = os.environ.get("WEB_PORT", "3000")
    for _ in range(40):
        try:
            body = urllib.request.urlopen(f"http://127.0.0.1:{port_}/api/health", timeout=5).read().decode()
            if '"db":"ok"' in body:
                return True
        except Exception:
            pass
        time.sleep(3)
    return False

ok, out = psql(old_pw, "select 1;")
if not ok:
    sys.exit("current password does not connect; nothing changed")

new_pw = secrets.token_urlsafe(32)
new_url = old_url.replace(f":{quote(old_pw, safe='')}@", f":{quote(new_pw, safe='')}@", 1) if f":{quote(old_pw, safe='')}@" in old_url \
    else old_url.replace(f":{u.password}@", f":{quote(new_pw, safe='')}@", 1)
assert new_url != old_url, "could not place the new password in the URL"

ok, out = set_pw(old_pw, new_pw)
if not ok:
    sys.exit("ALTER ROLE failed; nothing changed")
print("password changed in Postgres")
try:
    write_all(new_url)
    ok, _ = psql(new_pw, "select 1;")
    if not ok:
        raise RuntimeError("new password does not connect")
    print(".env updated; new password connects")
    if not reload_and_health():
        raise RuntimeError("app not healthy after reload")
    print("app reloaded and healthy on the new password")
    ok, _ = psql(old_pw, "select 1;")
    print("old password rejected" if not ok else "WARNING: old password still connects")
except Exception as e:
    print(f"!! {e}: rolling back")
    set_pw(new_pw, old_pw); restore(); reload_and_health()
    print("!! rolled back to the old password")
    sys.exit(1)
