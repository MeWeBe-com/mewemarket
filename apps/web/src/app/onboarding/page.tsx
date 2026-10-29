import type { Metadata } from "next";
import { requireUser } from "@/lib/session";
import { CreateWorkspaceForm } from "./form";

export const metadata: Metadata = { title: "Create your workspace" };

export default async function OnboardingPage({ searchParams }: { searchParams: Promise<{ app?: string }> }) {
  const { user } = await requireUser();
  const { app } = await searchParams;
  return (
    <main className="flex min-h-dvh items-center justify-center px-4 py-12">
      <div className="w-full max-w-md">
        <p className="text-sm font-semibold text-accent">Step 1 of 2</p>
        <h1 className="mt-2 text-3xl font-bold">Welcome, {user.name.split(" ")[0]}</h1>
        <p className="mb-8 mt-2 text-[var(--muted)]">Name your workspace. Next you can pick your apps and invite your team.</p>
        <CreateWorkspaceForm app={app && /^[a-z0-9-]{1,60}$/.test(app) ? app : undefined} />
      </div>
    </main>
  );
}
