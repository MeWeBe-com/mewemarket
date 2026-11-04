"use client";
import { useEffect, useRef, useState } from "react";
import { Pause, Play, RotateCcw } from "lucide-react";
import { Button, Field, Input } from "@/components/ui";
import { Stat, fmt, num } from "./shared";

const clock = (ms: number) => {
  const s = Math.floor(ms / 1000);
  const hh = Math.floor(s / 3600), mm = Math.floor((s % 3600) / 60), ss = s % 60;
  return `${hh}:${String(mm).padStart(2, "0")}:${String(ss).padStart(2, "0")}`;
};

export default function MeetingCostCalculator() {
  const [people, setPeople] = useState("6");
  const [rateType, setRateType] = useState<"hourly" | "annual">("hourly");
  const [rate, setRate] = useState("50");
  const [hoursYear, setHoursYear] = useState("2080");
  const [minutes, setMinutes] = useState("60");
  const [running, setRunning] = useState(false);
  const [elapsed, setElapsed] = useState(0);
  const startRef = useRef(0);
  const baseRef = useRef(0);

  useEffect(() => {
    if (!running) return;
    startRef.current = Date.now();
    const t = setInterval(() => setElapsed(baseRef.current + Date.now() - startRef.current), 250);
    return () => { clearInterval(t); baseRef.current += Date.now() - startRef.current; };
  }, [running]);

  const hourly = rateType === "hourly" ? num(rate) : (num(hoursYear) > 0 ? num(rate) / num(hoursYear) : 0);
  const perHour = num(people) * hourly;
  const total = perHour * num(minutes) / 60;
  const live = perHour * elapsed / 3600000;

  return (
    <div className="space-y-5">
      <div className="flex flex-wrap gap-2">
        <Button type="button" variant={rateType === "hourly" ? "primary" : "secondary"} aria-pressed={rateType === "hourly"} onClick={() => setRateType("hourly")}>Hourly rate</Button>
        <Button type="button" variant={rateType === "annual" ? "primary" : "secondary"} aria-pressed={rateType === "annual"} onClick={() => setRateType("annual")}>Annual salary</Button>
      </div>
      <div className="grid gap-4 sm:grid-cols-2">
        <Field label="Number of attendees"><Input type="number" min={1} value={people} onChange={(e) => setPeople(e.target.value)} /></Field>
        <Field label={rateType === "hourly" ? "Average hourly rate" : "Average annual salary"}><Input type="number" min={0} value={rate} onChange={(e) => setRate(e.target.value)} /></Field>
        {rateType === "annual" && <Field label="Working hours per year" hint="40 hours × 52 weeks = 2080"><Input type="number" min={1} value={hoursYear} onChange={(e) => setHoursYear(e.target.value)} /></Field>}
        <Field label="Meeting length (minutes)"><Input type="number" min={0} value={minutes} onChange={(e) => setMinutes(e.target.value)} /></Field>
      </div>
      <div className="grid gap-3 sm:grid-cols-3" aria-live="polite">
        <Stat label="Total meeting cost" value={fmt(total)} />
        <Stat label="Cost per hour" value={fmt(perHour)} />
        <Stat label="Cost per minute" value={fmt(perHour / 60)} />
      </div>
      <div className="space-y-3 rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] p-4 text-center">
        <div className="text-sm font-medium">Live meeting timer</div>
        <div className="font-mono text-3xl font-bold tabular-nums">{fmt(live, 2, 2)}</div>
        <div className="font-mono text-sm text-[var(--muted)] tabular-nums">{clock(elapsed)}</div>
        <div className="flex flex-wrap justify-center gap-2">
          <Button type="button" onClick={() => setRunning((r) => !r)}>
            {running ? <Pause className="size-4" aria-hidden /> : <Play className="size-4" aria-hidden />}
            {running ? "Pause" : elapsed ? "Resume" : "Start"}
          </Button>
          <Button type="button" variant="secondary" onClick={() => { setRunning(false); baseRef.current = 0; setElapsed(0); setTimeout(() => { baseRef.current = 0; setElapsed(0); }, 0); }}><RotateCcw className="size-4" aria-hidden /> Reset</Button>
        </div>
      </div>
    </div>
  );
}
