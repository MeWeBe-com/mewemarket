"use server";
import { saveContactMessage } from "@mewe/core";
import Redis from "ioredis";
import { headers } from "next/headers";
import { z } from "zod";
import { sendMail } from "@/lib/email";

const Input = z.object({
  name: z.string().trim().min(2, "Please enter your name").max(100),
  email: z.string().trim().email("Please enter a valid email"),
  topic: z.enum(["sales", "support", "partnership", "other"]),
  message: z.string().trim().min(10, "Please write a little more").max(5000),
  website: z.string().max(0).optional(), // honeypot: bots fill hidden fields
});

const redis = process.env.REDIS_URL ? new Redis(process.env.REDIS_URL) : null;

export type ContactState = { ok: boolean; error: string | null } | null;

export async function sendContact(_prev: ContactState, form: FormData): Promise<ContactState> {
  const parsed = Input.safeParse(Object.fromEntries(form));
  if (!parsed.success) return { ok: false, error: parsed.error.issues[0]?.message ?? "Please check the form" };
  if (parsed.data.website) return { ok: true, error: null };

  const ip = (await headers()).get("x-forwarded-for")?.split(",")[0]?.trim() ?? null;
  if (redis && ip) {
    const key = `contact:${ip}`;
    const count = await redis.incr(key);
    if (count === 1) await redis.expire(key, 3600);
    if (count > 5) return { ok: false, error: "Too many messages. Please try again in an hour." };
  }

  const { website: _, ...data } = parsed.data;
  await saveContactMessage({ ...data, ip });
  if (process.env.CONTACT_INBOX) {
    await sendMail({
      to: process.env.CONTACT_INBOX,
      subject: `[Contact · ${data.topic}] ${data.name}`,
      heading: `New ${data.topic} message`,
      body: `<strong>${escape(data.name)}</strong> &lt;${escape(data.email)}&gt;<br><br>${escape(data.message).replace(/\n/g, "<br>")}`,
    }).catch((e) => console.error("[contact] notify failed", e));
  }
  return { ok: true, error: null };
}

const escape = (s: string) => s.replace(/[&<>"']/g, (c) => `&#${c.charCodeAt(0)};`);
