"use client";
import { useRouter } from "next/navigation";
import { useState } from "react";
import { Alert, Button, Field, Input } from "@/components/ui";
import { authClient } from "@/lib/auth-client";

export default function TwoFactorPage() {
  const router = useRouter();
  const [backup, setBackup] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [pending, setPending] = useState(false);

  async function onSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    setPending(true);
    const f = new FormData(e.currentTarget);
    const code = String(f.get("code")).trim();
    const trustDevice = f.get("trust") === "on";
    const { error } = backup
      ? await authClient.twoFactor.verifyBackupCode({ code, trustDevice })
      : await authClient.twoFactor.verifyTotp({ code, trustDevice });
    setPending(false);
    if (error) return setError(error.message ?? "Invalid code");
    router.push("/dashboard");
    router.refresh();
  }

  return (
    <>
      <h1 className="mb-2 text-2xl font-bold">Two-factor authentication</h1>
      <p className="mb-6 text-sm text-[var(--muted)]">
        {backup ? "Enter one of your backup codes." : "Enter the 6-digit code from your authenticator app."}
      </p>
      <form onSubmit={onSubmit} className="space-y-4">
        {error && <Alert>{error}</Alert>}
        <Field label={backup ? "Backup code" : "Code"}>
          <Input name="code" inputMode={backup ? "text" : "numeric"} autoComplete="one-time-code" required autoFocus />
        </Field>
        <label className="flex items-center gap-2 text-sm"><input type="checkbox" name="trust" /> Trust this device for 30 days</label>
        <Button type="submit" className="w-full" disabled={pending}>Verify</Button>
        <button type="button" className="w-full text-sm text-[var(--muted)] hover:text-[var(--fg)]" onClick={() => setBackup(!backup)}>
          {backup ? "Use authenticator app" : "Use a backup code"}
        </button>
      </form>
    </>
  );
}
