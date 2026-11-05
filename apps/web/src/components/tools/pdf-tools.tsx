"use client";
import { useRef, useState, type DragEvent } from "react";
import { ArrowDown, ArrowUp, FileText, Trash2, Upload } from "lucide-react";
import { Alert, Button, Field, Input, cx } from "@/components/ui";
import { Select, Stat } from "./shared";

type Tab = "merge" | "split" | "pages";
type Item = { id: string; file: File; pages: number };

const sizeLabel = (b: number) => (b < 1024 ? `${b} B` : b < 1048576 ? `${(b / 1024).toFixed(1)} KB` : `${(b / 1048576).toFixed(2)} MB`);
const baseName = (n: string) => n.replace(/\.pdf$/i, "").replace(/[^\w\- .]+/g, "_").trim() || "document";

function saveBlob(data: Uint8Array | Blob, name: string, type = "application/pdf") {
  const blob = data instanceof Blob ? data : new Blob([new Uint8Array(data)], { type });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a"); a.href = url; a.download = name; a.click();
  setTimeout(() => URL.revokeObjectURL(url), 1500);
}

async function loadPdf(file: File) {
  const { PDFDocument } = await import("pdf-lib");
  if (!/\.pdf$/i.test(file.name) && file.type !== "application/pdf") throw new Error(`"${file.name}" is not a PDF file.`);
  try {
    return await PDFDocument.load(await file.arrayBuffer());
  } catch (e) {
    const msg = e instanceof Error ? `${e.name} ${e.message}` : String(e);
    if (/encrypt/i.test(msg)) throw new Error(`"${file.name}" is password protected. Remove the password first, then try again.`);
    throw new Error(`"${file.name}" could not be read. It may be damaged or not a real PDF.`);
  }
}

/** Parses "1-3,5" into 0-based page index groups. Throws a friendly error on bad input. */
function parseRanges(src: string, total: number): number[][] {
  const parts = src.split(/[,;\s]+/).filter(Boolean);
  if (!parts.length) throw new Error("Enter at least one page range, like 1-3,5.");
  return parts.map((p) => {
    const m = p.match(/^(\d+)(?:-(\d+)?)?$/);
    if (!m) throw new Error(`"${p}" is not a valid range. Use numbers like 2 or 4-7.`);
    const a = +m[1]!, b = m[2] ? +m[2] : p.endsWith("-") ? total : a;
    if (a < 1 || b < 1 || a > total || b > total) throw new Error(`"${p}" is outside the document (it has ${total} pages).`);
    const lo = Math.min(a, b), hi = Math.max(a, b);
    return Array.from({ length: hi - lo + 1 }, (_, i) => lo - 1 + i);
  });
}

function DropZone({ multiple, onFiles, label }: { multiple?: boolean; onFiles: (f: File[]) => void; label: string }) {
  const ref = useRef<HTMLInputElement>(null);
  const [over, setOver] = useState(false);
  const drop = (e: DragEvent) => { e.preventDefault(); setOver(false); onFiles(Array.from(e.dataTransfer.files)); };
  return (
    <div
      role="button" tabIndex={0}
      onClick={() => ref.current?.click()}
      onKeyDown={(e) => (e.key === "Enter" || e.key === " ") && ref.current?.click()}
      onDragOver={(e) => { e.preventDefault(); setOver(true); }} onDragLeave={() => setOver(false)} onDrop={drop}
      className={cx("flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed p-6 text-center transition", over ? "border-accent bg-accent/5" : "border-[var(--border)] bg-[var(--bg-subtle)] hover:border-accent/60")}
    >
      <Upload className="size-6 text-[var(--muted)]" aria-hidden />
      <p className="text-sm font-medium">{label}</p>
      <p className="text-xs text-[var(--muted)]">Drop here or click to choose. Files never leave your device.</p>
      <input ref={ref} type="file" accept="application/pdf,.pdf" multiple={multiple} className="hidden" onChange={(e) => { onFiles(Array.from(e.target.files ?? [])); e.target.value = ""; }} />
    </div>
  );
}

function Merge() {
  const [items, setItems] = useState<Item[]>([]);
  const [err, setErr] = useState(""); const [busy, setBusy] = useState(false);
  const add = async (files: File[]) => {
    setErr(""); const errors: string[] = []; const next: Item[] = [];
    for (const f of files) {
      try { const d = await loadPdf(f); next.push({ id: crypto.randomUUID(), file: f, pages: d.getPageCount() }); } catch (e) { errors.push((e as Error).message); }
    }
    setItems((s) => [...s, ...next]); if (errors.length) setErr(errors.join(" "));
  };
  const move = (i: number, d: number) => setItems((s) => { const c = [...s]; const j = i + d; if (j < 0 || j >= c.length) return s; [c[i], c[j]] = [c[j]!, c[i]!]; return c; });
  const merge = async () => {
    setBusy(true); setErr("");
    try {
      const { PDFDocument } = await import("pdf-lib");
      const out = await PDFDocument.create();
      for (const it of items) { const src = await loadPdf(it.file); (await out.copyPages(src, src.getPageIndices())).forEach((p) => out.addPage(p)); }
      saveBlob(await out.save(), "merged.pdf");
    } catch (e) { setErr((e as Error).message); } finally { setBusy(false); }
  };
  const total = items.reduce((n, i) => n + i.pages, 0);
  return (
    <div className="space-y-4">
      <DropZone multiple onFiles={add} label="Add PDFs to merge" />
      {err && <Alert>{err}</Alert>}
      {items.length > 0 && (
        <>
          <ul className="divide-y divide-[var(--border)] rounded-xl border border-[var(--border)]">
            {items.map((it, i) => (
              <li key={it.id} className="flex items-center gap-3 p-3">
                <span className="w-5 shrink-0 text-center text-xs text-[var(--muted)]">{i + 1}</span>
                <FileText className="size-5 shrink-0 text-accent" aria-hidden />
                <div className="min-w-0 flex-1"><p className="truncate text-sm font-medium">{it.file.name}</p><p className="text-xs text-[var(--muted)]">{it.pages} pages · {sizeLabel(it.file.size)}</p></div>
                <div className="flex shrink-0 gap-1">
                  <Button type="button" variant="ghost" className="h-8 w-8 px-0" aria-label="Move up" disabled={i === 0} onClick={() => move(i, -1)}><ArrowUp className="size-4" /></Button>
                  <Button type="button" variant="ghost" className="h-8 w-8 px-0" aria-label="Move down" disabled={i === items.length - 1} onClick={() => move(i, 1)}><ArrowDown className="size-4" /></Button>
                  <Button type="button" variant="ghost" className="h-8 w-8 px-0 text-red-600" aria-label="Remove" onClick={() => setItems((s) => s.filter((x) => x.id !== it.id))}><Trash2 className="size-4" /></Button>
                </div>
              </li>
            ))}
          </ul>
          <div className="flex flex-wrap items-center gap-3">
            <Button type="button" onClick={merge} disabled={busy || items.length < 2}>{busy ? "Merging…" : `Merge ${items.length} PDFs`}</Button>
            <span className="text-sm text-[var(--muted)]">{total} pages in total{items.length < 2 ? " · add at least two files" : ""}</span>
          </div>
        </>
      )}
    </div>
  );
}

function useSingle() {
  const [file, setFile] = useState<File | null>(null);
  const [pages, setPages] = useState(0);
  const [err, setErr] = useState("");
  const pick = async (files: File[]) => {
    setErr(""); const f = files[0]; if (!f) return;
    try { const d = await loadPdf(f); setFile(f); setPages(d.getPageCount()); } catch (e) { setErr((e as Error).message); setFile(null); setPages(0); }
  };
  return { file, pages, err, setErr, pick };
}

function Split() {
  const { file, pages, err, setErr, pick } = useSingle();
  const [mode, setMode] = useState<"ranges" | "every">("ranges");
  const [ranges, setRanges] = useState("1-3,4");
  const [busy, setBusy] = useState(false);
  const run = async () => {
    if (!file) return; setBusy(true); setErr("");
    try {
      const groups = mode === "every" ? Array.from({ length: pages }, (_, i) => [i]) : parseRanges(ranges, pages);
      const { PDFDocument } = await import("pdf-lib"); const { zipSync } = await import("fflate");
      const src = await loadPdf(file); const name = baseName(file.name);
      const files: Record<string, Uint8Array> = {};
      for (const g of groups) {
        const out = await PDFDocument.create();
        (await out.copyPages(src, g)).forEach((p) => out.addPage(p));
        const label = g.length === 1 ? `page-${g[0]! + 1}` : `pages-${g[0]! + 1}-${g[g.length - 1]! + 1}`;
        let fn = `${name}-${label}.pdf`, k = 2; while (files[fn]) fn = `${name}-${label}-copy${k++}.pdf`;
        files[fn] = await out.save();
      }
      if (groups.length === 1) saveBlob(Object.values(files)[0]!, Object.keys(files)[0]!);
      else saveBlob(zipSync(files, { level: 0 }), `${name}-split.zip`, "application/zip");
    } catch (e) { setErr((e as Error).message); } finally { setBusy(false); }
  };
  return (
    <div className="space-y-4">
      <DropZone onFiles={pick} label={file ? `${file.name} (click to change)` : "Choose a PDF to split"} />
      {err && <Alert>{err}</Alert>}
      {file && (
        <div className="space-y-4">
          <div className="grid grid-cols-2 gap-3"><Stat label="Pages" value={pages} /><Stat label="File size" value={sizeLabel(file.size)} /></div>
          <div className="grid gap-4 sm:grid-cols-2">
            <Field label="How to split"><Select value={mode} onChange={(e) => setMode(e.target.value as "ranges" | "every")}><option value="ranges">By page ranges</option><option value="every">Every page as its own PDF</option></Select></Field>
            {mode === "ranges" && <Field label="Page ranges" hint="Each range becomes one PDF. Example: 1-3,5,8-"><Input value={ranges} onChange={(e) => setRanges(e.target.value)} placeholder="1-3,5" /></Field>}
          </div>
          <Button type="button" onClick={run} disabled={busy}>{busy ? "Splitting…" : "Split and download"}</Button>
        </div>
      )}
    </div>
  );
}

function Pages() {
  const { file, pages, err, setErr, pick } = useSingle();
  const [sel, setSel] = useState("");
  const [action, setAction] = useState("90");
  const [busy, setBusy] = useState(false);
  const run = async () => {
    if (!file) return; setBusy(true); setErr("");
    try {
      const idx = new Set((sel.trim() ? parseRanges(sel, pages) : [Array.from({ length: pages }, (_, i) => i)]).flat());
      const { degrees } = await import("pdf-lib");
      const doc = await loadPdf(file);
      if (action === "delete") {
        if (idx.size >= pages) throw new Error("You can't delete every page. Leave at least one.");
        [...idx].sort((a, b) => b - a).forEach((i) => doc.removePage(i));
      } else {
        const add = +action;
        doc.getPages().forEach((p, i) => { if (idx.has(i)) p.setRotation(degrees((((p.getRotation().angle + add) % 360) + 360) % 360)); });
      }
      saveBlob(await doc.save(), `${baseName(file.name)}-edited.pdf`);
    } catch (e) { setErr((e as Error).message); } finally { setBusy(false); }
  };
  return (
    <div className="space-y-4">
      <DropZone onFiles={pick} label={file ? `${file.name} (click to change)` : "Choose a PDF to edit"} />
      {err && <Alert>{err}</Alert>}
      {file && (
        <div className="space-y-4">
          <div className="grid grid-cols-2 gap-3"><Stat label="Pages" value={pages} /><Stat label="File size" value={sizeLabel(file.size)} /></div>
          <div className="grid gap-4 sm:grid-cols-2">
            <Field label="Pages" hint="Leave empty for all pages. Example: 1,3-4"><Input value={sel} onChange={(e) => setSel(e.target.value)} placeholder={`1-${pages}`} /></Field>
            <Field label="Action"><Select value={action} onChange={(e) => setAction(e.target.value)}><option value="90">Rotate 90° clockwise</option><option value="180">Rotate 180°</option><option value="270">Rotate 90° counter-clockwise</option><option value="delete">Delete pages</option></Select></Field>
          </div>
          <Button type="button" variant={action === "delete" ? "danger" : "primary"} onClick={run} disabled={busy}>{busy ? "Working…" : "Apply and download"}</Button>
        </div>
      )}
    </div>
  );
}

export default function PdfTools() {
  const [tab, setTab] = useState<Tab>("merge");
  const tabs: [Tab, string][] = [["merge", "Merge"], ["split", "Split"], ["pages", "Rotate / delete"]];
  return (
    <div className="space-y-5">
      <div role="tablist" className="inline-flex max-w-full gap-1 overflow-x-auto rounded-xl border border-[var(--border)] bg-[var(--bg-subtle)] p-1">
        {tabs.map(([k, l]) => (
          <button key={k} role="tab" type="button" aria-selected={tab === k} onClick={() => setTab(k)} className={cx("whitespace-nowrap rounded-lg px-3 py-1.5 text-sm font-medium transition", tab === k ? "bg-[var(--card)] shadow-[var(--shadow-sm)]" : "text-[var(--muted)] hover:text-current")}>{l}</button>
        ))}
      </div>
      {tab === "merge" && <Merge />}
      {tab === "split" && <Split />}
      {tab === "pages" && <Pages />}
    </div>
  );
}
