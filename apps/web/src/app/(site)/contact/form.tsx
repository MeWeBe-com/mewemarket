"use client";
import { useActionState } from "react";
import { Alert, Button, Field, Input } from "@/components/ui";
import { sendContact } from "./actions";

export function ContactForm() {
  const [state, action, pending] = useActionState(sendContact, null);
  if (state?.ok) return <Alert tone="success">Thanks! We&apos;ve got your message and will reply within one working day.</Alert>;
  return (
    <form action={action} className="space-y-4">
      {state?.error && <Alert>{state.error}</Alert>}
      <div className="grid gap-4 sm:grid-cols-2">
        <Field label="Name"><Input name="name" autoComplete="name" required /></Field>
        <Field label="Email"><Input name="email" type="email" autoComplete="email" required /></Field>
      </div>
      <Field label="What's it about?">
        <select name="topic" defaultValue="support" className="h-10 w-full rounded-lg border border-[var(--border)] bg-transparent px-3 text-sm">
          <option value="support">Help with my account</option>
          <option value="sales">Plans and pricing</option>
          <option value="partnership">Partnerships and app listings</option>
          <option value="other">Something else</option>
        </select>
      </Field>
      <Field label="Message">
        <textarea name="message" rows={6} required minLength={10}
          className="w-full rounded-lg border border-[var(--border)] bg-transparent px-3 py-2 text-sm outline-none focus:border-accent focus:ring-2 focus:ring-accent/20" />
      </Field>
      <input type="text" name="website" tabIndex={-1} autoComplete="off" aria-hidden className="hidden" />
      <Button type="submit" disabled={pending}>{pending ? "Sending…" : "Send message"}</Button>
    </form>
  );
}
