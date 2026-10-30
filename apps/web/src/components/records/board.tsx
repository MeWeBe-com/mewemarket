"use client";
import Link from "next/link";
import { useOptimistic, useState, useTransition } from "react";
import { moveCardAction } from "@/app/w/[slug]/a/actions";

type Card = { id: string; column: string; title: string; meta: string[] };
type Props = { slug: string; app: string; entity: string; field: string; columns: string[]; colors: Record<string, string>; cards: Card[]; canEdit: boolean; base: string };

export function Board({ slug, app, entity, field, columns, colors, cards, canEdit, base }: Props) {
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
              className={`flex w-72 shrink-0 flex-col rounded-2xl border p-2 transition ${over === col ? "border-accent bg-accent/5" : "border-[var(--border)] bg-black/[0.025] dark:bg-white/[0.03]"}`}>
              <h2 className="flex items-center gap-2 px-1.5 pb-2.5 pt-1 text-sm font-bold">
                <span className="size-2.5 rounded-full" style={{ background: colors[col] ?? "#94a3b8" }} />
                <span className="flex-1">{col || "No value"}</span>
                <span className="rounded-full bg-[var(--card)] px-2 py-0.5 text-xs text-[var(--muted)] ring-1 ring-[var(--border)]">{list.length}</span>
              </h2>
              <ul className="space-y-2">
                {list.map((c) => (
                  <li key={c.id} draggable={canEdit} onDragStart={(e) => e.dataTransfer.setData("text/plain", c.id)}
                    className={`group rounded-xl border border-[var(--border)] bg-[var(--card)] p-3 text-sm shadow-[var(--shadow-sm)] transition hover:shadow-[var(--shadow)] ${canEdit ? "cursor-grab active:cursor-grabbing" : ""}`}>
                    <Link href={`${base}/${c.id}`} className="font-semibold hover:text-accent">{c.title}</Link>
                    {c.meta.length > 0 && (
                      <ul className="mt-2 space-y-0.5 text-xs text-[var(--muted)]">{c.meta.map((m, i) => <li key={i} className={`truncate ${i === 0 ? "font-semibold text-[var(--fg)]" : ""}`}>{m}</li>)}</ul>
                    )}
                    {canEdit && (
                      <select aria-label={`Move ${c.title}`} value={known.has(c.column) ? c.column : ""} onChange={(e) => drop(c.id, e.target.value)}
                        className="mt-2.5 h-7 w-full rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] px-1.5 text-xs text-[var(--muted)] opacity-70 transition group-hover:opacity-100">
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
