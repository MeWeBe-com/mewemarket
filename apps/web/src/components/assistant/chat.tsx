"use client";
import { ArrowUp, RotateCcw, Sparkles } from "lucide-react";
import { useRouter } from "next/navigation";
import { useEffect, useRef, useState, useTransition } from "react";
import { askAssistantAction } from "@/app/w/[slug]/a/ai-actions";
import { markdownToHtml } from "@/lib/markdown";

type Msg = { role: "user" | "assistant"; content: string; error?: boolean };

const PROSE = "text-sm leading-relaxed [&_a]:font-semibold [&_a]:text-accent [&_a]:underline [&_code]:rounded [&_code]:bg-[var(--bg-subtle)] [&_code]:px-1 [&_code]:font-mono [&_h1]:font-bold [&_h2]:font-bold [&_h3]:font-semibold [&_ol]:list-decimal [&_ol]:pl-5 [&_pre]:overflow-x-auto [&_pre]:rounded-lg [&_pre]:bg-[var(--bg-subtle)] [&_pre]:p-3 [&_ul]:list-disc [&_ul]:pl-5 [&>*+*]:mt-2";

export function AssistantChat({ slug, name, suggestions, ready }: { slug: string; name: string; suggestions: string[]; ready: boolean }) {
  const router = useRouter();
  const storeKey = `mewe-ai:${slug}`;
  const [msgs, setMsgs] = useState<Msg[]>([]);
  const [text, setText] = useState("");
  const [pending, start] = useTransition();
  const end = useRef<HTMLDivElement>(null);

  // The conversation survives following a record link and coming back.
  useEffect(() => {
    try { const s = sessionStorage.getItem(storeKey); if (s) setMsgs(JSON.parse(s)); } catch { /* storage unavailable */ }
  }, [storeKey]);
  useEffect(() => {
    try { sessionStorage.setItem(storeKey, JSON.stringify(msgs)); } catch { /* storage unavailable */ }
    end.current?.scrollIntoView({ block: "end", behavior: "smooth" });
  }, [msgs, storeKey]);

  function send(q: string) {
    q = q.trim();
    if (!q || pending) return;
    const next: Msg[] = [...msgs, { role: "user", content: q }];
    setMsgs(next);
    setText("");
    start(async () => {
      const res = await askAssistantAction(slug, next.filter((m) => !m.error).map(({ role, content }) => ({ role, content })));
      setMsgs((m) => [...m, res.reply ? { role: "assistant", content: res.reply } : { role: "assistant", content: res.error ?? "No answer.", error: true }]);
    });
  }

  return (
    <div className="surface flex h-[min(70vh,720px)] min-h-[420px] flex-col overflow-hidden">
      <div
        className="flex-1 space-y-4 overflow-y-auto p-4 sm:p-6"
        onClick={(e) => {
          const a = (e.target as HTMLElement).closest("a");
          const href = a?.getAttribute("href");
          if (href?.startsWith("/")) { e.preventDefault(); router.push(href); }
        }}
      >
        {!msgs.length && (
          <div className="mx-auto max-w-lg py-8 text-center">
            <span className="mx-auto grid size-14 place-items-center rounded-2xl bg-gradient-to-br from-accent to-fuchsia-500 text-white shadow-lg"><Sparkles className="size-7" /></span>
            <p className="mt-4 font-display text-xl font-extrabold">Ask {name} anything about your business</p>
            <p className="mt-1 text-sm text-[var(--muted)]">It looks up your records to answer and links to what it used. It can read your data but never changes it.</p>
            {ready && (
              <div className="mt-6 flex flex-wrap justify-center gap-2">
                {suggestions.map((s) => (
                  <button key={s} type="button" onClick={() => send(s)} className="rounded-full border border-[var(--border)] bg-[var(--card)] px-3.5 py-1.5 text-sm font-medium shadow-[var(--shadow-sm)] transition hover:border-accent hover:text-accent">{s}</button>
                ))}
              </div>
            )}
          </div>
        )}
        {msgs.map((m, i) => m.role === "user" ? (
          <div key={i} className="flex justify-end">
            <p className="max-w-[85%] whitespace-pre-wrap rounded-2xl rounded-br-md bg-accent px-4 py-2.5 text-sm text-white">{m.content}</p>
          </div>
        ) : (
          <div key={i} className="flex gap-3">
            <span className="grid size-8 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-accent to-fuchsia-500 text-white"><Sparkles className="size-4" /></span>
            {m.error
              ? <p className="max-w-[85%] rounded-2xl rounded-tl-md bg-red-500/10 px-4 py-2.5 text-sm text-red-600">{m.content}</p>
              : <div className={`min-w-0 max-w-[85%] rounded-2xl rounded-tl-md bg-[var(--bg-subtle)] px-4 py-2.5 ${PROSE}`} dangerouslySetInnerHTML={{ __html: markdownToHtml(m.content) }} />}
          </div>
        ))}
        {pending && (
          <div className="flex gap-3" aria-live="polite">
            <span className="grid size-8 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-accent to-fuchsia-500 text-white"><Sparkles className="size-4 animate-pulse" /></span>
            <p className="rounded-2xl rounded-tl-md bg-[var(--bg-subtle)] px-4 py-2.5 text-sm text-[var(--muted)]">Looking through your records…</p>
          </div>
        )}
        <div ref={end} />
      </div>
      <form className="flex items-end gap-2 border-t border-[var(--border)] bg-[var(--card)] p-3" onSubmit={(e) => { e.preventDefault(); send(text); }}>
        {msgs.length > 0 && (
          <button type="button" title="New conversation" aria-label="New conversation" onClick={() => setMsgs([])} className="grid size-10 shrink-0 place-items-center rounded-xl text-[var(--muted)] hover:bg-[var(--bg-subtle)] hover:text-[var(--fg)]"><RotateCcw className="size-4" /></button>
        )}
        <textarea
          value={text} onChange={(e) => setText(e.target.value)} rows={1} disabled={!ready}
          onKeyDown={(e) => { if (e.key === "Enter" && !e.shiftKey) { e.preventDefault(); send(text); } }}
          placeholder={ready ? `Message ${name}…` : "Add an API key in the assistant settings to start"} aria-label={`Message ${name}`}
          className="max-h-40 min-h-10 flex-1 resize-none rounded-xl border border-[var(--border)] bg-[var(--card)] px-3 py-2.5 text-sm outline-none focus:border-accent focus:ring-4 focus:ring-accent/15 disabled:opacity-60"
        />
        <button type="submit" disabled={!ready || pending || !text.trim()} aria-label="Send" className="grid size-10 shrink-0 place-items-center rounded-xl bg-accent text-white transition hover:brightness-110 disabled:opacity-40"><ArrowUp className="size-5" /></button>
      </form>
    </div>
  );
}
