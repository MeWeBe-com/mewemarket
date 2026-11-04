"use client";
import { useEffect, useRef, useState, type DragEvent } from "react";
import { Download, Trash2, Upload } from "lucide-react";
import { Alert, Button, Field, Input, cx } from "@/components/ui";
import { Select, Stat, fmt } from "./shared";

type Fmt = "keep" | "image/jpeg" | "image/webp" | "image/png";
type Row = { id: string; file: File; status: "waiting" | "done" | "error"; out?: Blob; url?: string; name?: string; error?: string; w?: number; h?: number };

const sizeLabel = (b: number) => (b < 1024 ? `${b} B` : b < 1048576 ? `${(b / 1024).toFixed(1)} KB` : `${(b / 1048576).toFixed(2)} MB`);
const EXT: Record<string, string> = { "image/jpeg": "jpg", "image/webp": "webp", "image/png": "png" };

function decode(file: File): Promise<HTMLImageElement> {
  return new Promise((res, rej) => {
    const url = URL.createObjectURL(file); const img = new Image();
    img.onload = () => { URL.revokeObjectURL(url); res(img); };
    img.onerror = () => { URL.revokeObjectURL(url); rej(new Error("This image could not be opened.")); };
    img.src = url;
  });
}

async function compress(file: File, maxW: number, maxH: number, format: Fmt, quality: number) {
  const img = await decode(file);
  const scale = Math.min(1, maxW > 0 ? maxW / img.naturalWidth : 1, maxH > 0 ? maxH / img.naturalHeight : 1);
  const w = Math.max(1, Math.round(img.naturalWidth * scale)), h = Math.max(1, Math.round(img.naturalHeight * scale));
  let type = format === "keep" ? file.type : format;
  if (!EXT[type]) type = "image/jpeg"; // GIF, BMP, etc. fall back to JPEG
  const c = document.createElement("canvas"); c.width = w; c.height = h;
  const ctx = c.getContext("2d"); if (!ctx) throw new Error("Your browser could not create a canvas.");
  if (type === "image/jpeg") { ctx.fillStyle = "#fff"; ctx.fillRect(0, 0, w, h); }
  ctx.imageSmoothingQuality = "high"; ctx.drawImage(img, 0, 0, w, h);
  const blob = await new Promise<Blob | null>((r) => c.toBlob(r, type, quality / 100));
  if (!blob) throw new Error("Your browser could not encode this format.");
  const name = file.name.replace(/\.[^.]+$/, "") + "." + EXT[type];
  return { blob, name, w, h };
}

export default function BulkImageCompressor() {
  const [rows, setRows] = useState<Row[]>([]);
  const [maxW, setMaxW] = useState("1920"); const [maxH, setMaxH] = useState("1920");
  const [format, setFormat] = useState<Fmt>("keep"); const [quality, setQuality] = useState(80);
  const [busy, setBusy] = useState(false); const [progress, setProgress] = useState(0);
  const [err, setErr] = useState(""); const [over, setOver] = useState(false);
  const input = useRef<HTMLInputElement>(null);
  const urls = useRef<string[]>([]);
  useEffect(() => () => urls.current.forEach((u) => URL.revokeObjectURL(u)), []);

  const add = (files: File[]) => {
    const imgs = files.filter((f) => f.type.startsWith("image/"));
    const skipped = files.length - imgs.length;
    setErr(skipped ? `${skipped} file${skipped > 1 ? "s were" : " was"} skipped because ${skipped > 1 ? "they are" : "it is"} not an image.` : "");
    setRows((s) => [...s, ...imgs.map((file) => ({ id: crypto.randomUUID(), file, status: "waiting" as const }))]);
  };
  const clear = () => { urls.current.forEach((u) => URL.revokeObjectURL(u)); urls.current = []; setRows([]); setProgress(0); };

  const run = async () => {
    setBusy(true); setProgress(0);
    const list = [...rows];
    for (let i = 0; i < list.length; i++) {
      const r = list[i]!;
      if (r.url) URL.revokeObjectURL(r.url);
      try {
        const { blob, name, w, h } = await compress(r.file, parseInt(maxW) || 0, parseInt(maxH) || 0, format, quality);
        const url = URL.createObjectURL(blob); urls.current.push(url);
        list[i] = { ...r, status: "done", out: blob, url, name, w, h, error: undefined };
      } catch (e) { list[i] = { ...r, status: "error", error: (e as Error).message, out: undefined, url: undefined }; }
      setRows([...list]); setProgress(i + 1);
    }
    setBusy(false);
  };

  const zipAll = async () => {
    const { zipSync } = await import("fflate");
    const files: Record<string, Uint8Array> = {};
    for (const r of rows) {
      if (!r.out || !r.name) continue;
      let n = r.name, k = 2; while (files[n]) n = r.name.replace(/(\.[^.]+)$/, `-${k++}$1`);
      files[n] = new Uint8Array(await r.out.arrayBuffer());
    }
    const url = URL.createObjectURL(new Blob([new Uint8Array(zipSync(files, { level: 0 }))], { type: "application/zip" }));
    const a = document.createElement("a"); a.href = url; a.download = "compressed-images.zip"; a.click();
    setTimeout(() => URL.revokeObjectURL(url), 1500);
  };

  const done = rows.filter((r) => r.out);
  const before = done.reduce((n, r) => n + r.file.size, 0), after = done.reduce((n, r) => n + (r.out?.size ?? 0), 0);
  const drop = (e: DragEvent) => { e.preventDefault(); setOver(false); add(Array.from(e.dataTransfer.files)); };

  return (
    <div className="space-y-5">
      <div role="button" tabIndex={0} onClick={() => input.current?.click()} onKeyDown={(e) => (e.key === "Enter" || e.key === " ") && input.current?.click()}
        onDragOver={(e) => { e.preventDefault(); setOver(true); }} onDragLeave={() => setOver(false)} onDrop={drop}
        className={cx("flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed p-6 text-center transition", over ? "border-accent bg-accent/5" : "border-[var(--border)] bg-[var(--bg-subtle)] hover:border-accent/60")}>
        <Upload className="size-6 text-[var(--muted)]" aria-hidden />
        <p className="text-sm font-medium">Drop images here or click to choose</p>
        <p className="text-xs text-[var(--muted)]">JPEG, PNG, WebP and more. Everything is processed on your device.</p>
        <input ref={input} type="file" accept="image/*" multiple className="hidden" onChange={(e) => { add(Array.from(e.target.files ?? [])); e.target.value = ""; }} />
      </div>
      {err && <Alert>{err}</Alert>}

      <div className="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <Field label="Max width (px)" hint="0 = no limit"><Input type="number" min={0} value={maxW} onChange={(e) => setMaxW(e.target.value)} /></Field>
        <Field label="Max height (px)" hint="0 = no limit"><Input type="number" min={0} value={maxH} onChange={(e) => setMaxH(e.target.value)} /></Field>
        <Field label="Format"><Select value={format} onChange={(e) => setFormat(e.target.value as Fmt)}><option value="keep">Keep original</option><option value="image/jpeg">JPEG</option><option value="image/webp">WebP</option><option value="image/png">PNG</option></Select></Field>
        <Field label={`Quality: ${quality}%`} hint={format === "image/png" ? "PNG is lossless" : undefined}><input type="range" min={10} max={100} value={quality} onChange={(e) => setQuality(+e.target.value)} className="h-10 w-full accent-[var(--color-accent)]" /></Field>
      </div>

      <div className="flex flex-wrap items-center gap-2">
        <Button type="button" onClick={run} disabled={busy || !rows.length}>{busy ? `Compressing ${progress}/${rows.length}…` : `Compress ${rows.length || ""} image${rows.length === 1 ? "" : "s"}`}</Button>
        <Button type="button" variant="secondary" onClick={zipAll} disabled={busy || !done.length}><Download className="size-4" aria-hidden />Download all as ZIP</Button>
        <Button type="button" variant="ghost" onClick={clear} disabled={busy || !rows.length}><Trash2 className="size-4" aria-hidden />Clear</Button>
      </div>
      {busy && <div className="h-2 overflow-hidden rounded-full bg-[var(--bg-subtle)]"><div className="h-full bg-accent transition-all" style={{ width: `${(progress / Math.max(1, rows.length)) * 100}%` }} /></div>}

      {done.length > 0 && (
        <div className="grid grid-cols-3 gap-3">
          <Stat label="Before" value={sizeLabel(before)} /><Stat label="After" value={sizeLabel(after)} />
          <Stat label="Saved" value={`${fmt(before ? (1 - after / before) * 100 : 0, 1)}%`} />
        </div>
      )}

      {rows.length > 0 && (
        <div className="overflow-x-auto rounded-xl border border-[var(--border)]">
          <table className="w-full min-w-[34rem] text-sm">
            <thead className="bg-[var(--bg-subtle)] text-left text-xs text-[var(--muted)]"><tr><th className="p-2.5">File</th><th className="p-2.5">Original</th><th className="p-2.5">New</th><th className="p-2.5">Saved</th><th className="p-2.5" /></tr></thead>
            <tbody className="divide-y divide-[var(--border)]">
              {rows.map((r) => {
                const pct = r.out ? (1 - r.out.size / r.file.size) * 100 : 0;
                return (
                  <tr key={r.id}>
                    <td className="max-w-[14rem] p-2.5"><p className="truncate font-medium">{r.file.name}</p>{r.w && <p className="text-xs text-[var(--muted)]">{r.w}×{r.h}</p>}{r.error && <p className="text-xs text-red-600 dark:text-red-400">{r.error}</p>}</td>
                    <td className="whitespace-nowrap p-2.5">{sizeLabel(r.file.size)}</td>
                    <td className="whitespace-nowrap p-2.5">{r.out ? sizeLabel(r.out.size) : r.status === "error" ? "Failed" : "-"}</td>
                    <td className={cx("whitespace-nowrap p-2.5 font-medium", r.out && (pct >= 0 ? "text-emerald-600 dark:text-emerald-400" : "text-amber-600"))}>{r.out ? `${pct >= 0 ? "" : "+"}${fmt(Math.abs(pct), 1)}%` : ""}</td>
                    <td className="p-2.5 text-right">{r.url && r.name ? <a href={r.url} download={r.name} className="inline-flex items-center gap-1 text-xs font-semibold text-accent hover:underline"><Download className="size-3.5" aria-hidden />Save</a> : <button type="button" disabled={busy} aria-label="Remove" onClick={() => setRows((s) => s.filter((x) => x.id !== r.id))} className="text-[var(--muted)] hover:text-red-600"><Trash2 className="size-4" /></button>}</td>
                  </tr>
                );
              })}
            </tbody>
          </table>
        </div>
      )}
      {done.some((r) => r.out!.size > r.file.size) && <p className="text-xs text-[var(--muted)]">Some files got bigger. Try a lower quality or WebP for those.</p>}
    </div>
  );
}
