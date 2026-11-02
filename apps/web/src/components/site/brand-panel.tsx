import { Check } from "lucide-react";
import { AppIcon } from "@/components/app-icon";

const APPS = [["crm", "sales"], ["invoices", "finance"], ["projects", "business"], ["inventory", "logistics"], ["team-hr", "hr"], ["bookings", "customer-service"], ["clinic", "healthcare"], ["hotel", "hospitality"], ["campaigns", "marketing"]] as const;

/** Dark marketing panel beside the sign-in, sign-up and onboarding forms. */
export function BrandPanel({ title = "Every app your business runs on, in one workspace.", points = ["Over 100 apps on one subscription", "Free plan forever, 14-day Business trial", "Import your spreadsheets in minutes"] }: { title?: string; points?: string[] }) {
  return (
    <aside className="relative hidden overflow-hidden bg-[#0b0f24] p-12 text-white lg:flex lg:flex-col lg:justify-between">
      <div aria-hidden className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,#5b5bf666,transparent_55%),radial-gradient(ellipse_at_bottom_left,#ec489944,transparent_50%)]" />
      <div aria-hidden className="bg-grid absolute inset-0 opacity-20" />
      <div className="relative grid w-fit grid-cols-3 gap-x-4 gap-y-5">
        {APPS.map(([slug, cat], i) => <AppIcon key={slug} slug={slug} category={cat} size="lg" className={i % 3 === 1 ? "translate-y-6" : ""} />)}
      </div>
      <div className="relative">
        <h2 className="text-3xl font-extrabold leading-tight">{title}</h2>
        <ul className="mt-6 space-y-3 text-white/75">
          {points.map((t) => (
            <li key={t} className="flex items-center gap-3"><span className="grid size-6 place-items-center rounded-full bg-white/10"><Check className="size-3.5 text-emerald-400" strokeWidth={3} /></span>{t}</li>
          ))}
        </ul>
      </div>
    </aside>
  );
}
