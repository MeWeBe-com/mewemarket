import type { Metadata } from "next";
import { SocialButtons } from "@/components/social-buttons";
import { enabledProviders } from "@/lib/providers";
import { SignUpForm } from "./form";

export const metadata: Metadata = { title: "Create your account" };

export default function SignUpPage() {
  return (
    <>
      <h1 className="text-2xl font-bold">Create your account</h1>
      <p className="mb-6 mt-1 text-sm text-[var(--muted)]">14-day Business trial. No card needed.</p>
      <SocialButtons providers={enabledProviders()} />
      <SignUpForm />
    </>
  );
}
