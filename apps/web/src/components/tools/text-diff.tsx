"use client";
import { useMemo, useState } from "react";
import { TextArea } from "./shared";

type Op = { t: "same" | "add" | "del"; s: string };
function diff(a: string[], b: string[]): Op[] {
  const n = a.length, m = b.length;
  if (n * m > 4_000_000) return [...a.map((s) => ({ t: "del" as const, s })), ...b.map((s) => ({ t: "add" as const, s }))];
  const T = new Uint32Array((n + 1) * (m + 1)); const L = (i: number, j: number) => T[i * (m + 1) + j]!;
  for (let i = n - 1; i >= 0; i--) for (let j = m - 1; j >= 0; j--) T[i * (m + 1) + j] = a[i] === b[j] ? L(i + 1, j + 1) + 1 : Math.max(L(i + 1, j), L(i, j + 1));
  const out: Op[] = []; let i = 0, j = 0;
  while (i < n && j < m) { if (a[i] === b[j]) { out.push({ t: "same", s: a[i]! }); i++; j++; } else if (L(i + 1, j) >= L(i, j + 1)) out.push({ t: "del", s: a[i++]! }); else out.push({ t: "add", s: b[j++]! }); }
  while (i < n) out.push({ t: "del", s: a[i++]! }); while (j < m) out.push({ t: "add", s: b[j++]! });
  return out;
}

export default function TextDiff() {
  const [a, setA] = useState("apples\nbananas\ncherries\ndates");
  const [b, setB] = useState("apples\nblueberries\ncherries\ndates\nelderberries");
  const ops = useMemo(() => diff(a.split("\n"), b.split("\n")), [a, b]);
  const add = ops.filter((o) => o.t === "add").length, del = ops.filter((o) => o.t === "del").length;
  return (
    <div className="space-y-4">
      <div className="grid gap-4 md:grid-cols-2">
        <label className="block space-y-1.5"><span className="text-sm font-medium">Original</span><TextArea value={a} onChange={(e) => setA(e.target.value)} /></label>
        <label className="block space-y-1.5"><span className="text-sm font-medium">Changed</span><TextArea value={b} onChange={(e) => setB(e.target.value)} /></label>
      </div>
      <p className="text-sm"><span className="text-emerald-600 dark:text-emerald-400">{add} added</span> · <span className="text-red-600 dark:text-red-400">{del} removed</span></p>
      <pre className="overflow-x-auto rounded-lg border border-[var(--border)] text-sm" aria-label="Differences">
        {ops.map((o, i) => (
          <div key={i} className={o.t === "add" ? "bg-emerald-500/15" : o.t === "del" ? "bg-red-500/15" : ""}>
            <span className="inline-block w-6 select-none text-center text-[var(--muted)]">{o.t === "add" ? "+" : o.t === "del" ? "-" : " "}</span>{o.s || " "}
          </div>
        ))}
      </pre>
    </div>
  );
}
