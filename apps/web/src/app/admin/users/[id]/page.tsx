import Link from "next/link";
import { notFound } from "next/navigation";
import { sql } from "@mewe/db";
import { Button } from "@/components/ui";
import { envSuperadmins, fmtDate, requireSuperadmin } from "@/lib/admin";
import { setSuperadmin, signOutEverywhere } from "../../actions";
import { Table } from "../../table";

export default async function AdminUser({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const { user: me } = await requireSuperadmin();
  const [u] = await sql<{ id: string; name: string; email: string; role: string; email_verified: boolean; two_factor_enabled: boolean | null; created_at: Date }[]>`
    select id, name, email, role, email_verified, two_factor_enabled, created_at from users where id = ${id}`;
  if (!u) notFound();
  const [companies, sessions, logins] = await Promise.all([
    sql<{ id: string; name: string; slug: string; role: string; created_at: Date }[]>`
      select w.id, w.name, w.slug, m.role, m.created_at from members m join workspaces w on w.id = m.organization_id where m.user_id = ${id} order by m.created_at`,
    sql<{ ip_address: string | null; user_agent: string | null; created_at: Date; expires_at: Date }[]>`
      select ip_address, user_agent, created_at, expires_at from sessions where user_id = ${id} and expires_at > now() order by created_at desc limit 20`,
    sql<{ provider_id: string }[]>`select provider_id from accounts where user_id = ${id}`,
  ]);
  const viaEnv = envSuperadmins().includes(u.email.toLowerCase());
  const isSuper = viaEnv || u.role === "superadmin";
  return (
    <div className="space-y-8">
      <div>
        <Link href="/admin/users" className="text-sm text-[var(--muted)] hover:underline">← Users</Link>
        <h1 className="mt-2 text-3xl font-extrabold">{u.name}{isSuper && <span className="ml-3 align-middle rounded bg-red-500/10 px-2 py-0.5 text-sm text-red-600">super admin</span>}</h1>
        <p className="text-[var(--muted)]">{u.email} · joined {fmtDate(u.created_at)} · email {u.email_verified ? "verified" : "not verified"} · 2FA {u.two_factor_enabled ? "on" : "off"} · signs in with {logins.map((l) => l.provider_id).join(", ") || "—"}</p>
      </div>
      <div className="flex flex-wrap gap-3">
        <form action={signOutEverywhere.bind(null, u.id)}><Button variant="secondary">Sign out of all devices ({sessions.length})</Button></form>
        {!viaEnv && u.id !== me.id && (
          <form action={setSuperadmin.bind(null, u.id, !isSuper)}><Button variant={isSuper ? "danger" : "secondary"}>{isSuper ? "Remove super admin" : "Make super admin"}</Button></form>
        )}
      </div>
      <section><h2 className="mb-3 font-bold">Companies</h2>
        <Table head={["Company", "Role", "Joined"]} rows={companies.map((c) => [<Link key={c.id} href={`/admin/companies/${c.id}`} className="font-semibold hover:underline">{c.name}</Link>, c.role, fmtDate(c.created_at)])} /></section>
      <section><h2 className="mb-3 font-bold">Active sessions</h2>
        <Table head={["Device", "IP", "Since", "Expires"]} rows={sessions.map((s) => [<span key="d" className="block max-w-md truncate">{s.user_agent ?? "—"}</span>, s.ip_address ?? "—", fmtDate(s.created_at), fmtDate(s.expires_at)])} empty="Not signed in anywhere." /></section>
    </div>
  );
}
