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
  return `${signIn.base}/api/hosted-sso?t=${id}`;
}

export async function redeem(id: string): Promise<Ticket | null> {
  if (!/^[A-Za-z0-9_-]{20,64}$/.test(id)) return null;
  const blob = await take(`hosted-sso:${id}`);
  return blob ? (JSON.parse(decryptSecret(blob)) as Ticket) : null;
}
