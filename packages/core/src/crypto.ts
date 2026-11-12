// Secrets stored in the database (AI keys, hosted-app passwords): AES-256-GCM with ENCRYPTION_KEY.
import { createCipheriv, createDecipheriv, createHash, randomBytes } from "node:crypto";

export class SecretKeyMissing extends Error {
  constructor() { super("ENCRYPTION_KEY is not set on the server."); }
}

function cipherKey() {
  const k = process.env.ENCRYPTION_KEY;
  if (!k) throw new SecretKeyMissing();
  return createHash("sha256").update(k).digest();
}

export function encryptSecret(text: string) {
  const iv = randomBytes(12);
  const c = createCipheriv("aes-256-gcm", cipherKey(), iv);
  const body = Buffer.concat([c.update(text, "utf8"), c.final()]);
  return [iv, c.getAuthTag(), body].map((b) => b.toString("base64")).join(".");
}

export function decryptSecret(blob: string) {
  const [iv, tag, body] = blob.split(".").map((p) => Buffer.from(p, "base64"));
  const d = createDecipheriv("aes-256-gcm", cipherKey(), iv!);
  d.setAuthTag(tag!);
  return Buffer.concat([d.update(body!), d.final()]).toString("utf8");
}

/** A random password for an account the user never types into (hosted apps). */
export function randomPassword() {
  return randomBytes(24).toString("base64url") + "Aa1!";
}
