import type { ReactNode } from "react";

/** Header band for inner pages: soft gradient, eyebrow, title, intro. `tint` takes a hex colour (e.g. a category tone). */
export function PageHero({ eyebrow, title, intro, tint = "#5b5bf6", children, center = false }: {
  eyebrow?: ReactNode; title: ReactNode; intro?: ReactNode; tint?: string; children?: ReactNode; center?: boolean;
}) {
  return (
    <section className="relative overflow-hidden border-b border-[var(--border)]">
      <div aria-hidden className="bg-grid pointer-events-none absolute inset-0 [mask-image:linear-gradient(to_bottom,black,transparent)]" />
      <div aria-hidden className="pointer-events-none absolute -top-40 left-1/2 h-80 w-[900px] -translate-x-1/2 rounded-full blur-3xl" style={{ background: `${tint}2e` }} />
      <div className={`relative mx-auto max-w-6xl px-4 pb-12 pt-14 sm:pt-20 ${center ? "text-center" : ""}`}>
        {eyebrow && <p className={`inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest ${center ? "justify-center" : ""}`} style={{ color: tint }}>{eyebrow}</p>}
        <h1 className={`mt-3 max-w-3xl text-4xl font-extrabold leading-[1.1] sm:text-5xl ${center ? "mx-auto" : ""}`}>{title}</h1>
        {intro && <p className={`mt-4 max-w-2xl text-lg leading-relaxed text-[var(--muted)] ${center ? "mx-auto" : ""}`}>{intro}</p>}
        {children}
      </div>
    </section>
  );
}
