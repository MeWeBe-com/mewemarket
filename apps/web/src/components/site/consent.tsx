"use client";
import Script from "next/script";
import { useEffect, useState } from "react";

// Google Analytics 4, only after the visitor accepts (UK PECR/GDPR): with no choice or "Reject", gtag.js is
// never requested and no _ga cookies are set. Mounted in the root layout so sign-up and checkout conversions
// (sign_up, begin_checkout, purchase) are measured too. Page views come from GA4's own history tracking.
const GA_ID = process.env.NEXT_PUBLIC_GA_ID ?? "G-5N8J3BD22R";
const COOKIE = "mewe_consent";
const OPEN_EVENT = "mewe:cookie-settings";

type Choice = "granted" | "denied" | null;

function readChoice(): Choice {
  const m = document.cookie.match(/(?:^|; )mewe_consent=(granted|denied)/);
  return (m?.[1] as Choice) ?? null;
}

function saveChoice(c: "granted" | "denied") {
  document.cookie = `${COOKIE}=${c}; Max-Age=${60 * 60 * 24 * 180}; Path=/; SameSite=Lax; Secure`;
}

function clearGaCookies() {
  for (const name of document.cookie.split("; ").map((c) => c.split("=")[0]!)) {
    if (name === "_ga" || name.startsWith("_ga_")) {
      for (const domain of ["", "; Domain=.mewemarket.com", "; Domain=mewemarket.com"]) {
        document.cookie = `${name}=; Max-Age=0; Path=/${domain}`;
      }
    }
  }
}

type Gtag = (...a: unknown[]) => void;
const gtag = (): Gtag | undefined => (window as unknown as { gtag?: Gtag }).gtag;

/** Sends a GA4 event only if analytics was accepted (gtag exists only then). */
export function track(name: string, params?: Record<string, unknown>) {
  if (typeof window === "undefined") return;
  gtag()?.("event", name, params ?? {});
}

/** Fires one event when it mounts (once per page per session), e.g. purchase on the billing success page. */
export function TrackEvent({ name, params }: { name: string; params?: Record<string, unknown> }) {
  useEffect(() => {
    const key = `mewe_ev_${name}_${location.pathname}${location.search}`;
    try { if (sessionStorage.getItem(key)) return; } catch { /* storage blocked */ }
    const fire = () => {
      if (!gtag()) return false;
      track(name, params);
      try { sessionStorage.setItem(key, "1"); } catch { /* storage blocked */ }
      return true;
    };
    if (!fire()) { const t = setTimeout(fire, 2000); return () => clearTimeout(t); }
  }, [name, params]);
  return null;
}

export function ConsentAndAnalytics() {
  const [choice, setChoice] = useState<Choice>(null);
  const [open, setOpen] = useState(false);

  useEffect(() => {
    const c = readChoice();
    setChoice(c);
    setOpen(c === null);
    const reopen = () => setOpen(true);
    // Forms marked data-ga-event (e.g. the Stripe checkout buttons) send that event on submit.
    const submit = (e: Event) => {
      const el = e.target as HTMLElement | null;
      const ev = el?.getAttribute?.("data-ga-event");
      if (ev) track(ev, { plan: el!.getAttribute("data-ga-plan") ?? undefined });
    };
    window.addEventListener(OPEN_EVENT, reopen);
    document.addEventListener("submit", submit, true);
    return () => { window.removeEventListener(OPEN_EVENT, reopen); document.removeEventListener("submit", submit, true); };
  }, []);

  function decide(c: "granted" | "denied") {
    saveChoice(c);
    if (c === "denied") {
      clearGaCookies();
      // gtag may already be on the page from an earlier "accept": stop it collecting further.
      const w = window as unknown as { gtag?: (...a: unknown[]) => void; [k: string]: unknown };
      w[`ga-disable-${GA_ID}`] = true;
      w.gtag?.("consent", "update", { analytics_storage: "denied" });
    }
    setChoice(c);
    setOpen(false);
  }

  return (
    <>
      {choice === "granted" && GA_ID && (
        <>
          <Script src={`https://www.googletagmanager.com/gtag/js?id=${GA_ID}`} strategy="afterInteractive" />
          <Script id="ga4" strategy="afterInteractive">{`
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            window.gtag = gtag;
            gtag('consent', 'default', { analytics_storage: 'granted', ad_storage: 'denied', ad_user_data: 'denied', ad_personalization: 'denied' });
            gtag('js', new Date());
            gtag('config', '${GA_ID}');
          `}</Script>
        </>
      )}
      {open && (
        <div role="dialog" aria-label="Cookie choices" className="fixed inset-x-0 bottom-0 z-50 p-4">
          <div className="mx-auto flex max-w-3xl flex-col gap-3 rounded-2xl border border-[var(--border)] bg-[var(--bg)] p-4 text-sm shadow-xl sm:flex-row sm:items-center">
            <p className="flex-1 text-[var(--muted)]">
              We'd like to use Google Analytics cookies to see which pages are useful. They're only set if you accept.{" "}
              <a href="/cookies" className="underline hover:text-[var(--fg)]">Cookie policy</a>
            </p>
            <div className="flex shrink-0 gap-2">
              <button onClick={() => decide("denied")} className="rounded-lg border border-[var(--border)] px-4 py-2 font-semibold hover:bg-black/5 dark:hover:bg-white/5">Reject</button>
              <button onClick={() => decide("granted")} className="rounded-lg bg-[#5b5bf6] px-4 py-2 font-semibold text-white hover:bg-[#4338ca]">Accept</button>
            </div>
          </div>
        </div>
      )}
    </>
  );
}

export function CookieSettingsLink() {
  return (
    <button type="button" onClick={() => window.dispatchEvent(new Event(OPEN_EVENT))} className="underline-offset-2 hover:text-[var(--fg)] hover:underline">
      Cookie settings
    </button>
  );
}
