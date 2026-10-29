"use client";
import { useRef, useState } from "react";
import QRCode from "react-qr-code";
import { Button, Field, Input } from "@/components/ui";
import { TextArea } from "./shared";

export default function QrCodeGenerator() {
  const [text, setText] = useState("https://mewemarket.com");
  const [fg, setFg] = useState("#000000");
  const [bg, setBg] = useState("#ffffff");
  const wrap = useRef<HTMLDivElement>(null);
  const svgString = () => { const s = wrap.current?.querySelector("svg"); return s ? new XMLSerializer().serializeToString(s) : ""; };
  const download = (href: string, name: string) => { const a = document.createElement("a"); a.href = href; a.download = name; a.click(); };
  const dlSvg = () => { const url = URL.createObjectURL(new Blob([svgString()], { type: "image/svg+xml" })); download(url, "qr-code.svg"); setTimeout(() => URL.revokeObjectURL(url), 1000); };
  const dlPng = () => {
    const img = new Image();
    img.onload = () => { const c = document.createElement("canvas"); c.width = c.height = 1024; const ctx = c.getContext("2d")!; ctx.fillStyle = bg; ctx.fillRect(0, 0, 1024, 1024); ctx.drawImage(img, 64, 64, 896, 896); download(c.toDataURL("image/png"), "qr-code.png"); };
    img.src = "data:image/svg+xml;charset=utf-8," + encodeURIComponent(svgString());
  };
  return (
    <div className="grid gap-6 md:grid-cols-2">
      <div className="space-y-4">
        <Field label="Link or text"><TextArea className="min-h-28 font-sans" value={text} onChange={(e) => setText(e.target.value)} /></Field>
        <div className="grid grid-cols-2 gap-4">
          <Field label="Foreground"><Input type="color" className="p-1" value={fg} onChange={(e) => setFg(e.target.value)} /></Field>
          <Field label="Background"><Input type="color" className="p-1" value={bg} onChange={(e) => setBg(e.target.value)} /></Field>
        </div>
        <div className="flex flex-wrap gap-2"><Button type="button" onClick={dlPng} disabled={!text}>Download PNG</Button><Button type="button" variant="secondary" onClick={dlSvg} disabled={!text}>Download SVG</Button></div>
      </div>
      <div ref={wrap} className="flex items-center justify-center rounded-lg p-4" style={{ background: bg }}>
        {text ? <QRCode value={text} fgColor={fg} bgColor={bg} size={240} title="QR code preview" /> : <p className="text-sm text-gray-500">Type something to make a code.</p>}
      </div>
    </div>
  );
}
