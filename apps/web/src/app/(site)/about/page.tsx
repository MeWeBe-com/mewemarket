import type { Metadata } from "next";
import Link from "next/link";

export const metadata: Metadata = {
  title: "About",
  description: "MeweMarket brings the business apps small companies need into one simple subscription. Part of the MeWeBe Studio Network.",
};

export default function AboutPage() {
  return (
    <article className="mx-auto max-w-3xl px-4 py-14">
      <h1 className="text-4xl font-extrabold sm:text-5xl">About MeweMarket</h1>
      <div className="mt-8 space-y-5 text-lg leading-relaxed text-[var(--muted)]">
        <p>
          MeweMarket started as a marketplace of ready-to-use business apps: CRM, inventory, invoicing, HR, hospital and hotel
          systems, and more. Small companies liked having the tools they needed in one place, but each app stood alone,
          with its own login and its own copy of your data.
        </p>
        <p>
          The new MeweMarket fixes that. Every app now lives in one workspace with one login and one shared set of customers,
          products and people. You install the apps you need, and they work together from day one.
        </p>
        <p>
          Today the App Store has over 100 apps, from CRM and invoicing to clinics, hotels, schools, property and
          nonprofits, plus free online tools anyone can use without an account. We add new apps every month.
        </p>
      </div>
      <h2 className="mt-12 text-2xl font-bold">Part of the MeWeBe Studio Network</h2>
      <p className="mt-4 text-lg text-[var(--muted)]">
        MeweMarket is built by the <a href="https://mewebe.com" className="text-accent hover:underline">MeWeBe Studio Network</a>,
        a group of products for founders and small teams.
      </p>
      <div className="mt-12 flex flex-wrap gap-3">
        <Link href="/sign-up" className="rounded-lg bg-accent px-5 py-2.5 font-semibold text-white hover:bg-accent-strong">Start free</Link>
        <Link href="/contact" className="rounded-lg border border-[var(--border)] px-5 py-2.5 font-semibold hover:border-accent">Contact us</Link>
      </div>
    </article>
  );
}
