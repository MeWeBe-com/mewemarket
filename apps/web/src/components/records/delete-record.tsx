"use client";
import { useRouter } from "next/navigation";
import { useTransition } from "react";
import { deleteRecordAction } from "@/app/w/[slug]/a/actions";

export function DeleteRecord({ slug, app, entity, id, back, name }: { slug: string; app: string; entity: string; id: string; back: string; name: string }) {
  const router = useRouter();
  const [pending, start] = useTransition();
  return (
    <button type="button" disabled={pending} className="inline-flex h-9 items-center rounded-lg px-3 text-sm text-red-600 hover:bg-red-500/10 disabled:opacity-50"
      onClick={() => {
        if (!confirm(`Delete this ${name}? This can't be undone.`)) return;
        start(async () => { await deleteRecordAction(slug, app, entity, [id]); router.push(back); });
      }}>
      {pending ? "Deleting…" : "Delete"}
    </button>
  );
}
