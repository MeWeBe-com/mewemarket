"use client";
import { useState } from "react";
import { Button, Field, Input } from "@/components/ui";
import { CopyButton } from "./shared";

const words = ["Blue", "Swift", "Bright", "Calm", "Golden", "Happy", "Quiet", "Brave", "Sunny", "Clever"];
const things = ["River", "Falcon", "Garden", "Harbor", "Meadow", "Summit", "Lantern", "Comet", "Forest", "Bridge"];
function randomRoom() {
  const r = new Uint32Array(3); crypto.getRandomValues(r);
  return `Mewe${words[r[0]! % words.length]}${things[r[1]! % things.length]}${(r[2]! % 9000) + 1000}`;
}

export default function VideoMeeting() {
  const [room, setRoom] = useState(() => randomRoom());
  const [joined, setJoined] = useState(false);
  const clean = room.replace(/[^A-Za-z0-9-_]/g, "");
  const link = `https://meet.jit.si/${clean}`;
  return (
    <div className="space-y-4">
      <div className="flex flex-wrap items-end gap-2">
        <div className="min-w-56 flex-1"><Field label="Room name" hint="Anyone with the link can join."><Input value={room} onChange={(e) => { setRoom(e.target.value); setJoined(false); }} /></Field></div>
        <div className="flex flex-wrap gap-2 pb-6">
          <Button type="button" variant="secondary" onClick={() => { setRoom(randomRoom()); setJoined(false); }}>New room</Button>
          <Button type="button" disabled={!clean} onClick={() => setJoined(true)}>{joined ? "Rejoin" : "Start meeting"}</Button>
        </div>
      </div>
      <div className="flex flex-wrap items-center gap-2 text-sm"><span className="break-all font-mono">{link}</span><CopyButton value={link} label="Copy link" /><a href={link} target="_blank" rel="noopener noreferrer" className="text-accent hover:underline">Open in new tab</a></div>
      {joined && clean ? (
        <iframe key={clean} src={link} title="Video meeting" allow="camera; microphone; fullscreen; display-capture" allowFullScreen className="h-[70vh] min-h-96 w-full rounded-lg border border-[var(--border)]" />
      ) : (
        <div className="flex h-64 items-center justify-center rounded-lg border border-dashed border-[var(--border)] text-sm text-[var(--muted)]">Press Start meeting to join the room.</div>
      )}
      <p className="text-xs text-[var(--muted)]">Meetings are hosted by Jitsi Meet, a free open-source service.</p>
    </div>
  );
}
