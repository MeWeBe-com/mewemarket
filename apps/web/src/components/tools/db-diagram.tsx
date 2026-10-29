"use client";
import { useMemo, useRef } from "react";
import { useState } from "react";
import { Button, Field } from "@/components/ui";
import { TextArea } from "./shared";

type Col = { name: string; type: string; pk: boolean; ref?: string };
type Table = { name: string; cols: Col[] };

const SAMPLE = `users
  id int pk
  name text
  email text

orders
  id int pk
  user_id int > users.id
  total decimal
  created_at timestamp

order_items
  id int pk
  order_id int > orders.id
  product text
  qty int`;

function parse(src: string): Table[] {
  const tables: Table[] = [];
  for (const raw of src.split("\n")) {
    if (!raw.trim() || raw.trim().startsWith("#")) continue;
    if (!/^\s/.test(raw)) { tables.push({ name: raw.trim(), cols: [] }); continue; }
    const cur = tables[tables.length - 1]; if (!cur) continue;
    const [def = "", ref] = raw.split(">");
    const parts = def.trim().split(/\s+/);
    cur.cols.push({ name: parts[0] ?? "", type: parts[1] ?? "", pk: parts.slice(2).includes("pk"), ref: ref?.trim() });
  }
  return tables;
}

const W = 220, ROW = 24, HEAD = 32, GAP = 60;

export default function DbDiagram() {
  const [src, setSrc] = useState(SAMPLE);
  const svgRef = useRef<SVGSVGElement>(null);
  const tables = useMemo(() => parse(src), [src]);
  const perRow = 3;
  const layout = useMemo(() => {
    const rowH: number[] = [];
    tables.forEach((t, i) => { const r = Math.floor(i / perRow); rowH[r] = Math.max(rowH[r] ?? 0, HEAD + t.cols.length * ROW); });
    return tables.map((t, i) => {
      const r = Math.floor(i / perRow);
      const y = rowH.slice(0, r).reduce((s, h) => s + h + GAP, 20);
      return { t, x: 20 + (i % perRow) * (W + GAP), y };
    });
  }, [tables]);
  const width = Math.min(tables.length, perRow) * (W + GAP) + 20;
  const height = layout.reduce((m, l) => Math.max(m, l.y + HEAD + l.t.cols.length * ROW), 0) + 20;
  const pos = new Map(layout.map((l) => [l.t.name, l]));
  const links: { x1: number; y1: number; x2: number; y2: number }[] = [];
  layout.forEach((l) => l.t.cols.forEach((c, ci) => {
    if (!c.ref) return; const [tn = "", cn] = c.ref.split("."); const target = pos.get(tn); if (!target) return;
    const ti = Math.max(0, target.t.cols.findIndex((x) => x.name === cn));
    const y1 = l.y + HEAD + ci * ROW + ROW / 2, y2 = target.y + HEAD + ti * ROW + ROW / 2;
    const leftToRight = target.x >= l.x;
    links.push({ x1: leftToRight ? l.x + W : l.x, y1, x2: leftToRight ? (target.x === l.x ? target.x + W : target.x) : target.x + W, y2 });
  }));
  const download = () => {
    if (!svgRef.current) return;
    const url = URL.createObjectURL(new Blob([new XMLSerializer().serializeToString(svgRef.current)], { type: "image/svg+xml" }));
    const a = document.createElement("a"); a.href = url; a.download = "diagram.svg"; a.click(); setTimeout(() => URL.revokeObjectURL(url), 1000);
  };
  return (
    <div className="grid gap-6 lg:grid-cols-[320px_1fr]">
      <div className="space-y-3">
        <Field label="Tables" hint="Table name on its own line. Indent each column: name type [pk] [> table.column]."><TextArea className="min-h-96" value={src} onChange={(e) => setSrc(e.target.value)} /></Field>
        <Button type="button" variant="secondary" onClick={download} disabled={!tables.length}>Download SVG</Button>
      </div>
      <div className="overflow-auto rounded-lg border border-[var(--border)] bg-white">
        {tables.length ? (
          <svg ref={svgRef} xmlns="http://www.w3.org/2000/svg" width={width} height={height} role="img" aria-label="Database diagram" fontFamily="ui-sans-serif, system-ui, sans-serif" fontSize="12">
            <rect width={width} height={height} fill="#ffffff" />
            {links.map((k, i) => { const mx = (k.x1 + k.x2) / 2 + (k.x1 === k.x2 ? 40 : 0); return <path key={i} d={`M${k.x1},${k.y1} C${mx},${k.y1} ${mx},${k.y2} ${k.x2},${k.y2}`} fill="none" stroke="#6366f1" strokeWidth="1.5" />; })}
            {layout.map(({ t, x, y }) => (
              <g key={t.name + x + y}>
                <rect x={x} y={y} width={W} height={HEAD + t.cols.length * ROW} rx="6" fill="#ffffff" stroke="#cbd5e1" />
                <path d={`M${x},${y + HEAD} v-${HEAD - 6} a6,6 0 0 1 6,-6 h${W - 12} a6,6 0 0 1 6,6 v${HEAD - 6} z`} fill="#6366f1" />
                <text x={x + 10} y={y + 21} fill="#ffffff" fontWeight="700" fontSize="13">{t.name}</text>
                {t.cols.map((c, i) => (
                  <g key={i}>
                    {i > 0 && <line x1={x} x2={x + W} y1={y + HEAD + i * ROW} y2={y + HEAD + i * ROW} stroke="#e2e8f0" />}
                    <text x={x + 10} y={y + HEAD + i * ROW + 16} fill="#0f172a" fontWeight={c.pk ? 700 : 400}>{c.pk ? "PK " : c.ref ? "FK " : ""}{c.name}</text>
                    <text x={x + W - 10} y={y + HEAD + i * ROW + 16} fill="#64748b" textAnchor="end">{c.type}</text>
                  </g>
                ))}
              </g>
            ))}
          </svg>
        ) : <p className="p-6 text-sm text-gray-500">Add a table to see the diagram.</p>}
      </div>
    </div>
  );
}
