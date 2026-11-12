import "server-only";
import { randomBytes } from "node:crypto";
import { decryptSecret, encryptSecret, type SignIn } from "@mewe/core";
import { redis } from "./redis";

// Products without a login-link API (e.g. InvoiceShelf) are signed in server-side; their session cookies
// reach the browser through /api/hosted-sso, which the proxy serves on the product's own host so the
// cookies are set there and nowhere else. A ticket is encrypted, works once and expires after a minute.

type Ticket = Extract<SignIn, { kind: "cookies" }>;
const TTL = 60;
const memory = new Map<string, { value: string; until: number }>(); // only when Redis isn't configured (dev)

async function put(key: string, value: string) {
  if (redis) await redis.set(key, value, "EX", TTL);
  else memory.set(key, { value, until: Date.now() + TTL * 1000 });
}
async function peek(key: string) {
  if (redis) return redis.get(key);
  const hit = memory.get(key);
  return hit && hit.until > Date.now() ? hit.value : null;
}
async function take(key: string) {
  if (redis) return redis.getdel(key);
  const hit = memory.get(key);
  memory.delete(key);
  return hit && hit.until > Date.now() ? hit.value : null;
}

/** The URL to load in the frame: the product's own one-time link, or a bridge ticket on the product's host. */
export async function frameUrl(signIn: SignIn) {
  if (signIn.kind === "url") return signIn.url;
  const id = randomBytes(24).toString("base64url");
  await put(`hosted-sso:${id}`, encryptSecret(JSON.stringify(signIn)));
  return `${new URL(signIn.base).origin}/api/hosted-sso?t=${id}`;
}

/** Uses up a ticket, but only on the host it was made for (a ticket sent to another host isn't burnt). */
export async function redeem(id: string, host: string | null): Promise<Ticket | null> {
  if (!/^[A-Za-z0-9_-]{20,64}$/.test(id)) return null;
  const key = `hosted-sso:${id}`;
  const seen = await peek(key);
  if (!seen || new URL((JSON.parse(decryptSecret(seen)) as Ticket).base).host !== host) return null;
  const blob = await take(key);
  return blob ? (JSON.parse(decryptSecret(blob)) as Ticket) : null;
}

/** At most `limit` hosted-app sign-ins per person per minute (each one is a real sign-in to the product). */
export const signInAllowed = (userId: string, limit = 20) => perMinute(`hosted-open:${userId}`, limit);

/** A per-minute counter: true while `name` has been used at most `limit` times this minute. */
export async function perMinute(name: string, limit: number) {
  const key = `${name}:${Math.floor(Date.now() / 60_000)}`;
  if (redis) {
    const n = await redis.incr(key);
    if (n === 1) await redis.expire(key, 120);
    return n <= limit;
  }
  const hit = memory.get(key);
  const n = (hit ? Number(hit.value) : 0) + 1;
  memory.set(key, { value: String(n), until: Date.now() + 120_000 });
  return n <= limit;
}
