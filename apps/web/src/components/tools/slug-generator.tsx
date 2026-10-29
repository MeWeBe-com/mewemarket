"use client";
import { useState } from "react";
import { Output, Select, TextArea } from "./shared";

const slugify = (s: string, sep: string) => s.normalize("NFKD").replace(/[̀-ͯ]/g, "").toLowerCase().replace(/&/g, " and ").replace(/[^a-z0-9]+/g, sep).split(sep).filter(Boolean).join(sep);

export default function SlugGenerator() {
  const [text, setText] = useState("10 Tips for Café Owners & Small Shops!");
  const [sep, setSep] = useState("-");
  return (
    <div className="space-y-4">
      <label className="block space-y-1.5"><span className="text-sm font-medium">Titles (one per line)</span><TextArea className="min-h-24 font-sans" value={text} onChange={(e) => setText(e.target.value)} /></label>
      <label className="block max-w-xs space-y-1.5"><span className="text-sm font-medium">Separator</span><Select value={sep} onChange={(e) => setSep(e.target.value)}><option value="-">Hyphen (-)</option><option value="_">Underscore (_)</option></Select></label>
      <Output label="Slugs" value={text.split("\n").map((l) => slugify(l, sep)).join("\n")} />
    </div>
  );
}
