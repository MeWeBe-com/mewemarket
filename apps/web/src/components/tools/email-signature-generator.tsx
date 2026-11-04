"use client";
import { useRef, useState } from "react";
import { Check, Copy } from "lucide-react";
import { Button, Field, Input } from "@/components/ui";
import { CopyButton } from "./shared";

type Layout = "classic" | "stacked" | "compact";
const LAYOUTS: { id: Layout; label: string }[] = [{ id: "classic", label: "Side by side" }, { id: "stacked", label: "Stacked" }, { id: "compact", label: "Compact" }];

const esc = (s: string) => s.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#39;");
const safeUrl = (u: string) => { const t = u.trim(); if (!t) return ""; const full = /^[a-z]+:/i.test(t) ? t : `https://${t}`; try { const x = new URL(full); return x.protocol === "http:" || x.protocol === "https:" ? x.href : ""; } catch { return ""; } };
const safeColor = (c: string) => (/^#[0-9a-f]{3,8}$/i.test(c) ? c : "#5b5bf6");

type Data = { name: string; title: string; company: string; phone: string; email: string; website: string; address: string; color: string; image: string; layout: Layout };

function build(d: Data): string {
  const c = safeColor(d.color);
  const font = "font-family:Arial,Helvetica,sans-serif;";
  const img = safeUrl(d.image);
  const site = safeUrl(d.website);
  const email = /^[^\s@<>"]+@[^\s@<>"]+$/.test(d.email.trim()) ? d.email.trim() : "";
  const tel = d.phone.replace(/[^\d+]/g, "");
  const link = (href: string, text: string) => `<a href="${esc(href)}" style="color:${c};text-decoration:none;">${esc(text)}</a>`;
  const contacts = [
    d.phone && (tel ? link(`tel:${tel}`, d.phone) : esc(d.phone)),
    email && link(`mailto:${email}`, email),
    site && link(site, d.website.replace(/^https?:\/\//i, "").replace(/\/$/, "")),
  ].filter(Boolean) as string[];
  const nameHtml = `<div style="${font}font-size:16px;font-weight:bold;color:#111111;">${esc(d.name)}</div>`;
  const roleLine = [d.title, d.company].filter(Boolean).map(esc).join(" | ");
  const role = roleLine ? `<div style="${font}font-size:13px;color:${c};">${roleLine}</div>` : "";
  const addr = d.address ? `<div style="${font}font-size:12px;color:#666666;">${esc(d.address)}</div>` : "";

  if (d.layout === "compact") {
    return `<table cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;"><tr><td style="${font}font-size:13px;color:#333333;line-height:1.5;"><strong style="color:#111111;">${esc(d.name)}</strong>${roleLine ? ` <span style="color:${c};">${roleLine}</span>` : ""}<br>${contacts.join(' <span style="color:#bbbbbb;">&middot;</span> ')}${d.address ? `<br><span style="color:#666666;font-size:12px;">${esc(d.address)}</span>` : ""}</td></tr></table>`;
  }
  const contactRows = contacts.map((x) => `<div style="${font}font-size:12px;color:#333333;line-height:1.6;">${x}</div>`).join("");
  const imgTag = img ? `<img src="${esc(img)}" alt="${esc(d.name || "Logo")}" width="80" style="display:block;width:80px;max-width:80px;height:auto;border:0;border-radius:6px;">` : "";
  if (d.layout === "stacked") {
    return `<table cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">${imgTag ? `<tr><td style="padding-bottom:8px;">${imgTag}</td></tr>` : ""}<tr><td style="padding-bottom:6px;">${nameHtml}${role}</td></tr><tr><td style="border-top:2px solid ${c};padding-top:6px;">${contactRows}${addr}</td></tr></table>`;
  }
  return `<table cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;"><tr>${imgTag ? `<td valign="top" style="padding-right:14px;">${imgTag}</td>` : ""}<td valign="top" style="border-left:3px solid ${c};padding-left:14px;">${nameHtml}${role}<div style="height:6px;line-height:6px;font-size:6px;">&nbsp;</div>${contactRows}${addr}</td></tr></table>`;
}

export default function EmailSignatureGenerator() {
  const [d, setD] = useState<Data>({ name: "Alex Morgan", title: "Founder", company: "Morgan Studio", phone: "+1 555 123 4567", email: "alex@example.com", website: "example.com", address: "", color: "#5b5bf6", image: "", layout: "classic" });
  const [copied, setCopied] = useState(false);
  const ref = useRef<HTMLDivElement>(null);
  const set = (k: keyof Data) => (e: { target: { value: string } }) => setD((x) => ({ ...x, [k]: e.target.value }));
  const html = build(d);

  const copyRich = async () => {
    try {
      if (typeof ClipboardItem === "undefined" || !navigator.clipboard?.write) throw new Error("unsupported");
      const text = ref.current?.innerText ?? "";
      await navigator.clipboard.write([new ClipboardItem({ "text/html": new Blob([html], { type: "text/html" }), "text/plain": new Blob([text], { type: "text/plain" }) })]);
    } catch {
      const el = ref.current; if (!el) return;
      const r = document.createRange(); r.selectNodeContents(el);
      const sel = window.getSelection(); sel?.removeAllRanges(); sel?.addRange(r);
      try { document.execCommand("copy"); } catch { /* user can press Ctrl+C */ }
    }
    setCopied(true); setTimeout(() => setCopied(false), 1500);
  };

  return (
    <div className="space-y-5">
      <div className="grid gap-4 sm:grid-cols-2">
        <Field label="Full name"><Input value={d.name} onChange={set("name")} /></Field>
        <Field label="Job title"><Input value={d.title} onChange={set("title")} /></Field>
        <Field label="Company"><Input value={d.company} onChange={set("company")} /></Field>
        <Field label="Phone"><Input type="tel" value={d.phone} onChange={set("phone")} /></Field>
        <Field label="Email"><Input type="email" value={d.email} onChange={set("email")} /></Field>
        <Field label="Website"><Input value={d.website} onChange={set("website")} placeholder="example.com" /></Field>
        <Field label="Address"><Input value={d.address} onChange={set("address")} placeholder="Optional" /></Field>
        <Field label="Logo or photo URL" hint="Optional. Must be a public http(s) link."><Input value={d.image} onChange={set("image")} placeholder="https://…" /></Field>
        <Field label="Accent colour">
          <div className="flex gap-2">
            <input type="color" aria-label="Pick accent colour" value={safeColor(d.color)} onChange={set("color")} className="h-10 w-12 shrink-0 cursor-pointer rounded-lg border border-[var(--border)] bg-transparent" />
            <Input value={d.color} onChange={set("color")} />
          </div>
        </Field>
      </div>
      <div className="flex flex-wrap gap-2">
        {LAYOUTS.map((l) => <Button key={l.id} type="button" variant={d.layout === l.id ? "primary" : "secondary"} aria-pressed={d.layout === l.id} onClick={() => setD((x) => ({ ...x, layout: l.id }))}>{l.label}</Button>)}
      </div>
      <div className="space-y-2">
        <div className="flex flex-wrap items-center justify-between gap-2">
          <span className="text-sm font-medium">Preview</span>
          <div className="flex flex-wrap gap-2">
            <Button type="button" className="h-8 px-3 text-xs" onClick={copyRich}>{copied ? <Check className="size-3.5" aria-hidden /> : <Copy className="size-3.5" aria-hidden />}{copied ? "Copied" : "Copy signature"}</Button>
            <CopyButton value={html} label="Copy HTML" />
          </div>
        </div>
        {/* Always white so it looks like a real email, even in dark mode. */}
        <div className="overflow-x-auto rounded-lg border border-[var(--border)] bg-white p-4">
          <div ref={ref} dangerouslySetInnerHTML={{ __html: html }} />
        </div>
        <p className="text-xs text-[var(--muted)]">Paste the copied signature into your email app&apos;s signature settings (Gmail, Outlook, Apple Mail).</p>
      </div>
    </div>
  );
}
