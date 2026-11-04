"use client";
import { useEffect, useRef, useState } from "react";
import { Shuffle, Trophy, Users } from "lucide-react";
import { Button, Field, Input } from "@/components/ui";
import { CopyButton, TextArea } from "./shared";

const rand = (n: number) => { const a = new Uint32Array(1); const lim = Math.floor(0x100000000 / n) * n; do crypto.getRandomValues(a); while (a[0]! >= lim); return a[0]! % n; };
const shuffle = <T,>(arr: T[]) => { const a = [...arr]; for (let i = a.length - 1; i > 0; i--) { const j = rand(i + 1); [a[i], a[j]] = [a[j]!, a[i]!]; } return a; };

type Result = { kind: "winners" | "shuffle"; items: string[] } | { kind: "groups"; groups: string[][] };

export default function RandomPicker() {
  const [text, setText] = useState("Alice\nBob\nCharlie\nDiana\nEthan\nFiona");
  const [count, setCount] = useState("1");
  const [groups, setGroups] = useState("2");
  const [result, setResult] = useState<Result | null>(null);
  const [flash, setFlash] = useState("");
  const timer = useRef<ReturnType<typeof setInterval> | null>(null);
  useEffect(() => () => { if (timer.current) clearInterval(timer.current); }, []);

  const items = text.split("\n").map((s) => s.trim()).filter(Boolean);
  const n = Math.min(items.length, Math.max(1, Math.floor(parseFloat(count) || 1)));
  const g = Math.min(items.length, Math.max(2, Math.floor(parseFloat(groups) || 2)));

  const pick = () => {
    if (!items.length) return;
    if (timer.current) clearInterval(timer.current);
    setResult(null);
    let ticks = 0;
    timer.current = setInterval(() => {
      setFlash(items[rand(items.length)] ?? "");
      if (++ticks >= 12) { clearInterval(timer.current!); timer.current = null; setFlash(""); setResult({ kind: "winners", items: shuffle(items).slice(0, n) }); }
    }, 70);
  };
  const doShuffle = () => setResult({ kind: "shuffle", items: shuffle(items) });
  const split = () => { const s = shuffle(items); const out: string[][] = Array.from({ length: g }, () => []); s.forEach((x, i) => out[i % g]!.push(x)); setResult({ kind: "groups", groups: out }); };

  const copyText = !result ? "" : result.kind === "groups" ? result.groups.map((gr, i) => `Group ${i + 1}: ${gr.join(", ")}`).join("\n") : result.items.map((x, i) => `${i + 1}. ${x}`).join("\n");

  return (
    <div className="grid gap-6 md:grid-cols-2">
      <div className="space-y-4">
        <Field label="Names or items (one per line)" hint={`${items.length} item${items.length === 1 ? "" : "s"}`}>
          <TextArea className="min-h-56 font-sans" value={text} onChange={(e) => setText(e.target.value)} />
        </Field>
        <div className="grid grid-cols-2 gap-3">
          <Field label="How many winners"><Input type="number" min={1} max={items.length || 1} value={count} onChange={(e) => setCount(e.target.value)} /></Field>
          <Field label="Number of groups"><Input type="number" min={2} max={items.length || 2} value={groups} onChange={(e) => setGroups(e.target.value)} /></Field>
        </div>
        <div className="flex flex-wrap gap-2">
          <Button type="button" onClick={pick} disabled={!items.length}><Trophy className="size-4" aria-hidden /> Pick {n > 1 ? `${n} winners` : "a winner"}</Button>
          <Button type="button" variant="secondary" onClick={doShuffle} disabled={items.length < 2}><Shuffle className="size-4" aria-hidden /> Shuffle</Button>
          <Button type="button" variant="secondary" onClick={split} disabled={items.length < 2}><Users className="size-4" aria-hidden /> Split into {g} groups</Button>
        </div>
      </div>
      <div className="space-y-3">
        <div className="flex items-center justify-between gap-2">
          <span className="text-sm font-medium">Result</span>
          <CopyButton value={copyText} />
        </div>
        <div className="min-h-40 rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] p-4" aria-live="polite">
          {flash ? (
            <div className="flex h-32 items-center justify-center break-all text-2xl font-bold text-accent">{flash}</div>
          ) : !result ? (
            <p className="text-sm text-[var(--muted)]">Pick a winner, shuffle the list or split it into groups.</p>
          ) : result.kind === "groups" ? (
            <div className="grid gap-3 sm:grid-cols-2">
              {result.groups.map((gr, i) => (
                <div key={i} className="rounded-lg border border-[var(--border)] bg-[var(--card)] p-3">
                  <div className="mb-1 text-xs font-semibold text-[var(--muted)]">Group {i + 1} ({gr.length})</div>
                  <ul className="space-y-0.5 text-sm">{gr.map((x, j) => <li key={j} className="break-words">{x}</li>)}</ul>
                </div>
              ))}
            </div>
          ) : (
            <ol className="space-y-1">
              {result.items.map((x, i) => (
                <li key={i} className={`flex gap-2 break-words ${result.kind === "winners" ? "text-lg font-semibold" : "text-sm"}`}>
                  <span className="text-[var(--muted)] tabular-nums">{i + 1}.</span><span className="min-w-0">{x}</span>
                </li>
              ))}
            </ol>
          )}
        </div>
      </div>
    </div>
  );
}
