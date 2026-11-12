import { easyAppointmentsPublicUrl, getWorkspaceBySlug, hasHostedTenant, isInstalled } from "@mewe/core";
import type { Metadata } from "next";
import { notFound } from "next/navigation";

// A company's public booking page at mewemarket.com/{company}/book. The booking app runs on its own origin
// (book.mewemarket.com) and is shown here in a frame, so nothing in it can reach MeweMarket's session.

async function company(slug: string) {
  const ws = await getWorkspaceBySlug(slug).catch(() => null);
  if (!ws || !(await isInstalled(ws.id, "bookings")) || !(await hasHostedTenant(ws.id, "bookings"))) return null;
  return ws;
}

export async function generateMetadata({ params }: { params: Promise<{ slug: string }> }): Promise<Metadata> {
  const ws = await company((await params).slug);
  return ws ? { title: `Book an appointment with ${ws.name}`, description: `Choose a service and a time that suits you with ${ws.name}.` } : {};
}

export default async function BookingPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const ws = await company(slug);
  if (!ws) notFound();
  return (
    <iframe
      src={easyAppointmentsPublicUrl(slug)}
      title={`Book an appointment with ${ws.name}`}
      className="fixed inset-0 h-dvh w-full border-0"
      // The booking app needs scripts, forms and its own origin; it may not navigate this page.
      sandbox="allow-scripts allow-forms allow-same-origin allow-popups"
    />
  );
}
