import Link from "next/link";
import type { ComponentProps, ReactNode } from "react";

// Shared primitives. Colours come from the tokens in globals.css.
export const cx = (...c: (string | false | undefined)[]) => c.filter(Boolean).join(" ");

export const BUTTON_BASE =
  "inline-flex h-10 items-center justify-center gap-2 rounded-xl px-4 text-sm font-semibold transition active:scale-[0.98] disabled:opacity-50 disabled:pointer-events-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent";
export const BUTTON_PRIMARY =
  "bg-gradient-to-b from-[#6d6cf8] to-accent text-white shadow-[0_1px_2px_rgb(16_24_40/0.1),0_4px_14px_-4px_rgb(91_91_246/0.6),inset_0_1px_0_rgb(255_255_255/0.2)] hover:brightness-110";
export const BUTTON_SECONDARY =
  "border border-[var(--border)] bg-[var(--card)] shadow-[var(--shadow-sm)] hover:bg-[var(--bg-subtle)]";

export function Button({ variant = "primary", className, ...p }: ComponentProps<"button"> & { variant?: "primary" | "secondary" | "ghost" | "danger" }) {
  return (
    <button
      {...p}
      className={cx(
        BUTTON_BASE,
        variant === "primary" && BUTTON_PRIMARY,
        variant === "secondary" && BUTTON_SECONDARY,
        variant === "ghost" && "hover:bg-black/5 dark:hover:bg-white/5",
        variant === "danger" && "bg-red-600 text-white shadow-sm hover:bg-red-500",
        className,
      )}
    />
  );
}

export function Input({ className, ...p }: ComponentProps<"input">) {
  return (
    <input
      {...p}
      className={cx(
        "h-10 w-full rounded-xl border border-[var(--border)] bg-[var(--card)] px-3 text-sm shadow-[var(--shadow-sm)] outline-none transition placeholder:text-[var(--muted)] focus:border-accent focus:ring-4 focus:ring-accent/15",
        className,
      )}
    />
  );
}

export function Field({ label, hint, children }: { label: string; hint?: ReactNode; children: ReactNode }) {
  return (
    <label className="block space-y-1.5">
      <span className="text-sm font-medium">{label}</span>
      {children}
      {hint && <span className="block text-xs text-[var(--muted)]">{hint}</span>}
    </label>
  );
}

export function Card({ className, ...p }: ComponentProps<"div">) {
  return <div {...p} className={cx("surface p-6", className)} />;
}

export function Alert({ tone = "error", children }: { tone?: "error" | "success"; children: ReactNode }) {
  return (
    <p role="alert" className={cx("rounded-xl px-3 py-2 text-sm", tone === "error" ? "bg-red-500/10 text-red-600 dark:text-red-400" : "bg-emerald-500/10 text-emerald-700 dark:text-emerald-400")}>
      {children}
    </p>
  );
}

export function TextLink(p: ComponentProps<typeof Link>) {
  return <Link {...p} className={cx("font-medium text-accent hover:underline", p.className)} />;
}

/** Small rounded label; pass a colour via style for category or status tones. */
export function Badge({ className, ...p }: ComponentProps<"span">) {
  return <span {...p} className={cx("inline-flex items-center gap-1 rounded-full border border-[var(--border)] bg-[var(--bg-subtle)] px-2 py-0.5 text-[11px] font-semibold text-[var(--muted)]", className)} />;
}

export function Logo({ className }: { className?: string }) {
  return (
    <span className={cx("inline-flex items-center gap-2 font-display text-[17px] font-extrabold tracking-tight", className)}>
      <svg viewBox="0 0 32 32" className="size-8 drop-shadow-[0_4px_10px_rgb(91_91_246/0.45)]" aria-hidden>
        <defs><linearGradient id="mm-g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stopColor="#7c7cfa" /><stop offset="0.55" stopColor="#5b5bf6" /><stop offset="1" stopColor="#a855f7" /></linearGradient></defs>
        <rect width="32" height="32" rx="9" fill="url(#mm-g)" />
        <rect x="7" y="7" width="8" height="8" rx="2.5" fill="#fff" />
        <rect x="17" y="7" width="8" height="8" rx="2.5" fill="#fff" fillOpacity=".55" />
        <rect x="7" y="17" width="8" height="8" rx="2.5" fill="#fff" fillOpacity=".55" />
        <rect x="17" y="17" width="8" height="8" rx="4" fill="#fff" />
      </svg>
      MeweMarket
    </span>
  );
}
