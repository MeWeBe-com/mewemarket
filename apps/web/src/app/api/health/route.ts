import { sql } from "@mewe/db";
import Redis from "ioredis";

export const dynamic = "force-dynamic";

async function check(fn: () => Promise<unknown>): Promise<"ok" | string> {
  try {
    await fn();
    return "ok";
  } catch (e) {
    return e instanceof Error ? e.message : "error";
  }
}

export async function GET() {
  const redis = new Redis(process.env.REDIS_URL ?? "redis://127.0.0.1:6379", {
    lazyConnect: true,
    maxRetriesPerRequest: 1,
    connectTimeout: 2000,
  });
  const [db, cache, storageCheck] = await Promise.all([
    check(() => sql`select 1`),
    check(async () => {
      await redis.connect();
      await redis.ping();
    }),
    // Object storage is optional: no app feature uses it yet, so it's only checked when configured.
    check(async () => {
      if (!process.env.S3_ENDPOINT) return;
      const res = await fetch(`${process.env.S3_ENDPOINT}/minio/health/live`, {
        signal: AbortSignal.timeout(2000),
      });
      if (!res.ok) throw new Error(`status ${res.status}`);
    }),
  ]);
  redis.disconnect();
  const storage = process.env.S3_ENDPOINT ? storageCheck : "not configured";

  const healthy = db === "ok" && cache === "ok" && storageCheck === "ok";
  return Response.json({ status: healthy ? "ok" : "degraded", db, cache, storage }, { status: healthy ? 200 : 503 });
}
