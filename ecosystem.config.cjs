module.exports = {
  apps: [
    {
      name: "web",
      cwd: "./apps/web",
      script: "node_modules/next/dist/bin/next",
      // WEB_PORT (or PORT) must match the port nginx proxies the site to.
      args: `start -p ${process.env.WEB_PORT || process.env.PORT || 3000}`,
      exec_mode: "cluster",
      instances: 2,
      env: { NODE_ENV: "production" },
      max_memory_restart: "1G",
    },
    {
      name: "worker",
      cwd: "./apps/worker",
      script: "dist/index.js",
      exec_mode: "fork",
      instances: 1,
      env: { NODE_ENV: "production" },
      kill_timeout: 30000,
    },
  ],
};
