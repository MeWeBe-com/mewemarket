"use client";
import { useState } from "react";
import { Field, Input } from "@/components/ui";
import { Output, Select, fmt, num } from "./shared";

const UNITS: Record<string, Record<string, number>> = {
  Length: { Millimetres: 0.001, Centimetres: 0.01, Metres: 1, Kilometres: 1000, Inches: 0.0254, Feet: 0.3048, Yards: 0.9144, Miles: 1609.344 },
  Weight: { Grams: 1, Kilograms: 1000, Tonnes: 1e6, Ounces: 28.349523125, Pounds: 453.59237, Stones: 6350.29318 },
  Volume: { Millilitres: 0.001, Litres: 1, "Cubic metres": 1000, Teaspoons: 0.00492892, Tablespoons: 0.0147868, Cups: 0.24, "US gallons": 3.785411784, "UK gallons": 4.54609 },
  Area: { "Square metres": 1, "Square kilometres": 1e6, Hectares: 1e4, "Square feet": 0.09290304, Acres: 4046.8564224, "Square miles": 2589988.110336 },
  Speed: { "Metres per second": 1, "Kilometres per hour": 1 / 3.6, "Miles per hour": 0.44704, Knots: 0.514444 },
  Temperature: { Celsius: 1, Fahrenheit: 1, Kelvin: 1 },
  Data: { Bytes: 1, Kilobytes: 1e3, Megabytes: 1e6, Gigabytes: 1e9, Terabytes: 1e12, Kibibytes: 1024, Mebibytes: 1048576, Gibibytes: 1073741824 },
};
const toC = (v: number, u: string) => (u === "Fahrenheit" ? (v - 32) * 5 / 9 : u === "Kelvin" ? v - 273.15 : v);
const fromC = (v: number, u: string) => (u === "Fahrenheit" ? v * 9 / 5 + 32 : u === "Kelvin" ? v + 273.15 : v);

export default function UnitConverter() {
  const [kind, setKind] = useState("Length");
  const table = UNITS[kind] ?? {};
  const names = Object.keys(table);
  const [from, setFrom] = useState("Metres");
  const [to, setTo] = useState("Feet");
  const [val, setVal] = useState("1");
  const f = names.includes(from) ? from : names[0] ?? "", t = names.includes(to) ? to : names[1] ?? "";
  const v = num(val);
  const res = kind === "Temperature" ? fromC(toC(v, f), t) : (v * (table[f] ?? 1)) / (table[t] ?? 1);
  return (
    <div className="space-y-4">
      <label className="block max-w-xs space-y-1.5"><span className="text-sm font-medium">Measure</span><Select value={kind} onChange={(e) => { const k = e.target.value; setKind(k); const n = Object.keys(UNITS[k] ?? {}); setFrom(n[0] ?? ""); setTo(n[1] ?? ""); }}>{Object.keys(UNITS).map((k) => <option key={k}>{k}</option>)}</Select></label>
      <div className="grid gap-4 sm:grid-cols-3">
        <Field label="Value"><Input type="number" value={val} onChange={(e) => setVal(e.target.value)} /></Field>
        <label className="block space-y-1.5"><span className="text-sm font-medium">From</span><Select value={f} onChange={(e) => setFrom(e.target.value)}>{names.map((n) => <option key={n}>{n}</option>)}</Select></label>
        <label className="block space-y-1.5"><span className="text-sm font-medium">To</span><Select value={t} onChange={(e) => setTo(e.target.value)}>{names.map((n) => <option key={n}>{n}</option>)}</Select></label>
      </div>
      <Output label="Result" value={`${fmt(res, 6)} ${t.toLowerCase()}`} mono={false} />
    </div>
  );
}
