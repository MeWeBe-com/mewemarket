import Link from "next/link";
import { sql } from "@mewe/db";
import { fmtDate } from "@/lib/admin";
import { Stat, Table } from "./table";

export default async function AdminOverview() {
  const [[c], plans, apps, recentCompanies, recentUsers] = await Promise.all([
    sql<{ users: number; users7: number; companies: number; companies7: number; paying: number; sessions: number; messages: number }[]>`
      select (select count(*)::int from users) users,
             (select count(*)::int from users where created_at > now() - interval '7 days') users7,
             (select count(*)::int from workspaces) companies,
             (select count(*)::int from workspaces where created_at > now() - interval '7 days') companies7,
             (select count(*)::int from subscriptions where status = 'active' and stripe_subscription_id is not null) paying,
             (select count(*)::int from sessions where expires_at > now()) sessions,
             (select count(*)::int from contact_messages where status = 'new') messages`,
    sql<{ plan: string; status: string; n: number }[]>`
      select coalesce(p.name, s.plan_id) plan, s.status, count(*)::int n
      from subscriptions s left join plans p on p.id = s.plan_id group by 1, 2 order by 3 desc`,
    sql<{ name: string; n: number }[]>`
      select ca.name, count(*)::int n from installed_apps ia join catalog_apps ca on ca.id = ia.catalog_app_id
      group by 1 order by 2 desc limit 12`,
    sql<{ id: string; name: string; slug: string; created_at: Date }[]>`select id, name, slug, created_at from workspaces order by created_at desc limit 8`,
    sql<{ id: string; name: string; email: string; created_at: Date }[]>`select id, name, email, created_at from users order by created_at desc limit 8`,
  ]);
  return (
    <div className="space-y-8">
      <h1 className="text-3xl font-extrabold">Overview</h1>
      <div className="grid grid-cols-2 gap-4 md:grid-cols-4">
        <Stat label="Companies" value={c!.companies} hint={`+${c!.companies7} this week`} />
        <Stat label="Users" value={c!.users} hint={`+${c!.users7} this week`} />
        <Stat label="Paying (Stripe)" value={c!.paying} />
        <Stat label="Signed in now" value={c!.sessions} hint={<Link href="/admin/messages" className="underline">{c!.messages} new messages</Link>} />
      </div>
      <div className="grid gap-6 md:grid-cols-2">
        <section><h2 className="mb-3 font-bold">Plans</h2>
          <Table head={["Plan", "Status", "Companies"]} rows={plans.map((p) => [p.plan, p.status, p.n])} /></section>
        <section><h2 className="mb-3 font-bold">Apps in use</h2>
          <Table head={["App", "Companies"]} rows={apps.map((a) => [a.name, a.n])} /></section>
        <section><h2 className="mb-3 font-bold">Newest companies</h2>
          <Table head={["Company", "Created"]} rows={recentCompanies.map((w) => [<Link key={w.id} href={`/admin/companies/${w.id}`} className="font-semibold hover:underline">{w.name}</Link>, fmtDate(w.created_at)])} /></section>
        <section><h2 className="mb-3 font-bold">Newest users</h2>
          <Table head={["User", "Joined"]} rows={recentUsers.map((u) => [<Link key={u.id} href={`/admin/users/${u.id}`} className="hover:underline"><b>{u.name}</b> <span className="text-[var(--muted)]">{u.email}</span></Link>, fmtDate(u.created_at)])} /></section>
      </div>
    </div>
  );
}
