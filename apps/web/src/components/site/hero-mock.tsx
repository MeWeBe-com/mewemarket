import { CalendarCheck, CheckCircle2, Search } from "lucide-react";
import { AppIcon } from "@/components/app-icon";

// A static picture of the workspace, drawn in HTML so it stays sharp and themes with the site.
const SIDEBAR = [
  ["crm", "CRM & Pipeline", "sales"], ["invoices", "Invoices & Quotes", "finance"], ["projects", "Projects & Tasks", "business"],
  ["inventory", "Inventory & Orders", "logistics"], ["team-hr", "Team & HR", "hr"], ["bookings", "Bookings", "customer-service"],
] as const;

const COLUMNS = [
  { name: "Lead", color: "#94a3b8", cards: [["Northwind refit", "$4,200", "SP"], ["Bluebird Café", "$850", "JL"]] },
  { name: "Proposal", color: "#5b5bf6", cards: [["Harbor Dental", "$12,600", "AM"], ["Summit Gym", "$3,100", "SP"]] },
  { name: "Negotiation", color: "#f59e0b", cards: [["Meadow Hotels", "$28,000", "JL"]] },
  { name: "Won", color: "#10b981", cards: [["Lantern Studio", "$6,400", "AM"], ["Comet Logistics", "$9,900", "JL"]] },
];
const AVATAR: Record<string, string> = { SP: "#ec4899", JL: "#0ea5e9", AM: "#f59e0b" };

export function HeroMock() {
  return (
    <div aria-hidden className="relative mx-auto mt-16 max-w-5xl select-none text-left [perspective:2000px]">
      <div className="absolute -inset-x-10 -bottom-10 top-10 rounded-[3rem] bg-gradient-to-b from-[#5b5bf633] to-transparent blur-2xl" />
      <div className="relative overflow-hidden rounded-2xl border border-[var(--border)] bg-[var(--card)] shadow-[0_40px_100px_-30px_rgb(16_24_40/0.35)] sm:[transform:rotateX(8deg)] sm:origin-top">
        {/* Window chrome */}
        <div className="flex items-center gap-2 border-b border-[var(--border)] bg-[var(--bg-subtle)] px-4 py-2.5">
          <span className="size-3 rounded-full bg-[#ff5f57]" /><span className="size-3 rounded-full bg-[#febc2e]" /><span className="size-3 rounded-full bg-[#28c840]" />
          <span className="mx-auto hidden w-72 items-center justify-center gap-1.5 rounded-md bg-[var(--card)] px-3 py-1 text-[11px] text-[var(--muted)] ring-1 ring-[var(--border)] sm:flex">
            mewemarket.com/w/acme/crm
          </span>
        </div>
        <div className="flex h-[300px] sm:h-[420px]">
          {/* Sidebar */}
          <div className="hidden w-52 shrink-0 border-r border-[var(--border)] p-3 md:block">
            <div className="flex items-center gap-2 rounded-lg bg-[var(--bg-subtle)] px-2.5 py-2 text-xs font-bold">
              <span className="grid size-5 place-items-center rounded-md bg-gradient-to-br from-amber-400 to-orange-500 text-[10px] text-white">A</span>Acme Ltd
            </div>
            <p className="mt-4 px-2 text-[10px] font-bold uppercase tracking-wider text-[var(--muted)]">Your apps</p>
            <ul className="mt-2 space-y-0.5">
              {SIDEBAR.map(([slug, name, cat], i) => (
                <li key={slug} className={`flex items-center gap-2 rounded-lg px-2 py-1.5 text-xs font-semibold ${i === 0 ? "bg-accent/10 text-accent" : "text-[var(--muted)]"}`}>
                  <AppIcon slug={slug} name={name} category={cat} size="sm" className="!size-5 !rounded-md [&>svg]:size-3" />{name}
                </li>
              ))}
            </ul>
          </div>
          {/* Board */}
          <div className="min-w-0 flex-1 p-4 sm:p-5">
            <div className="flex items-center gap-3">
              <p className="font-display text-sm font-bold sm:text-base">Deals</p>
              <span className="rounded-full bg-[var(--bg-subtle)] px-2 py-0.5 text-[10px] font-semibold text-[var(--muted)]">7 open · $65,050</span>
              <span className="ml-auto hidden items-center gap-1.5 rounded-lg border border-[var(--border)] px-2.5 py-1 text-[11px] text-[var(--muted)] sm:flex"><Search className="size-3" />Search deals…</span>
              <span className="rounded-lg bg-accent px-2.5 py-1 text-[11px] font-semibold text-white">+ New deal</span>
            </div>
            <div className="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
              {COLUMNS.map((c, ci) => (
                <div key={c.name} className={`rounded-xl bg-[var(--bg-subtle)] p-2 ${ci > 1 ? "hidden sm:block" : ""}`}>
                  <p className="flex items-center gap-1.5 px-1 pb-2 text-[11px] font-bold"><span className="size-2 rounded-full" style={{ background: c.color }} />{c.name}<span className="ml-auto text-[var(--muted)]">{c.cards.length}</span></p>
                  <div className="space-y-2">
                    {c.cards.map(([title, value, who]) => (
                      <div key={title} className="rounded-lg border border-[var(--border)] bg-[var(--card)] p-2.5 shadow-[var(--shadow-sm)]">
                        <p className="truncate text-[11px] font-semibold">{title}</p>
                        <div className="mt-2 flex items-center justify-between">
                          <span className="text-[11px] font-bold" style={{ color: c.color === "#94a3b8" ? undefined : c.color }}>{value}</span>
                          <span className="grid size-5 place-items-center rounded-full text-[8px] font-bold text-white" style={{ background: AVATAR[who ?? ""] }}>{who}</span>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
      {/* Floating notifications */}
      <div className="absolute -left-14 top-[22%] hidden animate-[float_6s_ease-in-out_infinite] items-center gap-3 rounded-2xl border border-[var(--border)] bg-[var(--card)] p-3 pr-5 shadow-[var(--shadow-lg)] lg:flex">
        <span className="grid size-9 place-items-center rounded-xl bg-emerald-500/15 text-emerald-600"><CheckCircle2 className="size-5" /></span>
        <span><span className="block text-xs font-bold">Invoice INV-1042 paid</span><span className="block text-[11px] text-[var(--muted)]">$2,400.00 · just now</span></span>
      </div>
      <div className="absolute -right-6 bottom-16 hidden animate-[float_7s_ease-in-out_1s_infinite] items-center gap-3 rounded-2xl border border-[var(--border)] bg-[var(--card)] p-3 pr-5 shadow-[var(--shadow-lg)] lg:flex">
        <span className="grid size-9 place-items-center rounded-xl bg-sky-500/15 text-sky-600"><CalendarCheck className="size-5" /></span>
        <span><span className="block text-xs font-bold">New booking</span><span className="block text-[11px] text-[var(--muted)]">Haircut · Fri 10:30</span></span>
      </div>
    </div>
  );
}
