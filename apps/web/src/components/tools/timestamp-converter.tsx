"use client";
import { useState } from "react";
import { Button, Field, Input } from "@/components/ui";
import { Output } from "./shared";

export default function TimestampConverter() {
  const [ts, setTs] = useState(() => String(Math.floor(Date.now() / 1000)));
  const [local, setLocal] = useState("");
  const n = Number(ts.trim());
  const ms = ts.trim().length > 11 ? n : n * 1000;
  const d = new Date(ms);
  const valid = ts.trim() !== "" && Number.isFinite(n) && !isNaN(d.getTime());
  const ld = local ? new Date(local) : null;
  return (
    <div className="space-y-8">
      <section className="space-y-4">
        <div className="flex items-end gap-2">
          <div className="flex-1"><Field label="Unix timestamp (seconds or milliseconds)"><Input inputMode="numeric" value={ts} onChange={(e) => setTs(e.target.value)} /></Field></div>
          <Button type="button" variant="secondary" onClick={() => setTs(String(Math.floor(Date.now() / 1000)))}>Now</Button>
        </div>
        {valid ? (
          <div className="grid gap-4 sm:grid-cols-2">
            <Output label="UTC" value={d.toUTCString()} mono={false} />
            <Output label="Your local time" value={d.toLocaleString(undefined, { dateStyle: "full", timeStyle: "long" })} mono={false} />
            <Output label="ISO 8601" value={d.toISOString()} />
            <Output label="Milliseconds" value={String(ms)} />
          </div>
        ) : <p className="text-sm text-[var(--muted)]">Enter a number to convert.</p>}
      </section>
      <section className="space-y-4 border-t border-[var(--border)] pt-6">
        <Field label="Date and time (your local time)"><Input type="datetime-local" step="1" value={local} onChange={(e) => setLocal(e.target.value)} /></Field>
        {ld && !isNaN(ld.getTime()) && (
          <div className="grid gap-4 sm:grid-cols-2">
            <Output label="Seconds" value={String(Math.floor(ld.getTime() / 1000))} />
            <Output label="Milliseconds" value={String(ld.getTime())} />
          </div>
        )}
      </section>
    </div>
  );
}
