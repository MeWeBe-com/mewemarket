import type { Metadata } from "next";
import { LegalPage } from "@/components/site/legal-page";

export const metadata: Metadata = { title: "Terms of service" };

export default function TermsPage() {
  return (
    <LegalPage title="Terms of service" updated="28 October 2026" sections={[
      ["1. Who we are", ["MeweMarket (\"we\", \"us\") provides an online workspace of business applications at mewemarket.com, as part of the MeWeBe Studio Network. By creating an account or using the service you agree to these terms."]],
      ["2. Your account", ["You must give accurate information and keep your login secure. You are responsible for activity in your account and workspace. Workspace owners and admins control who has access to their workspace and its data."]],
      ["3. Plans, trials and payment", ["Paid plans are billed in advance, monthly or yearly, through our payment provider Stripe. New workspaces receive a 14-day trial of the Business plan; when it ends the workspace moves to the Free plan unless you choose a paid plan. You can cancel at any time and keep access until the end of the paid period. Fees are non-refundable except where the law requires otherwise."]],
      ["4. Your data", ["You own the data you put into MeweMarket. We process it only to provide the service, as described in our Privacy Policy. You can export your data at any time, and we delete it after you close your workspace, subject to backup retention."]],
      ["5. Free tools", ["Free tools run in your browser and are provided as is, without any guarantee. Check results such as calculations and generated documents before relying on them."]],
      ["6. Third-party services", ["The free video meeting tool connects you to the public Jitsi Meet service, which has its own terms and privacy policy. We do not control or record those calls."]],
      ["7. Acceptable use", ["Do not use MeweMarket to break the law, send spam, infringe others' rights, attack or overload the service, or try to access other customers' data. We may suspend accounts that do."]],
      ["8. Availability and changes", ["We work to keep the service available and back up data nightly, but we cannot guarantee uninterrupted service. We may change features over time and will give notice of material changes to these terms."]],
      ["9. Liability", ["To the extent the law allows, the service is provided \"as is\" and our total liability for any claim is limited to the amount you paid us in the 12 months before the claim."]],
      ["10. Contact", ["Questions about these terms? Use our contact page at mewemarket.com/contact."]],
    ]} />
  );
}
