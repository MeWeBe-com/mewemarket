"use client";
import { useActionState, useState } from "react";
import { saveAiSettingsAction, type AiFormState } from "@/app/w/[slug]/a/ai-actions";
import { Alert, Button, Field, Input } from "@/components/ui";

type Provider = { id: string; name: string; defaultModel: string; keyHint: string };
type Current = { provider: string; model: string; name: string; instructions: string; hasKey: boolean; keyEnd: string };

const KEY_LINKS: Record<string, string> = {
  anthropic: "https://console.anthropic.com/settings/keys",
  openai: "https://platform.openai.com/api-keys",
};

export function AssistantSettingsForm({ slug, providers, current }: { slug: string; providers: Provider[]; current: Current }) {
  const [state, action, pending] = useActionState<AiFormState, FormData>(saveAiSettingsAction.bind(null, slug), null);
  const [provider, setProvider] = useState(current.provider);
  const p = providers.find((x) => x.id === provider)!;
  const sameProvider = provider === current.provider;

  return (
    <form action={action} className="space-y-4">
      {state?.error && <Alert>{state.error}</Alert>}
      {state?.ok && <Alert tone="success">Saved.</Alert>}
      <Field label="AI provider">
        <div className="grid gap-2 sm:grid-cols-2">
          {providers.map((x) => (
            <label key={x.id} className={`flex cursor-pointer items-center gap-2 rounded-xl border px-3 py-2.5 text-sm font-semibold transition ${provider === x.id ? "border-accent bg-accent/5 ring-4 ring-accent/10" : "border-[var(--border)]"}`}>
              <input type="radio" name="provider" value={x.id} checked={provider === x.id} onChange={() => setProvider(x.id)} className="accent-[var(--color-accent)]" />{x.name}
            </label>
          ))}
        </div>
      </Field>
      <Field
        label="API key"
        hint={<>Stored encrypted and only used for this workspace. Get one from <a href={KEY_LINKS[provider]} target="_blank" rel="noopener noreferrer" className="font-semibold text-accent underline">{p.name}</a>. Usage is billed by {p.name} to your account.</>}
      >
        <Input name="api_key" type="password" autoComplete="off" placeholder={sameProvider && current.hasKey ? `Saved key ending in ${current.keyEnd}. Leave empty to keep it.` : p.keyHint} required={!(sameProvider && current.hasKey)} />
      </Field>
      {sameProvider && current.hasKey && (
        <label className="flex items-center gap-2 text-sm text-[var(--muted)]"><input type="checkbox" name="remove_key" className="accent-red-600" /> Remove the saved key</label>
      )}
      <Field label="Model" hint={`Leave as is unless you want a different model. Default: ${p.defaultModel}.`}>
        <Input key={provider} name="model" defaultValue={sameProvider ? current.model : p.defaultModel} />
      </Field>
      <Field label="Assistant name">
        <Input name="name" defaultValue={current.name} maxLength={40} />
      </Field>
      <Field label="About your business and how to answer" hint="Personalises every answer. For example: who you are, your customers, your tone, words to use or avoid.">
        <textarea name="instructions" defaultValue={current.instructions} rows={5} maxLength={4000}
          placeholder="We're a 12-person interior design studio in Leeds. Keep answers brief and friendly, use British spelling, and show money in GBP."
          className="w-full rounded-xl border border-[var(--border)] bg-[var(--card)] px-3 py-2.5 text-sm shadow-[var(--shadow-sm)] outline-none focus:border-accent focus:ring-4 focus:ring-accent/15" />
      </Field>
      <Button type="submit" disabled={pending}>{pending ? "Checking key…" : "Save settings"}</Button>
    </form>
  );
}
