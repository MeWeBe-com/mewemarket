"use client";
import { useEffect, useState } from "react";
import { X } from "lucide-react";
import { Button, Field, Input } from "@/components/ui";
import { Select } from "./shared";

const zones = (): string[] => { try { return (Intl as unknown as { supportedValuesOf: (k: string) => string[] }).supportedValuesOf("timeZone"); } catch { return ["UTC", "Europe/London", "America/New_York", "Asia/Tokyo"]; } };

// Offset (ms) of a zone at a given instant.
function offset(zone: string, at: Date) {
  const p: Record<string, string> = Object.fromEntries(new Intl.DateTimeFormat("en-US", { timeZone: zone, hourCycle: "h23", year: "numeric", month: "2-digit", day: "2-digit", hour: "2-digit", minute: "2-digit", second: "2-digit" }).formatToParts(at).map((x) => [x.type, x.value]));
  return Date.UTC(Number(p.year), Number(p.month) - 1, Number(p.day), Number(p.hour), Number(p.minute), Number(p.second)) - Math.floor(at.getTime() / 1000) * 1000;
}
function instant(local: string, zone: string) {
  const [d = "", t = "00:00"] = local.split("T"); const [y = 1970, mo = 1, da = 1] = d.split("-").map(Number); const [h = 0, mi = 0] = t.split(":").map(Number);
  const guess = Date.UTC(y, mo - 1, da, h, mi);
  let at = new Date(guess - offset(zone, new Date(guess)));
  at = new Date(guess - offset(zone, at));
  return at;
}

export default function TimezoneConverter() {
  const [all, setAll] = useState<string[]>([]);
  const [here, setHere] = useState("UTC");
  const [local, setLocal] = useState("");
  const [targets, setTargets] = useState(["UTC", "America/New_York", "Europe/London", "Asia/Tokyo", "Australia/Sydney"]);
  const [add, setAdd] = useState("");
  useEffect(() => {
    setAll(zones()); setHere(Intl.DateTimeFormat().resolvedOptions().timeZone || "UTC");
    const n = new Date(); n.setSeconds(0, 0); setLocal(new Date(n.getTime() - n.getTimezoneOffset() * 60000).toISOString().slice(0, 16));
  }, []);
  const at = local ? instant(local, here) : null;
  const valid = at && !isNaN(at.getTime());
  return (
    <div className="space-y-5">
      <div className="grid gap-4 sm:grid-cols-2">
        <Field label="Date and time"><Input type="datetime-local" value={local} onChange={(e) => setLocal(e.target.value)} /></Field>
        <label className="block space-y-1.5"><span className="text-sm font-medium">In time zone</span><Select value={here} onChange={(e) => setHere(e.target.value)}>{(all.includes(here) ? all : [here, ...all]).map((z) => <option key={z}>{z}</option>)}</Select></label>
      </div>
      <ul className="divide-y divide-[var(--border)] rounded-lg border border-[var(--border)]">
        {targets.map((z) => (
          <li key={z} className="flex items-center justify-between gap-2 p-3">
            <div><div className="font-medium">{z.replace(/_/g, " ")}</div><div className="text-sm text-[var(--muted)]">{valid ? at!.toLocaleString(undefined, { timeZone: z, weekday: "short", day: "numeric", month: "short", hour: "2-digit", minute: "2-digit", timeZoneName: "short" }) : "-"}</div></div>
            <Button type="button" variant="ghost" className="h-8 px-2" aria-label={`Remove ${z}`} onClick={() => setTargets(targets.filter((x) => x !== z))}><X className="size-4" aria-hidden /></Button>
          </li>
        ))}
      </ul>
      <div className="flex items-end gap-2">
        <label className="block flex-1 space-y-1.5"><span className="text-sm font-medium">Add a time zone</span><Select value={add} onChange={(e) => setAdd(e.target.value)}><option value="">Choose...</option>{all.map((z) => <option key={z}>{z}</option>)}</Select></label>
        <Button type="button" disabled={!add || targets.includes(add)} onClick={() => { setTargets([...targets, add]); setAdd(""); }}>Add</Button>
      </div>
    </div>
  );
}
