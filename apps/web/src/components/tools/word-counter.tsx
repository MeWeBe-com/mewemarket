"use client";
import { useState } from "react";
import { Stat, TextArea } from "./shared";

export default function WordCounter() {
  const [text, setText] = useState("");
  const words = text.match(/[\p{L}\p{N}'’-]+/gu) ?? [];
  const sentences = text.split(/[.!?]+(?:\s|$)/).filter((s) => s.trim()).length;
  const paras = text.split(/\n\s*\n/).filter((s) => s.trim()).length;
  const mins = words.length / 225;
  const freq = new Map<string, number>();
  words.forEach((w) => { const k = w.toLowerCase(); if (k.length > 3) freq.set(k, (freq.get(k) ?? 0) + 1); });
  const top = [...freq].sort((x, y) => y[1] - x[1]).slice(0, 8);
  return (
    <div className="space-y-4">
      <label className="block space-y-1.5"><span className="text-sm font-medium">Your text</span><TextArea className="min-h-56 font-sans" placeholder="Start typing or paste text here" value={text} onChange={(e) => setText(e.target.value)} /></label>
      <div className="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6" aria-live="polite">
        <Stat label="Words" value={words.length} />
        <Stat label="Characters" value={text.length} />
        <Stat label="No spaces" value={text.replace(/\s/g, "").length} />
        <Stat label="Sentences" value={sentences} />
        <Stat label="Paragraphs" value={paras} />
        <Stat label="Reading time" value={mins < 1 ? `${Math.ceil(mins * 60)} sec` : `${Math.ceil(mins)} min`} />
      </div>
      {top.length > 0 && <p className="text-sm text-[var(--muted)]">Top words: {top.map(([w, c]) => `${w} (${c})`).join(", ")}</p>}
    </div>
  );
}
