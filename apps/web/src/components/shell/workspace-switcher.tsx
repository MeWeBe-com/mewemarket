"use client";
import { useRouter } from "next/navigation";
import { authClient } from "@/lib/auth-client";

type W = { id: string; name: string; slug: string };

export function WorkspaceSwitcher({ current, workspaces }: { current: W; workspaces: W[] }) {
  const router = useRouter();
  return (
    <div className="relative">
    <span aria-hidden className="pointer-events-none absolute left-2 top-1/2 grid size-7 -translate-y-1/2 place-items-center rounded-lg bg-gradient-to-br from-amber-400 to-orange-500 text-xs font-bold text-white shadow-sm">{current.name[0]?.toUpperCase()}</span>
    <select
      aria-label="Switch workspace"
      value={current.slug}
      className="h-11 w-full cursor-pointer truncate rounded-xl border border-[var(--border)] bg-[var(--card)] pl-11 pr-2 text-sm font-bold shadow-[var(--shadow-sm)] outline-none focus:ring-4 focus:ring-accent/15"
      onChange={async (e) => {
        if (e.target.value === "__new") return router.push("/onboarding");
        const w = workspaces.find((x) => x.slug === e.target.value)!;
        await authClient.organization.setActive({ organizationId: w.id });
        router.push(`/${w.slug}`);
      }}
    >
      {workspaces.map((w) => <option key={w.id} value={w.slug}>{w.name}</option>)}
      <option value="__new">+ New workspace</option>
    </select>
    </div>
  );
}
