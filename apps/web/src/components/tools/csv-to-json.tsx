"use client";
import { useMemo, useState } from "react";
import { Output, Select, TextArea } from "./shared";

function parseCsv(src: string, d: string): string[][] {
  const rows: string[][] = []; let row: string[] = [], cell = "", q = false;
  for (let i = 0; i < src.length; i++) {
    const c = src[i];
    if (q) { if (c === '"') { if (src[i + 1] === '"') { cell += '"'; i++; } else q = false; } else cell += c; }
    else if (c === '"') q = true;
    else if (c === d) { row.push(cell); cell = ""; }
    else if (c === "\n" || c === "\r") { if (c === "\r" && src[i + 1] === "\n") i++; row.push(cell); rows.push(row); row = []; cell = ""; }
    else cell += c;
  }
  if (cell || row.length) { row.push(cell); rows.push(row); }
  return rows.filter((r) => r.some((x) => x !== ""));
}

export default function CsvToJson() {
  const [csv, setCsv] = useState('name,email,age\nAnna,anna@example.com,31\n"Smith, Bob",bob@example.com,45');
  const [delim, setDelim] = useState(",");
  const [types, setTypes] = useState(true);
  const out = useMemo(() => {
    const [head, ...rows] = parseCsv(csv, delim === "tab" ? "\t" : delim);
    if (!head) return "";
    const conv = (v: string) => { if (!types) return v; if (v !== "" && !isNaN(Number(v))) return Number(v); if (v === "true" || v === "false") return v === "true"; return v; };
    return JSON.stringify(rows.map((r) => Object.fromEntries(head.map((h, i) => [h.trim() || `column${i + 1}`, conv(r[i] ?? "")]))), null, 2);
  }, [csv, delim, types]);
  return (
    <div className="space-y-4">
      <div className="flex flex-wrap items-end gap-3">
        <label className="block w-40 space-y-1.5"><span className="text-sm font-medium">Delimiter</span><Select value={delim} onChange={(e) => setDelim(e.target.value)}><option value=",">Comma</option><option value=";">Semicolon</option><option value="tab">Tab</option><option value="|">Pipe</option></Select></label>
        <label className="flex h-10 items-center gap-2 text-sm"><input type="checkbox" checked={types} onChange={(e) => setTypes(e.target.checked)} /> Detect numbers and true/false</label>
      </div>
      <div className="grid gap-4 md:grid-cols-2">
        <label className="block space-y-1.5"><span className="text-sm font-medium">CSV (first row is the header)</span><TextArea className="min-h-64" value={csv} onChange={(e) => setCsv(e.target.value)} /></label>
        <Output label="JSON" value={out} />
      </div>
    </div>
  );
}
