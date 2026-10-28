import type { Metadata } from "next";
import { LegalPage } from "@/components/site/legal-page";

export const metadata: Metadata = { title: "Privacy policy" };

export default function PrivacyPage() {
  return (
    <LegalPage title="Privacy policy" updated="28 October 2026" sections={[
      ["What we collect", ["Account details (name, email, password hash), workspace data you enter, billing details handled by Stripe (we never see full card numbers), and technical data such as IP address, browser and sign-in times for security."]],
      ["How we use it", ["To provide and secure the service, process payments, send account and service emails, provide support, and improve the product. We do not sell your personal data."]],
      ["AI processing", ["When you use AI features, the relevant content is sent to our AI providers (such as Anthropic or Google) to generate the result. They process it on our behalf and do not use it to train their models."]],
      ["Analytics and cookies", ["We use essential cookies to keep you signed in, and privacy-friendly analytics without tracking cookies. See our cookie policy."]],
      ["Sub-processors", ["Stripe (payments), our email delivery provider, our AI providers, and our hosting provider. Each is bound by a data processing agreement."]],
      ["Retention", ["We keep your data while your account is active. After you close a workspace we delete its data, and backups expire within 14 days."]],
      ["Your rights", ["You can access, correct, export or delete your data, and object to or restrict processing. Most of this is available in your account settings; for anything else, contact us."]],
      ["Contact", ["For privacy questions or requests, use mewemarket.com/contact and choose \"Something else\"."]],
    ]} />
  );
}
