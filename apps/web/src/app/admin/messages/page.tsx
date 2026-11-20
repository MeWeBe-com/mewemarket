import { sql } from "@mewe/db";
import { fmtDate } from "@/lib/admin";
import { setMessageStatus } from "../actions";
import { Table } from "../table";

export default async function AdminMessages({ searchParams }: { searchParams: Promise<{ status?: string }> }) {
  const { status = "new" } = await searchParams;
  const rows = await sql<{ id: string; name: string; email: string; topic: string; message: string; status: string; created_at: Date }[]>`
    select id, name, email, topic, message, status, created_at from contact_messages
    where ${status} = 'all' or status = ${status} order by created_at desc limit 200`;
  return (
    <div>
      <h1 className="mb-4 text-3xl font-extrabold">Contact messages</h1>
      <p className="mb-4 flex gap-3 text-sm">{["new", "replied", "closed", "spam", "all"].map((s) =>
        <a key={s} href={`?status=${s}`} className={s === status ? "font-bold underline" : "text-[var(--muted)] hover:underline"}>{s}</a>)}</p>
      <Table head={["From", "Topic", "Message", "Received", "Mark as"]} rows={rows.map((m) => [
        <span key="f"><b>{m.name}</b><br /><a href={`mailto:${m.email}`} className="text-[var(--muted)] hover:underline">{m.email}</a></span>,
        m.topic, <p key="m" className="max-w-md whitespace-pre-wrap">{m.message}</p>, fmtDate(m.created_at),
        <span key="a" className="flex gap-2">{["replied", "closed", "spam"].filter((s) => s !== m.status).map((s) =>
          <form key={s} action={setMessageStatus.bind(null, m.id, s)}><button className="text-xs underline">{s}</button></form>)}</span>,
      ])} />
    </div>
  );
}
