import Link from "next/link";
import { sql } from "@mewe/db";
import { envSuperadmins, fmtDate } from "@/lib/admin";
import { Search, Table } from "../table";

export default async function AdminUsers({ searchParams }: { searchParams: Promise<{ q?: string }> }) {
  const { q = "" } = await searchParams;
  const like = `%${q.trim()}%`;
  const env = envSuperadmins();
  const rows = await sql<{ id: string; name: string; email: string; role: string; email_verified: boolean; two_factor_enabled: boolean | null; created_at: Date; companies: number; last_seen: Date | null }[]>`
    select u.id, u.name, u.email, u.role, u.email_verified, u.two_factor_enabled, u.created_at,
      (select count(*)::int from members m where m.user_id = u.id) companies,
      (select max(s.updated_at) from sessions s where s.user_id = u.id) last_seen
    from users u where u.name ilike ${like} or u.email ilike ${like}
    order by u.created_at desc limit 200`;
  return (
    <div>
      <h1 className="mb-6 text-3xl font-extrabold">Users</h1>
      <Search q={q} placeholder="Search name or email…" />
      <Table head={["Name", "Email", "Companies", "Verified", "2FA", "Last seen", "Joined"]} rows={rows.map((u) => [
        <Link key={u.id} href={`/admin/users/${u.id}`} className="font-semibold hover:underline">{u.name}
          {(u.role === "superadmin" || env.includes(u.email.toLowerCase())) && <span className="ml-2 rounded bg-red-500/10 px-1.5 text-xs text-red-600">super admin</span>}</Link>,
        u.email, u.companies, u.email_verified ? "yes" : "no", u.two_factor_enabled ? "on" : "off", fmtDate(u.last_seen), fmtDate(u.created_at),
      ])} />
    </div>
  );
}
