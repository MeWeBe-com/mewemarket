import Link from "next/link";
import type { ComponentProps, ReactNode } from "react";

// Minimal primitives until the shadcn/ui design system lands in M3.
const cx = (...c: (string | false | undefined)[]) => c.filter(Boolean).join(" ");

export function Button({ variant = "primary", className, ...p }: ComponentProps<"button"> & { variant?: "primary" | "secondary" | "ghost" | "danger" }) {
  return (
    <button
      {...p}
      className={cx(
        "inline-flex h-10 items-center justify-center gap-2 rounded-lg px-4 text-sm font-semibold transition disabled:opacity-50 disabled:pointer-events-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent",
        variant === "primary" && "bg-accent text-white hover:bg-indigo-500",
        variant === "secondary" && "border border-[var(--border)] hover:bg-black/5 dark:hover:bg-white/5",
        variant === "ghost" && "hover:bg-black/5 dark:hover:bg-white/5",
        variant === "danger" && "bg-red-600 text-white hover:bg-red-500",
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
        "h-10 w-full rounded-lg border border-[var(--border)] bg-transparent px-3 text-sm outline-none placeholder:text-[var(--muted)] focus:border-accent focus:ring-2 focus:ring-accent/20",
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
  return <div {...p} className={cx("rounded-xl border border-[var(--border)] p-6", className)} />;
}

export function Alert({ tone = "error", children }: { tone?: "error" | "success"; children: ReactNode }) {
  return (
    <p role="alert" className={cx("rounded-lg px-3 py-2 text-sm", tone === "error" ? "bg-red-500/10 text-red-600 dark:text-red-400" : "bg-emerald-500/10 text-emerald-700 dark:text-emerald-400")}>
      {children}
    </p>
  );
}

export function TextLink(p: ComponentProps<typeof Link>) {
  return <Link {...p} className={cx("font-medium text-accent hover:underline", p.className)} />;
}
