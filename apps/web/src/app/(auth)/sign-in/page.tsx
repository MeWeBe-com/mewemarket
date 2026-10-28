import type { Metadata } from "next";
import { Suspense } from "react";
import { SocialButtons } from "@/components/social-buttons";
import { enabledProviders } from "@/lib/providers";
import { SignInForm } from "./form";

export const metadata: Metadata = { title: "Sign in" };

export default function SignInPage() {
  return (
    <>
      <h1 className="mb-6 text-2xl font-bold">Sign in</h1>
      <SocialButtons providers={enabledProviders()} />
      <Suspense><SignInForm /></Suspense>
    </>
  );
}
