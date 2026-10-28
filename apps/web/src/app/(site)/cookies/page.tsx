import type { Metadata } from "next";
import { LegalPage } from "@/components/site/legal-page";

export const metadata: Metadata = { title: "Cookie policy" };

export default function CookiesPage() {
  return (
    <LegalPage title="Cookie policy" updated="28 October 2026" sections={[
      ["Essential cookies", ["We use a small number of essential cookies to keep you signed in, protect forms against misuse, and remember your theme choice. The service cannot work without them, so they don't need consent."]],
      ["Analytics", ["We measure site usage with self-hosted, cookie-free analytics. No personal profile is built and no data is shared with advertisers."]],
      ["Advertising and affiliate links", ["Our free tools and guides may show clearly labelled sponsored links. These do not set cookies unless you accept them in the cookie banner."]],
      ["Managing cookies", ["You can delete or block cookies in your browser settings. Blocking essential cookies will sign you out."]],
    ]} />
  );
}
