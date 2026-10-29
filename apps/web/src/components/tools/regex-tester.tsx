"use client";
import { useMemo, useState } from "react";
import { Alert, Field, Input } from "@/components/ui";
import { TextArea } from "./shared";

export default function RegexTester() {
  const [pattern, setPattern] = useState("(\\w+)@(\\w+)\\.com");
  const [flags, setFlags] = useState("g");
  const [text, setText] = useState("Email anna@example.com or bob@test.com for help.");
  const res = useMemo(() => {
    try {
      const re = new RegExp(pattern, flags.includes("g") ? flags : flags + "g");
      const matches = pattern ? [...text.matchAll(re)].filter((m) => m[0] !== "" || true).slice(0, 500) : [];
      return { matches, err: "" };
    } catch (e) { return { matches: [] as RegExpMatchArray[], err: e instanceof Error ? e.message : "Invalid pattern" }; }
  }, [pattern, flags, text]);
  const parts: React.ReactNode[] = []; let last = 0;
  res.matches.forEach((m, i) => { const s = m.index ?? 0; if (m[0] === "") return; parts.push(text.slice(last, s)); parts.push(<mark key={i} className="rounded bg-accent/25 text-inherit">{m[0]}</mark>); last = s + m[0].length; });
  parts.push(text.slice(last));
  return (
    <div className="space-y-4">
      <div className="grid gap-3 sm:grid-cols-[1fr_120px]">
        <Field label="Pattern"><Input className="font-mono" value={pattern} onChange={(e) => setPattern(e.target.value)} /></Field>
        <Field label="Flags"><Input className="font-mono" value={flags} onChange={(e) => setFlags(e.target.value.replace(/[^dgimsuyv]/g, ""))} /></Field>
      </div>
      {res.err && <Alert>{res.err}</Alert>}
      <label className="block space-y-1.5"><span className="text-sm font-medium">Test text</span><TextArea className="min-h-28" value={text} onChange={(e) => setText(e.target.value)} /></label>
      <div><div className="text-sm font-medium">Highlighted ({res.matches.filter((m) => m[0]).length} matches)</div><div className="mt-1.5 whitespace-pre-wrap break-words rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] p-3 font-mono text-sm">{parts}</div></div>
      {res.matches.length > 0 && (
        <div className="overflow-x-auto"><table className="w-full text-left font-mono text-sm"><thead><tr className="border-b border-[var(--border)] font-sans"><th className="py-1">#</th><th>Match</th><th>Index</th><th>Groups</th></tr></thead>
          <tbody>{res.matches.map((m, i) => <tr key={i} className="border-b border-[var(--border)]"><td className="py-1">{i + 1}</td><td>{m[0]}</td><td>{m.index}</td><td>{m.slice(1).map((g) => g ?? "").join(", ")}</td></tr>)}</tbody></table></div>
      )}
    </div>
  );
}
