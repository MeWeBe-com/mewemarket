"use client";
import { useEffect, useRef, useState } from "react";
import { Download, ImagePlus } from "lucide-react";
import { Button, Field, Input } from "@/components/ui";
import { Select, Stat, fmt } from "./shared";

type Fmt = "image/jpeg" | "image/png" | "image/webp";
const EXT: Record<Fmt, string> = { "image/jpeg": "jpg", "image/png": "png", "image/webp": "webp" };
const size = (b: number) => (b < 1024 ? `${b} B` : b < 1048576 ? `${fmt(b / 1024, 1)} KB` : `${fmt(b / 1048576, 2)} MB`);

export default function ImageResizer() {
  const [file, setFile] = useState<File | null>(null);
  const [src, setSrc] = useState("");
  const [nat, setNat] = useState({ w: 0, h: 0 });
  const [by, setBy] = useState<"px" | "pct">("px");
  const [w, setW] = useState("");
  const [h, setH] = useState("");
  const [pct, setPct] = useState("50");
  const [keep, setKeep] = useState(true);
  const [format, setFormat] = useState<Fmt>("image/jpeg");
  const [quality, setQuality] = useState(85);
  const [out, setOut] = useState<{ url: string; size: number; w: number; h: number } | null>(null);
  const [drag, setDrag] = useState(false);
  const [err, setErr] = useState("");
  const imgRef = useRef<HTMLImageElement | null>(null);
  const inputRef = useRef<HTMLInputElement>(null);
  const urls = useRef<string[]>([]);

  useEffect(() => () => { urls.current.forEach((u) => URL.revokeObjectURL(u)); }, []);
  const track = (u: string) => { urls.current.push(u); return u; };

  const load = (f: File | undefined) => {
    if (!f) return;
    if (!/^image\/(jpeg|png|webp)$/.test(f.type)) { setErr("Please choose a JPG, PNG or WebP image."); return; }
    setErr("");
    const u = track(URL.createObjectURL(f));
    const img = new Image();
    img.onload = () => { imgRef.current = img; setFile(f); setFormat(f.type as Fmt); setSrc(u); setOut(null); setNat({ w: img.naturalWidth, h: img.naturalHeight }); setW(String(img.naturalWidth)); setH(String(img.naturalHeight)); };
    img.onerror = () => setErr("That image could not be read.");
    img.src = u;
  };

  const target = () => {
    if (!nat.w) return { tw: 0, th: 0 };
    if (by === "pct") { const p = Math.max(1, parseFloat(pct) || 0) / 100; return { tw: Math.max(1, Math.round(nat.w * p)), th: Math.max(1, Math.round(nat.h * p)) }; }
    return { tw: Math.max(1, Math.round(parseFloat(w) || 0)), th: Math.max(1, Math.round(parseFloat(h) || 0)) };
  };
  const { tw, th } = target();

  const onW = (v: string) => { setW(v); if (keep && nat.w) setH(String(Math.max(1, Math.round(((parseFloat(v) || 0) * nat.h) / nat.w)))); };
  const onH = (v: string) => { setH(v); if (keep && nat.h) setW(String(Math.max(1, Math.round(((parseFloat(v) || 0) * nat.w) / nat.h)))); };

  useEffect(() => {
    const img = imgRef.current;
    if (!img || !tw || !th || tw > 16000 || th > 16000) return;
    let cancelled = false;
    const t = setTimeout(() => {
      const c = document.createElement("canvas"); c.width = tw; c.height = th;
      const ctx = c.getContext("2d"); if (!ctx) return;
      if (format === "image/jpeg") { ctx.fillStyle = "#fff"; ctx.fillRect(0, 0, tw, th); }
      ctx.imageSmoothingQuality = "high";
      ctx.drawImage(img, 0, 0, tw, th);
      c.toBlob((b) => {
        if (!b || cancelled) return;
        const u = track(URL.createObjectURL(b));
        setOut((prev) => { if (prev) URL.revokeObjectURL(prev.url); return { url: u, size: b.size, w: tw, h: th }; });
      }, format, quality / 100);
    }, 250);
    return () => { cancelled = true; clearTimeout(t); };
  }, [tw, th, format, quality, src, nat.w]);

  const download = () => {
    if (!out || !file) return;
    const a = document.createElement("a"); a.href = out.url;
    a.download = `${file.name.replace(/\.[^.]+$/, "")}-${out.w}x${out.h}.${EXT[format]}`; a.click();
  };

  return (
    <div className="space-y-6">
      <div
        onDragOver={(e) => { e.preventDefault(); setDrag(true); }}
        onDragLeave={() => setDrag(false)}
        onDrop={(e) => { e.preventDefault(); setDrag(false); load(e.dataTransfer.files[0]); }}
        onClick={() => inputRef.current?.click()}
        className={`flex cursor-pointer flex-col items-center justify-center gap-2 rounded-lg border-2 border-dashed p-6 text-center text-sm ${drag ? "border-accent bg-accent/5" : "border-[var(--border)] bg-[var(--bg-subtle)]"}`}
      >
        <ImagePlus className="size-6 text-[var(--muted)]" aria-hidden />
        <span className="font-medium">{file ? file.name : "Drop an image here or tap to choose"}</span>
        <span className="text-xs text-[var(--muted)]">JPG, PNG or WebP. Your image stays on your device.</span>
        <input ref={inputRef} type="file" accept="image/jpeg,image/png,image/webp" className="hidden" onChange={(e) => { load(e.target.files?.[0]); e.target.value = ""; }} />
      </div>
      {err && <p className="text-sm text-red-600 dark:text-red-400">{err}</p>}

      {file && nat.w > 0 && (
        <>
          <div className="grid gap-4 sm:grid-cols-2">
            <Field label="Resize by">
              <Select value={by} onChange={(e) => setBy(e.target.value as "px" | "pct")}><option value="px">Width and height</option><option value="pct">Percentage</option></Select>
            </Field>
            {by === "pct" ? (
              <Field label="Percentage (%)"><Input type="number" min={1} max={400} value={pct} onChange={(e) => setPct(e.target.value)} /></Field>
            ) : (
              <div className="grid grid-cols-2 gap-3">
                <Field label="Width (px)"><Input type="number" min={1} value={w} onChange={(e) => onW(e.target.value)} /></Field>
                <Field label="Height (px)"><Input type="number" min={1} value={h} onChange={(e) => onH(e.target.value)} /></Field>
              </div>
            )}
            <Field label="Output format">
              <Select value={format} onChange={(e) => setFormat(e.target.value as Fmt)}><option value="image/jpeg">JPEG</option><option value="image/png">PNG</option><option value="image/webp">WebP</option></Select>
            </Field>
            <Field label={`Quality: ${quality}%`} hint={format === "image/png" ? "PNG is lossless, so quality has no effect." : undefined}>
              <input type="range" min={10} max={100} value={quality} disabled={format === "image/png"} onChange={(e) => setQuality(+e.target.value)} className="w-full accent-[var(--color-accent,#5b5bf6)]" />
            </Field>
          </div>
          {by === "px" && (
            <label className="flex items-center gap-2 text-sm"><input type="checkbox" checked={keep} onChange={(e) => { setKeep(e.target.checked); if (e.target.checked) onW(w); }} /> Keep aspect ratio</label>
          )}
          <div className="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <Stat label="Original" value={`${nat.w}×${nat.h}`} />
            <Stat label="Original size" value={size(file.size)} />
            <Stat label="New" value={`${tw}×${th}`} />
            <Stat label="New size" value={out ? size(out.size) : "…"} />
          </div>
          <div className="grid gap-4 sm:grid-cols-2">
            <figure className="space-y-1.5">
              <figcaption className="text-sm font-medium">Before</figcaption>
              <div className="flex items-center justify-center rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] p-2"><img src={src} alt="Original" className="max-h-64 max-w-full object-contain" /></div>
            </figure>
            <figure className="space-y-1.5">
              <figcaption className="text-sm font-medium">After</figcaption>
              <div className="flex items-center justify-center rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] p-2">{out ? <img src={out.url} alt="Resized" className="max-h-64 max-w-full object-contain" /> : <span className="text-sm text-[var(--muted)]">Working…</span>}</div>
            </figure>
          </div>
          <Button type="button" onClick={download} disabled={!out}><Download className="size-4" aria-hidden /> Download {EXT[format].toUpperCase()}</Button>
        </>
      )}
    </div>
  );
}
