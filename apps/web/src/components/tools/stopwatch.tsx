"use client";
import { useEffect, useRef, useState } from "react";
import { Flag, Pause, Play, RotateCcw } from "lucide-react";
import { Button } from "@/components/ui";

const show = (ms: number) => {
  const cs = Math.floor(ms / 10) % 100, s = Math.floor(ms / 1000) % 60, m = Math.floor(ms / 60000) % 60, h = Math.floor(ms / 3600000);
  const p = (n: number) => String(n).padStart(2, "0");
  return `${h ? `${h}:` : ""}${p(m)}:${p(s)}.${p(cs)}`;
};

export default function Stopwatch() {
  const [elapsed, setElapsed] = useState(0);
  const [running, setRunning] = useState(false);
  const [laps, setLaps] = useState<number[]>([]);
  const start = useRef(0);
  const base = useRef(0);
  const raf = useRef(0);

  useEffect(() => {
    if (!running) return;
    start.current = performance.now();
    const tick = () => { setElapsed(base.current + performance.now() - start.current); raf.current = requestAnimationFrame(tick); };
    raf.current = requestAnimationFrame(tick);
    return () => { cancelAnimationFrame(raf.current); base.current += performance.now() - start.current; };
  }, [running]);

  const now = () => (running ? base.current + performance.now() - start.current : base.current);
  const toggle = () => setRunning((r) => !r);
  const lap = () => { if (running) setLaps((l) => [...l, now()]); };
  const reset = () => { setRunning(false); base.current = 0; setElapsed(0); setLaps([]); };

  useEffect(() => {
    const onKey = (e: KeyboardEvent) => {
      const t = e.target as HTMLElement;
      if (e.code !== "Space" || /^(INPUT|TEXTAREA|SELECT|BUTTON)$/.test(t.tagName) || t.isContentEditable) return;
      e.preventDefault(); toggle();
    };
    window.addEventListener("keydown", onKey);
    return () => window.removeEventListener("keydown", onKey);
  }, []);

  return (
    <div className="space-y-6 text-center">
      <div className="font-mono text-5xl font-bold tabular-nums sm:text-7xl" role="timer" aria-live="off">{show(elapsed)}</div>
      <div className="flex flex-wrap justify-center gap-2">
        <Button type="button" onClick={toggle}>{running ? <><Pause className="size-4" aria-hidden /> Pause</> : <><Play className="size-4" aria-hidden /> Start</>}</Button>
        <Button type="button" variant="secondary" onClick={lap} disabled={!running}><Flag className="size-4" aria-hidden /> Lap</Button>
        <Button type="button" variant="secondary" onClick={reset} disabled={!elapsed && !laps.length}><RotateCcw className="size-4" aria-hidden /> Reset</Button>
      </div>
      <p className="text-xs text-[var(--muted)]">Tip: press the space bar to start or pause.</p>
      {laps.length > 0 && (
        <ol className="mx-auto max-w-md divide-y divide-[var(--border)] rounded-lg border border-[var(--border)] text-sm">
          <li className="grid grid-cols-3 gap-2 bg-[var(--bg-subtle)] px-3 py-2 text-xs font-medium text-[var(--muted)]"><span className="text-left">Lap</span><span>Split</span><span className="text-right">Total</span></li>
          {laps.map((t, i) => ({ t, i })).reverse().map(({ t, i }) => (
            <li key={i} className="grid grid-cols-3 gap-2 px-3 py-2 font-mono tabular-nums">
              <span className="text-left">{i + 1}</span><span>{show(t - (laps[i - 1] ?? 0))}</span><span className="text-right">{show(t)}</span>
            </li>
          ))}
        </ol>
      )}
    </div>
  );
}
