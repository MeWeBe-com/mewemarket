"use client";
import { useRouter } from "next/navigation";
import { useState } from "react";
import QRCode from "react-qr-code";
import { Alert, Button, Field, Input } from "@/components/ui";
import { authClient } from "@/lib/auth-client";

type Msg = { tone: "error" | "success"; text: string } | null;

export function ProfileForm({ name, email }: { name: string; email: string }) {
  const router = useRouter();
  const [msg, setMsg] = useState<Msg>(null);
  return (
    <form className="space-y-4" onSubmit={async (e) => {
      e.preventDefault();
      const { error } = await authClient.updateUser({ name: String(new FormData(e.currentTarget).get("name")) });
      setMsg(error ? { tone: "error", text: error.message ?? "Update failed" } : { tone: "success", text: "Profile updated." });
      router.refresh();
    }}>
      <h2 className="text-lg font-bold">Profile</h2>
      {msg && <Alert tone={msg.tone}>{msg.text}</Alert>}
      <Field label="Name"><Input name="name" defaultValue={name} required /></Field>
      <Field label="Email"><Input value={email} disabled /></Field>
      <Button type="submit">Save</Button>
    </form>
  );
}

export function PasswordForm() {
  const [msg, setMsg] = useState<Msg>(null);
  return (
    <form className="space-y-4" onSubmit={async (e) => {
      e.preventDefault();
      const form = e.currentTarget;
      const f = new FormData(form);
      const { error } = await authClient.changePassword({
        currentPassword: String(f.get("current")), newPassword: String(f.get("next")), revokeOtherSessions: true,
      });
      if (!error) form.reset();
      setMsg(error ? { tone: "error", text: error.message ?? "Could not change password" } : { tone: "success", text: "Password changed. Other devices were signed out." });
    }}>
      <h2 className="text-lg font-bold">Password</h2>
      {msg && <Alert tone={msg.tone}>{msg.text}</Alert>}
      <Field label="Current password"><Input name="current" type="password" autoComplete="current-password" required /></Field>
      <Field label="New password" hint="At least 10 characters."><Input name="next" type="password" autoComplete="new-password" minLength={10} required /></Field>
      <Button type="submit">Change password</Button>
    </form>
  );
}

export function TwoFactorSetup({ enabled }: { enabled: boolean }) {
  const router = useRouter();
  const [step, setStep] = useState<"idle" | "password" | "verify">("idle");
  const [uri, setUri] = useState("");
  const [codes, setCodes] = useState<string[]>([]);
  const [error, setError] = useState<string | null>(null);

  async function start(password: string) {
    setError(null);
    if (enabled) {
      const { error } = await authClient.twoFactor.disable({ password });
      if (error) return setError(error.message ?? "Could not disable");
      setStep("idle");
      return router.refresh();
    }
    const { data, error } = await authClient.twoFactor.enable({ password });
    if (error || !data || data.method !== "totp") return setError(error?.message ?? "Could not start setup");
    setUri(data.totpURI);
    setCodes(data.backupCodes);
    setStep("verify");
  }

  async function verify(code: string) {
    const { error } = await authClient.twoFactor.verifyTotp({ code });
    if (error) return setError(error.message ?? "Invalid code");
    setStep("idle");
    router.refresh();
  }

  return (
    <div className="space-y-4">
      <h2 className="text-lg font-bold">Two-factor authentication</h2>
      <p className="text-sm text-[var(--muted)]">{enabled ? "On. You'll be asked for a code when you sign in." : "Add a second step to sign-in with an authenticator app."}</p>
      {error && <Alert>{error}</Alert>}
      {step === "idle" && <Button variant={enabled ? "secondary" : "primary"} onClick={() => setStep("password")}>{enabled ? "Turn off" : "Turn on"}</Button>}
      {step === "password" && (
        <form className="flex gap-2" onSubmit={(e) => { e.preventDefault(); start(String(new FormData(e.currentTarget).get("password"))); }}>
          <Input name="password" type="password" placeholder="Confirm your password" required autoFocus />
          <Button type="submit">Continue</Button>
        </form>
      )}
      {step === "verify" && (
        <div className="space-y-4">
          <div className="inline-block rounded-lg bg-white p-3"><QRCode value={uri} size={160} /></div>
          <p className="text-sm">Scan this with your authenticator app, then enter the 6-digit code.</p>
          <div className="rounded-xl bg-[var(--bg-subtle)] p-4 ring-1 ring-[var(--border)]">
            <p className="text-sm font-medium">Backup codes. Save these somewhere safe:</p>
            <p className="mt-2 grid grid-cols-2 gap-1 font-mono text-xs">{codes.map((c) => <span key={c}>{c}</span>)}</p>
          </div>
          <form className="flex gap-2" onSubmit={(e) => { e.preventDefault(); verify(String(new FormData(e.currentTarget).get("code"))); }}>
            <Input name="code" inputMode="numeric" autoComplete="one-time-code" placeholder="123456" required />
            <Button type="submit">Verify and turn on</Button>
          </form>
        </div>
      )}
    </div>
  );
}

// `since` is formatted on the server so the text matches during hydration.
type S = { token: string; userAgent: string; ipAddress: string; since: string };

export function SessionList({ sessions, currentToken, more }: { sessions: S[]; currentToken: string; more: number }) {
  const router = useRouter();
  return (
    <div className="space-y-3">
      <div className="flex items-center justify-between">
        <h2 className="text-lg font-bold">Active sessions</h2>
        {sessions.length + more > 1 && (
          <Button variant="ghost" className="h-8 text-xs" onClick={async () => { await authClient.revokeOtherSessions(); router.refresh(); }}>
            Sign out other devices
          </Button>
        )}
      </div>
      <ul className="divide-y divide-[var(--border)] text-sm">
        {sessions.map((s) => (
          <li key={s.token} className="flex items-center justify-between gap-4 py-2">
            <span className="min-w-0">
              <span className="block truncate">{s.userAgent}</span>
              <span className="text-xs text-[var(--muted)]">{s.ipAddress} · since {s.since}</span>
            </span>
            {s.token === currentToken ? (
              <span className="rounded-full bg-emerald-500/10 px-2 py-0.5 text-xs font-bold text-emerald-600">This device</span>
            ) : (
              <Button variant="ghost" className="h-8 text-xs" onClick={async () => { await authClient.revokeSession({ token: s.token }); router.refresh(); }}>Revoke</Button>
            )}
          </li>
        ))}
      </ul>
      {more > 0 && <p className="text-xs text-[var(--muted)]">And {more} older sessions. "Sign out other devices" ends them all.</p>}
    </div>
  );
}
