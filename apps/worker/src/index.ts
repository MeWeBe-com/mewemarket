import { execFile } from "node:child_process";
import { existsSync } from "node:fs";
import { promisify } from "node:util";
import { Queue, Worker } from "bullmq";
import { Redis } from "ioredis";

const exec = promisify(execFile);
const connection = new Redis(process.env.REDIS_URL ?? "redis://127.0.0.1:6379", { maxRetriesPerRequest: null });

// System jobs (backups, maintenance). Feature queues are added per milestone.
const system = new Queue("system", { connection });

// The nightly backup runs here only where its script exists (the release-style install under /srv).
// Folder installs back up with their own cron job (private/backup-db.sh), so the schedule is removed
// there instead of failing every night. BACKUP_SCRIPT overrides the path.
const backupScript = process.env.BACKUP_SCRIPT ?? "/srv/mewemarket/current/infra/backup.sh";
if (existsSync(backupScript)) {
  await system.upsertJobScheduler("nightly-backup", { pattern: "30 2 * * *" }, { name: "backup" });
} else {
  await system.removeJobScheduler("nightly-backup");
  console.log(`[system] nightly-backup off: ${backupScript} not found (backups run from cron)`);
}

const worker = new Worker(
  "system",
  async (job) => {
    if (job.name === "backup") {
      const { stdout } = await exec("bash", [backupScript], { timeout: 30 * 60_000 });
      return stdout.trim();
    }
    throw new Error(`Unknown system job: ${job.name}`);
  },
  { connection },
);

worker.on("failed", (job, err) => console.error(`[system] ${job?.name} failed:`, err.message));
worker.on("completed", (job) => console.log(`[system] ${job.name} done`));

async function shutdown() {
  await worker.close();
  await connection.quit();
  process.exit(0);
}
process.on("SIGTERM", shutdown);
process.on("SIGINT", shutdown);

console.log("Worker started");
