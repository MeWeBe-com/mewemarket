import type { Metadata } from "next";
import { ContactForm } from "./form";

export const metadata: Metadata = { title: "Contact & support", description: "Get help with your MeweMarket workspace, ask about plans, or talk to us about listing your app." };

export default function ContactPage() {
  return (
    <div className="mx-auto grid max-w-5xl gap-12 px-4 py-14 lg:grid-cols-[1fr_1.4fr]">
      <div>
        <h1 className="text-4xl font-bold tracking-tight">Contact & support</h1>
        <p className="mt-4 text-[var(--muted)]">Questions about plans, help with your workspace, or want to list your app in our catalogue? Send us a message.</p>
        <dl className="mt-8 space-y-4 text-sm">
          <div><dt className="font-semibold">Response time</dt><dd className="text-[var(--muted)]">Within one working day. Scale plan customers get priority.</dd></div>
          <div><dt className="font-semibold">Already a customer?</dt><dd className="text-[var(--muted)]">Sign in and include your workspace name so we can help faster.</dd></div>
        </dl>
      </div>
      <div className="rounded-xl border border-[var(--border)] p-6"><ContactForm /></div>
    </div>
  );
}
