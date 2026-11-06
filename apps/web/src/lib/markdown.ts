// Small Markdown renderer. The input is HTML-escaped first, so the output is safe to inject.
const esc = (s: string) => s.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#39;");
// "//host" is another site, so a bare leading slash must be followed by something else.
const safeUrl = (u: string) => (/^(https?:|mailto:|\/(?![/\\])|#)/i.test(u) ? u : "#");

function inline(s: string, images: boolean) {
  const codes: string[] = [];
  s = s.replace(/`([^`]+)`/g, (_, c) => `\u0000${codes.push(c) - 1}\u0000`);
  s = s
    .replace(/!\[([^\]]*)\]\(([^)\s]+)\)/g, (_, a, u) => (images ? `<img src="${safeUrl(u)}" alt="${a}">` : a))
    .replace(/\[([^\]]+)\]\(([^)\s]+)\)/g, (_, t, u) => `<a href="${safeUrl(u)}" rel="noopener noreferrer">${t}</a>`)
    .replace(/\*\*(.+?)\*\*/g, "<strong>$1</strong>").replace(/__(.+?)__/g, "<strong>$1</strong>")
    .replace(/\*(.+?)\*/g, "<em>$1</em>").replace(/(^|\W)_(.+?)_(?=\W|$)/g, "$1<em>$2</em>")
    .replace(/~~(.+?)~~/g, "<del>$1</del>");
  return s.replace(/\u0000(\d+)\u0000/g, (_, i) => `<code>${codes[+i] ?? ""}</code>`);
}

/** `images: false` drops images: untrusted text (e.g. AI answers) could use them to send data to another site. */
export function markdownToHtml(md: string, { images = true } = {}) {
  const lines = esc(md).split(/\r?\n/);
  const at = (k: number) => lines[k] ?? "";
  const out: string[] = []; let i = 0;
  while (i < lines.length) {
    const l = at(i);
    if (/^```/.test(l)) { const buf: string[] = []; i++; while (i < lines.length && !/^```/.test(at(i))) buf.push(at(i++)); i++; out.push(`<pre><code>${buf.join("\n")}</code></pre>`); continue; }
    const h = l.match(/^(#{1,6})\s+(.*)$/); if (h) { out.push(`<h${h[1]!.length}>${inline(h[2]!, images)}</h${h[1]!.length}>`); i++; continue; }
    if (/^(\*\s*\*\s*\*|-{3,}|_{3,})\s*$/.test(l)) { out.push("<hr>"); i++; continue; }
    if (/^&gt;\s?/.test(l)) { const buf: string[] = []; while (i < lines.length && /^&gt;\s?/.test(at(i))) buf.push(at(i++).replace(/^&gt;\s?/, "")); out.push(`<blockquote>${inline(buf.join(" "), images)}</blockquote>`); continue; }
    if (/^\s*[-*+]\s+/.test(l)) { const buf: string[] = []; while (i < lines.length && /^\s*[-*+]\s+/.test(at(i))) buf.push(`<li>${inline(at(i++).replace(/^\s*[-*+]\s+/, ""), images)}</li>`); out.push(`<ul>${buf.join("")}</ul>`); continue; }
    if (/^\s*\d+[.)]\s+/.test(l)) { const buf: string[] = []; while (i < lines.length && /^\s*\d+[.)]\s+/.test(at(i))) buf.push(`<li>${inline(at(i++).replace(/^\s*\d+[.)]\s+/, ""), images)}</li>`); out.push(`<ol>${buf.join("")}</ol>`); continue; }
    if (!l.trim()) { i++; continue; }
    const buf: string[] = []; while (i < lines.length && at(i).trim() && !/^(#{1,6}\s|```|&gt;|\s*[-*+]\s|\s*\d+[.)]\s)/.test(at(i))) buf.push(at(i++));
    if (!buf.length) buf.push(at(i++));
    out.push(`<p>${inline(buf.join("<br>"), images)}</p>`);
  }
  return out.join("\n");
}
