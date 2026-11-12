import { type AppDef, canManageWorkspace, getAiSettings, HostedError, openHostedApp } from "@mewe/core";
import Link from "next/link";
import { BUTTON_BASE, BUTTON_PRIMARY } from "@/components/ui";
import { connection } from "next/server";
import { Alert, Button, Card } from "@/components/ui";
import { frameUrl, signInAllowed } from "@/lib/hosted-sso";
import { requireWorkspace } from "@/lib/session";
import { setUpHostedAppAction } from "@/app/w/[slug]/a/actions";
import { HostedFrame } from "./hosted-frame";

/** The page for a hosted app: signs the person in to their company's tenant and shows it. */
export async function HostedHome({ slug, app }: { slug: string; app: AppDef }) {
  await connection(); // a fresh one-time sign-in link on every visit
  const { workspace, role, session } = await requireWorkspace(slug);
  const canManage = canManageWorkspace(role);
  // AI Chat needs the company's own AI key first.
  if (app.hosted?.provider === "openwebui" && !(await getAiSettings(workspace.id)).hasKey) {
    return (
      <Card className="max-w-xl space-y-3">
        <p className="font-semibold">{app.name} needs your company&apos;s Claude or OpenAI key.</p>
        <p className="text-sm text-[var(--muted)]">It&apos;s saved encrypted in MeweMarket and used only for your company&apos;s chats.</p>
        {canManage ? <Link href={`/${slug}/${app.slug}/ai-settings`} className={`${BUTTON_BASE} ${BUTTON_PRIMARY} h-10 px-5`}>Add your AI key</Link>
          : <p className="text-sm">Ask an owner or admin to add it.</p>}
      </Card>
    );
  }
  let src: string | null;
  if (!(await signInAllowed(session.user.id))) {
    return <Card className="max-w-xl"><Alert>You&apos;ve opened apps a lot in the last minute. Please wait a moment and try again.</Alert></Card>;
  }
  try {
    const signIn = await openHostedApp(workspace, app.slug, { id: session.user.id, name: session.user.name }, role);
    src = signIn && (await frameUrl(signIn));
  } catch (e) {
    if (!(e instanceof HostedError)) console.error("openHostedApp", app.slug, e);
    const message = e instanceof HostedError ? e.message : `${app.name} isn't responding right now. Please try again in a minute.`;
    return <Card className="max-w-xl"><Alert>{message}</Alert></Card>;
  }
  if (!src) {
    // Installed but its tenant was never created (e.g. the service was down when it was added).
    return (
      <Card className="max-w-xl space-y-3">
        <p className="font-semibold">{app.name} isn&apos;t set up for {workspace.name} yet.</p>
        {canManage ? (
          <form action={setUpHostedAppAction.bind(null, slug, app.slug)}><Button type="submit">Set up {app.name}</Button></form>
        ) : <p className="text-sm text-[var(--muted)]">Ask an owner or admin to open it once to finish setting it up.</p>}
      </Card>
    );
  }
  return <HostedFrame slug={slug} app={app} src={src} canManage={canManage} />;
}
