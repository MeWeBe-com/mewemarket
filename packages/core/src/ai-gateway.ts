// AI gateway: an OpenAI-compatible endpoint for hosted AI apps (Open WebUI). The app sends every model call here
// with a shared secret and the person's generated login (X-OpenWebUI-User-Email, set by Open WebUI's server; the
// browser can't). The gateway finds that person's company, uses the COMPANY'S OWN Claude or OpenAI key (saved
// encrypted in MeweMarket; the AI app never sees it), enforces the plan's monthly AI messages and a per-person
// rate, and translates to the provider. Usage is recorded in ai_credits_ledger.
import { randomUUID } from "node:crypto";
import { db, schema } from "@mewe/db";
import { and, count, eq, gte, sql } from "drizzle-orm";
import { AiError, getAiCredentials } from "./ai";
import { currentPlan } from "./billing";

export class GatewayError extends Error {
  constructor(public status: number, message: string) { super(message); }
}

/** The company and person behind a hosted AI app's login, if they're still a member there. */
export async function gatewayCaller(provider: string, login: string) {
  const [row] = await db
    .select({ workspaceId: schema.hostedTenants.workspaceId, userId: schema.hostedAccounts.userId })
    .from(schema.hostedAccounts)
    .innerJoin(schema.hostedTenants, eq(schema.hostedTenants.id, schema.hostedAccounts.scope))
    .innerJoin(schema.hostedMembers, and(eq(schema.hostedMembers.tenantId, schema.hostedTenants.id), eq(schema.hostedMembers.userId, schema.hostedAccounts.userId)))
    .innerJoin(schema.members, and(eq(schema.members.organizationId, schema.hostedTenants.workspaceId), eq(schema.members.userId, schema.hostedAccounts.userId)))
    .where(and(eq(schema.hostedAccounts.provider, provider), eq(sql`lower(${schema.hostedAccounts.login})`, login.toLowerCase())))
    .limit(1);
  return row ?? null;
}

const monthStart = () => { const d = new Date(); return new Date(Date.UTC(d.getUTCFullYear(), d.getUTCMonth(), 1)); };

/** Throws when the company has used this month's AI messages (plan limit; -1 = unlimited). */
export async function checkAiAllowance(workspaceId: string) {
  const plan = await currentPlan(workspaceId);
  const max = plan.limits.aiCreditsMonthly;
  if (max < 0) return;
  const [row] = await db.select({ n: count() }).from(schema.aiCreditsLedger)
    .where(and(eq(schema.aiCreditsLedger.workspaceId, workspaceId), eq(schema.aiCreditsLedger.reason, "usage"), gte(schema.aiCreditsLedger.createdAt, monthStart())));
  if ((row?.n ?? 0) >= max) {
    throw new GatewayError(429, `Your company has used its ${max.toLocaleString()} AI messages for this month on the ${plan.name} plan. Upgrade for more, or wait until next month.`);
  }
}

export async function recordAiUsage(workspaceId: string, userId: string, model: string, inputTokens?: number, outputTokens?: number) {
  await db.insert(schema.aiCreditsLedger).values({ id: randomUUID(), workspaceId, userId, delta: -1, reason: "usage", model, inputTokens, outputTokens });
}

export async function gatewayCredentials(workspaceId: string) {
  const c = await getAiCredentials(workspaceId).catch((e) => { if (e instanceof AiError) throw new GatewayError(500, e.message); throw e; });
  if (!c) throw new GatewayError(400, "Your company hasn't added its Claude or OpenAI key yet. An owner or admin can add it in the AI Chat settings in MeweMarket.");
  return c;
}

// --- OpenAI-format messages -> provider calls ------------------------------------------------------------------

type Part = { type: string; text?: string; image_url?: { url: string } | string };
export type OpenAiMessage = { role: string; content: string | Part[] | null };

const MAX_TOKENS = 4096;
const ANTHROPIC_BASE = () => process.env.AI_ANTHROPIC_BASE_URL || "https://api.anthropic.com";
const OPENAI_BASE = () => process.env.AI_OPENAI_BASE_URL || "https://api.openai.com";

function anthropicContent(c: OpenAiMessage["content"]) {
  if (typeof c === "string" || c === null) return c ?? "";
  return c.map((p) => {
    if (p.type === "text") return { type: "text", text: p.text ?? "" };
    if (p.type === "image_url") {
      const url = typeof p.image_url === "string" ? p.image_url : p.image_url?.url ?? "";
      const m = /^data:(image\/[a-z+.-]+);base64,(.+)$/i.exec(url);
      return m ? { type: "image", source: { type: "base64", media_type: m[1], data: m[2] } } : { type: "image", source: { type: "url", url } };
    }
    return { type: "text", text: "" };
  });
}

/** Calls the company's provider; returns the upstream Response in OpenAI chat-completions shape (streamed or not). */
export async function gatewayChat(creds: { provider: "anthropic" | "openai"; model: string; key: string }, body: { messages: OpenAiMessage[]; stream?: boolean; temperature?: number; max_tokens?: number }, onUsage: (input?: number, output?: number) => void) {
  const stream = !!body.stream;
  if (creds.provider === "openai") {
    const res = await fetch(`${OPENAI_BASE()}/v1/chat/completions`, {
      method: "POST",
      headers: { authorization: `Bearer ${creds.key}`, "content-type": "application/json" },
      body: JSON.stringify({ model: creds.model, messages: body.messages, stream, temperature: body.temperature, max_completion_tokens: Math.min(body.max_tokens ?? MAX_TOKENS, MAX_TOKENS), ...(stream ? { stream_options: { include_usage: true } } : {}) }),
      signal: AbortSignal.timeout(300_000),
    });
    if (!res.ok) throw new GatewayError(res.status === 401 ? 400 : res.status, await providerMessage(res, "OpenAI"));
    if (!stream) { const j = await res.json() as { usage?: { prompt_tokens?: number; completion_tokens?: number } }; onUsage(j.usage?.prompt_tokens, j.usage?.completion_tokens); return Response.json(j); }
    onUsage();
    return new Response(res.body, { headers: { "content-type": "text/event-stream", "cache-control": "no-cache" } });
  }
  const system = body.messages.filter((m) => m.role === "system").map((m) => typeof m.content === "string" ? m.content : (m.content ?? []).map((p) => p.text ?? "").join("\n")).join("\n\n");
  const messages = body.messages.filter((m) => m.role === "user" || m.role === "assistant").map((m) => ({ role: m.role, content: anthropicContent(m.content) }));
  const res = await fetch(`${ANTHROPIC_BASE()}/v1/messages`, {
    method: "POST",
    headers: { "x-api-key": creds.key, "anthropic-version": "2023-06-01", "content-type": "application/json" },
    body: JSON.stringify({ model: creds.model, max_tokens: Math.min(body.max_tokens ?? MAX_TOKENS, MAX_TOKENS), ...(system ? { system } : {}), messages, stream, ...(body.temperature !== undefined ? { temperature: Math.min(body.temperature, 1) } : {}) }),
    signal: AbortSignal.timeout(300_000),
  });
  if (!res.ok) throw new GatewayError(res.status === 401 ? 400 : res.status, await providerMessage(res, "Claude"));
  const id = `chatcmpl-${randomUUID()}`, created = Math.floor(Date.now() / 1000);
  if (!stream) {
    const j = await res.json() as { content: { type: string; text?: string }[]; stop_reason?: string; usage?: { input_tokens?: number; output_tokens?: number } };
    onUsage(j.usage?.input_tokens, j.usage?.output_tokens);
    return Response.json({ id, object: "chat.completion", created, model: creds.model,
      choices: [{ index: 0, message: { role: "assistant", content: j.content.filter((c) => c.type === "text").map((c) => c.text).join("") }, finish_reason: j.stop_reason === "max_tokens" ? "length" : "stop" }],
      usage: { prompt_tokens: j.usage?.input_tokens ?? 0, completion_tokens: j.usage?.output_tokens ?? 0, total_tokens: (j.usage?.input_tokens ?? 0) + (j.usage?.output_tokens ?? 0) } });
  }
  // Claude's event stream -> OpenAI chunks.
  const enc = new TextEncoder(), dec = new TextDecoder();
  const chunk = (delta: Record<string, unknown>, finish: string | null = null) =>
    enc.encode(`data: ${JSON.stringify({ id, object: "chat.completion.chunk", created, model: creds.model, choices: [{ index: 0, delta, finish_reason: finish }] })}\n\n`);
  let input: number | undefined, output: number | undefined, buf = "";
  const out = new ReadableStream({
    async start(ctrl) {
      ctrl.enqueue(chunk({ role: "assistant", content: "" }));
      const reader = res.body!.getReader();
      try {
        for (;;) {
          const { value, done } = await reader.read();
          if (done) break;
          buf += dec.decode(value, { stream: true });
          let i;
          while ((i = buf.indexOf("\n\n")) >= 0) {
            const evt = buf.slice(0, i); buf = buf.slice(i + 2);
            const data = evt.split("\n").find((l) => l.startsWith("data: "))?.slice(6);
            if (!data) continue;
            const e = JSON.parse(data) as { type: string; delta?: { type?: string; text?: string; stop_reason?: string }; message?: { usage?: { input_tokens?: number } }; usage?: { output_tokens?: number } };
            if (e.type === "message_start") input = e.message?.usage?.input_tokens;
            else if (e.type === "content_block_delta" && e.delta?.type === "text_delta") ctrl.enqueue(chunk({ content: e.delta.text ?? "" }));
            else if (e.type === "message_delta") { output = e.usage?.output_tokens; ctrl.enqueue(chunk({}, e.delta?.stop_reason === "max_tokens" ? "length" : "stop")); }
          }
        }
      } finally {
        onUsage(input, output);
        ctrl.enqueue(enc.encode("data: [DONE]\n\n"));
        ctrl.close();
      }
    },
  });
  return new Response(out, { headers: { "content-type": "text/event-stream", "cache-control": "no-cache" } });
}

async function providerMessage(res: Response, name: string) {
  const j = await res.json().catch(() => null) as { error?: { message?: string } } | null;
  if (res.status === 401 || res.status === 403) return `${name} rejected your company's API key. An owner or admin can update it in MeweMarket.`;
  if (res.status === 429) return `${name} says your company hit a rate or spending limit. Wait a moment or check your ${name} account.`;
  return `${name} error (${res.status}): ${j?.error?.message ?? "no details"}`;
}
