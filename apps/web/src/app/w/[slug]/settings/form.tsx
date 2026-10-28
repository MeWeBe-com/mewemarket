"use client";
import { useActionState } from "react";
import { Alert, Button, Field, Input } from "@/components/ui";
import { saveWorkspaceSettings } from "./actions";

type Values = { name: string; currency: string; timezone: string; locale: string };

export function WorkspaceSettingsForm({ slug, values, disabled }: { slug: string; values: Values; disabled: boolean }) {
  const [state, action, pending] = useActionState(saveWorkspaceSettings.bind(null, slug), null);
  return (
    <form action={action} className="grid gap-4 sm:grid-cols-2">
      {state?.error && <div className="sm:col-span-2"><Alert>{state.error}</Alert></div>}
      {state?.ok && <div className="sm:col-span-2"><Alert tone="success">Saved.</Alert></div>}
      <div className="sm:col-span-2"><Field label="Name"><Input name="name" defaultValue={values.name} disabled={disabled} required /></Field></div>
      <Field label="Currency" hint="ISO code, e.g. USD, GBP, EUR"><Input name="currency" defaultValue={values.currency} disabled={disabled} maxLength={3} required /></Field>
      <Field label="Timezone" hint="e.g. Europe/London"><Input name="timezone" defaultValue={values.timezone} disabled={disabled} required /></Field>
      <Field label="Locale"><Input name="locale" defaultValue={values.locale} disabled={disabled} required /></Field>
      {!disabled && <div className="sm:col-span-2"><Button type="submit" disabled={pending}>{pending ? "Saving…" : "Save changes"}</Button></div>}
    </form>
  );
}
