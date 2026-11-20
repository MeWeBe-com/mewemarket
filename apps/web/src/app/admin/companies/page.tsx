import Link from "next/link";
import { sql } from "@mewe/db";
import { fmtDate } from "@/lib/admin";
import { Search, Table } from "../table";

export default async function AdminCompanies({ searchParams }: { searchParams: Promise<{ q?: string }> }) {
  const { q = "" } = await searchParams;
  const like = `%${q.trim()}%`;
  const rows = await sql<{ id: string; name: string; slug: string; created_at: Date; members: number; apps: number; plan: string | null; status: string | null; owner: string | null }[]>`
    select w.id, w.name, w.slug, w.created_at,
      (select count(*)::int from members m where m.organization_id = w.id) members,
      (select count(*)::int from installed_apps ia where ia.workspace_id = w.id) apps,
      s.plan_id plan, s.status,
      (select u.email from members m join users u on u.id = m.user_id where m.organization_id = w.id and m.role = 'owner' order by m.created_at limit 1) owner
    from workspaces w left join subscriptions s on s.workspace_id = w.id
    where w.name ilike ${like} or w.slug ilike ${like}
    order by w.created_at desc limit 200`;
  return (
    <div>
      <h1 className="mb-6 text-3xl font-extrabold">Companies</h1>
      <Search q={q} placeholder="Search name or URL…" />
      <Table head={["Company", "URL", "Owner", "Members", "Apps", "Plan", "Created"]} rows={rows.map((w) => [
        <Link key={w.id} href={`/admin/companies/${w.id}`} className="font-semibold hover:underline">{w.name}</Link>,
        <a key="u" href={`/${w.slug}`} className="text-[var(--muted)] hover:underline">/{w.slug}</a>,
        w.owner ?? "—", w.members, w.apps, w.plan ? `${w.plan} · ${w.status}` : "—", fmtDate(w.created_at),
      ])} />
    </div>
  );
}
