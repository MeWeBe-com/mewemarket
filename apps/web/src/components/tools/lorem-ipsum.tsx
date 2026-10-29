"use client";
import { useMemo, useState } from "react";
import { Button, Field, Input } from "@/components/ui";
import { Output, Select } from "./shared";

const W = "lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi aliquip ex ea commodo consequat duis aute irure in reprehenderit voluptate velit esse cillum fugiat nulla pariatur excepteur sint occaecat cupidatat non proident sunt culpa qui officia deserunt mollit anim id est laborum".split(" ");
const r = (n: number) => Math.floor(Math.random() * n);
const sentence = () => { const s = Array.from({ length: 6 + r(10) }, () => W[r(W.length)]).join(" "); return s.charAt(0).toUpperCase() + s.slice(1) + "."; };
const para = () => Array.from({ length: 4 + r(4) }, sentence).join(" ");

export default function LoremIpsum() {
  const [count, setCount] = useState("3");
  const [unit, setUnit] = useState("paragraphs");
  const [classic, setClassic] = useState(true);
  const [seed, setSeed] = useState(0);
  const out = useMemo(() => {
    const n = Math.min(200, Math.max(1, parseInt(count) || 1));
    let t = unit === "paragraphs" ? Array.from({ length: n }, para).join("\n\n") : unit === "sentences" ? Array.from({ length: n }, sentence).join(" ") : Array.from({ length: n }, () => W[r(W.length)]).join(" ");
    if (classic) t = "Lorem ipsum dolor sit amet, " + t.charAt(0).toLowerCase() + t.slice(1);
    return t;
  }, [count, unit, classic, seed]); // eslint-disable-line react-hooks/exhaustive-deps
  return (
    <div className="space-y-4">
      <div className="flex flex-wrap items-end gap-3">
        <div className="w-28"><Field label="Amount"><Input type="number" min={1} max={200} value={count} onChange={(e) => setCount(e.target.value)} /></Field></div>
        <label className="block w-40 space-y-1.5"><span className="text-sm font-medium">Type</span><Select value={unit} onChange={(e) => setUnit(e.target.value)}><option value="paragraphs">Paragraphs</option><option value="sentences">Sentences</option><option value="words">Words</option></Select></label>
        <label className="flex h-10 items-center gap-2 text-sm"><input type="checkbox" checked={classic} onChange={(e) => setClassic(e.target.checked)} /> Start with &quot;Lorem ipsum&quot;</label>
        <Button type="button" onClick={() => setSeed(seed + 1)}>Regenerate</Button>
      </div>
      <Output label="Placeholder text" value={out} mono={false} />
    </div>
  );
}
