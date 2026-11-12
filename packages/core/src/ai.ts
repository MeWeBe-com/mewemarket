// AI assistant: each workspace brings its own Claude or OpenAI key. The model can only read records,
// through the tools below, and only for apps the workspace has installed.
import { db, schema } from "@mewe/db";
import { eq, sql } from "drizzle-orm";
import { getEntityDef } from "./apps";
import { decryptSecret, encryptSecret, SecretKeyMissing } from "./crypto";
import { wsUrl } from "./urls";
import { displayTitle, entityCounts, getRecord, listInstalledApps, listRecords, recordTitles, type RecordRow } from "./records";

export type AiProvider = "anthropic" | "openai";
export const AI_PROVIDERS: Record<AiProvider, { name: string; defaultModel: string; keyHint: string }> = {
  anthropic: { name: "Claude (Anthropic)", defaultModel: "claude-sonnet-5-5", keyHint: "sk-ant-..." },
  openai: { name: "OpenAI", defaultModel: "gpt-5", keyHint: "sk-..." },
};

type Stored = { provider: AiProvider; model: string; key: string; keyEnd: string; name: string; instructions: string };
export type AiSettings = Omit<Stored, "key"> & { hasKey: boolean };

export class AiError extends Error {}

// --- Key storage (see crypto.ts) -------------------------------------------

function encrypt(text: string) {
  try { return encryptSecret(text); } catch (e) { throw e instanceof SecretKeyMissing ? new AiError(e.message) : e; }
}
function decrypt(blob: string) {
  try { return decryptSecret(blob); } catch (e) { throw e instanceof SecretKeyMissing ? new AiError(e.message) : e; }
}

async function readStored(workspaceId: string): Promise<Partial<Stored>> {
  const [w] = await db.select({ settings: schema.workspaces.settings }).from(schema.workspaces).where(eq(schema.workspaces.id, workspaceId)).limit(1);
  return (w?.settings.ai as Partial<Stored> | undefined) ?? {};
}

export async function getAiSettings(workspaceId: string): Promise<AiSettings> {
  const s = await readStored(workspaceId);
  const provider = s.provider ?? "anthropic";
  return {
    provider, model: s.model || AI_PROVIDERS[provider].defaultModel, keyEnd: s.keyEnd ?? "",
    name: s.name || "Assistant", instructions: s.instructions ?? "", hasKey: !!s.key,
  };
}

/** Checks a new key against the provider (listing models costs nothing) before saving it. */
export async function saveAiSettings(
  workspaceId: string,
  input: { provider: AiProvider; model?: string; apiKey?: string; name?: string; instructions?: string; removeKey?: boolean },
) {
  if (!AI_PROVIDERS[input.provider]) throw new AiError("Unknown provider.");
  const prev = await readStored(workspaceId);
  const next: Partial<Stored> = {
    ...prev, provider: input.provider, model: input.model?.trim() || AI_PROVIDERS[input.provider].defaultModel,
    name: (input.name ?? prev.name)?.trim().slice(0, 40) || "Assistant", instructions: (input.instructions ?? prev.instructions ?? "").slice(0, 4000),
  };
  const apiKey = input.apiKey?.trim();
  if (input.removeKey) { delete next.key; delete next.keyEnd; }
  else if (apiKey) {
    await checkKey(input.provider, apiKey);
    next.key = encrypt(apiKey);
    next.keyEnd = apiKey.slice(-4);
  } else if (prev.provider && prev.provider !== input.provider) { delete next.key; delete next.keyEnd; }
  await db.update(schema.workspaces)
    .set({ settings: sql`jsonb_set(${schema.workspaces.settings}, '{ai}', ${JSON.stringify(next)}::jsonb)` })
    .where(eq(schema.workspaces.id, workspaceId));
}

async function checkKey(provider: AiProvider, key: string) {
  const res = provider === "anthropic"
    ? await fetch("https://api.anthropic.com/v1/models?limit=1", { headers: { "x-api-key": key, "anthropic-version": "2023-06-01" } })
    : await fetch("https://api.openai.com/v1/models", { headers: { authorization: `Bearer ${key}` } });
  if (res.status === 401 || res.status === 403) throw new AiError(`${AI_PROVIDERS[provider].name} rejected this API key.`);
  if (!res.ok) throw new AiError(`Couldn't check the key (${AI_PROVIDERS[provider].name} answered ${res.status}). Try again.`);
}

// --- Tools the model can call ------------------------------------------------

const TOOLS = [
  {
    name: "search_records",
    description: "List records of one entity in an installed app, newest first. Optional text search across all fields, exact-match filters on select fields, and sorting.",
    schema: {
      type: "object",
      properties: {
        app: { type: "string", description: "App slug, e.g. contacts" },
        entity: { type: "string", description: "Entity key, e.g. deal" },
        query: { type: "string", description: "Words to search for" },
        filter: { type: "object", description: "Field key to exact value, e.g. {\"stage\":\"Won\"}", additionalProperties: { type: "string" } },
        sort: { type: "string", description: "Field key to sort by" },
        dir: { type: "string", enum: ["asc", "desc"] },
        limit: { type: "number", description: "Max 50, default 20" },
      },
      required: ["app", "entity"],
    },
  },
  {
    name: "get_record",
    description: "Read one record in full by its id.",
    schema: { type: "object", properties: { app: { type: "string" }, entity: { type: "string" }, id: { type: "string" } }, required: ["app", "entity", "id"] },
  },
] as const;

type Ctx = { workspaceId: string; slug: string; installed: Set<string> };

async function present(ctx: Ctx, app: string, entity: string, rows: RecordRow[]) {
  const e = getEntityDef(app, entity)!;
  const refIds = rows.flatMap((row) => e.fields.filter((f) => f.type === "ref").map((f) => row.data[f.key]).filter((v): v is string => typeof v === "string"));
  const titles = await recordTitles(ctx.workspaceId, refIds);
  return rows.map((row) => {
    const data: Record<string, unknown> = {};
    for (const f of e.fields) {
      const v = row.data[f.key];
      if (v === undefined || v === null || v === "") continue;
      data[f.key] = f.type === "ref" && typeof v === "string" ? titles[v] ?? v : v;
    }
    return { id: row.id, title: displayTitle(e, row.data, titles), link: wsUrl(ctx.slug, app, entity, row.id), updated: row.updatedAt, ...data };
  });
}

async function runTool(ctx: Ctx, name: string, input: Record<string, unknown>) {
  const app = String(input.app ?? ""), entity = String(input.entity ?? "");
  if (!ctx.installed.has(app) || !getEntityDef(app, entity)) return { error: `No installed app/entity ${app}.${entity}. Use the list in the instructions.` };
  if (name === "get_record") {
    const row = await getRecord(ctx.workspaceId, app, entity, String(input.id ?? ""));
    return row ? (await present(ctx, app, entity, [row]))[0] : { error: "Record not found." };
  }
  if (name === "search_records") {
    const filter = typeof input.filter === "object" && input.filter ? Object.fromEntries(Object.entries(input.filter).map(([k, v]) => [k, String(v)])) : undefined;
    const { rows, total } = await listRecords(ctx.workspaceId, app, entity, {
      q: typeof input.query === "string" ? input.query : undefined, filter,
      sort: typeof input.sort === "string" ? input.sort : undefined, dir: input.dir === "asc" ? "asc" : "desc",
      limit: Math.min(Math.max(Number(input.limit) || 20, 1), 50),
    });
    return { total, shown: rows.length, records: await present(ctx, app, entity, rows) };
  }
  return { error: `Unknown tool ${name}` };
}

const asText = (v: unknown) => { const s = JSON.stringify(v); return s.length > 30_000 ? `${s.slice(0, 30_000)}…(truncated)` : s; };

// --- Chat ----------------------------------------------------------------------

export type ChatMessage = { role: "user" | "assistant"; content: string };

async function systemPrompt(ctx: Ctx, ws: { name: string; currency: string; timezone: string }, user: string, s: AiSettings) {
  const apps = (await listInstalledApps(ctx.workspaceId)).filter((a) => !a.kind);
  const lines = await Promise.all(apps.map(async (a) => {
    const counts = await entityCounts(ctx.workspaceId, a.slug);
    const ents = a.entities.map((e) => `  - ${e.key} (${e.plural}, ${counts[e.key] ?? 0} records): ${e.fields.map((f) => `${f.key}:${f.type}${f.options ? `[${f.options.join("|")}]` : ""}`).join(", ")}`);
    return `- ${a.slug} "${a.name}"\n${ents.join("\n")}`;
  }));
  return [
    `You are ${s.name}, the AI assistant inside MeweMarket for the workspace "${ws.name}". You are talking to ${user}.`,
    `Today is ${new Date().toISOString().slice(0, 10)}. Workspace currency: ${ws.currency}. Time zone: ${ws.timezone}.`,
    "Answer from the workspace's records: use the tools to look things up rather than guessing, and say so when the data doesn't contain the answer.",
    "You can read records but not change them. If asked to create or edit something, explain where in the app to do it.",
    "When you mention a record, link it with Markdown using its `link` value, e.g. [Harbor Dental](/acme/contacts/deal/123). Keep answers short. For several items use a bullet list (no tables).",
    "Money values are plain numbers in the workspace currency. A `lines` field is a list of {description, qty, price}; its total is the sum of qty × price.",
    apps.length ? `Installed apps and their fields:\n${lines.join("\n")}` : "No apps with records are installed yet; suggest adding some from the App Store.",
    s.instructions ? `Instructions from the workspace owner (follow these):\n${s.instructions}` : "",
  ].filter(Boolean).join("\n\n");
}

const MAX_ROUNDS = 6;

async function providerError(res: Response, provider: AiProvider) {
  const name = AI_PROVIDERS[provider].name;
  const body = await res.json().catch(() => null) as { error?: { message?: string } } | null;
  if (res.status === 401 || res.status === 403) return new AiError(`${name} rejected the API key. An owner can update it in the assistant settings.`);
  if (res.status === 429) return new AiError(`${name} says you've hit a rate or spending limit. Wait a moment or check your ${name} account.`);
  if (res.status === 404) return new AiError(`${name} doesn't know the model you chose. Check the model name in the assistant settings.`);
  return new AiError(`${name} error (${res.status}): ${body?.error?.message ?? "no details"}`);
}

async function chatAnthropic(key: string, model: string, system: string, history: ChatMessage[], ctx: Ctx) {
  const messages: { role: string; content: unknown }[] = history.map((m) => ({ role: m.role, content: m.content }));
  for (let round = 0; round < MAX_ROUNDS; round++) {
    const res = await fetch("https://api.anthropic.com/v1/messages", {
      method: "POST",
      headers: { "x-api-key": key, "anthropic-version": "2023-06-01", "content-type": "application/json" },
      body: JSON.stringify({ model, max_tokens: 2048, system, messages, tools: TOOLS.map((t) => ({ name: t.name, description: t.description, input_schema: t.schema })) }),
    });
    if (!res.ok) throw await providerError(res, "anthropic");
    const out = await res.json() as { stop_reason: string; content: { type: string; text?: string; id?: string; name?: string; input?: Record<string, unknown> }[] };
    const text = out.content.filter((c) => c.type === "text").map((c) => c.text).join("\n").trim();
    const calls = out.content.filter((c) => c.type === "tool_use");
    if (out.stop_reason !== "tool_use" || !calls.length) return text;
    messages.push({ role: "assistant", content: out.content });
    messages.push({ role: "user", content: await Promise.all(calls.map(async (c) => ({ type: "tool_result", tool_use_id: c.id, content: asText(await runTool(ctx, c.name!, c.input ?? {})) }))) });
  }
  return "I needed too many lookups for that one. Try a narrower question.";
}

async function chatOpenAI(key: string, model: string, system: string, history: ChatMessage[], ctx: Ctx) {
  const messages: Record<string, unknown>[] = [{ role: "system", content: system }, ...history];
  for (let round = 0; round < MAX_ROUNDS; round++) {
    const res = await fetch("https://api.openai.com/v1/chat/completions", {
      method: "POST",
      headers: { authorization: `Bearer ${key}`, "content-type": "application/json" },
      body: JSON.stringify({ model, messages, tools: TOOLS.map((t) => ({ type: "function", function: { name: t.name, description: t.description, parameters: t.schema } })) }),
    });
    if (!res.ok) throw await providerError(res, "openai");
    const out = await res.json() as { choices: { message: { content: string | null; tool_calls?: { id: string; function: { name: string; arguments: string } }[] } }[] };
    const msg = out.choices[0]!.message;
    if (!msg.tool_calls?.length) return (msg.content ?? "").trim();
    messages.push(msg);
    for (const c of msg.tool_calls) {
      let input: Record<string, unknown> = {};
      try { input = JSON.parse(c.function.arguments || "{}"); } catch { /* model sent bad JSON; tool reports the error */ }
      messages.push({ role: "tool", tool_call_id: c.id, content: asText(await runTool(ctx, c.function.name, input)) });
    }
  }
  return "I needed too many lookups for that one. Try a narrower question.";
}

export async function aiChat(
  ws: { id: string; slug: string; name: string; currency: string; timezone: string },
  userName: string,
  history: ChatMessage[],
) {
  const stored = await readStored(ws.id);
  if (!stored.key) throw new AiError("No API key yet. An owner or admin can add one in the assistant settings.");
  const settings = await getAiSettings(ws.id);
  const clean = history.filter((m) => (m.role === "user" || m.role === "assistant") && typeof m.content === "string" && m.content.trim())
    .slice(-20).map((m) => ({ role: m.role, content: m.content.slice(0, 8000) }));
  if (clean.at(-1)?.role !== "user") throw new AiError("Send a question first.");
  while (clean[0]?.role === "assistant") clean.shift();
  const installed = new Set((await listInstalledApps(ws.id)).map((a) => a.slug));
  const ctx: Ctx = { workspaceId: ws.id, slug: ws.slug, installed };
  const system = await systemPrompt(ctx, ws, userName, settings);
  const key = decrypt(stored.key);
  const reply = settings.provider === "openai"
    ? await chatOpenAI(key, settings.model, system, clean, ctx)
    : await chatAnthropic(key, settings.model, system, clean, ctx);
  return reply || "I don't have an answer for that.";
}
