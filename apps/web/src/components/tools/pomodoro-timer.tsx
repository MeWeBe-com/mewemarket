"use client";
import { useEffect, useRef, useState } from "react";
import { Pause, Play, RotateCcw, SkipForward } from "lucide-react";
import { Button, Field, Input } from "@/components/ui";

type Mode = "work" | "short" | "long";
const LABEL: Record<Mode, string> = { work: "Focus", short: "Short break", long: "Long break" };

function beep() {
  try {
    const Ctx = window.AudioContext || (window as unknown as { webkitAudioContext: typeof AudioContext }).webkitAudioContext;
    const ctx = new Ctx(); [0, 0.3, 0.6].forEach((t) => { const o = ctx.createOscillator(), g = ctx.createGain(); o.frequency.value = 880; g.gain.setValueAtTime(0.2, ctx.currentTime + t); g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + t + 0.25); o.connect(g).connect(ctx.destination); o.start(ctx.currentTime + t); o.stop(ctx.currentTime + t + 0.25); });
    setTimeout(() => ctx.close(), 1500);
  } catch { /* audio not available */ }
}

export default function PomodoroTimer() {
  const [mins, setMins] = useState<Record<Mode, string>>({ work: "25", short: "5", long: "15" });
  const [mode, setMode] = useState<Mode>("work");
  const [left, setLeft] = useState(25 * 60);
  const [running, setRunning] = useState(false);
  const [done, setDone] = useState(0);
  const end = useRef(0);
  const baseTitle = useRef("");
  useEffect(() => { baseTitle.current = document.title; return () => { document.title = baseTitle.current; }; }, []);
  const len = (m: Mode) => Math.max(1, Math.round(parseFloat(mins[m]) || 1)) * 60;

  const switchTo = (m: Mode) => { setMode(m); setLeft(len(m)); setRunning(false); };
  const next = () => {
    if (mode === "work") { const n = done + 1; setDone(n); switchTo(n % 4 === 0 ? "long" : "short"); } else switchTo("work");
  };

  useEffect(() => {
    if (!running) return;
    end.current = Date.now() + left * 1000;
    const id = setInterval(() => {
      const s = Math.max(0, Math.round((end.current - Date.now()) / 1000));
      setLeft(s);
      if (s === 0) { clearInterval(id); beep(); next(); }
    }, 250);
    return () => clearInterval(id);
  }, [running]); // eslint-disable-line react-hooks/exhaustive-deps

  const mm = String(Math.floor(left / 60)).padStart(2, "0"), ss = String(left % 60).padStart(2, "0");
  useEffect(() => { if (baseTitle.current) document.title = running ? `${mm}:${ss} ${LABEL[mode]}` : baseTitle.current; }, [mm, ss, running, mode]);
  return (
    <div className="space-y-6 text-center">
      <div className="flex flex-wrap justify-center gap-2" role="tablist" aria-label="Session type">
        {(Object.keys(LABEL) as Mode[]).map((m) => <Button key={m} type="button" role="tab" aria-selected={mode === m} variant={mode === m ? "primary" : "secondary"} onClick={() => switchTo(m)}>{LABEL[m]}</Button>)}
      </div>
      <div className="font-mono text-7xl font-bold tabular-nums sm:text-8xl" role="timer" aria-live="off" aria-label={`${mm} minutes ${ss} seconds left`}>{mm}:{ss}</div>
      <div className="flex justify-center gap-2">
        <Button type="button" onClick={() => setRunning(!running)}>{running ? <><Pause className="size-4" aria-hidden /> Pause</> : <><Play className="size-4" aria-hidden /> Start</>}</Button>
        <Button type="button" variant="secondary" onClick={() => { setRunning(false); setLeft(len(mode)); }}><RotateCcw className="size-4" aria-hidden /> Reset</Button>
        <Button type="button" variant="secondary" onClick={next}><SkipForward className="size-4" aria-hidden /> Skip</Button>
      </div>
      <p className="text-sm text-[var(--muted)]">Focus sessions completed: <strong className="text-[var(--fg)]">{done}</strong></p>
      <div className="mx-auto grid max-w-md grid-cols-3 gap-3 text-left">
        {(Object.keys(LABEL) as Mode[]).map((m) => (
          <Field key={m} label={`${LABEL[m]} (min)`}><Input type="number" min={1} max={180} value={mins[m]} onChange={(e) => { setMins({ ...mins, [m]: e.target.value }); if (m === mode && !running) setLeft(Math.max(1, Math.round(parseFloat(e.target.value) || 1)) * 60); }} /></Field>
        ))}
      </div>
    </div>
  );
}
