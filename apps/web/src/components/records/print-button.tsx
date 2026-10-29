"use client";
export function PrintButton() {
  return <button onClick={() => window.print()} className="rounded-lg border border-slate-300 px-3 py-1.5 text-sm print:hidden">Print / Save PDF</button>;
}
