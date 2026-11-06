"use client";
import { useEffect, useRef, useState } from "react";
import { Button, Field, Input } from "@/components/ui";
import { CopyButton } from "./shared";

// In-page video meetings: browser-to-browser WebRTC, connected through /api/meet/[room].
// Every peer already in the room sends an offer to each newcomer, so offers never cross.

const words = ["Blue", "Swift", "Bright", "Calm", "Golden", "Happy", "Quiet", "Brave", "Sunny", "Clever"];
const things = ["River", "Falcon", "Garden", "Harbor", "Meadow", "Summit", "Lantern", "Comet", "Forest", "Bridge"];
function randomRoom() {
  // A readable start plus 10 random characters (~50 bits), so room links can't be guessed.
  const r = new Uint32Array(12); crypto.getRandomValues(r);
  const tail = Array.from(r.slice(2), (n) => "abcdefghijkmnpqrstuvwxyz23456789"[n % 32]).join("");
  return `Mewe${words[r[0]! % words.length]}${things[r[1]! % things.length]}-${tail}`;
}

const ICE: RTCIceServer[] = [
  { urls: "stun:stun.l.google.com:19302" },
  ...(process.env.NEXT_PUBLIC_TURN_URL
    ? [{ urls: process.env.NEXT_PUBLIC_TURN_URL, username: process.env.NEXT_PUBLIC_TURN_USER, credential: process.env.NEXT_PUBLIC_TURN_PASS }]
    : []),
];

type Peer = { id: string; name: string; stream: MediaStream | null };
// eslint-disable-next-line @typescript-eslint/no-explicit-any
type Signal = { type: string; from: string; to?: string; name?: string; data?: any };

export default function VideoMeeting() {
  const [room, setRoom] = useState("");
  const [name, setName] = useState("");
  const [inCall, setInCall] = useState(false);
  const [peers, setPeers] = useState<Peer[]>([]);
  const [mic, setMic] = useState(true);
  const [cam, setCam] = useState(true);
  const [sharing, setSharing] = useState(false);
  const [notice, setNotice] = useState("");
  const [link, setLink] = useState("");
  const local = useRef<MediaStream | null>(null);
  const screen = useRef<MediaStreamTrack | null>(null);
  const pcs = useRef(new Map<string, RTCPeerConnection>());
  const me = useRef<{ id: string; secret: string } | null>(null);
  const es = useRef<EventSource | null>(null);
  const localVideo = useRef<HTMLVideoElement>(null);

  const clean = room.replace(/[^A-Za-z0-9_-]/g, "");

  useEffect(() => {
    const q = new URLSearchParams(window.location.search).get("room");
    setRoom(q?.replace(/[^A-Za-z0-9_-]/g, "") || randomRoom());
  }, []);
  useEffect(() => setLink(`${window.location.origin}/tools/video-meeting?room=${clean}`), [clean]);
  useEffect(() => () => leave(), []); // eslint-disable-line react-hooks/exhaustive-deps

  const send = (msg: Omit<Signal, "from">) => {
    if (!me.current) return;
    void fetch(`/api/meet/${clean}`, { method: "POST", body: JSON.stringify({ ...msg, from: me.current.id, secret: me.current.secret, name }) });
  };

  const upsert = (id: string, patch: Partial<Peer>) =>
    setPeers((list) => list.some((p) => p.id === id) ? list.map((p) => (p.id === id ? { ...p, ...patch } : p)) : [...list, { id, name: "Guest", stream: null, ...patch }]);

  function connection(id: string) {
    let pc = pcs.current.get(id);
    if (pc) return pc;
    pc = new RTCPeerConnection({ iceServers: ICE });
    pcs.current.set(id, pc);
    for (const t of local.current?.getTracks() ?? []) {
      pc.addTrack(t.kind === "video" && screen.current ? screen.current : t, local.current!);
    }
    // Receive even when we have no camera or microphone of our own.
    if (!local.current?.getAudioTracks().length) pc.addTransceiver("audio", { direction: "recvonly" });
    if (!local.current?.getVideoTracks().length) pc.addTransceiver("video", { direction: "recvonly" });
    pc.onicecandidate = (e) => e.candidate && send({ type: "ice", to: id, data: e.candidate.toJSON() });
    pc.ontrack = (e) => upsert(id, { stream: e.streams[0] ?? new MediaStream([e.track]) });
    pc.onconnectionstatechange = () => {
      if (pc!.connectionState === "failed") setNotice("Couldn't connect to someone in the room. Their network may block direct calls.");
    };
    return pc;
  }

  function drop(id: string) {
    pcs.current.get(id)?.close();
    pcs.current.delete(id);
    setPeers((list) => list.filter((p) => p.id !== id));
  }

  async function onSignal(m: Signal) {
    if (m.type === "leave") return drop(m.from);
    if (m.name) upsert(m.from, { name: m.name });
    if (m.type === "join") {
      const pc = connection(m.from);
      await pc.setLocalDescription(await pc.createOffer());
      send({ type: "offer", to: m.from, data: pc.localDescription });
    } else if (m.type === "offer") {
      const pc = connection(m.from);
      await pc.setRemoteDescription(m.data);
      await pc.setLocalDescription(await pc.createAnswer());
      send({ type: "answer", to: m.from, data: pc.localDescription });
    } else if (m.type === "answer") {
      await pcs.current.get(m.from)?.setRemoteDescription(m.data);
    } else if (m.type === "ice") {
      await pcs.current.get(m.from)?.addIceCandidate(m.data).catch(() => {});
    }
  }

  async function join() {
    setNotice("");
    try {
      local.current = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
    } catch {
      try {
        local.current = await navigator.mediaDevices.getUserMedia({ audio: true });
        setCam(false);
        setNotice("No camera found or camera blocked. You joined with audio only.");
      } catch {
        local.current = null;
        setMic(false); setCam(false);
        setNotice("Microphone and camera are blocked. You can watch and listen; allow access in your browser's address bar to take part.");
      }
    }
    setInCall(true);
    const src = new EventSource(`/api/meet/${clean}?name=${encodeURIComponent(name || "Guest")}`);
    es.current = src;
    src.addEventListener("hello", (e) => { me.current = JSON.parse((e as MessageEvent).data); });
    src.addEventListener("signal", (e) => void onSignal(JSON.parse((e as MessageEvent).data)));
    src.addEventListener("full", () => { leave(); setNotice("This room is full (6 people). Try another room."); });
    src.onerror = () => { if (src.readyState === EventSource.CLOSED) setNotice("Lost connection to the meeting."); };
  }

  function leave() {
    es.current?.close(); es.current = null;
    for (const id of [...pcs.current.keys()]) drop(id);
    local.current?.getTracks().forEach((t) => t.stop()); local.current = null;
    screen.current?.stop(); screen.current = null;
    me.current = null;
    setInCall(false); setSharing(false); setMic(true); setCam(true); setPeers([]);
  }

  useEffect(() => {
    if (localVideo.current && !sharing) localVideo.current.srcObject = local.current;
  }, [inCall, sharing]);

  const toggle = (kind: "audio" | "video", on: boolean) => local.current?.getTracks().filter((t) => t.kind === kind).forEach((t) => (t.enabled = on));

  async function share() {
    if (sharing) return stopShare();
    try {
      const display = await navigator.mediaDevices.getDisplayMedia({ video: true });
      const track = display.getVideoTracks()[0]!;
      screen.current = track;
      track.onended = () => stopShare();
      for (const pc of pcs.current.values()) void pc.getSenders().find((s) => s.track?.kind === "video")?.replaceTrack(track);
      if (localVideo.current) localVideo.current.srcObject = display;
      setSharing(true);
    } catch { /* picker cancelled */ }
  }
  function stopShare() {
    const camTrack = local.current?.getVideoTracks()[0] ?? null;
    for (const pc of pcs.current.values()) void pc.getSenders().find((s) => s.track?.kind === "video")?.replaceTrack(camTrack);
    screen.current?.stop(); screen.current = null;
    setSharing(false);
  }

  if (!inCall) {
    return (
      <div className="space-y-4">
        <div className="grid gap-3 sm:grid-cols-2">
          <Field label="Room name" hint="Anyone with the link can join."><Input value={room} onChange={(e) => setRoom(e.target.value)} /></Field>
          <Field label="Your name"><Input value={name} onChange={(e) => setName(e.target.value)} placeholder="Guest" maxLength={40} /></Field>
        </div>
        <div className="flex flex-wrap gap-2">
          <Button type="button" disabled={clean.length < 3} onClick={() => void join()}>Join meeting</Button>
          <Button type="button" variant="secondary" onClick={() => setRoom(randomRoom())}>New room</Button>
        </div>
        {link && <div className="flex flex-wrap items-center gap-2 text-sm"><span className="break-all font-mono">{link}</span><CopyButton value={link} label="Copy invite link" /></div>}
        {notice && <p className="text-sm text-amber-600 dark:text-amber-400">{notice}</p>}
        <p className="text-xs text-[var(--muted)]">Up to 6 people. Video goes directly between browsers; no sign-in, no time limit.</p>
      </div>
    );
  }

  const tiles = peers.length + 1;
  const hasAudio = !!local.current?.getAudioTracks().length, hasVideo = !!local.current?.getVideoTracks().length;
  return (
    <div className="space-y-3">
      <div className="flex flex-wrap items-center gap-2 text-sm">
        <span className="font-medium">{clean}</span>
        <span className="text-[var(--muted)]">· {tiles} {tiles === 1 ? "person" : "people"}</span>
        <CopyButton value={link} label="Copy invite link" />
      </div>
      {notice && <p className="text-sm text-amber-600 dark:text-amber-400">{notice}</p>}
      <div className={`grid gap-2 ${tiles === 1 ? "" : tiles <= 4 ? "sm:grid-cols-2" : "sm:grid-cols-3"}`}>
        <Tile label={`${name || "You"} (you)${sharing ? " · sharing screen" : ""}`} off={!cam && !sharing}>
          <video ref={localVideo} autoPlay playsInline muted className={`h-full w-full object-cover ${sharing ? "" : "-scale-x-100"}`} />
        </Tile>
        {peers.map((p) => (
          <Tile key={p.id} label={p.name} off={!p.stream}>
            <RemoteVideo stream={p.stream} />
          </Tile>
        ))}
      </div>
      {peers.length === 0 && <p className="text-sm text-[var(--muted)]">Waiting for others. Send them the invite link.</p>}
      <div className="flex flex-wrap justify-center gap-2">
        <Button type="button" variant="secondary" disabled={!hasAudio} onClick={() => { toggle("audio", !mic); setMic(!mic); }}>{mic && hasAudio ? "Mute" : "Unmute"}</Button>
        <Button type="button" variant="secondary" disabled={!hasVideo} onClick={() => { toggle("video", !cam); setCam(!cam); }}>{cam && hasVideo ? "Stop camera" : "Start camera"}</Button>
        {typeof navigator !== "undefined" && "getDisplayMedia" in (navigator.mediaDevices ?? {}) && (
          <Button type="button" variant="secondary" disabled={!hasVideo} onClick={() => void share()}>{sharing ? "Stop sharing" : "Share screen"}</Button>
        )}
        <Button type="button" className="bg-red-600 hover:bg-red-500" onClick={leave}>Leave</Button>
      </div>
    </div>
  );
}

function Tile({ label, off, children }: { label: string; off: boolean; children: React.ReactNode }) {
  return (
    <div className="relative aspect-video overflow-hidden rounded-lg bg-slate-900">
      {children}
      {off && <div className="absolute inset-0 flex items-center justify-center text-sm text-slate-300">Camera off</div>}
      <span className="absolute bottom-2 left-2 rounded bg-black/60 px-2 py-0.5 text-xs text-white">{label}</span>
    </div>
  );
}

function RemoteVideo({ stream }: { stream: MediaStream | null }) {
  const ref = useRef<HTMLVideoElement>(null);
  useEffect(() => { if (ref.current) ref.current.srcObject = stream; }, [stream]);
  return <video ref={ref} autoPlay playsInline className="h-full w-full object-cover" />;
}
