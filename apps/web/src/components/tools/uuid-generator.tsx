"use client";
import { useEffect, useState } from "react";
import { Button, Field, Input } from "@/components/ui";
import { Output } from "./shared";

const uuid = () => {
  if (typeof crypto.randomUUID === "function") return crypto.randomUUID();
  const b = crypto.getRandomValues(new Uint8Array(16)); b[6] = (b[6]! & 0x0f) | 0x40; b[8] = (b[8]! & 0x3f) | 0x80;
  const h = Array.from(b, (x) => x.toString(16).padStart(2, "0")).join("");
  return `${h.slice(0, 8)}-${h.slice(8, 12)}-${h.slice(12, 16)}-${h.slice(16, 20)}-${h.slice(20)}`;
};

export default function UuidGenerator() {
  const [count, setCount] = useState("5");
  const [upper, setUpper] = useState(false);
  const [list, setList] = useState<string[]>([]);
  const gen = () => setList(Array.from({ length: Math.min(1000, Math.max(1, parseInt(count) || 1)) }, uuid));
  useEffect(gen, []); // eslint-disable-line react-hooks/exhaustive-deps
  const text = list.map((u) => (upper ? u.toUpperCase() : u)).join("\n");
  return (
    <div className="space-y-4">
      <div className="flex flex-wrap items-end gap-3">
        <div className="w-32"><Field label="How many"><Input type="number" min={1} max={1000} value={count} onChange={(e) => setCount(e.target.value)} /></Field></div>
        <label className="flex h-10 items-center gap-2 text-sm"><input type="checkbox" checked={upper} onChange={(e) => setUpper(e.target.checked)} /> Upper case</label>
        <Button type="button" onClick={gen}>Generate</Button>
      </div>
      <Output label="UUIDs" value={text} />
    </div>
  );
}
