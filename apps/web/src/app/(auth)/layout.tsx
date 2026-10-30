import { Check } from "lucide-react";
import Link from "next/link";
import { AppIcon } from "@/components/app-icon";
import { Logo } from "@/components/ui";

const APPS = [["crm", "sales"], ["invoices", "finance"], ["projects", "business"], ["inventory", "logistics"], ["team-hr", "hr"], ["bookings", "customer-service"], ["clinic", "healthcare"], ["hotel", "hospitality"], ["campaigns", "marketing"]] as const;

export default function AuthLayout({ children }: { children: React.ReactNode }) {
  return (
    <main className="grid min-h-dvh lg:grid-cols-[1fr_520px] xl:grid-cols-[1fr_600px]">
      <div className="flex flex-col px-4 py-8 sm:px-10">
        <Link href="/" aria-label="MeweMarket home"><Logo /></Link>
        <div className="mx-auto flex w-full max-w-sm flex-1 flex-col justify-center py-12">{children}</div>
        <p className="text-center text-xs text-[var(--muted)]">© {new Date().getFullYear()} MeweMarket · <Link href="/privacy" className="hover:underline">Privacy</Link> · <Link href="/terms" className="hover:underline">Terms</Link></p>
      </div>
      <aside className="relative hidden overflow-hidden bg-[#0b0f24] p-12 text-white lg:flex lg:flex-col lg:justify-between">
        <div aria-hidden className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,#5b5bf666,transparent_55%),radial-gradient(ellipse_at_bottom_left,#ec489944,transparent_50%)]" />
        <div aria-hidden className="bg-grid absolute inset-0 opacity-20" />
        <div className="relative grid w-fit grid-cols-3 gap-x-4 gap-y-5">
          {APPS.map(([slug, cat], i) => (
            <AppIcon key={slug} slug={slug} category={cat} size="lg" className={i % 3 === 1 ? "translate-y-6" : ""} />
          ))}
        </div>
        <div className="relative">
          <h2 className="text-3xl font-extrabold leading-tight">Every app your business runs on, in one workspace.</h2>
          <ul className="mt-6 space-y-3 text-white/75">
            {["Over 100 apps on one subscription", "Free plan forever, 14-day Business trial", "Import your spreadsheets in minutes"].map((t) => (
              <li key={t} className="flex items-center gap-3"><span className="grid size-6 place-items-center rounded-full bg-white/10"><Check className="size-3.5 text-emerald-400" strokeWidth={3} /></span>{t}</li>
            ))}
          </ul>
        </div>
      </aside>
    </main>
  );
}
