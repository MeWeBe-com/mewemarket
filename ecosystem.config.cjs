// PM2 keeps the environment a process was first started with, so .env is read here and passed in on
// every start/reload: editing .env and redeploying is enough for a change to apply.
const fs = require("node:fs");
const path = require("node:path");

function readEnv(file) {
  const env = {};
  if (!fs.existsSync(file)) return env;
  for (const raw of fs.readFileSync(file, "utf8").split(/\r?\n/)) {
    const m = raw.match(/^\s*(?:export\s+)?([A-Za-z_][A-Za-z0-9_]*)\s*=\s*(.*)$/);
    if (!m) continue;
    let v = m[2].trim();
    if ((v.startsWith('"') && v.endsWith('"')) || (v.startsWith("'") && v.endsWith("'"))) v = v.slice(1, -1);
    else v = v.replace(/\s+#.*$/, "");
    env[m[1]] = v;
  }
  return env;
}

const fileEnv = readEnv(path.join(__dirname, ".env"));
const port = process.env.WEB_PORT || fileEnv.WEB_PORT || process.env.PORT || fileEnv.PORT || 3000;

module.exports = {
  apps: [
    {
      name: "web",
      cwd: "./apps/web",
      script: "node_modules/next/dist/bin/next",
      // WEB_PORT (or PORT) must match the port nginx proxies the site to.
      args: `start -p ${port}`,
      exec_mode: "cluster",
      instances: 2,
      env: { ...fileEnv, NODE_ENV: "production" },
      max_memory_restart: "1G",
    },
    {
      name: "worker",
      cwd: "./apps/worker",
      script: "dist/index.js",
      exec_mode: "fork",
      instances: 1,
      env: { ...fileEnv, NODE_ENV: "production" },
      kill_timeout: 30000,
    },
  ],
};
