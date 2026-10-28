"use client";
import { useRouter, useSearchParams } from "next/navigation";
import { Suspense, useState } from "react";
import { Alert, Button, Field, Input, TextLink } from "@/components/ui";
import { authClient } from "@/lib/auth-client";

function ResetForm() {
  const router = useRouter();
  const token = useSearchParams().get("token");
  const [error, setError] = useState<string | null>(null);
  const [pending, setPending] = useState(false);

  if (!token) return <Alert>This reset link is invalid or has expired. <TextLink href="/forgot-password">Request a new one</TextLink>.</Alert>;

  async function onSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    setPending(true);
    const { error } = await authClient.resetPassword({ newPassword: String(new FormData(e.currentTarget).get("password")), token: token! });
    setPending(false);
    if (error) return setError(error.message ?? "Reset failed");
    router.push("/sign-in");
  }

  return (
    <form onSubmit={onSubmit} className="space-y-4">
      {error && <Alert>{error}</Alert>}
      <Field label="New password" hint="At least 10 characters.">
        <Input name="password" type="password" autoComplete="new-password" minLength={10} required autoFocus />
      </Field>
      <Button type="submit" className="w-full" disabled={pending}>Save new password</Button>
    </form>
  );
}

export default function ResetPasswordPage() {
  return (
    <>
      <h1 className="mb-6 text-2xl font-bold">Choose a new password</h1>
      <Suspense><ResetForm /></Suspense>
    </>
  );
}
