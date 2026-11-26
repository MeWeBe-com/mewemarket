import { canonical } from "@/lib/canonical";
import type { Metadata } from "next";
import { LegalPage } from "@/components/site/legal-page";

export const metadata: Metadata = { alternates: canonical("/cookies"), title: "Cookie policy" };

export default function CookiesPage() {
  return (
    <LegalPage title="Cookie policy" updated="26 November 2026" sections={[
      ["Essential cookies", ["We use a small number of essential cookies to keep you signed in, protect forms against misuse, and remember your theme choice. The service cannot work without them, so they don't need consent."]],
      ["Analytics (only with your consent)", ["If you accept analytics in the cookie banner, we load Google Analytics 4 on our public pages to see which pages are used. It sets the _ga and _ga_* cookies (kept up to 2 years). IP addresses are not stored by Google Analytics 4. If you decline, or make no choice, Google Analytics is not loaded and sets no cookies. It never runs inside your workspace.", "You can change your choice at any time with “Cookie settings” at the bottom of every page."]],
      ["Advertising and affiliate links", ["Our free tools and guides may show clearly labelled sponsored links. These do not set cookies unless you accept them in the cookie banner."]],
      ["Managing cookies", ["You can delete or block cookies in your browser settings. Blocking essential cookies will sign you out."]],
    ]} />
  );
}
