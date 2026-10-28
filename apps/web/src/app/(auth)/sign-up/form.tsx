"use client";
import { useRouter } from "next/navigation";
import { useState } from "react";
import { Alert, Button, Field, Input, TextLink } from "@/components/ui";
import { authClient } from "@/lib/auth-client";

export function SignUpForm() {
  const router = useRouter();
  const [error, setError] = useState<string | null>(null);
  const [pending, setPending] = useState(false);

  async function onSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    setError(null);
    setPending(true);
    const f = new FormData(e.currentTarget);
    const email = String(f.get("email"));
    const { error } = await authClient.signUp.email({
      name: String(f.get("name")), email, password: String(f.get("password")), callbackURL: "/onboarding",
    });
    setPending(false);
    if (error) return setError(error.message ?? "Sign up failed");
    router.push(`/check-email?email=${encodeURIComponent(email)}`);
  }

  return (
    <form onSubmit={onSubmit} className="space-y-4">
      {error && <Alert>{error}</Alert>}
      <Field label="Full name"><Input name="name" autoComplete="name" required autoFocus /></Field>
      <Field label="Work email"><Input name="email" type="email" autoComplete="email" required /></Field>
      <Field label="Password" hint="At least 10 characters.">
        <Input name="password" type="password" autoComplete="new-password" minLength={10} required />
      </Field>
      <Button type="submit" className="w-full" disabled={pending}>{pending ? "Creating account…" : "Create account"}</Button>
      <p className="text-center text-xs text-[var(--muted)]">
        By signing up you agree to our <TextLink href="/terms">Terms</TextLink> and <TextLink href="/privacy">Privacy Policy</TextLink>.
      </p>
      <p className="text-center text-sm text-[var(--muted)]">Already have an account? <TextLink href="/sign-in">Sign in</TextLink></p>
    </form>
  );
}
