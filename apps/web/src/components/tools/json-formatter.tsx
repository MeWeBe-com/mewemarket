"use client";
import { useState } from "react";
import { Button, Alert } from "@/components/ui";
import { Output, TextArea, Select } from "./shared";

export default function JsonFormatter() {
  const [input, setInput] = useState('{"name":"MeweMarket","tools":["json","qr"],"free":true}');
  const [indent, setIndent] = useState("2");
  const [out, setOut] = useState("");
  const [err, setErr] = useState("");
  const run = (min: boolean) => {
    try { const v = JSON.parse(input); setOut(min ? JSON.stringify(v) : JSON.stringify(v, null, indent === "tab" ? "\t" : Number(indent))); setErr(""); }
    catch (e) { setErr(e instanceof Error ? e.message : "Invalid JSON"); setOut(""); }
  };
  return (
    <div className="space-y-4">
      <label className="block space-y-1.5"><span className="text-sm font-medium">JSON input</span><TextArea className="min-h-56" value={input} onChange={(e) => setInput(e.target.value)} /></label>
      <div className="flex flex-wrap items-center gap-2">
        <Button type="button" onClick={() => run(false)}>Format</Button>
        <Button type="button" variant="secondary" onClick={() => run(true)}>Minify</Button>
        <label className="flex items-center gap-2 text-sm">Indent <Select className="w-28" value={indent} onChange={(e) => setIndent(e.target.value)}><option value="2">2 spaces</option><option value="4">4 spaces</option><option value="tab">Tab</option></Select></label>
      </div>
      {err && <Alert>{err}</Alert>}
      {out && <Alert tone="success">Valid JSON</Alert>}
      <Output label="Result" value={out} />
    </div>
  );
}
