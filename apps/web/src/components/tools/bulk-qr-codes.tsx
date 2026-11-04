"use client";
import { useEffect, useMemo, useState } from "react";
import { Download } from "lucide-react";
import QRCode from "qrcode";
import { Alert, Button, Field, Input } from "@/components/ui";
import { Select, Stat, TextArea } from "./shared";

type Ecl = "L" | "M" | "Q" | "H";
type Entry = { name: string; content: string };
const PREVIEW = 12;

const sanitize = (s: string) => s.normalize("NFKD").replace(/[̀-ͯ]/g, "").replace(/^[a-z]+:\/\//i, "").replace(/[^\w\-.]+/g, "-").replace(/-+/g, "-").replace(/^[-.]+|[-.]+$/g, "").slice(0, 60);

function splitLine(line: string): [string, string] | null {
  // "filename,content" where filename may be quoted and content keeps any further commas
  const m = line.match(/^\s*(?:"((?:[^"]|"")*)"|([^,]*)),(.*)$/);
  if (!m) return null;
  let content = (m[3] ?? "").trim();
  if (/^".*"$/.test(content)) content = content.slice(1, -1).replace(/""/g, '"');
  return [(m[1] ?? m[2] ?? "").replace(/""/g, '"').trim(), content];
}

function parse(src: string, csv: boolean): Entry[] {
  const used = new Map<string, number>();
  return src.split(/\r?\n/).map((l) => l.trim()).filter(Boolean).map((line, i) => {
    let name = "", content = line;
    if (csv) { const p = splitLine(line); if (p && p[1]) [name, content] = p; }
    let base = sanitize(name || content) || `qr-${i + 1}`;
    const key = base.toLowerCase(); const n = used.get(key) ?? 0; used.set(key, n + 1);
    if (n) base = `${base}-${n + 1}`;
    return { name: base, content };
  });
}

export default function BulkQrCodes() {
  const [text, setText] = useState("https://mewemarket.com\nhttps://example.com/product/1\nhttps://example.com/product/2");
  const [csv, setCsv] = useState(false);
  const [size, setSize] = useState("512"); const [margin, setMargin] = useState("2");
  const [fg, setFg] = useState("#000000"); const [bg, setBg] = useState("#ffffff");
  const [ecl, setEcl] = useState<Ecl>("M"); const [format, setFormat] = useState<"png" | "svg">("png");
  const [previews, setPreviews] = useState<string[]>([]);
  const [err, setErr] = useState(""); const [busy, setBusy] = useState(false); const [progress, setProgress] = useState(0);

  const entries = useMemo(() => parse(text, csv), [text, csv]);
  const opts = useMemo(() => ({ width: Math.min(4096, Math.max(64, parseInt(size) || 512)), margin: Math.min(20, Math.max(0, parseInt(margin) || 0)), errorCorrectionLevel: ecl, color: { dark: fg, light: bg } }), [size, margin, ecl, fg, bg]);

  useEffect(() => {
    let live = true;
    Promise.all(entries.slice(0, PREVIEW).map((e) => QRCode.toDataURL(e.content, { ...opts, width: 256 }).catch(() => "")))
      .then((r) => { if (live) { setPreviews(r); setErr(r.some((x) => !x) ? "Some lines are too long to fit in a QR code. Shorten them or use a lower error-correction level." : ""); } });
    return () => { live = false; };
  }, [entries, opts]);

  const download = async () => {
    setBusy(true); setErr(""); setProgress(0);
    try {
      const { zipSync, strToU8 } = await import("fflate");
      const files: Record<string, Uint8Array> = {}; const bad: string[] = [];
      for (let i = 0; i < entries.length; i++) {
        const e = entries[i]!;
        try {
          if (format === "svg") files[`${e.name}.svg`] = strToU8(await QRCode.toString(e.content, { ...opts, type: "svg" }));
          else { const url = await QRCode.toDataURL(e.content, opts); const bin = atob(url.split(",")[1] ?? ""); const u = new Uint8Array(bin.length); for (let j = 0; j < bin.length; j++) u[j] = bin.charCodeAt(j); files[`${e.name}.png`] = u; }
        } catch { bad.push(`line ${i + 1}`); }
        if (i % 20 === 0) { setProgress(i + 1); await new Promise((r) => setTimeout(r)); }
      }
      if (!Object.keys(files).length) throw new Error("No QR codes could be made. Check your list.");
      const url = URL.createObjectURL(new Blob([new Uint8Array(zipSync(files, { level: format === "png" ? 0 : 6 }))], { type: "application/zip" }));
      const a = document.createElement("a"); a.href = url; a.download = `qr-codes-${format}.zip`; a.click();
      setTimeout(() => URL.revokeObjectURL(url), 1500);
      if (bad.length) setErr(`Skipped ${bad.length} item(s) that were too long: ${bad.slice(0, 5).join(", ")}${bad.length > 5 ? "…" : ""}`);
    } catch (e) { setErr((e as Error).message); } finally { setBusy(false); }
  };

  return (
    <div className="grid gap-6 lg:grid-cols-2">
      <div className="min-w-0 space-y-4">
        <Field label={csv ? "One per line: filename,content" : "One link or text per line"} hint={csv ? 'Example: product-1,https://example.com/p/1 (quote names that contain commas)' : "The file name is made from the content."}>
          <TextArea className="min-h-56" value={text} onChange={(e) => setText(e.target.value)} placeholder={csv ? "name,https://…" : "https://…"} />
        </Field>
        <label className="flex items-center gap-2 text-sm"><input type="checkbox" checked={csv} onChange={(e) => setCsv(e.target.checked)} /> Lines are CSV with a file name first</label>
        <div className="grid grid-cols-2 gap-4">
          <Field label="Size (px)"><Input type="number" min={64} max={4096} value={size} onChange={(e) => setSize(e.target.value)} /></Field>
          <Field label="Margin (modules)"><Input type="number" min={0} max={20} value={margin} onChange={(e) => setMargin(e.target.value)} /></Field>
          <Field label="Foreground"><Input type="color" className="p-1" value={fg} onChange={(e) => setFg(e.target.value)} /></Field>
          <Field label="Background"><Input type="color" className="p-1" value={bg} onChange={(e) => setBg(e.target.value)} /></Field>
          <Field label="Error correction"><Select value={ecl} onChange={(e) => setEcl(e.target.value as Ecl)}><option value="L">Low (7%)</option><option value="M">Medium (15%)</option><option value="Q">Quartile (25%)</option><option value="H">High (30%)</option></Select></Field>
          <Field label="Format"><Select value={format} onChange={(e) => setFormat(e.target.value as "png" | "svg")}><option value="png">PNG</option><option value="svg">SVG</option></Select></Field>
        </div>
        <Button type="button" onClick={download} disabled={busy || !entries.length}><Download className="size-4" aria-hidden />{busy ? `Building ${progress}/${entries.length}…` : `Download all ${entries.length} as ZIP`}</Button>
        {err && <Alert>{err}</Alert>}
      </div>
      <div className="min-w-0 space-y-3">
        <div className="grid grid-cols-2 gap-3"><Stat label="QR codes" value={entries.length} /><Stat label="Format" value={format.toUpperCase()} /></div>
        {entries.length ? (
          <div className="grid grid-cols-2 gap-3 sm:grid-cols-3">
            {entries.slice(0, PREVIEW).map((e, i) => (
              <figure key={i} className="min-w-0 rounded-xl border border-[var(--border)] bg-[var(--bg-subtle)] p-2">
                {previews[i] ? <img src={previews[i]} alt={`QR code for ${e.content}`} className="aspect-square w-full rounded" /> : <div className="flex aspect-square items-center justify-center text-center text-xs text-red-600">Too long</div>}
                <figcaption className="mt-1.5 truncate text-xs text-[var(--muted)]" title={`${e.name}.${format}`}>{e.name}.{format}</figcaption>
              </figure>
            ))}
          </div>
        ) : <p className="rounded-xl border border-dashed border-[var(--border)] p-6 text-center text-sm text-[var(--muted)]">Add some lines to see previews.</p>}
        {entries.length > PREVIEW && <p className="text-xs text-[var(--muted)]">Showing the first {PREVIEW} of {entries.length}. All are included in the ZIP.</p>}
      </div>
    </div>
  );
}
