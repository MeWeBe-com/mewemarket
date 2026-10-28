export function LegalPage({ title, updated, sections }: { title: string; updated: string; sections: [string, string[]][] }) {
  return (
    <article className="mx-auto max-w-3xl px-4 py-14">
      <h1 className="text-4xl font-bold tracking-tight">{title}</h1>
      <p className="mt-2 text-sm text-[var(--muted)]">Last updated {updated}</p>
      {sections.map(([heading, paras]) => (
        <section key={heading} className="mt-10">
          <h2 className="text-xl font-semibold">{heading}</h2>
          {paras.map((p) => <p key={p.slice(0, 40)} className="mt-3 leading-relaxed text-[var(--muted)]">{p}</p>)}
        </section>
      ))}
    </article>
  );
}
