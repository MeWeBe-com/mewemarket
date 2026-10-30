import type { FieldDef } from "@mewe/core";
import { Check, Minus } from "lucide-react";
import { formatValue, type Fmt } from "@/lib/format";

// Status words get a meaning colour; other options cycle through a palette so each value keeps the same colour.
const GOOD = /^(won|paid|done|completed?|confirmed|approved|accepted|active|delivered|received|resolved|closed|fixed|present|attended|checked out|published|worked|filled|in stock|signed|passed|hired|available|open|yes)$/i;
const BAD = /^(lost|cancelled|canceled|rejected|overdue|declined|failed|absent|no-show|missed|expired|blocker|critical|urgent|terminated|won't fix|out of stock|late)$/i;
const BUSY = /^(in progress|proposal|sent|negotiation|in review|review|confirmed|checked in|seated|shipped|packed|ordered|scheduled|booked|pending|on hold|requested|qualified|interview|offer|major|high)$/i;
const IDLE = /^(draft|new|lead|to do|planned|enquiry|minor|low|inactive|none|other|backlog)$/i;
const PALETTE = ["#6366f1", "#0ea5e9", "#14b8a6", "#f59e0b", "#ec4899", "#8b5cf6", "#84cc16", "#f97316"];

export function optionColor(value: string, options: string[] = []) {
  if (GOOD.test(value)) return "#10b981";
  if (BAD.test(value)) return "#ef4444";
  if (BUSY.test(value)) return "#3b82f6";
  if (IDLE.test(value)) return "#94a3b8";
  const i = options.indexOf(value);
  return PALETTE[(i < 0 ? value.length : i) % PALETTE.length]!;
}

export function Pill({ value, color }: { value: string; color: string }) {
  return (
    <span className="inline-flex max-w-full items-center gap-1.5 truncate rounded-full px-2 py-0.5 text-xs font-semibold" style={{ background: `${color}1c`, color }}>
      <span className="size-1.5 shrink-0 rounded-full" style={{ background: color }} />{value}
    </span>
  );
}

const AVATAR = ["#6366f1", "#ec4899", "#0ea5e9", "#f59e0b", "#10b981", "#8b5cf6", "#f97316", "#14b8a6"];
export function Avatar({ name, size = 22 }: { name: string; size?: number }) {
  const initials = name.split(/\s+/).filter(Boolean).map((w) => w[0]).slice(0, 2).join("").toUpperCase() || "?";
  const color = AVATAR[[...name].reduce((h, c) => h + c.charCodeAt(0), 0) % AVATAR.length];
  return (
    <span aria-hidden className="inline-grid shrink-0 place-items-center rounded-full font-bold text-white" style={{ width: size, height: size, fontSize: size * 0.4, background: color }}>{initials}</span>
  );
}

/** A record value for lists and cards: status pills, linked-record chips, stars and ticks instead of plain text. */
export function Value({ field, value, f }: { field: FieldDef; value: unknown; f: Fmt }) {
  if (value === undefined || value === null || value === "") return <span className="text-[var(--muted)]/50">—</span>;
  const text = formatValue(field, value, f);
  switch (field.type) {
    case "select": return <Pill value={String(value)} color={optionColor(String(value), field.options)} />;
    case "bool": return value ? <Check className="size-4 text-emerald-500" strokeWidth={3} /> : <Minus className="size-4 text-[var(--muted)]/50" />;
    case "rating": return <span className="tracking-tight text-amber-400">{"★".repeat(Number(value))}<span className="text-[var(--border)]">{"★".repeat(5 - Number(value))}</span></span>;
    case "ref": return text ? <span className="inline-flex max-w-full items-center gap-1.5"><Avatar name={text} /><span className="truncate">{text}</span></span> : null;
    case "email": return <a href={`mailto:${text}`} className="hover:text-accent hover:underline">{text}</a>;
    case "url": return <a href={String(value)} target="_blank" rel="noopener noreferrer" className="hover:text-accent hover:underline">{text.replace(/^https?:\/\//, "")}</a>;
    default:
      return /(^|_)(owner|assignee|staff|person|employee|manager|contact_name|agent)$/.test(field.key) && field.type === "text"
        ? <span className="inline-flex max-w-full items-center gap-1.5"><Avatar name={text} /><span className="truncate">{text}</span></span>
        : <>{text}</>;
  }
}
