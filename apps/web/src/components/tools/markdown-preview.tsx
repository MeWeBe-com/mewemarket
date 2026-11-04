"use client";
import { useMemo, useState } from "react";
import { markdownToHtml } from "@/lib/markdown";
import { CopyButton, TextArea } from "./shared";

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
