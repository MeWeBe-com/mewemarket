import type { Metadata } from "next";
import Link from "next/link";
import { BrandPanel } from "@/components/site/brand-panel";
import { Logo } from "@/components/ui";
import { requireUser } from "@/lib/session";
import { CreateWorkspaceForm } from "./form";

export const metadata: Metadata = { title: "Create your workspace" };

const STEPS = ["Create your workspace", "Pick your apps", "Invite your team"];

export default async function OnboardingPage({ searchParams }: { searchParams: Promise<{ app?: string }> }) {
  const { user } = await requireUser();
  const { app } = await searchParams;
  return (
    <main className="grid min-h-dvh lg:grid-cols-[1fr_520px] xl:grid-cols-[1fr_600px]">
      <div className="flex flex-col px-4 py-8 sm:px-10">
        <Link href="/" aria-label="MeweMarket home"><Logo /></Link>
        <div className="mx-auto flex w-full max-w-md flex-1 flex-col justify-center py-12">
          <ol className="flex items-center gap-2 text-xs font-semibold" aria-label="Setup progress">
            {STEPS.map((s, i) => (
              <li key={s} className="flex flex-1 flex-col gap-2" aria-current={i === 0 ? "step" : undefined}>
                <span className={`h-1.5 rounded-full ${i === 0 ? "bg-gradient-to-r from-accent to-fuchsia-500" : "bg-[var(--border)]"}`} />
                <span className={i === 0 ? "text-accent" : "text-[var(--muted)]"}>{i + 1}. {s}</span>
              </li>
            ))}
          </ol>
          <h1 className="mt-10 text-3xl font-extrabold sm:text-4xl">Welcome, {user.name.split(" ")[0]}</h1>
          <p className="mb-8 mt-3 text-[var(--muted)]">Name your workspace. Next you can pick your apps and invite your team.</p>
          <CreateWorkspaceForm app={app && /^[a-z0-9-]{1,60}$/.test(app) ? app : undefined} />
        </div>
      </div>
      <BrandPanel title="Your whole business, set up in two minutes." points={["Add apps in one click, with sample data", "Bring your team with owner, admin, member or guest roles", "Free plan forever, 14-day Business trial"]} />
    </main>
  );
}
