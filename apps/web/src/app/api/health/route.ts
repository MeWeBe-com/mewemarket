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
  const [db, cache, storage] = await Promise.all([
    check(() => sql`select 1`),
    check(async () => {
      await redis.connect();
      await redis.ping();
    }),
    check(async () => {
      const res = await fetch(`${process.env.S3_ENDPOINT ?? "http://127.0.0.1:9000"}/minio/health/live`, {
        signal: AbortSignal.timeout(2000),
      });
      if (!res.ok) throw new Error(`status ${res.status}`);
    }),
  ]);
  redis.disconnect();

  const healthy = db === "ok" && cache === "ok" && storage === "ok";
  return Response.json({ status: healthy ? "ok" : "degraded", db, cache, storage }, { status: healthy ? 200 : 503 });
}
