"use client";
import { useState } from "react";
import { Alert } from "@/components/ui";
import { Output, Select, TextArea } from "./shared";

export default function UrlEncoder() {
  const [input, setInput] = useState("https://example.com/search?q=hello world&lang=en");
  const [mode, setMode] = useState("component");
  let out = "", err = "";
  try {
    out = mode === "component" ? encodeURIComponent(input) : mode === "uri" ? encodeURI(input) : decodeURIComponent(input.replace(/\+/g, " "));
  } catch { err = "This text has a broken percent code and cannot be decoded."; }
  return (
    <div className="space-y-4">
      <label className="block max-w-xs space-y-1.5"><span className="text-sm font-medium">Mode</span>
        <Select value={mode} onChange={(e) => setMode(e.target.value)}><option value="component">Encode (component)</option><option value="uri">Encode (full URL)</option><option value="decode">Decode</option></Select>
      </label>
      <label className="block space-y-1.5"><span className="text-sm font-medium">Input</span><TextArea className="min-h-28" value={input} onChange={(e) => setInput(e.target.value)} /></label>
      {err ? <Alert>{err}</Alert> : <Output label="Result" value={out} />}
    </div>
  );
}
