"use client";
import { useState } from "react";
import { Alert, Button, Field, Input, TextLink } from "@/components/ui";
import { authClient } from "@/lib/auth-client";

export default function ForgotPasswordPage() {
  const [sent, setSent] = useState(false);
  const [pending, setPending] = useState(false);

  async function onSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    setPending(true);
    const email = String(new FormData(e.currentTarget).get("email"));
    // Always show success so the form can't be used to discover which emails have accounts.
    await authClient.requestPasswordReset({ email, redirectTo: "/reset-password" });
    setSent(true);
    setPending(false);
  }

  return (
    <>
      <h1 className="mb-6 text-2xl font-bold">Reset your password</h1>
      {sent ? (
        <Alert tone="success">If an account exists for that email, a reset link is on its way.</Alert>
      ) : (
        <form onSubmit={onSubmit} className="space-y-4">
          <Field label="Email"><Input name="email" type="email" required autoFocus /></Field>
          <Button type="submit" className="w-full" disabled={pending}>Send reset link</Button>
        </form>
      )}
      <p className="mt-6 text-center text-sm"><TextLink href="/sign-in">Back to sign in</TextLink></p>
    </>
  );
}
