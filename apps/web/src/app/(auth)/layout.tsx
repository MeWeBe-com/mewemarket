import Link from "next/link";
import { BrandPanel } from "@/components/site/brand-panel";
import { Logo } from "@/components/ui";

export default function AuthLayout({ children }: { children: React.ReactNode }) {
  return (
    <main className="grid min-h-dvh lg:grid-cols-[1fr_520px] xl:grid-cols-[1fr_600px]">
      <div className="flex flex-col px-4 py-8 sm:px-10">
        <Link href="/" aria-label="MeweMarket home"><Logo /></Link>
        <div className="mx-auto flex w-full max-w-sm flex-1 flex-col justify-center py-12">{children}</div>
        <p className="text-center text-xs text-[var(--muted)]">© {new Date().getFullYear()} MeweMarket · <Link href="/privacy" className="hover:underline">Privacy</Link> · <Link href="/terms" className="hover:underline">Terms</Link></p>
      </div>
      <BrandPanel />
    </main>
  );
}
