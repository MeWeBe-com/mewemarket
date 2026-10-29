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
  const clean = room.replace(/[^A-Za-z0-9-_]/g, "");
  const link = `https://meet.jit.si/${clean}`;
  // meet.jit.si only allows short embedded calls and needs the host to sign in, so meetings open in their own tab.
  return (
    <div className="space-y-4">
      <div className="flex flex-wrap items-end gap-2">
        <div className="min-w-56 flex-1"><Field label="Room name" hint="Anyone with the link can join."><Input value={room} onChange={(e) => setRoom(e.target.value)} /></Field></div>
        <div className="flex flex-wrap gap-2 pb-6">
          <Button type="button" variant="secondary" onClick={() => setRoom(randomRoom())}>New room</Button>
          <Button type="button" disabled={!clean} onClick={() => window.open(link, "_blank", "noopener,noreferrer")}>Start meeting</Button>
        </div>
      </div>
      <div className="flex flex-wrap items-center gap-2 text-sm"><span className="break-all font-mono">{link}</span><CopyButton value={link} label="Copy link" /></div>
      <ol className="list-decimal space-y-1 rounded-lg border border-[var(--border)] p-4 pl-8 text-sm">
        <li>Press <strong>Start meeting</strong>. The meeting opens in a new tab.</li>
        <li>The host presses <strong>Log-in</strong> on the meeting page and signs in with Google, GitHub or Facebook. This starts the meeting.</li>
        <li>Share the link. Guests join without signing in.</li>
        <li>Allow camera and microphone when your browser asks.</li>
      </ol>
      <p className="text-xs text-[var(--muted)]">Meetings are hosted by Jitsi Meet, a free open-source service.</p>
    </div>
  );
}
