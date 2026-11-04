"use client";
import { useEffect, useRef, useState } from "react";
import { Pause, Play, RotateCcw } from "lucide-react";
import { Button, Field, Input } from "@/components/ui";

function beep() {
  try {
    const Ctx = window.AudioContext || (window as unknown as { webkitAudioContext: typeof AudioContext }).webkitAudioContext;
    const ctx = new Ctx(); [0, 0.3, 0.6, 0.9].forEach((t) => { const o = ctx.createOscillator(), g = ctx.createGain(); o.frequency.value = 880; g.gain.setValueAtTime(0.2, ctx.currentTime + t); g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + t + 0.25); o.connect(g).connect(ctx.destination); o.start(ctx.currentTime + t); o.stop(ctx.currentTime + t + 0.25); });
    setTimeout(() => ctx.close(), 2000);
  } catch { /* audio not available */ }
}

const show = (ms: number) => {
  const t = Math.ceil(ms / 1000), d = Math.floor(t / 86400), h = Math.floor(t / 3600) % 24, m = Math.floor(t / 60) % 60, s = t % 60;
  const p = (n: number) => String(n).padStart(2, "0");
  return `${d ? `${d}d ` : ""}${d || h ? `${p(h)}:` : ""}${p(m)}:${p(s)}`;
};
const PRESETS = [1, 5, 10, 15, 30];

export default function CountdownTimer() {
  const [mode, setMode] = useState<"duration" | "date">("duration");
  const [hh, setHh] = useState("0");
  const [mm, setMm] = useState("5");
  const [ss, setSs] = useState("0");
  const [until, setUntil] = useState("");
  const [total, setTotal] = useState(5 * 60000);
  const [left, setLeft] = useState(5 * 60000);
  const [running, setRunning] = useState(false);
  const [finished, setFinished] = useState(false);
  const end = useRef(0);
  const baseTitle = useRef("");
  useEffect(() => { baseTitle.current = document.title; return () => { document.title = baseTitle.current; }; }, []);

  const dur = (h = hh, m = mm, s = ss) => Math.max(0, ((parseFloat(h) || 0) * 3600 + (parseFloat(m) || 0) * 60 + (parseFloat(s) || 0)) * 1000);
  const setDuration = (h: string, m: string, s: string) => { setHh(h); setMm(m); setSs(s); if (!running) { const d = dur(h, m, s); setTotal(d); setLeft(d); setFinished(false); } };

  useEffect(() => {
    if (!running) return;
    if (mode === "duration") end.current = Date.now() + left;
    const id = setInterval(() => {
      const l = Math.max(0, end.current - Date.now());
      setLeft(l);
      if (l === 0) { clearInterval(id); setRunning(false); setFinished(true); beep(); }
    }, 200);
    return () => clearInterval(id);
  }, [running]); // eslint-disable-line react-hooks/exhaustive-deps

  useEffect(() => { if (baseTitle.current) document.title = running ? `${show(left)} left` : finished ? "Time's up!" : baseTitle.current; }, [left, running, finished]);

  const start = () => {
    setFinished(false);
    if (mode === "date") {
      const t = new Date(until).getTime();
      if (!until || !Number.isFinite(t) || t <= Date.now()) return;
      end.current = t; const l = t - Date.now(); setTotal(l); setLeft(l); setRunning(true); return;
    }
    if (left <= 0) { const d = dur(); if (!d) return; setTotal(d); setLeft(d); }
    setRunning(true);
  };
  const reset = () => { setRunning(false); setFinished(false); const d = mode === "duration" ? dur() : 0; setTotal(d); setLeft(d); };
  const switchMode = (m: "duration" | "date") => { setRunning(false); setFinished(false); setMode(m); const d = m === "duration" ? dur() : 0; setTotal(d); setLeft(d); };

  const frac = total > 0 ? left / total : 0;
  const R = 90, C = 2 * Math.PI * R;
  const dateInvalid = mode === "date" && (!until || new Date(until).getTime() <= Date.now());

  return (
    <div className="space-y-6 text-center">
      <div className="flex flex-wrap justify-center gap-2" role="tablist" aria-label="Timer type">
        <Button type="button" role="tab" aria-selected={mode === "duration"} variant={mode === "duration" ? "primary" : "secondary"} onClick={() => switchMode("duration")}>Duration</Button>
        <Button type="button" role="tab" aria-selected={mode === "date"} variant={mode === "date" ? "primary" : "secondary"} onClick={() => switchMode("date")}>Until a date</Button>
      </div>

      <div className="relative mx-auto aspect-square w-full max-w-[260px]">
        <svg viewBox="0 0 200 200" className="size-full -rotate-90" aria-hidden>
          <circle cx="100" cy="100" r={R} fill="none" stroke="var(--border)" strokeWidth="10" />
          <circle cx="100" cy="100" r={R} fill="none" stroke="currentColor" className="text-accent transition-[stroke-dashoffset] duration-200" strokeWidth="10" strokeLinecap="round" strokeDasharray={C} strokeDashoffset={C * (1 - frac)} />
        </svg>
        <div className="absolute inset-0 flex flex-col items-center justify-center px-6">
          <div className={`font-mono font-bold tabular-nums ${left >= 86400000 ? "text-2xl" : left >= 3600000 ? "text-3xl" : "text-5xl"}`} role="timer" aria-live="off">{show(left)}</div>
          {finished && <div className="mt-1 text-sm font-semibold text-accent" role="status">Time&apos;s up!</div>}
        </div>
      </div>

      <div className="flex flex-wrap justify-center gap-2">
        <Button type="button" onClick={() => (running ? setRunning(false) : start())} disabled={!running && (mode === "date" ? dateInvalid : !left && !dur())}>
          {running ? <><Pause className="size-4" aria-hidden /> Pause</> : <><Play className="size-4" aria-hidden /> Start</>}
        </Button>
        <Button type="button" variant="secondary" onClick={reset}><RotateCcw className="size-4" aria-hidden /> Reset</Button>
      </div>

      {mode === "duration" ? (
        <div className="mx-auto max-w-md space-y-4 text-left">
          <div className="flex flex-wrap justify-center gap-2">
            {PRESETS.map((p) => <Button key={p} type="button" variant="secondary" className="h-8 px-3 text-xs" disabled={running} onClick={() => setDuration("0", String(p), "0")}>{p} min</Button>)}
          </div>
          <div className="grid grid-cols-3 gap-3">
            <Field label="Hours"><Input type="number" min={0} max={99} value={hh} disabled={running} onChange={(e) => setDuration(e.target.value, mm, ss)} /></Field>
            <Field label="Minutes"><Input type="number" min={0} max={59} value={mm} disabled={running} onChange={(e) => setDuration(hh, e.target.value, ss)} /></Field>
            <Field label="Seconds"><Input type="number" min={0} max={59} value={ss} disabled={running} onChange={(e) => setDuration(hh, mm, e.target.value)} /></Field>
          </div>
        </div>
      ) : (
        <div className="mx-auto max-w-xs text-left">
          <Field label="Count down to" hint={until && dateInvalid ? "Pick a time in the future." : "Uses your local time zone."}>
            <Input type="datetime-local" value={until} disabled={running} onChange={(e) => setUntil(e.target.value)} />
          </Field>
        </div>
      )}
    </div>
  );
}
