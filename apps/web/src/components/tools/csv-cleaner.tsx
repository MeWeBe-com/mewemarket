"use client";
import { useEffect, useMemo, useRef, useState, type DragEvent } from "react";
import { ArrowDown, ArrowUp, Download, Upload } from "lucide-react";
import { Alert, Button, Field, Input, cx } from "@/components/ui";
import { CopyButton, Select, Stat, TextArea } from "./shared";

type Delim = "auto" | "," | ";" | "\t" | "|";

function detectDelimiter(src: string): string {
  const sample = src.slice(0, 5000);
  let best = ",", score = -1;
  for (const d of [",", ";", "\t", "|"]) {
    let n = 0, q = false;
    for (const c of sample) { if (c === '"') q = !q; else if (!q && c === d) n++; else if (!q && c === "\n") break; }
    if (n > score) { score = n; best = d; }
  }
  return best;
}

function parseCsv(src: string, d: string): string[][] {
  const rows: string[][] = []; let row: string[] = [], cell = "", q = false;
  if (src.charCodeAt(0) === 0xfeff) src = src.slice(1);
  for (let i = 0; i < src.length; i++) {
    const c = src[i];
    if (q) { if (c === '"') { if (src[i + 1] === '"') { cell += '"'; i++; } else q = false; } else cell += c; }
    else if (c === '"' && cell === "") q = true;
    else if (c === d) { row.push(cell); cell = ""; }
    else if (c === "\n" || c === "\r") { if (c === "\r" && src[i + 1] === "\n") i++; row.push(cell); rows.push(row); row = []; cell = ""; }
    else cell += c;
  }
  if (cell || row.length) { row.push(cell); rows.push(row); }
  return rows;
}

function toCsv(rows: string[][], d: string): string {
  const esc = (v: string) => (v.includes(d) || /["\r\n]/.test(v) || /^\s|\s$/.test(v) ? `"${v.replace(/"/g, '""')}"` : v);
  return rows.map((r) => r.map(esc).join(d)).join("\r\n");
}

const titleCase = (s: string) => s.toLowerCase().replace(/(^|[\s\-_/])(\p{L})/gu, (_, a: string, b: string) => a + b.toUpperCase());
const cmp = new Intl.Collator(undefined, { numeric: true, sensitivity: "base" });
const asNum = (v: string) => {
  let t = v.trim().replace(/\s/g, "");
  // "1,5" is a decimal comma (common with ; delimited files); "1,200" / "1,200.50" use thousands separators
  t = /^[-+]?\d+,\d{1,2}$|^[-+]?\d+,\d{4,}$/.test(t) ? t.replace(",", ".") : t.replace(/,/g, "");
  return t !== "" && !isNaN(Number(t)) ? Number(t) : null;
};

function Check({ checked, onChange, label }: { checked: boolean; onChange: (v: boolean) => void; label: string }) {
  return <label className="flex items-center gap-2 text-sm font-medium"><input type="checkbox" checked={checked} onChange={(e) => onChange(e.target.checked)} />{label}</label>;
}

function ColPicker({ header, value, onChange }: { header: string[]; value: number[]; onChange: (v: number[]) => void }) {
  return (
    <div className="flex flex-wrap gap-1.5">
      {header.map((h, i) => {
        const on = value.includes(i);
        return <button key={i} type="button" onClick={() => onChange(on ? value.filter((x) => x !== i) : [...value, i])} className={cx("max-w-full truncate rounded-full border px-2.5 py-1 text-xs font-medium", on ? "border-accent bg-accent/10 text-accent" : "border-[var(--border)] text-[var(--muted)]")}>{h || `Column ${i + 1}`}</button>;
      })}
    </div>
  );
}

export default function CsvCleaner() {
  const [src, setSrc] = useState('name,email,city,amount\n  Anna , anna@example.com,paris,31\n"Smith, Bob",BOB@example.com,London,1200\n,,,\n  Anna , anna@example.com,paris,31\nCara,cara@example.com,"New\nYork",9');
  const [delimSel, setDelimSel] = useState<Delim>("auto");
  const [hasHeader, setHasHeader] = useState(true);
  const [err, setErr] = useState(""); const [over, setOver] = useState(false);
  const fileRef = useRef<HTMLInputElement>(null);

  const [trim, setTrim] = useState(true);
  const [dropEmpty, setDropEmpty] = useState(true);
  const [dedupe, setDedupe] = useState(true); const [dedupeCols, setDedupeCols] = useState<number[]>([]);
  const [caseOn, setCaseOn] = useState(false); const [caseCols, setCaseCols] = useState<number[]>([]); const [caseMode, setCaseMode] = useState("lower");
  const [frOn, setFrOn] = useState(false); const [find, setFind] = useState(""); const [repl, setRepl] = useState(""); const [frCol, setFrCol] = useState("-1"); const [frCase, setFrCase] = useState(false);
  const [colsOn, setColsOn] = useState(false); const [order, setOrder] = useState<number[]>([]); const [hidden, setHidden] = useState<number[]>([]);
  const [sortOn, setSortOn] = useState(false); const [sortCol, setSortCol] = useState("0"); const [sortDir, setSortDir] = useState<"asc" | "desc">("asc");
  const [outDelim, setOutDelim] = useState<"same" | "," | ";" | "\t">("same");

  const delim = delimSel === "auto" ? detectDelimiter(src) : delimSel;
  const parsed = useMemo(() => parseCsv(src, delim), [src, delim]);
  const width = parsed.reduce((m, r) => Math.max(m, r.length), 0);
  const header = useMemo(() => Array.from({ length: width }, (_, i) => (hasHeader ? parsed[0]?.[i]?.trim() : "") || `Column ${i + 1}`), [parsed, width, hasHeader]);
  const headerKey = header.join("\u0001");
  useEffect(() => { setOrder(header.map((_, i) => i)); setHidden([]); setDedupeCols([]); setCaseCols([]); }, [headerKey]); // eslint-disable-line react-hooks/exhaustive-deps

  const body = useMemo(() => (hasHeader ? parsed.slice(1) : parsed), [parsed, hasHeader]);

  const result = useMemo(() => {
    let rows = body.map((r) => Array.from({ length: width }, (_, i) => r[i] ?? ""));
    if (trim) rows = rows.map((r) => r.map((v) => v.trim().replace(/ {2,}/g, " ")));
    if (dropEmpty) rows = rows.filter((r) => r.some((v) => v.trim() !== ""));
    if (frOn && find) {
      const re = new RegExp(find.replace(/[.*+?^${}()|[\]\\]/g, "\\$&"), frCase ? "g" : "gi"); const c = +frCol;
      rows = rows.map((r) => r.map((v, i) => (c < 0 || c === i ? v.replace(re, () => repl) : v)));
    }
    if (caseOn && caseCols.length) {
      const f = caseMode === "upper" ? (s: string) => s.toUpperCase() : caseMode === "title" ? titleCase : (s: string) => s.toLowerCase();
      rows = rows.map((r) => r.map((v, i) => (caseCols.includes(i) ? f(v) : v)));
    }
    if (dedupe) {
      const seen = new Set<string>(); const cols = dedupeCols.length ? dedupeCols : null;
      rows = rows.filter((r) => { const k = JSON.stringify(cols ? cols.map((i) => r[i]) : r); if (seen.has(k)) return false; seen.add(k); return true; });
    }
    if (sortOn) {
      const c = +sortCol, s = sortDir === "asc" ? 1 : -1;
      rows = [...rows].sort((a, b) => {
        const x = a[c] ?? "", y = b[c] ?? "";
        if (x === "" || y === "") return x === y ? 0 : x === "" ? 1 : -1; // blanks last
        const nx = asNum(x), ny = asNum(y);
        return s * (nx !== null && ny !== null ? nx - ny : cmp.compare(x, y));
      });
    }
    const cols = colsOn ? order.filter((i) => !hidden.includes(i) && i < width) : header.map((_, i) => i);
    const head = cols.map((i) => (hasHeader ? (parsed[0]?.[i] ?? "").trim() : header[i] ?? ""));
    return { head, rows: rows.map((r) => cols.map((i) => r[i] ?? "")) };
  }, [body, width, trim, dropEmpty, frOn, find, repl, frCol, frCase, caseOn, caseCols, caseMode, dedupe, dedupeCols, sortOn, sortCol, sortDir, colsOn, order, hidden, header, hasHeader, parsed]);

  const od = outDelim === "same" ? delim : outDelim;
  const output = useMemo(() => (result.head.length ? toCsv(hasHeader ? [result.head, ...result.rows] : result.rows, od) : ""), [result, od, hasHeader]);

  const load = async (files: File[]) => {
    const f = files[0]; if (!f) return; setErr("");
    if (f.size > 50 * 1048576) return setErr("That file is over 50 MB. Please split it into smaller files first.");
    if (!/\.(csv|tsv|txt)$/i.test(f.name) && !/text|csv/.test(f.type)) return setErr(`"${f.name}" doesn't look like a CSV file. Use a .csv, .tsv or .txt file.`);
    const t = await f.text();
    if (t.includes("\u0000")) return setErr(`"${f.name}" looks like a binary file (maybe an Excel .xlsx). Save it as CSV first.`);
    setSrc(t);
  };
  const download = () => {
    const url = URL.createObjectURL(new Blob(["﻿" + output], { type: "text/csv;charset=utf-8" }));
    const a = document.createElement("a"); a.href = url; a.download = od === "\t" ? "cleaned.tsv" : "cleaned.csv"; a.click();
    setTimeout(() => URL.revokeObjectURL(url), 1500);
  };
  const moveCol = (pos: number, d: number) => setOrder((o) => { const c = [...o]; const j = pos + d; if (j < 0 || j >= c.length) return o; [c[pos], c[j]] = [c[j]!, c[pos]!]; return c; });
  const drop = (e: DragEvent) => { e.preventDefault(); setOver(false); load(Array.from(e.dataTransfer.files)); };
  const card = "space-y-3 rounded-xl border border-[var(--border)] p-3";

  return (
    <div className="space-y-5">
      <div className="grid gap-4 lg:grid-cols-[1fr_16rem]">
        <div className="min-w-0 space-y-2">
          <TextArea className="min-h-44" value={src} onChange={(e) => setSrc(e.target.value)} placeholder="Paste CSV here…" aria-label="CSV input" />
        </div>
        <div role="button" tabIndex={0} onClick={() => fileRef.current?.click()} onKeyDown={(e) => (e.key === "Enter" || e.key === " ") && fileRef.current?.click()}
          onDragOver={(e) => { e.preventDefault(); setOver(true); }} onDragLeave={() => setOver(false)} onDrop={drop}
          className={cx("flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed p-5 text-center transition", over ? "border-accent bg-accent/5" : "border-[var(--border)] bg-[var(--bg-subtle)] hover:border-accent/60")}>
          <Upload className="size-6 text-[var(--muted)]" aria-hidden />
          <p className="text-sm font-medium">Drop a CSV file or click</p>
          <p className="text-xs text-[var(--muted)]">Stays on your device.</p>
          <input ref={fileRef} type="file" accept=".csv,.tsv,.txt,text/csv,text/plain" className="hidden" onChange={(e) => { load(Array.from(e.target.files ?? [])); e.target.value = ""; }} />
        </div>
      </div>
      {err && <Alert>{err}</Alert>}

      <div className="flex flex-wrap items-end gap-4">
        <div className="w-44"><Field label="Delimiter"><Select value={delimSel} onChange={(e) => setDelimSel(e.target.value as Delim)}><option value="auto">Auto ({delim === "\t" ? "tab" : delim})</option><option value=",">Comma</option><option value=";">Semicolon</option><option value={"\t"}>Tab</option><option value="|">Pipe</option></Select></Field></div>
        <label className="flex h-10 items-center gap-2 text-sm"><input type="checkbox" checked={hasHeader} onChange={(e) => setHasHeader(e.target.checked)} /> First row is a header</label>
      </div>

      <div className="grid gap-3 md:grid-cols-2">
        <div className={card}>
          <Check checked={trim} onChange={setTrim} label="Trim spaces in every cell" />
          <Check checked={dropEmpty} onChange={setDropEmpty} label="Remove empty rows" />
          <Check checked={dedupe} onChange={setDedupe} label="Remove duplicate rows" />
          {dedupe && <div className="space-y-1.5 pl-6"><p className="text-xs text-[var(--muted)]">Compare only these columns (none selected = whole row):</p><ColPicker header={header} value={dedupeCols} onChange={setDedupeCols} /></div>}
        </div>
        <div className={card}>
          <Check checked={caseOn} onChange={setCaseOn} label="Change text case" />
          {caseOn && (
            <div className="space-y-2 pl-6">
              <Select value={caseMode} onChange={(e) => setCaseMode(e.target.value)}><option value="lower">lowercase</option><option value="upper">UPPERCASE</option><option value="title">Title Case</option></Select>
              <ColPicker header={header} value={caseCols} onChange={setCaseCols} />
              {!caseCols.length && <p className="text-xs text-[var(--muted)]">Pick one or more columns.</p>}
            </div>
          )}
        </div>
        <div className={card}>
          <Check checked={frOn} onChange={setFrOn} label="Find and replace" />
          {frOn && (
            <div className="grid grid-cols-2 gap-2 pl-6">
              <Input placeholder="Find" value={find} onChange={(e) => setFind(e.target.value)} aria-label="Find" />
              <Input placeholder="Replace with" value={repl} onChange={(e) => setRepl(e.target.value)} aria-label="Replace with" />
              <Select value={frCol} onChange={(e) => setFrCol(e.target.value)} aria-label="Column"><option value="-1">All columns</option>{header.map((h, i) => <option key={i} value={i}>{h}</option>)}</Select>
              <label className="flex items-center gap-2 text-sm"><input type="checkbox" checked={frCase} onChange={(e) => setFrCase(e.target.checked)} /> Match case</label>
            </div>
          )}
        </div>
        <div className={card}>
          <Check checked={sortOn} onChange={setSortOn} label="Sort rows" />
          {sortOn && (
            <div className="grid grid-cols-2 gap-2 pl-6">
              <Select value={sortCol} onChange={(e) => setSortCol(e.target.value)} aria-label="Sort column">{header.map((h, i) => <option key={i} value={i}>{h}</option>)}</Select>
              <Select value={sortDir} onChange={(e) => setSortDir(e.target.value as "asc" | "desc")} aria-label="Direction"><option value="asc">A → Z / 1 → 9</option><option value="desc">Z → A / 9 → 1</option></Select>
            </div>
          )}
        </div>
        <div className={cx(card, "md:col-span-2")}>
          <Check checked={colsOn} onChange={setColsOn} label="Choose and reorder columns" />
          {colsOn && (
            <ul className="grid gap-1.5 pl-6 sm:grid-cols-2">
              {order.map((ci, pos) => (
                <li key={ci} className="flex min-w-0 items-center gap-2 rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] px-2 py-1">
                  <input type="checkbox" aria-label={`Keep ${header[ci]}`} checked={!hidden.includes(ci)} onChange={(e) => setHidden((h) => (e.target.checked ? h.filter((x) => x !== ci) : [...h, ci]))} />
                  <span className={cx("min-w-0 flex-1 truncate text-sm", hidden.includes(ci) && "text-[var(--muted)] line-through")}>{header[ci]}</span>
                  <button type="button" aria-label="Move up" disabled={pos === 0} onClick={() => moveCol(pos, -1)} className="p-1 disabled:opacity-30"><ArrowUp className="size-3.5" /></button>
                  <button type="button" aria-label="Move down" disabled={pos === order.length - 1} onClick={() => moveCol(pos, 1)} className="p-1 disabled:opacity-30"><ArrowDown className="size-3.5" /></button>
                </li>
              ))}
            </ul>
          )}
        </div>
      </div>

      <div className="grid grid-cols-3 gap-3">
        <Stat label="Rows before" value={body.length.toLocaleString()} />
        <Stat label="Rows after" value={result.rows.length.toLocaleString()} />
        <Stat label="Columns" value={`${result.head.length} / ${width}`} />
      </div>

      <div className="flex flex-wrap items-center gap-2">
        <Button type="button" onClick={download} disabled={!output}><Download className="size-4" aria-hidden />Download CSV</Button>
        <CopyButton value={output} label="Copy output" />
        <div className="ml-auto w-40"><Select value={outDelim} onChange={(e) => setOutDelim(e.target.value as typeof outDelim)} aria-label="Output delimiter"><option value="same">Output: same</option><option value=",">Output: comma</option><option value=";">Output: semicolon</option><option value={"\t"}>Output: tab</option></Select></div>
      </div>

      {result.head.length > 0 ? (
        <div className="space-y-1.5">
          <div className="max-h-[28rem] overflow-auto rounded-xl border border-[var(--border)]">
            <table className="w-max min-w-full text-sm">
              <thead className="sticky top-0 bg-[var(--bg-subtle)] text-left"><tr><th className="p-2 text-xs text-[var(--muted)]">#</th>{result.head.map((h, i) => <th key={i} className="whitespace-nowrap p-2 font-semibold">{h}</th>)}</tr></thead>
              <tbody className="divide-y divide-[var(--border)]">
                {result.rows.slice(0, 50).map((r, i) => <tr key={i}><td className="p-2 text-xs text-[var(--muted)]">{i + 1}</td>{r.map((v, j) => <td key={j} className="max-w-[20rem] truncate whitespace-nowrap p-2" title={v}>{v}</td>)}</tr>)}
              </tbody>
            </table>
          </div>
          {result.rows.length > 50 && <p className="text-xs text-[var(--muted)]">Preview shows the first 50 of {result.rows.length.toLocaleString()} rows. The download includes all rows.</p>}
        </div>
      ) : <p className="text-sm text-[var(--muted)]">Paste or upload a CSV to get started.</p>}
    </div>
  );
}
