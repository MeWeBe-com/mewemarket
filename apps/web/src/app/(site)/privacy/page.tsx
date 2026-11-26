import { canonical } from "@/lib/canonical";
import type { Metadata } from "next";
import { LegalPage } from "@/components/site/legal-page";

export const metadata: Metadata = { alternates: canonical("/privacy"), title: "Privacy policy" };

export default function PrivacyPage() {
  return (
    <LegalPage title="Privacy policy" updated="26 November 2026" sections={[
      ["What we collect", ["Account details (name, email, password hash), workspace data you enter, billing details handled by Stripe (we never see full card numbers), and technical data such as IP address, browser and sign-in times for security."]],
      ["How we use it", ["To provide and secure the service, process payments, send account and service emails, provide support, and improve the product. We do not sell your personal data."]],
      ["Analytics and cookies", ["We use essential cookies to keep you signed in. With your consent only, we use Google Analytics 4 on our public pages to measure usage; Google acts as our processor. See our cookie policy to change your choice."]],
      ["Sub-processors", ["Stripe (payments), our email delivery provider, and our hosting provider. Each is bound by a data processing agreement."]],
      ["Retention", ["We keep your data while your account is active. After you close a workspace we delete its data, and backups expire within 14 days."]],
      ["Your rights", ["You can access, correct, export or delete your data, and object to or restrict processing. Most of this is available in your account settings; for anything else, contact us."]],
      ["Contact", ["For privacy questions or requests, use mewemarket.com/contact and choose \"Something else\"."]],
    ]} />
  );
}
