import type { AppDef } from "@mewe/core";
import { ExternalLink, Settings2 } from "lucide-react";
import { AppIcon } from "@/components/app-icon";
import { uninstallAppAction } from "@/app/w/[slug]/a/actions";

/**
 * A hosted product shown full-size beside the workspace sidebar. `src` is a one-time sign-in link, so the
 * person lands in their own company's tenant already signed in.
 */
export function HostedFrame({ slug, app, src, canManage }: { slug: string; app: AppDef; src: string; canManage: boolean }) {
  const h = app.hosted!;
  return (
    <div className="fixed inset-x-0 bottom-0 top-[57px] z-20 flex flex-col bg-[var(--bg)] md:left-64 md:top-0">
      <div className="flex h-11 shrink-0 items-center gap-2.5 border-b border-[var(--border)] px-3 text-sm">
        <AppIcon slug={app.slug} name={app.name} category={app.category} size="sm" className="!size-6 !rounded-md [&>svg]:size-3.5" />
        <span className="font-semibold">{app.name}</span>
        <a href={h.sourceUrl} target="_blank" rel="noreferrer" className="hidden truncate text-xs text-[var(--muted)] hover:text-accent sm:inline">
          Powered by {h.poweredBy} ({h.license})
        </a>
        <span className="flex-1" />
        <a href={`/${slug}/${app.slug}/open`} target="_blank" rel="noreferrer" className="inline-flex items-center gap-1 rounded-lg px-2 py-1 text-xs font-medium text-[var(--muted)] hover:bg-[var(--bg-subtle)] hover:text-[var(--fg)]">
          <ExternalLink className="size-3.5" /><span className="hidden sm:inline">Open in new tab</span>
        </a>
        {canManage && (
          <details className="relative">
            <summary aria-label={`${app.name} settings`} className="grid size-7 cursor-pointer list-none place-items-center rounded-lg text-[var(--muted)] hover:bg-[var(--bg-subtle)] hover:text-[var(--fg)]">
              <Settings2 className="size-4" />
            </summary>
            <form action={uninstallAppAction.bind(null, slug, app.slug)} className="absolute right-0 z-30 mt-2 w-80 space-y-3 rounded-xl border border-[var(--border)] bg-[var(--card)] p-4 text-sm shadow-xl">
              <p className="font-semibold">Remove {app.name}</p>
              <p className="text-[var(--muted)]">This hides {app.name} from your workspace. Your {app.name} data is kept, so adding it back brings everything back.</p>
              <label className="flex items-start gap-2"><input type="checkbox" name="delete_data" className="mt-0.5 accent-red-600" /> Also delete all {app.name} data permanently. This can&apos;t be undone.</label>
              <button className="h-9 w-full rounded-lg bg-red-600 px-4 font-semibold text-white hover:bg-red-500">Remove {app.name}</button>
            </form>
          </details>
        )}
      </div>
      <iframe src={src} title={app.name} className="min-h-0 w-full flex-1 border-0" allow="clipboard-read; clipboard-write; fullscreen" />
    </div>
  );
}
