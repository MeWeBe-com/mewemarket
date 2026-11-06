import type { Metadata } from "next";
import { SocialButtons } from "@/components/social-buttons";
import { enabledProviders } from "@/lib/providers";
import { safeNext } from "@/lib/safe-next";
import { SignUpForm } from "./form";

export const metadata: Metadata = { title: "Create your account" };

export default async function SignUpPage({ searchParams }: { searchParams: Promise<{ app?: string; next?: string }> }) {
  const { app, next } = await searchParams;
  const appSlug = app && /^[a-z0-9-]{1,60}$/.test(app) ? app : undefined;
  return (
    <>
      <h1 className="text-2xl font-bold">Create your account</h1>
      <p className="mb-6 mt-1 text-sm text-[var(--muted)]">14-day Business trial. No card needed.</p>
      <SocialButtons providers={enabledProviders()} />
      <SignUpForm app={appSlug} next={safeNext(next, "") || undefined} />
    </>
  );
}
