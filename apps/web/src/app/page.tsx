const apps = ["CRM", "Invoices & Quotes", "Projects & Tasks", "Inventory & Orders", "Team & HR", "Bookings"];

export default function Home() {
  return (
    <main className="mx-auto max-w-5xl px-4 py-20">
      <p className="text-sm font-semibold text-accent">MeweMarket 2.0 · launching soon</p>
      <h1 className="mt-3 text-4xl font-bold tracking-tight sm:text-6xl">
        Every business app your company runs on — ready for your AI agent.
      </h1>
      <p className="mt-6 max-w-2xl text-lg text-[var(--muted)]">
        One workspace for CRM, invoicing, projects, inventory, HR, bookings and a growing catalogue of apps.
        Your team uses it in the browser; Claude, ChatGPT and Gemini use it through MCP.
      </p>
      <ul className="mt-12 grid grid-cols-2 gap-3 sm:grid-cols-3">
        {apps.map((a) => (
          <li key={a} className="rounded-xl border border-[var(--border)] p-4 font-medium">{a}</li>
        ))}
      </ul>
    </main>
  );
}
