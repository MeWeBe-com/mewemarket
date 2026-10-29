import { randomBytes, randomUUID } from "node:crypto";
import Redis from "ioredis";

// Signalling for in-page video meetings. Media flows browser to browser (WebRTC);
// this only relays offers, answers and ICE candidates between the peers of a room.
// GET opens an event stream and registers the peer; POST sends a message to the room or to one peer.

export const dynamic = "force-dynamic";
export const runtime = "nodejs";

const MAX_PEERS = 6;
const TYPES = new Set(["offer", "answer", "ice", "state"]);
const ROOM = /^[A-Za-z0-9_-]{3,64}$/;

const url = process.env.REDIS_URL;
const pub = url ? new Redis(url) : null;
const peersKey = (room: string) => `meet:${room}:peers`;
const channel = (room: string) => `meet:${room}`;

type Msg = { type: string; from: string; to?: string; name?: string; data?: unknown };

export async function GET(req: Request, { params }: { params: Promise<{ room: string }> }) {
  const { room } = await params;
  if (!pub || !url) return new Response("Meetings are unavailable", { status: 503 });
  if (!ROOM.test(room)) return new Response("Bad room name", { status: 400 });
  const name = (new URL(req.url).searchParams.get("name") ?? "Guest").replace(/[^\p{L}\p{N} ._'-]/gu, "").slice(0, 40) || "Guest";

  // Peers expire if their stream dies without a clean leave.
  const key = peersKey(room);
  const live = await pub.hlen(key);
  const enc = new TextEncoder();
  if (live >= MAX_PEERS) {
    return new Response(`event: full\ndata: {}\n\n`, { headers: { "content-type": "text/event-stream" } });
  }
  const id = randomUUID(), secret = randomBytes(16).toString("hex");
  await pub.hset(key, id, secret);
  await pub.expire(key, 6 * 3600);

  const sub = new Redis(url);
  let beat: ReturnType<typeof setInterval>;
  const stream = new ReadableStream({
    async start(ctl) {
      const send = (event: string, data: unknown) => ctl.enqueue(enc.encode(`event: ${event}\ndata: ${JSON.stringify(data)}\n\n`));
      sub.on("message", (_c, raw) => {
        const m = JSON.parse(raw) as Msg;
        if (m.from !== id && (!m.to || m.to === id)) send("signal", m);
      });
      await sub.subscribe(channel(room));
      send("hello", { id, secret });
      await pub.publish(channel(room), JSON.stringify({ type: "join", from: id, name } satisfies Msg));
      beat = setInterval(() => ctl.enqueue(enc.encode(`: ping\n\n`)), 20_000);
    },
    async cancel() { await leave(); },
  });
  const leave = async () => {
    clearInterval(beat);
    await pub.hdel(key, id);
    await pub.publish(channel(room), JSON.stringify({ type: "leave", from: id } satisfies Msg));
    sub.disconnect();
  };
  req.signal.addEventListener("abort", () => void leave().catch(() => {}), { once: true });

  return new Response(stream, {
    headers: { "content-type": "text/event-stream", "cache-control": "no-cache, no-transform", connection: "keep-alive", "x-accel-buffering": "no" },
  });
}

export async function POST(req: Request, { params }: { params: Promise<{ room: string }> }) {
  const { room } = await params;
  if (!pub || !ROOM.test(room)) return new Response(null, { status: 400 });
  const body = await req.text();
  if (body.length > 64_000) return new Response(null, { status: 413 });
  let m: Msg & { secret?: string };
  try { m = JSON.parse(body); } catch { return new Response(null, { status: 400 }); }
  if (!TYPES.has(m.type) || typeof m.from !== "string") return new Response(null, { status: 400 });
  // Only the peer holding the secret issued with its id may speak as it.
  if (!m.secret || (await pub.hget(peersKey(room), m.from)) !== m.secret) return new Response(null, { status: 403 });
  const out: Msg = { type: m.type, from: m.from, to: typeof m.to === "string" ? m.to : undefined, name: typeof m.name === "string" ? m.name.slice(0, 40) : undefined, data: m.data };
  await pub.publish(channel(room), JSON.stringify(out));
  return new Response(null, { status: 204 });
}
