import "server-only";
import Redis from "ioredis";

/** Shared Redis connection (sessions, rate limits, hosted-app sign-in tickets). Null when REDIS_URL is unset. */
export const redis = process.env.REDIS_URL ? new Redis(process.env.REDIS_URL, { lazyConnect: true }) : null;
