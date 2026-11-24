import type { Metadata } from "next";
import { SocialButtons } from "@/components/social-buttons";
import { parsePlanIntent, planQuery } from "@/lib/plan-intent";
import { enabledProviders } from "@/lib/providers";
import { safeNext } from "@/lib/safe-next";
import { SignUpForm } from "./form";

export const metadata: Metadata = { title: "Create your account", robots: { index: false, follow: true } };

export default async function SignUpPage({ searchParams }: { searchParams: Promise<{ app?: string; next?: string; plan?: string; interval?: string }> }) {
  const { app, next, plan, interval } = await searchParams;
  const appSlug = app && /^[a-z0-9-]{1,60}$/.test(app) ? app : undefined;
  const intent = parsePlanIntent(plan, interval);
  return (
    <>
      <h1 className="text-2xl font-bold">Create your account</h1>
      <p className="mb-6 mt-1 text-sm text-[var(--muted)]">
        {intent
          ? `Start your 14-day ${intent.plan.name} trial. You add a card after creating your workspace; nothing is charged until the trial ends, and you can cancel before then.`
          : "14-day Business trial. No card needed."}
      </p>
      <SocialButtons providers={enabledProviders()} />
      <SignUpForm app={appSlug} next={safeNext(next, "") || undefined} planQuery={planQuery(intent) || undefined} />
    </>
  );
}
