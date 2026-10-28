"use client";
import { useRouter, useSearchParams } from "next/navigation";
import { useState } from "react";
import { Alert, Button, Field, Input, TextLink } from "@/components/ui";
import { authClient } from "@/lib/auth-client";

export function SignInForm() {
  const router = useRouter();
  const next = useSearchParams().get("next") ?? "/dashboard";
  const [mode, setMode] = useState<"password" | "magic">("password");
  const [error, setError] = useState<string | null>(null);
  const [sent, setSent] = useState(false);
  const [pending, setPending] = useState(false);

  async function onSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    setError(null);
    setPending(true);
    const f = new FormData(e.currentTarget);
    const email = String(f.get("email"));
    if (mode === "magic") {
      const { error } = await authClient.signIn.magicLink({ email, callbackURL: next });
      if (error) setError(error.message ?? "Could not send the link");
      else setSent(true);
    } else {
      const { error } = await authClient.signIn.email({ email, password: String(f.get("password")) });
      if (error) {
        setError(error.status === 403 ? "Please verify your email first. We've sent you a new link." : (error.message ?? "Sign in failed"));
      } else {
        router.push(next);
        router.refresh();
      }
    }
    setPending(false);
  }

  if (sent) return <Alert tone="success">Check your inbox. We sent a sign-in link that expires in 5 minutes.</Alert>;

  return (
    <form onSubmit={onSubmit} className="space-y-4">
      {error && <Alert>{error}</Alert>}
      <Field label="Email"><Input name="email" type="email" autoComplete="email" required autoFocus /></Field>
      {mode === "password" && (
        <Field label="Password" hint={<TextLink href="/forgot-password">Forgot password?</TextLink>}>
          <Input name="password" type="password" autoComplete="current-password" required />
        </Field>
      )}
      <Button type="submit" className="w-full" disabled={pending}>
        {pending ? "Please wait…" : mode === "password" ? "Sign in" : "Email me a sign-in link"}
      </Button>
      <button type="button" className="w-full text-sm text-[var(--muted)] hover:text-[var(--fg)]"
        onClick={() => setMode(mode === "password" ? "magic" : "password")}>
        {mode === "password" ? "Sign in with an email link instead" : "Sign in with a password instead"}
      </button>
      <p className="text-center text-sm text-[var(--muted)]">New here? <TextLink href="/sign-up">Create an account</TextLink></p>
    </form>
  );
}
