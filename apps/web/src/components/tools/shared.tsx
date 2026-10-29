"use client";
import { useState, type ComponentProps, type ReactNode } from "react";
import { Check, Copy } from "lucide-react";
import { Button } from "@/components/ui";

export function CopyButton({ value, label = "Copy" }: { value: string; label?: string }) {
  const [done, setDone] = useState(false);
  return (
    <Button
      type="button"
      variant="secondary"
      className="h-8 px-3 text-xs"
      disabled={!value}
      onClick={async () => {
        try { await navigator.clipboard.writeText(value); setDone(true); setTimeout(() => setDone(false), 1500); } catch { /* clipboard blocked */ }
      }}
    >
      {done ? <Check className="size-3.5" aria-hidden /> : <Copy className="size-3.5" aria-hidden />}
      {done ? "Copied" : label}
    </Button>
  );
}

export function TextArea({ className = "", ...p }: ComponentProps<"textarea">) {
  return <textarea spellCheck={false} {...p} className={`min-h-40 w-full rounded-lg border border-[var(--border)] bg-transparent p-3 font-mono text-sm outline-none placeholder:text-[var(--muted)] focus:border-accent focus:ring-2 focus:ring-accent/20 ${className}`} />;
}

export function Select({ className = "", ...p }: ComponentProps<"select">) {
  return <select {...p} className={`h-10 w-full rounded-lg border border-[var(--border)] bg-[var(--bg)] px-3 text-sm outline-none focus:border-accent ${className}`} />;
}

export function Output({ label, value, mono = true }: { label: string; value: string; mono?: boolean }) {
  return (
    <div className="space-y-1.5">
      <div className="flex items-center justify-between gap-2">
        <span className="text-sm font-medium">{label}</span>
        <CopyButton value={value} />
      </div>
      <output className={`block min-h-10 w-full overflow-x-auto whitespace-pre-wrap break-all rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] p-3 text-sm ${mono ? "font-mono" : ""}`}>{value || " "}</output>
    </div>
  );
}

export function Stat({ label, value }: { label: string; value: ReactNode }) {
  return (
    <div className="rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] p-3">
      <div className="text-xs text-[var(--muted)]">{label}</div>
      <div className="mt-1 text-lg font-semibold break-words">{value}</div>
    </div>
  );
}

export const num = (v: string) => { const n = parseFloat(v); return Number.isFinite(n) ? n : 0; };
export const fmt = (n: number, d = 2, min = 0) => (Number.isFinite(n) ? n.toLocaleString(undefined, { minimumFractionDigits: min, maximumFractionDigits: d }) : "-");
