"use client";
import { useState } from "react";
import { Field, Input } from "@/components/ui";
import { Output } from "./shared";

type RGB = [number, number, number];
function parse(s: string): RGB | null {
  s = s.trim().toLowerCase();
  let m = s.match(/^#?([0-9a-f]{3}|[0-9a-f]{6})$/);
  if (m) { let h = m[1]!; if (h.length === 3) h = [...h].map((c) => c + c).join(""); return [0, 2, 4].map((i) => parseInt(h.slice(i, i + 2), 16)) as RGB; }
  m = s.match(/^rgba?\(\s*(\d+)[,\s]+(\d+)[,\s]+(\d+)/);
  if (m) return [m[1], m[2], m[3]].map((x) => Math.min(255, +x!)) as RGB;
  m = s.match(/^hsla?\(\s*([\d.]+)(?:deg)?[,\s]+([\d.]+)%[,\s]+([\d.]+)%/);
  if (m) return hslToRgb(+m[1]!, +m[2]! / 100, +m[3]! / 100);
  return null;
}
function hslToRgb(h: number, s: number, l: number): RGB {
  const k = (n: number) => (n + h / 30) % 12, a = s * Math.min(l, 1 - l);
  const f = (n: number) => l - a * Math.max(-1, Math.min(k(n) - 3, 9 - k(n), 1));
  return [f(0), f(8), f(4)].map((x) => Math.round(x * 255)) as RGB;
}
function rgbToHsl([r, g, b]: RGB) {
  r /= 255; g /= 255; b /= 255;
  const max = Math.max(r, g, b), min = Math.min(r, g, b), l = (max + min) / 2, d = max - min;
  let h = 0; const s = d === 0 ? 0 : d / (1 - Math.abs(2 * l - 1));
  if (d) h = max === r ? ((g - b) / d) % 6 : max === g ? (b - r) / d + 2 : (r - g) / d + 4;
  return [Math.round((h * 60 + 360) % 360), Math.round(s * 100), Math.round(l * 100)];
}
const hex = (c: RGB) => "#" + c.map((x) => x.toString(16).padStart(2, "0")).join("");

export default function ColorConverter() {
  const [input, setInput] = useState("#6366f1");
  const rgb = parse(input);
  return (
    <div className="space-y-4">
      <div className="flex items-end gap-3">
        <div className="flex-1"><Field label="Colour (HEX, RGB or HSL)" hint={rgb ? undefined : "Try #ff8800, rgb(255, 136, 0) or hsl(32, 100%, 50%)"}><Input value={input} onChange={(e) => setInput(e.target.value)} /></Field></div>
        <label className={rgb ? "" : "pb-5"}><span className="sr-only">Colour picker</span><input type="color" className="h-10 w-14 cursor-pointer rounded border border-[var(--border)]" value={rgb ? hex(rgb) : "#000000"} onChange={(e) => setInput(e.target.value)} /></label>
      </div>
      {rgb && (
        <>
          <div className="h-20 rounded-lg border border-[var(--border)]" style={{ background: hex(rgb) }} aria-hidden />
          <div className="grid gap-4 sm:grid-cols-3">
            <Output label="HEX" value={hex(rgb)} />
            <Output label="RGB" value={`rgb(${rgb.join(", ")})`} />
            <Output label="HSL" value={(() => { const [h, s, l] = rgbToHsl(rgb); return `hsl(${h}, ${s}%, ${l}%)`; })()} />
          </div>
        </>
      )}
    </div>
  );
}
