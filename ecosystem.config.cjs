module.exports = {
  apps: [
    {
      name: "web",
      cwd: "./apps/web",
      script: "node_modules/next/dist/bin/next",
      args: "start -p 3000",
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
