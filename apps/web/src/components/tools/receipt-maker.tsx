"use client";
import { useState } from "react";
import { Plus, Printer, Trash2 } from "lucide-react";
import { Button, Field, Input } from "@/components/ui";
import { Select, TextArea, num } from "./shared";

type Line = { id: number; desc: string; qty: string; price: string };
let nextId = 2;

export default function ReceiptMaker() {
  const [business, setBusiness] = useState("Your business\n1 Main Street\nCity");
  const [customer, setCustomer] = useState("Customer name");
  const [number, setNumber] = useState("R-001");
  const [date, setDate] = useState("");
  const [method, setMethod] = useState("Cash");
  const [currency, setCurrency] = useState("USD");
  const [taxRate, setTaxRate] = useState("0");
  const [notes, setNotes] = useState("Thank you for your payment.");
  const [lines, setLines] = useState<Line[]>([{ id: 1, desc: "Item", qty: "1", price: "25" }]);

  const money = (n: number) => { try { return n.toLocaleString(undefined, { style: "currency", currency: currency || "USD" }); } catch { return `${currency} ${n.toFixed(2)}`; } };
  const subtotal = lines.reduce((s, l) => s + num(l.qty) * num(l.price), 0);
  const tax = subtotal * num(taxRate) / 100;
  const total = subtotal + tax;
  const upd = (id: number, k: keyof Line, v: string) => setLines((ls) => ls.map((l) => (l.id === id ? { ...l, [k]: v } : l)));
  const [bizName, ...bizRest] = business.split("\n");

  return (
    <div className="receipt-root space-y-6">
      <style>{`@media print { body * { visibility: hidden !important; } .receipt-print, .receipt-print * { visibility: visible !important; } .receipt-print { position: absolute; left: 0; top: 0; width: 100%; color: #000 !important; background: #fff !important; padding: 24px; border: 0 !important; } }`}</style>
      <div className="grid gap-6 lg:grid-cols-2 print:block">
        <div className="space-y-4 print:hidden">
          <Field label="Business name and address" hint="First line is the business name."><TextArea className="min-h-24 font-sans" value={business} onChange={(e) => setBusiness(e.target.value)} /></Field>
          <div className="grid gap-4 sm:grid-cols-2">
            <Field label="Customer"><Input value={customer} onChange={(e) => setCustomer(e.target.value)} /></Field>
            <Field label="Receipt number"><Input value={number} onChange={(e) => setNumber(e.target.value)} /></Field>
            <Field label="Date"><Input type="date" value={date} onChange={(e) => setDate(e.target.value)} /></Field>
            <Field label="Payment method">
              <Select value={method} onChange={(e) => setMethod(e.target.value)}>
                {["Cash", "Card", "Bank transfer", "Cheque", "Mobile payment", "PayPal", "Other"].map((m) => <option key={m}>{m}</option>)}
              </Select>
            </Field>
            <Field label="Currency code"><Input value={currency} maxLength={3} onChange={(e) => setCurrency(e.target.value.toUpperCase())} /></Field>
            <Field label="Tax rate (%)"><Input type="number" min={0} step="0.01" value={taxRate} onChange={(e) => setTaxRate(e.target.value)} /></Field>
          </div>
          <div className="space-y-3">
            <span className="text-sm font-medium">Items</span>
            {lines.map((l, i) => (
              <div key={l.id} className="grid grid-cols-[1fr_auto] gap-2 rounded-lg border border-[var(--border)] p-2 sm:grid-cols-[1fr_5rem_7rem_auto]">
                <Input className="col-span-2 sm:col-span-1" aria-label={`Item ${i + 1} description`} placeholder="Description" value={l.desc} onChange={(e) => upd(l.id, "desc", e.target.value)} />
                <div className="col-span-2 grid grid-cols-2 gap-2 sm:col-span-2">
                  <Input aria-label={`Item ${i + 1} quantity`} type="number" min="0" placeholder="Qty" value={l.qty} onChange={(e) => upd(l.id, "qty", e.target.value)} />
                  <Input aria-label={`Item ${i + 1} price`} type="number" min="0" step="0.01" placeholder="Price" value={l.price} onChange={(e) => upd(l.id, "price", e.target.value)} />
                </div>
                <Button type="button" variant="ghost" className="col-span-2 h-8 px-2 sm:col-span-1 sm:h-10" aria-label={`Remove item ${i + 1}`} onClick={() => setLines((ls) => ls.filter((x) => x.id !== l.id))}><Trash2 className="size-4" aria-hidden /></Button>
              </div>
            ))}
            <Button type="button" variant="secondary" onClick={() => setLines((ls) => [...ls, { id: nextId++, desc: "", qty: "1", price: "0" }])}><Plus className="size-4" aria-hidden /> Add item</Button>
          </div>
          <Field label="Notes"><TextArea className="min-h-20 font-sans" value={notes} onChange={(e) => setNotes(e.target.value)} /></Field>
        </div>

        <div className="space-y-3">
          <div className="flex justify-end print:hidden"><Button type="button" onClick={() => window.print()}><Printer className="size-4" aria-hidden /> Print / save PDF</Button></div>
          <div className="receipt-print space-y-4 rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] p-5 text-sm">
            <div className="text-center">
              <div className="text-lg font-bold break-words">{bizName}</div>
              {bizRest.filter(Boolean).map((r, i) => <div key={i} className="text-[var(--muted)] break-words">{r}</div>)}
              <div className="mt-3 text-xs font-semibold tracking-widest uppercase">Payment receipt</div>
            </div>
            <dl className="grid grid-cols-2 gap-x-3 gap-y-1 border-y border-dashed border-[var(--border)] py-3">
              <dt className="text-[var(--muted)]">Receipt no.</dt><dd className="text-right break-words">{number}</dd>
              <dt className="text-[var(--muted)]">Date</dt><dd className="text-right">{date || "-"}</dd>
              <dt className="text-[var(--muted)]">Customer</dt><dd className="text-right break-words">{customer}</dd>
              <dt className="text-[var(--muted)]">Paid by</dt><dd className="text-right">{method}</dd>
            </dl>
            <ul className="space-y-2">
              {lines.map((l) => (
                <li key={l.id} className="flex justify-between gap-3">
                  <span className="min-w-0 break-words">{l.desc || "Item"} <span className="text-[var(--muted)]">× {num(l.qty)}</span></span>
                  <span className="shrink-0">{money(num(l.qty) * num(l.price))}</span>
                </li>
              ))}
            </ul>
            <dl className="space-y-1 border-t border-dashed border-[var(--border)] pt-3">
              <div className="flex justify-between"><dt>Subtotal</dt><dd>{money(subtotal)}</dd></div>
              {num(taxRate) > 0 && <div className="flex justify-between"><dt>Tax ({num(taxRate)}%)</dt><dd>{money(tax)}</dd></div>}
              <div className="flex justify-between text-base font-bold"><dt>Total paid</dt><dd>{money(total)}</dd></div>
            </dl>
            {notes && <p className="whitespace-pre-wrap break-words text-center text-[var(--muted)]">{notes}</p>}
          </div>
        </div>
      </div>
    </div>
  );
}
