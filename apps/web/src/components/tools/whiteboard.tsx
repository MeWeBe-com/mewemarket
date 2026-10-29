"use client";
import { useEffect, useRef, useState } from "react";
import { Download, Eraser, Pen, Trash2 } from "lucide-react";
import { Button } from "@/components/ui";

const COLOURS = ["#111827", "#ef4444", "#f59e0b", "#10b981", "#3b82f6", "#8b5cf6", "#ec4899"];

export default function Whiteboard() {
  const canvas = useRef<HTMLCanvasElement>(null);
  const [colour, setColour] = useState<string>(COLOURS[0]!);
  const [size, setSize] = useState(4);
  const [erase, setErase] = useState(false);
  const last = useRef<{ x: number; y: number } | null>(null);

  useEffect(() => {
    const c = canvas.current!; const ctx = c.getContext("2d")!;
    const resize = () => {
      const r = c.getBoundingClientRect(); const dpr = window.devicePixelRatio || 1;
      const copy = document.createElement("canvas"); copy.width = c.width; copy.height = c.height; copy.getContext("2d")!.drawImage(c, 0, 0);
      c.width = Math.round(r.width * dpr); c.height = Math.round(r.height * dpr);
      ctx.fillStyle = "#ffffff"; ctx.fillRect(0, 0, c.width, c.height); ctx.drawImage(copy, 0, 0);
    };
    resize();
    window.addEventListener("resize", resize);
    return () => window.removeEventListener("resize", resize);
  }, []);

  const pos = (e: React.PointerEvent) => { const c = canvas.current!; const r = c.getBoundingClientRect(); return { x: (e.clientX - r.left) * (c.width / r.width), y: (e.clientY - r.top) * (c.height / r.height) }; };
  const draw = (e: React.PointerEvent) => {
    if (!last.current) return;
    const ctx = canvas.current!.getContext("2d")!; const p = pos(e); const dpr = window.devicePixelRatio || 1;
    ctx.strokeStyle = erase ? "#ffffff" : colour; ctx.lineWidth = (erase ? size * 4 : size) * dpr; ctx.lineCap = "round"; ctx.lineJoin = "round";
    ctx.beginPath(); ctx.moveTo(last.current.x, last.current.y); ctx.lineTo(p.x, p.y); ctx.stroke(); last.current = p;
  };
  const clear = () => { const c = canvas.current!; const ctx = c.getContext("2d")!; ctx.fillStyle = "#ffffff"; ctx.fillRect(0, 0, c.width, c.height); };
  const download = () => { const a = document.createElement("a"); a.href = canvas.current!.toDataURL("image/png"); a.download = "whiteboard.png"; a.click(); };

  return (
    <div className="space-y-3">
      <div className="flex flex-wrap items-center gap-2" role="toolbar" aria-label="Drawing tools">
        <Button type="button" variant={erase ? "secondary" : "primary"} aria-pressed={!erase} onClick={() => setErase(false)}><Pen className="size-4" aria-hidden /> Pen</Button>
        <Button type="button" variant={erase ? "primary" : "secondary"} aria-pressed={erase} onClick={() => setErase(true)}><Eraser className="size-4" aria-hidden /> Eraser</Button>
        <div className="flex gap-1">
          {COLOURS.map((c) => (
            <button key={c} type="button" aria-label={`Colour ${c}`} aria-pressed={colour === c && !erase} onClick={() => { setColour(c); setErase(false); }} className={`size-8 rounded-full border-2 ${colour === c && !erase ? "border-accent" : "border-[var(--border)]"}`} style={{ background: c }} />
          ))}
        </div>
        <label className="flex items-center gap-2 text-sm">Size <input type="range" min={1} max={30} value={size} onChange={(e) => setSize(Number(e.target.value))} /></label>
        <Button type="button" variant="secondary" onClick={clear}><Trash2 className="size-4" aria-hidden /> Clear</Button>
        <Button type="button" variant="secondary" onClick={download}><Download className="size-4" aria-hidden /> PNG</Button>
      </div>
      <canvas
        ref={canvas}
        aria-label="Drawing area"
        className="h-[60vh] min-h-80 w-full cursor-crosshair touch-none rounded-lg border border-[var(--border)] bg-white"
        onPointerDown={(e) => { e.currentTarget.setPointerCapture(e.pointerId); last.current = pos(e); draw(e); }}
        onPointerMove={draw}
        onPointerUp={() => (last.current = null)}
        onPointerCancel={() => (last.current = null)}
      />
    </div>
  );
}
