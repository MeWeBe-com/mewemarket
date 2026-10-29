"use client";
import { useState } from "react";
import { Alert, Button } from "@/components/ui";
import { Output, TextArea } from "./shared";

const enc = (s: string, urlSafe: boolean) => {
  const bytes = new TextEncoder().encode(s); let bin = ""; bytes.forEach((b) => (bin += String.fromCharCode(b)));
  const b = btoa(bin); return urlSafe ? b.replace(/\+/g, "-").replace(/\//g, "_").replace(/=+$/, "") : b;
};
const dec = (s: string) => {
  let b = s.trim().replace(/-/g, "+").replace(/_/g, "/").replace(/\s/g, ""); while (b.length % 4) b += "=";
  const bin = atob(b); return new TextDecoder("utf-8", { fatal: true }).decode(Uint8Array.from(bin, (c) => c.charCodeAt(0)));
};

export default function Base64Tool() {
  const [input, setInput] = useState("Hello, world!");
  const [mode, setMode] = useState<"encode" | "decode">("encode");
  const [urlSafe, setUrlSafe] = useState(false);
  let out = "", err = "";
  try { out = mode === "encode" ? enc(input, urlSafe) : dec(input); } catch { err = "That is not valid Base64 text."; }
  return (
    <div className="space-y-4">
      <div className="flex flex-wrap items-center gap-2">
        <Button type="button" variant={mode === "encode" ? "primary" : "secondary"} aria-pressed={mode === "encode"} onClick={() => setMode("encode")}>Encode</Button>
        <Button type="button" variant={mode === "decode" ? "primary" : "secondary"} aria-pressed={mode === "decode"} onClick={() => setMode("decode")}>Decode</Button>
        <Button type="button" variant="ghost" onClick={() => { setInput(out); setMode(mode === "encode" ? "decode" : "encode"); }} disabled={!out}>Swap</Button>
        {mode === "encode" && <label className="flex items-center gap-2 text-sm"><input type="checkbox" checked={urlSafe} onChange={(e) => setUrlSafe(e.target.checked)} /> URL-safe</label>}
      </div>
      <label className="block space-y-1.5"><span className="text-sm font-medium">{mode === "encode" ? "Text" : "Base64"}</span><TextArea value={input} onChange={(e) => setInput(e.target.value)} /></label>
      {err ? <Alert>{err}</Alert> : <Output label={mode === "encode" ? "Base64" : "Text"} value={out} />}
    </div>
  );
}
