"use client";
import Link from "next/link";
import { useOptimistic, useState, useTransition } from "react";
import { moveCardAction } from "@/app/w/[slug]/a/actions";

type Card = { id: string; column: string; title: string; meta: string[] };
type Props = { slug: string; app: string; entity: string; field: string; columns: string[]; cards: Card[]; canEdit: boolean; base: string };

export function Board({ slug, app, entity, field, columns, cards, canEdit, base }: Props) {
  const [optimistic, move] = useOptimistic(cards, (s, m: { id: string; column: string }) => s.map((c) => (c.id === m.id ? { ...c, column: m.column } : c)));
  const [, start] = useTransition();
  const [error, setError] = useState<string | null>(null);
  const [over, setOver] = useState<string | null>(null);

  const drop = (id: string, column: string) =>
    start(async () => {
      move({ id, column });
      setError((await moveCardAction(slug, app, entity, id, field, column)) ?? null);
    });

  const known = new Set(columns);
  const cols = optimistic.some((c) => !known.has(c.column)) ? [...columns, ""] : columns;

  return (
    <>
      {error && <p role="alert" className="mb-3 rounded-lg bg-red-500/10 px-3 py-2 text-sm text-red-600">{error}</p>}
      <div className="flex gap-3 overflow-x-auto pb-4">
        {cols.map((col) => {
          const list = optimistic.filter((c) => (col ? c.column === col : !known.has(c.column)));
          return (
            <section key={col || "none"} aria-label={col || "No value"}
              onDragOver={(e) => { if (canEdit) { e.preventDefault(); setOver(col); } }}
              onDragLeave={() => setOver(null)}
              onDrop={(e) => { e.preventDefault(); setOver(null); const id = e.dataTransfer.getData("text/plain"); if (id && col) drop(id, col); }}
              className={`flex w-64 shrink-0 flex-col rounded-xl border p-2 ${over === col ? "border-accent bg-accent/5" : "border-[var(--border)] bg-[var(--bg-subtle)]"}`}>
              <h2 className="flex justify-between px-1 pb-2 text-xs font-semibold uppercase tracking-wide text-[var(--muted)]">
                <span>{col || "No value"}</span><span>{list.length}</span>
              </h2>
              <ul className="space-y-2">
                {list.map((c) => (
                  <li key={c.id} draggable={canEdit} onDragStart={(e) => e.dataTransfer.setData("text/plain", c.id)}
                    className="rounded-lg border border-[var(--border)] bg-[var(--card)] p-2.5 text-sm shadow-sm">
                    <Link href={`${base}/${c.id}`} className="font-medium hover:underline">{c.title}</Link>
                    {c.meta.length > 0 && <p className="mt-1 truncate text-xs text-[var(--muted)]">{c.meta.join(" · ")}</p>}
                    {canEdit && (
                      <select aria-label={`Move ${c.title}`} value={known.has(c.column) ? c.column : ""} onChange={(e) => drop(c.id, e.target.value)}
                        className="mt-2 h-7 w-full rounded border border-[var(--border)] bg-transparent px-1 text-xs text-[var(--muted)]">
                        {!known.has(c.column) && <option value="">Move to…</option>}
                        {columns.map((o) => <option key={o}>{o}</option>)}
                      </select>
                    )}
                  </li>
                ))}
              </ul>
            </section>
          );
        })}
      </div>
    </>
  );
}
