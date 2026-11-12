import { timingSafeEqual } from "node:crypto";
import { checkAiAllowance, gatewayCaller, GatewayError, gatewayChat, gatewayCredentials, type OpenAiMessage, recordAiUsage } from "@mewe/core";
import { perMinute } from "@/lib/hosted-sso";

// OpenAI-compatible endpoint for the hosted AI Chat app (Open WebUI): see packages/core/src/ai-gateway.ts.
// Only Open WebUI's server calls it, with AI_GATEWAY_KEY; it names the person in X-OpenWebUI-User-Email.

export const dynamic = "force-dynamic";
const MODEL_ID = "company-ai";
const MAX_BODY = 8 * 1024 * 1024; // images arrive inline as data URLs

function authorised(req: Request) {
  const want = process.env.AI_GATEWAY_KEY ?? "";
  const got = (req.headers.get("authorization") ?? "").replace(/^Bearer\s+/i, "");
  return want.length >= 32 && got.length === want.length && timingSafeEqual(Buffer.from(got), Buffer.from(want));
}

const fail = (status: number, message: string) =>
  Response.json({ error: { message, type: status === 429 ? "rate_limit" : "invalid_request_error" } }, { status });

export async function GET(req: Request, { params }: { params: Promise<{ path: string[] }> }) {
  if (!authorised(req)) return fail(401, "Unauthorised");
  const path = (await params).path.join("/");
  if (path !== "models") return fail(404, "Not found");
  // One model: each company's own choice of Claude or OpenAI model, picked from its settings at call time.
  return Response.json({ object: "list", data: [{ id: MODEL_ID, object: "model", created: 0, owned_by: "mewemarket", name: "Company AI" }] });
}

export async function POST(req: Request, { params }: { params: Promise<{ path: string[] }> }) {
  if (!authorised(req)) return fail(401, "Unauthorised");
  if ((await params).path.join("/") !== "chat/completions") return fail(404, "Not found");
  if (Number(req.headers.get("content-length") ?? 0) > MAX_BODY) return fail(413, "That message is too large.");
  const login = req.headers.get("x-openwebui-user-email") ?? "";
  const caller = login ? await gatewayCaller("openwebui", login) : null;
  if (!caller) return fail(403, "You're not a member of a company that uses AI Chat.");
  try {
    if (!(await perMinute(`ai-gw:${caller.userId}`, 20))) throw new GatewayError(429, "You're sending messages very quickly. Please wait a moment.");
    await checkAiAllowance(caller.workspaceId);
    const creds = await gatewayCredentials(caller.workspaceId);
    const body = (await req.json()) as { messages?: OpenAiMessage[]; stream?: boolean; temperature?: number; max_tokens?: number };
    if (!Array.isArray(body.messages) || !body.messages.length) throw new GatewayError(400, "No messages.");
    return await gatewayChat(creds, { messages: body.messages, stream: body.stream, temperature: body.temperature, max_tokens: body.max_tokens },
      (input, output) => { void recordAiUsage(caller.workspaceId, caller.userId, creds.model, input, output); });
  } catch (e) {
    if (e instanceof GatewayError) return fail(e.status, e.message);
    console.error("ai-gateway", e);
    return fail(502, "The AI provider didn't answer. Please try again.");
  }
}
