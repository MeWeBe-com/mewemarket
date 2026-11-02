"use client";
import { useRouter } from "next/navigation";
import { useState } from "react";
import { Alert, Button, Field, Input } from "@/components/ui";
import { authClient } from "@/lib/auth-client";

const slugify = (s: string) => s.toLowerCase().trim().replace(/[^a-z0-9]+/g, "-").replace(/^-+|-+$/g, "").slice(0, 40);

export function CreateWorkspaceForm({ app }: { app?: string }) {
  const router = useRouter();
  const [name, setName] = useState("");
  const [slug, setSlug] = useState("");
  const [slugEdited, setSlugEdited] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [pending, setPending] = useState(false);

  async function onSubmit(e: React.FormEvent) {
    e.preventDefault();
    setError(null);
    setPending(true);
    const { data: free } = await authClient.organization.checkSlug({ slug });
    if (!free?.status) {
      setPending(false);
      return setError("That address is taken. Try another.");
    }
    const { data, error } = await authClient.organization.create({ name, slug });
    if (error || !data) {
      setPending(false);
      return setError(error?.message ?? "Could not create the workspace");
    }
    await authClient.organization.setActive({ organizationId: data.id });
    router.push(app ? `/w/${data.slug}/apps?app=${app}#${app}` : `/w/${data.slug}/apps`);
    router.refresh();
  }

  return (
    <form onSubmit={onSubmit} className="space-y-5">
      {error && <Alert>{error}</Alert>}
      <div className="surface flex items-center gap-3 p-3" aria-hidden>
        <span className="grid size-11 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-lg font-bold text-white shadow-sm">{(name.trim()[0] ?? "?").toUpperCase()}</span>
        <span className="min-w-0">
          <span className="block truncate font-bold">{name.trim() || "Your company"}</span>
          <span className="block truncate text-xs text-[var(--muted)]">mewemarket.com/w/{slug || "your-company"}</span>
        </span>
      </div>
      <Field label="Company or team name">
        <Input value={name} required autoFocus placeholder="Acme Ltd"
          onChange={(e) => { setName(e.target.value); if (!slugEdited) setSlug(slugify(e.target.value)); }} />
      </Field>
      <Field label="Workspace address" hint={`mewemarket.com/w/${slug || "your-company"}`}>
        <Input value={slug} required pattern="[a-z0-9-]{2,40}"
          onChange={(e) => { setSlug(slugify(e.target.value)); setSlugEdited(true); }} />
      </Field>
      <Button type="submit" className="h-11 w-full text-base" disabled={pending || !slug}>{pending ? "Creating…" : "Create workspace"}</Button>
    </form>
  );
}
