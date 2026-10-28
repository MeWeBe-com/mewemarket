import type { Metadata } from "next";
import { requireUser } from "@/lib/session";
import { CreateWorkspaceForm } from "./form";

export const metadata: Metadata = { title: "Create your workspace" };

export default async function OnboardingPage() {
  const { user } = await requireUser();
  return (
    <main className="flex min-h-dvh items-center justify-center px-4 py-12">
      <div className="w-full max-w-md">
        <p className="text-sm font-semibold text-accent">Step 1 of 2</p>
        <h1 className="mt-2 text-3xl font-bold">Welcome, {user.name.split(" ")[0]}</h1>
        <p className="mb-8 mt-2 text-[var(--muted)]">Name your workspace. You can invite your team and install apps next.</p>
        <CreateWorkspaceForm />
      </div>
    </main>
  );
}
