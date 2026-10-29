"use client";
import { useState } from "react";
import { Plus, Printer, Trash2 } from "lucide-react";
import { Button, Field, Input } from "@/components/ui";
import { TextArea, num } from "./shared";

type Line = { id: number; desc: string; qty: string; price: string };
let nextId = 2;

export default function InvoiceGenerator() {
  const today = new Date().toISOString().slice(0, 10);
  const [from, setFrom] = useState("Your company\n1 Main Street\nCity");
  const [to, setTo] = useState("Customer name\nAddress");
  const [number, setNumber] = useState("INV-001");
  const [date, setDate] = useState(today);
  const [due, setDue] = useState("");
  const [currency, setCurrency] = useState("USD");
  const [taxRate, setTaxRate] = useState("10");
  const [discount, setDiscount] = useState("0");
  const [notes, setNotes] = useState("Thank you for your business.");
  const [lines, setLines] = useState<Line[]>([{ id: 1, desc: "Design work", qty: "1", price: "500" }]);

  const money = (n: number) => { try { return n.toLocaleString(undefined, { style: "currency", currency: currency || "USD" }); } catch { return `${currency} ${n.toFixed(2)}`; } };
  const subtotal = lines.reduce((s, l) => s + num(l.qty) * num(l.price), 0);
  const disc = Math.min(num(discount), subtotal);
  const tax = (subtotal - disc) * num(taxRate) / 100;
  const total = subtotal - disc + tax;
  const upd = (id: number, k: keyof Line, v: string) => setLines((ls) => ls.map((l) => (l.id === id ? { ...l, [k]: v } : l)));

  return (
    <div className="invoice-root">
      <style>{`@media print { body * { visibility: hidden !important; } .invoice-print, .invoice-print * { visibility: visible !important; } .invoice-print { position: absolute; left: 0; top: 0; width: 100%; color: #000; background: #fff; padding: 24px; } .invoice-print input, .invoice-print textarea { border: 0 !important; padding: 0 !important; resize: none; color: #000; } }`}</style>
      <div className="mb-4 flex justify-end print:hidden"><Button type="button" onClick={() => window.print()}><Printer className="size-4" aria-hidden /> Print or save PDF</Button></div>
      <div className="invoice-print space-y-6">
        <div className="flex flex-wrap items-start justify-between gap-4">
          <h2 className="text-3xl font-bold">Invoice</h2>
          <div className="grid w-full gap-3 sm:w-auto sm:grid-cols-2">
            <Field label="Invoice number"><Input value={number} onChange={(e) => setNumber(e.target.value)} /></Field>
            <Field label="Currency code"><Input value={currency} maxLength={3} onChange={(e) => setCurrency(e.target.value.toUpperCase())} /></Field>
            <Field label="Date"><Input type="date" value={date} onChange={(e) => setDate(e.target.value)} /></Field>
            <Field label="Due date"><Input type="date" value={due} onChange={(e) => setDue(e.target.value)} /></Field>
          </div>
        </div>
        <div className="grid gap-4 sm:grid-cols-2">
          <Field label="From"><TextArea className="min-h-24 font-sans" value={from} onChange={(e) => setFrom(e.target.value)} /></Field>
          <Field label="Bill to"><TextArea className="min-h-24 font-sans" value={to} onChange={(e) => setTo(e.target.value)} /></Field>
        </div>
        <div className="overflow-x-auto">
          <table className="w-full min-w-[560px] text-sm">
            <thead><tr className="border-b border-[var(--border)] text-left"><th className="py-2">Description</th><th className="w-20">Qty</th><th className="w-32">Price</th><th className="w-32 text-right">Amount</th><th className="w-10 print:hidden"><span className="sr-only">Remove</span></th></tr></thead>
            <tbody>
              {lines.map((l, i) => (
                <tr key={l.id} className="border-b border-[var(--border)]">
                  <td className="py-2 pr-2"><Input aria-label={`Item ${i + 1} description`} value={l.desc} onChange={(e) => upd(l.id, "desc", e.target.value)} /></td>
                  <td className="pr-2"><Input aria-label={`Item ${i + 1} quantity`} type="number" min="0" value={l.qty} onChange={(e) => upd(l.id, "qty", e.target.value)} /></td>
                  <td className="pr-2"><Input aria-label={`Item ${i + 1} price`} type="number" min="0" step="0.01" value={l.price} onChange={(e) => upd(l.id, "price", e.target.value)} /></td>
                  <td className="text-right font-medium">{money(num(l.qty) * num(l.price))}</td>
                  <td className="text-right print:hidden"><Button type="button" variant="ghost" className="h-8 px-2" aria-label={`Remove item ${i + 1}`} onClick={() => setLines((ls) => ls.filter((x) => x.id !== l.id))}><Trash2 className="size-4" aria-hidden /></Button></td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
        <Button type="button" variant="secondary" className="print:hidden" onClick={() => setLines((ls) => [...ls, { id: nextId++, desc: "", qty: "1", price: "0" }])}><Plus className="size-4" aria-hidden /> Add line</Button>
        <div className="flex flex-wrap justify-between gap-6">
          <div className="w-full max-w-sm"><Field label="Notes"><TextArea className="min-h-20 font-sans" value={notes} onChange={(e) => setNotes(e.target.value)} /></Field></div>
          <dl className="w-full max-w-xs space-y-2 text-sm">
            <div className="flex justify-between"><dt>Subtotal</dt><dd>{money(subtotal)}</dd></div>
            <div className="flex items-center justify-between gap-2"><dt><label htmlFor="inv-disc">Discount</label></dt><dd><Input id="inv-disc" type="number" min="0" className="h-8 w-28 text-right" value={discount} onChange={(e) => setDiscount(e.target.value)} /></dd></div>
            <div className="flex items-center justify-between gap-2"><dt><label htmlFor="inv-tax">Tax rate (%)</label></dt><dd><Input id="inv-tax" type="number" min="0" className="h-8 w-28 text-right" value={taxRate} onChange={(e) => setTaxRate(e.target.value)} /></dd></div>
            <div className="flex justify-between"><dt>Tax</dt><dd>{money(tax)}</dd></div>
            <div className="flex justify-between border-t border-[var(--border)] pt-2 text-lg font-bold"><dt>Total</dt><dd>{money(total)}</dd></div>
          </dl>
        </div>
      </div>
    </div>
  );
}
