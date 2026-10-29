"use client";
import { useCallback, useEffect, useState } from "react";
import { RefreshCw } from "lucide-react";
import { Button } from "@/components/ui";
import { CopyButton } from "./shared";

const SETS = { lower: "abcdefghijklmnopqrstuvwxyz", upper: "ABCDEFGHIJKLMNOPQRSTUVWXYZ", digits: "0123456789", symbols: "!@#$%^&*()-_=+[]{};:,.?/" };
type K = keyof typeof SETS;
const LABELS: Record<K, string> = { lower: "Lower case (a-z)", upper: "Upper case (A-Z)", digits: "Numbers (0-9)", symbols: "Symbols (!@#)" };

const rand = (n: number) => { const max = Math.floor(0x100000000 / n) * n; const a = new Uint32Array(1); do crypto.getRandomValues(a); while (a[0]! >= max); return a[0]! % n; };

export default function PasswordGenerator() {
  const [len, setLen] = useState(20);
  const [opts, setOpts] = useState<Record<K, boolean>>({ lower: true, upper: true, digits: true, symbols: true });
  const [pw, setPw] = useState("");
  const pool = (Object.keys(SETS) as K[]).filter((k) => opts[k]).map((k) => SETS[k]).join("");
  const gen = useCallback(() => { setPw(pool ? Array.from({ length: len }, () => pool[rand(pool.length)]).join("") : ""); }, [pool, len]);
  useEffect(gen, [gen]);
  const bits = pool ? Math.round(len * Math.log2(pool.length)) : 0;
  const strength = bits < 40 ? "Weak" : bits < 70 ? "Fair" : bits < 100 ? "Strong" : "Very strong";
  return (
    <div className="space-y-5">
      <div className="flex items-center gap-2 rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] p-3">
        <output aria-label="Generated password" className="min-w-0 flex-1 break-all font-mono text-lg">{pw || "Pick at least one character set"}</output>
        <Button type="button" variant="ghost" className="h-8 px-2" aria-label="Generate new password" onClick={gen}><RefreshCw className="size-4" aria-hidden /></Button>
        <CopyButton value={pw} />
      </div>
      <p className="text-sm text-[var(--muted)]">Strength: <strong className="text-[var(--fg)]">{strength}</strong> (about {bits} bits)</p>
      <label className="block space-y-1.5 text-sm font-medium">Length: {len}<input type="range" min={4} max={128} value={len} onChange={(e) => setLen(Number(e.target.value))} className="w-full" /></label>
      <fieldset className="grid gap-2 sm:grid-cols-2"><legend className="sr-only">Characters</legend>
        {(Object.keys(SETS) as K[]).map((k) => (
          <label key={k} className="flex items-center gap-2 text-sm"><input type="checkbox" checked={opts[k]} onChange={(e) => setOpts({ ...opts, [k]: e.target.checked })} /> {LABELS[k]}</label>
        ))}
      </fieldset>
    </div>
  );
}
