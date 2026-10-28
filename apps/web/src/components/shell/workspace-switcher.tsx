"use client";
import { useRouter } from "next/navigation";
import { authClient } from "@/lib/auth-client";

type W = { id: string; name: string; slug: string };

export function WorkspaceSwitcher({ current, workspaces }: { current: W; workspaces: W[] }) {
  const router = useRouter();
  return (
    <select
      aria-label="Switch workspace"
      value={current.slug}
      className="h-10 w-full truncate rounded-lg border border-[var(--border)] bg-transparent px-2 text-sm font-semibold"
      onChange={async (e) => {
        if (e.target.value === "__new") return router.push("/onboarding");
        const w = workspaces.find((x) => x.slug === e.target.value)!;
        await authClient.organization.setActive({ organizationId: w.id });
        router.push(`/w/${w.slug}`);
      }}
    >
      {workspaces.map((w) => <option key={w.id} value={w.slug}>{w.name}</option>)}
      <option value="__new">+ New workspace</option>
    </select>
  );
}
