"use client";
import { useState } from "react";
import { Coins, Dices, RotateCcw } from "lucide-react";
import { Button, Field } from "@/components/ui";
import { Select, Stat } from "./shared";

const rand = (n: number) => { const a = new Uint32Array(1); const lim = Math.floor(0x100000000 / n) * n; do crypto.getRandomValues(a); while (a[0]! >= lim); return a[0]! % n; };
const SIDES = [4, 6, 8, 10, 12, 20];
type Roll = { label: string; detail: string };

export default function CoinDice() {
  const [coin, setCoin] = useState<"Heads" | "Tails" | null>(null);
  const [counts, setCounts] = useState({ Heads: 0, Tails: 0 });
  const [qty, setQty] = useState(2);
  const [sides, setSides] = useState(6);
  const [dice, setDice] = useState<number[]>([]);
  const [history, setHistory] = useState<Roll[]>([]);
  const [anim, setAnim] = useState(0);

  const add = (r: Roll) => setHistory((h) => [r, ...h].slice(0, 20));
  const flip = () => {
    const r = rand(2) ? "Heads" : "Tails";
    setCoin(r); setCounts((c) => ({ ...c, [r]: c[r] + 1 })); setAnim((a) => a + 1);
    add({ label: "Coin", detail: r });
  };
  const roll = () => {
    const d = Array.from({ length: qty }, () => rand(sides) + 1);
    setDice(d); setAnim((a) => a + 1);
    add({ label: `${qty}d${sides}`, detail: `${d.join(" + ")} = ${d.reduce((a, b) => a + b, 0)}` });
  };
  const total = dice.reduce((a, b) => a + b, 0);

  return (
    <div className="space-y-6">
      <div className="grid gap-6 md:grid-cols-2">
        <section className="space-y-4 rounded-lg border border-[var(--border)] p-4 text-center">
          <h3 className="font-semibold">Coin flip</h3>
          <div key={`c${anim}`} className="mx-auto flex size-28 animate-[spin_0.4s_ease-out_1] items-center justify-center rounded-full border-4 border-amber-400 bg-amber-300/30 text-lg font-bold" aria-live="polite">{coin ?? "?"}</div>
          <Button type="button" onClick={flip}><Coins className="size-4" aria-hidden /> Flip coin</Button>
          <div className="grid grid-cols-2 gap-3"><Stat label="Heads" value={counts.Heads} /><Stat label="Tails" value={counts.Tails} /></div>
        </section>
        <section className="space-y-4 rounded-lg border border-[var(--border)] p-4">
          <h3 className="text-center font-semibold">Dice roller</h3>
          <div className="grid grid-cols-2 gap-3">
            <Field label="Number of dice"><Select value={qty} onChange={(e) => setQty(+e.target.value)}>{Array.from({ length: 10 }, (_, i) => <option key={i} value={i + 1}>{i + 1}</option>)}</Select></Field>
            <Field label="Dice type"><Select value={sides} onChange={(e) => setSides(+e.target.value)}>{SIDES.map((s) => <option key={s} value={s}>d{s}</option>)}</Select></Field>
          </div>
          <div key={`d${anim}`} className="flex min-h-14 flex-wrap justify-center gap-2" aria-live="polite">
            {dice.length ? dice.map((d, i) => <span key={i} className="flex size-12 animate-[bounce_0.4s_ease-out_1] items-center justify-center rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] font-mono text-lg font-bold">{d}</span>) : <span className="self-center text-sm text-[var(--muted)]">Roll to see the dice.</span>}
          </div>
          <div className="flex items-center justify-between gap-2">
            <Button type="button" onClick={roll}><Dices className="size-4" aria-hidden /> Roll</Button>
            {dice.length > 0 && <span className="text-sm">Total: <strong className="text-lg">{total}</strong></span>}
          </div>
        </section>
      </div>
      {history.length > 0 && (
        <div className="space-y-2">
          <div className="flex items-center justify-between"><span className="text-sm font-medium">History</span><Button type="button" variant="ghost" className="h-8 px-3 text-xs" onClick={() => { setHistory([]); setCounts({ Heads: 0, Tails: 0 }); setCoin(null); setDice([]); }}><RotateCcw className="size-3.5" aria-hidden /> Clear</Button></div>
          <ul className="divide-y divide-[var(--border)] rounded-lg border border-[var(--border)] text-sm">
            {history.map((h, i) => <li key={history.length - i} className="flex gap-3 px-3 py-2"><span className="w-14 shrink-0 text-[var(--muted)]">{h.label}</span><span className="min-w-0 break-words font-mono">{h.detail}</span></li>)}
          </ul>
        </div>
      )}
    </div>
  );
}
