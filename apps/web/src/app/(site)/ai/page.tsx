import { ArrowRight, KeyRound, ListChecks, Plug, ShieldCheck } from "lucide-react";
import type { Metadata } from "next";
import Link from "next/link";

export const metadata: Metadata = {
  title: "AI & MCP: let your assistant run your apps",
  description: "Connect MeweMarket to Claude, ChatGPT or Gemini with MCP. Ask your assistant to create invoices, update deals and book appointments, with your permissions and a full activity log.",
};

const STEPS = [
  [Plug, "Connect once", "In your workspace settings, copy your MCP address. Paste it into Claude, ChatGPT or Gemini and approve access."],
  [ListChecks, "Ask in plain English", "\"Invoice Acme for last week's hours.\" The assistant finds the hours, creates the invoice and asks you to confirm before sending."],
  [ShieldCheck, "Stay in control", "The assistant can only do what your account can do. Every action is logged, and you can revoke access at any time."],
] as const;

const EXAMPLES = [
  ["Sales", "Which deals over £5,000 have had no activity for two weeks? Draft a follow-up for each."],
  ["Finance", "List unpaid invoices older than 30 days and send each customer a polite reminder."],
  ["Bookings", "Move all of Sarah's Friday appointments to Monday and let the customers know."],
  ["Inventory", "What's running low? Create a purchase order for anything under 10 units."],
  ["HR", "Who's on leave next week? Add it to the team update."],
  ["Reports", "Summarise this month's sales by product in a short table."],
];

export default function AiPage() {
  return (
    <div className="mx-auto max-w-6xl px-4 py-14">
      <div className="mx-auto max-w-3xl text-center">
        <p className="text-sm font-semibold text-accent">AI & MCP</p>
        <h1 className="mt-3 text-4xl font-bold tracking-tight sm:text-5xl">Your AI assistant can now do the work, not just talk about it</h1>
        <p className="mt-6 text-lg text-[var(--muted)]">
          MCP (Model Context Protocol) is the standard way AI assistants connect to other software. MeweMarket gives every workspace
          its own secure MCP connection, so Claude, ChatGPT and Gemini can work inside your apps.
        </p>
      </div>

      <div className="mt-16 grid gap-6 md:grid-cols-3">
        {STEPS.map(([Icon, title, body], i) => (
          <div key={title} className="rounded-xl border border-[var(--border)] p-6">
            <span className="text-xs font-semibold text-[var(--muted)]">Step {i + 1}</span>
            <Icon className="mt-3 size-6 text-accent" />
            <h2 className="mt-3 font-semibold">{title}</h2>
            <p className="mt-2 text-sm text-[var(--muted)]">{body}</p>
          </div>
        ))}
      </div>

      <h2 className="mt-24 text-center text-3xl font-bold tracking-tight">Things you can ask</h2>
      <div className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        {EXAMPLES.map(([area, prompt]) => (
          <div key={prompt} className="rounded-xl border border-[var(--border)] bg-[var(--bg-subtle)] p-5">
            <p className="text-xs font-semibold uppercase tracking-wide text-accent">{area}</p>
            <p className="mt-2">&ldquo;{prompt}&rdquo;</p>
          </div>
        ))}
      </div>

      <section className="mt-24 grid gap-10 rounded-2xl border border-[var(--border)] p-8 sm:p-12 lg:grid-cols-2">
        <div>
          <KeyRound className="size-6 text-accent" />
          <h2 className="mt-3 text-2xl font-bold">Built-in AI, too</h2>
          <p className="mt-3 text-[var(--muted)]">
            You don&apos;t need an outside assistant. Every workspace includes an AI copilot (press ⌘J) that can search, create and
            update across all your apps, read receipts and documents, draft emails, and even build a new app from a description.
          </p>
        </div>
        <div>
          <h2 className="text-2xl font-bold">For developers</h2>
          <p className="mt-3 text-[var(--muted)]">
            Everything the assistant can do is also available through a documented REST API with scoped API keys and signed webhooks.
          </p>
          <Link href="/sign-up" className="mt-6 inline-flex items-center gap-2 rounded-lg bg-accent px-5 py-2.5 font-semibold text-white hover:bg-accent-strong">
            Try it free <ArrowRight className="size-4" />
          </Link>
        </div>
      </section>
    </div>
  );
}
