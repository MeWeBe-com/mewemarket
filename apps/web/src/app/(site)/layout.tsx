import { SiteFooter } from "@/components/site/footer";
import { SiteHeader } from "@/components/site/header";
import { ConsentAndAnalytics } from "@/components/site/consent";

export default function SiteLayout({ children }: { children: React.ReactNode }) {
  return (
    <>
      <SiteHeader />
      <main>{children}</main>
      <SiteFooter />
      <ConsentAndAnalytics />
    </>
  );
}
