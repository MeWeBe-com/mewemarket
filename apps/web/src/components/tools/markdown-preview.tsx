"use client";
import { useMemo, useState } from "react";
import { CopyButton, TextArea } from "./shared";

const esc = (s: string) => s.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#39;");
const safeUrl = (u: string) => (/^(https?:|mailto:|\/|#)/i.test(u) ? u : "#");

function inline(s: string) {
  const codes: string[] = [];
  s = s.replace(/`([^`]+)`/g, (_, c) => `\u0000${codes.push(c) - 1}\u0000`);
  s = s
    .replace(/!\[([^\]]*)\]\(([^)\s]+)\)/g, (_, a, u) => `<img src="${safeUrl(u)}" alt="${a}">`)
    .replace(/\[([^\]]+)\]\(([^)\s]+)\)/g, (_, t, u) => `<a href="${safeUrl(u)}" rel="noopener noreferrer">${t}</a>`)
    .replace(/\*\*(.+?)\*\*/g, "<strong>$1</strong>").replace(/__(.+?)__/g, "<strong>$1</strong>")
    .replace(/\*(.+?)\*/g, "<em>$1</em>").replace(/(^|\W)_(.+?)_(?=\W|$)/g, "$1<em>$2</em>")
    .replace(/~~(.+?)~~/g, "<del>$1</del>");
  return s.replace(/\u0000(\d+)\u0000/g, (_, i) => `<code>${codes[+i] ?? ""}</code>`);
}

function markdownToHtml(md: string) {
  const lines = esc(md).split(/\r?\n/);
  const at = (k: number) => lines[k] ?? "";
  const out: string[] = []; let i = 0;
  while (i < lines.length) {
    const l = at(i);
    if (/^```/.test(l)) { const buf: string[] = []; i++; while (i < lines.length && !/^```/.test(at(i))) buf.push(at(i++)); i++; out.push(`<pre><code>${buf.join("\n")}</code></pre>`); continue; }
    const h = l.match(/^(#{1,6})\s+(.*)$/); if (h) { out.push(`<h${h[1]!.length}>${inline(h[2]!)}</h${h[1]!.length}>`); i++; continue; }
    if (/^(\*\s*\*\s*\*|-{3,}|_{3,})\s*$/.test(l)) { out.push("<hr>"); i++; continue; }
    if (/^&gt;\s?/.test(l)) { const buf: string[] = []; while (i < lines.length && /^&gt;\s?/.test(at(i))) buf.push(at(i++).replace(/^&gt;\s?/, "")); out.push(`<blockquote>${inline(buf.join(" "))}</blockquote>`); continue; }
    if (/^\s*[-*+]\s+/.test(l)) { const buf: string[] = []; while (i < lines.length && /^\s*[-*+]\s+/.test(at(i))) buf.push(`<li>${inline(at(i++).replace(/^\s*[-*+]\s+/, ""))}</li>`); out.push(`<ul>${buf.join("")}</ul>`); continue; }
    if (/^\s*\d+[.)]\s+/.test(l)) { const buf: string[] = []; while (i < lines.length && /^\s*\d+[.)]\s+/.test(at(i))) buf.push(`<li>${inline(at(i++).replace(/^\s*\d+[.)]\s+/, ""))}</li>`); out.push(`<ol>${buf.join("")}</ol>`); continue; }
    if (!l.trim()) { i++; continue; }
    const buf: string[] = []; while (i < lines.length && at(i).trim() && !/^(#{1,6}\s|```|&gt;|\s*[-*+]\s|\s*\d+[.)]\s)/.test(at(i))) buf.push(at(i++));
    if (!buf.length) buf.push(at(i++));
    out.push(`<p>${inline(buf.join("<br>"))}</p>`);
  }
  return out.join("\n");
}

const SAMPLE = `# Hello Markdown

Write **bold**, *italic*, \`code\` and [links](https://mewemarket.com).

- First item
- Second item

1. One
2. Two

> A short quote.

\`\`\`
const x = 1;
\`\`\``;

export default function MarkdownPreview() {
  const [md, setMd] = useState(SAMPLE);
  const html = useMemo(() => markdownToHtml(md), [md]);
  return (
    <div className="grid gap-4 md:grid-cols-2">
      <label className="block space-y-1.5"><span className="text-sm font-medium">Markdown</span><TextArea className="min-h-96" value={md} onChange={(e) => setMd(e.target.value)} /></label>
      <div className="space-y-1.5">
        <div className="flex items-center justify-between"><span className="text-sm font-medium">Preview</span><CopyButton value={html} label="Copy HTML" /></div>
        <div className="md-preview min-h-96 overflow-auto rounded-lg border border-[var(--border)] p-4 text-sm leading-relaxed [&_a]:text-accent [&_a]:underline [&_blockquote]:border-l-4 [&_blockquote]:border-[var(--border)] [&_blockquote]:pl-3 [&_blockquote]:text-[var(--muted)] [&_code]:rounded [&_code]:bg-[var(--bg-subtle)] [&_code]:px-1 [&_code]:font-mono [&_h1]:text-2xl [&_h1]:font-bold [&_h2]:text-xl [&_h2]:font-bold [&_h3]:text-lg [&_h3]:font-semibold [&_hr]:border-[var(--border)] [&_img]:max-w-full [&_ol]:list-decimal [&_ol]:pl-6 [&_pre]:overflow-x-auto [&_pre]:rounded-lg [&_pre]:bg-[var(--bg-subtle)] [&_pre]:p-3 [&_ul]:list-disc [&_ul]:pl-6 [&>*+*]:mt-3" dangerouslySetInnerHTML={{ __html: html }} />
      </div>
    </div>
  );
}
