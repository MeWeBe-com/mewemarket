"use client";
import { useState } from "react";
import { Output, TextArea } from "./shared";

const words = (s: string) => s.replace(/([a-z0-9])([A-Z])/g, "$1 $2").split(/[^\p{L}\p{N}]+/u).filter(Boolean);
const cap = (w: string) => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase();

export default function CaseConverter() {
  const [text, setText] = useState("Hello world from MeweMarket");
  const w = words(text);
  const cases: [string, string][] = [
    ["UPPER CASE", text.toUpperCase()],
    ["lower case", text.toLowerCase()],
    ["Title Case", text.toLowerCase().replace(/(^|\s)(\p{L})/gu, (m) => m.toUpperCase())],
    ["Sentence case", text.toLowerCase().replace(/(^\s*|[.!?]\s+)(\p{L})/gu, (m) => m.toUpperCase())],
    ["camelCase", w.map((x, i) => (i ? cap(x) : x.toLowerCase())).join("")],
    ["PascalCase", w.map(cap).join("")],
    ["snake_case", w.map((x) => x.toLowerCase()).join("_")],
    ["kebab-case", w.map((x) => x.toLowerCase()).join("-")],
    ["CONSTANT_CASE", w.map((x) => x.toUpperCase()).join("_")],
  ];
  return (
    <div className="space-y-4">
      <label className="block space-y-1.5"><span className="text-sm font-medium">Text</span><TextArea className="min-h-24 font-sans" value={text} onChange={(e) => setText(e.target.value)} /></label>
      <div className="grid gap-4 md:grid-cols-2">{cases.map(([l, v]) => <Output key={l} label={l} value={v} />)}</div>
    </div>
  );
}
