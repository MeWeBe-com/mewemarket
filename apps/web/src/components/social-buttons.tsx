"use client";
import { authClient } from "@/lib/auth-client";
import { Button } from "./ui";

export function SocialButtons({ providers }: { providers: ("google" | "github")[] }) {
  if (!providers.length) return null;
  return (
    <div className="space-y-2">
      {providers.map((p) => (
        <Button key={p} type="button" variant="secondary" className="w-full"
          onClick={() => authClient.signIn.social({ provider: p, callbackURL: "/dashboard" })}>
          Continue with {p === "google" ? "Google" : "GitHub"}
        </Button>
      ))}
      <div className="flex items-center gap-3 py-2 text-xs text-[var(--muted)]">
        <span className="h-px flex-1 bg-[var(--border)]" />or<span className="h-px flex-1 bg-[var(--border)]" />
      </div>
    </div>
  );
}
