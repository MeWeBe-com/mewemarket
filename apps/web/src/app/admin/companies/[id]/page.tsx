import Link from "next/link";
import { notFound } from "next/navigation";
import { sql } from "@mewe/db";
import { fmtDate } from "@/lib/admin";
import { Stat, Table } from "../../table";

export default async function AdminCompany({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const [w] = await sql<{ id: string; name: string; slug: string; created_at: Date; currency: string; timezone: string }[]>`
    select id, name, slug, created_at, currency, timezone from workspaces where id = ${id}`;
  if (!w) notFound();
  const [[sub], members, apps, hosted, [records], invites] = await Promise.all([
    sql<{ plan: string; status: string; interval: string; stripe_customer_id: string | null; stripe_subscription_id: string | null; current_period_end: Date | null; trial_ends_at: Date | null; extra_seats: number }[]>`
      select plan_id plan, status, interval, stripe_customer_id, stripe_subscription_id, current_period_end, trial_ends_at, extra_seats from subscriptions where workspace_id = ${id}`,
    sql<{ user_id: string; name: string; email: string; role: string; created_at: Date }[]>`
      select m.user_id, u.name, u.email, m.role, m.created_at from members m join users u on u.id = m.user_id where m.organization_id = ${id} order by m.created_at`,
    sql<{ name: string; slug: string; status: string; created_at: Date }[]>`
      select ca.name, ca.slug, ia.status, ia.created_at from installed_apps ia join catalog_apps ca on ca.id = ia.catalog_app_id where ia.workspace_id = ${id} order by ia.created_at`,
    sql<{ provider: string; url: string; created_at: Date }[]>`select provider, url, created_at from hosted_tenants where workspace_id = ${id} order by created_at`,
    sql<{ n: number }[]>`select count(*)::int n from records where workspace_id = ${id}`,
    sql<{ email: string; role: string | null; status: string; expires_at: Date }[]>`select email, role, status, expires_at from invitations where organization_id = ${id} and status = 'pending'`,
  ]);
  const stripeBase = process.env.STRIPE_SECRET_KEY?.startsWith("sk_test") ? "https://dashboard.stripe.com/test" : "https://dashboard.stripe.com";
  return (
    <div className="space-y-8">
      <div>
        <Link href="/admin/companies" className="text-sm text-[var(--muted)] hover:underline">← Companies</Link>
        <h1 className="mt-2 text-3xl font-extrabold">{w.name}</h1>
        <p className="text-[var(--muted)]"><a href={`/${w.slug}`} className="hover:underline">mewemarket.com/{w.slug}</a> · created {fmtDate(w.created_at)} · {w.currency} · {w.timezone}</p>
      </div>
      <div className="grid grid-cols-2 gap-4 md:grid-cols-4">
        <Stat label="Plan" value={sub ? sub.plan : "—"} hint={sub ? `${sub.status} · ${sub.interval}ly` : "no subscription"} />
        <Stat label="Members" value={members.length} hint={sub?.extra_seats ? `+${sub.extra_seats} extra seats` : undefined} />
        <Stat label="Apps" value={apps.length} hint={`${hosted.length} hosted`} />
        <Stat label="Records" value={records!.n} />
      </div>
      {sub && (
        <section><h2 className="mb-3 font-bold">Billing</h2>
          <Table head={["Renews / ends", "Trial ends", "Stripe customer", "Stripe subscription"]} rows={[[
            fmtDate(sub.current_period_end), fmtDate(sub.trial_ends_at),
            sub.stripe_customer_id ? <a href={`${stripeBase}/customers/${sub.stripe_customer_id}`} target="_blank" className="underline">{sub.stripe_customer_id}</a> : "—",
            sub.stripe_subscription_id ? <a href={`${stripeBase}/subscriptions/${sub.stripe_subscription_id}`} target="_blank" className="underline">{sub.stripe_subscription_id}</a> : "—",
          ]]} /></section>
      )}
      <section><h2 className="mb-3 font-bold">Members</h2>
        <Table head={["Name", "Email", "Role", "Joined"]} rows={members.map((m) => [
          <Link key={m.user_id} href={`/admin/users/${m.user_id}`} className="font-semibold hover:underline">{m.name}</Link>, m.email, m.role, fmtDate(m.created_at)])} /></section>
      {invites.length > 0 && (
        <section><h2 className="mb-3 font-bold">Pending invitations</h2>
          <Table head={["Email", "Role", "Expires"]} rows={invites.map((i) => [i.email, i.role ?? "member", fmtDate(i.expires_at)])} /></section>
      )}
      <section><h2 className="mb-3 font-bold">Apps</h2>
        <Table head={["App", "Status", "Added"]} rows={apps.map((a) => [<a key={a.slug} href={`/${w.slug}/${a.slug}`} className="hover:underline">{a.name}</a>, a.status, fmtDate(a.created_at)])} /></section>
      {hosted.length > 0 && (
        <section><h2 className="mb-3 font-bold">Hosted app tenants</h2>
          <Table head={["Product", "Tenant", "Created"]} rows={hosted.map((h) => [h.provider, h.url, fmtDate(h.created_at)])} /></section>
      )}
    </div>
  );
}
