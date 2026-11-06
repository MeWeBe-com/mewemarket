import Link from "next/link";
import { BUTTON_BASE, BUTTON_PRIMARY, BUTTON_SECONDARY, Logo } from "@/components/ui";

export const metadata = { title: "Page not found" };

export default function NotFound() {
  return (
    <main className="bg-grid grid min-h-dvh place-items-center px-4 text-center">
      <div>
        <Link href="/" aria-label="MeweMarket home" className="inline-block"><Logo /></Link>
        <p className="mt-10 font-display text-7xl font-extrabold text-gradient">404</p>
        <h1 className="mt-3 text-2xl font-bold">We couldn't find that page</h1>
        <p className="mx-auto mt-2 max-w-md text-[var(--muted)]">It may have moved when we rebuilt MeweMarket. Try the app catalogue or head back home.</p>
        <div className="mt-8 flex flex-wrap justify-center gap-3">
          <Link href="/" className={`${BUTTON_BASE} ${BUTTON_PRIMARY} h-11 px-6`}>Go home</Link>
          <Link href="/apps" className={`${BUTTON_BASE} ${BUTTON_SECONDARY} h-11 px-6`}>Browse apps</Link>
        </div>
      </div>
    </main>
  );
}
