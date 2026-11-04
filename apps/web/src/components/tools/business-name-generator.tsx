"use client";
import { useState } from "react";
import { Sparkles } from "lucide-react";
import { Button, Field, Input } from "@/components/ui";
import { CopyButton } from "./shared";

type Style = "Modern" | "Classic" | "Playful" | "Techy";
const WORDS: Record<Style, { pre: string[]; suf: string[]; tails: string[] }> = {
  Modern: { pre: ["Nova", "Studio", "Pure", "True", "North", "Bold", "Bright", "Clear"], suf: ["ly", "io", "ify", "hub", "co", "lab"], tails: ["Studio", "Collective", "House", "Supply", "Works", "Lab"] },
  Classic: { pre: ["Royal", "Heritage", "Golden", "Oak", "Crown", "Sterling", "Grand", "First"], suf: ["field", "wood", "stone", "ford", "well", "worth"], tails: ["& Co.", "Brothers", "Company", "Trading", "Guild", "Partners"] },
  Playful: { pre: ["Happy", "Little", "Sunny", "Jolly", "Bubbly", "Cheeky", "Busy", "Lucky"], suf: ["oo", "y", "ito", "ster", "zy", "pop"], tails: ["Box", "Nest", "Club", "Corner", "Party", "Patch"] },
  Techy: { pre: ["Cyber", "Quantum", "Pixel", "Byte", "Smart", "Neo", "Data", "Cloud"], suf: ["ify", "ly", "io", "ex", "ware", "flow"], tails: ["Labs", "Systems", "AI", "Tech", "Logic", "Stack"] },
};

const cap = (s: string) => s.charAt(0).toUpperCase() + s.slice(1).toLowerCase();

function generate(keywords: string, style: Style, seed: number): string[] {
  const kws = keywords.split(/[,\s]+/).map((k) => k.replace(/[^a-z0-9]/gi, "")).filter(Boolean).map(cap);
  if (!kws.length) return [];
  const w = WORDS[style];
  // Small deterministic PRNG so the first list is stable; "More ideas" bumps the seed.
  let s = seed * 9301 + 49297;
  const rnd = () => { s = (s * 9301 + 49297) % 233280; return s / 233280; };
  const pick = <T,>(a: T[]) => a[Math.floor(rnd() * a.length)] as T;
  const patterns: (() => string)[] = [
    () => `${pick(w.pre)}${pick(kws)}`,
    () => `${pick(kws)} ${pick(w.tails)}`,
    () => `${pick(kws)}${pick(w.suf)}`,
    () => `${pick(w.pre)} ${pick(kws)} ${pick(w.tails)}`,
    () => (kws.length > 1 ? `${pick(kws)}${pick(kws)}` : `${pick(kws)}${pick(w.suf)}`),
    () => `The ${pick(kws)} ${pick(w.tails)}`,
    () => { const k = pick(kws); return `${k.slice(0, Math.max(3, Math.ceil(k.length / 2)))}${pick(w.suf)}`; },
    () => `${pick(w.pre)}${pick(w.suf)} ${pick(kws)}`,
  ];
  const out = new Set<string>();
  for (let i = 0; out.size < 24 && i < 400; i++) out.add(patterns[i % patterns.length]!().replace(/\s+/g, " ").trim());
  return [...out];
}

export default function BusinessNameGenerator() {
  const [keywords, setKeywords] = useState("coffee, bean");
  const [style, setStyle] = useState<Style>("Modern");
  const [seed, setSeed] = useState(1);
  const names = generate(keywords, style, seed);

  return (
    <div className="space-y-5">
      <Field label="Keywords" hint="Separate words with commas or spaces."><Input value={keywords} onChange={(e) => setKeywords(e.target.value)} placeholder="e.g. bakery, sweet" /></Field>
      <div className="flex flex-wrap gap-2">
        {(Object.keys(WORDS) as Style[]).map((s) => (
          <Button key={s} type="button" variant={style === s ? "primary" : "secondary"} aria-pressed={style === s} onClick={() => setStyle(s)}>{s}</Button>
        ))}
      </div>
      <Button type="button" variant="secondary" disabled={!names.length} onClick={() => setSeed(Math.floor(Math.random() * 100000) + 2)}><Sparkles className="size-4" aria-hidden /> More ideas</Button>
      {names.length ? (
        <ul className="grid gap-2 sm:grid-cols-2" aria-live="polite">
          {names.map((n) => (
            <li key={n} className="flex items-center justify-between gap-2 rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] p-3">
              <span className="min-w-0 font-semibold break-words">{n}</span>
              <CopyButton value={n} />
            </li>
          ))}
        </ul>
      ) : <p className="text-sm text-[var(--muted)]">Type a keyword or two to see name ideas.</p>}
    </div>
  );
}
