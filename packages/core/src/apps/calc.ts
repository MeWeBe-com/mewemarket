// Calculated fields: tiny arithmetic over other fields of the same record (no eval).
// Grammar: numbers, field keys, + - * / ( ), hours(start, end) for times, days(from, to) for dates.
// A key ending in "?" counts as 0 when empty; any other empty input leaves the result empty.

type Values = Record<string, unknown>;

const TOKEN = /\s*(\d+(?:\.\d+)?|[a-z_][a-z0-9_]*\??|[-+*/(),])/gy;

const bad = (expr: string): never => { throw new Error(`Bad calc expression "${expr}"`); };

function tokenize(expr: string) {
  const src = expr.trim(), out: string[] = [];
  TOKEN.lastIndex = 0;
  while (TOKEN.lastIndex < src.length) {
    const m = TOKEN.exec(src);
    if (!m) bad(expr);
    out.push(m![1]!);
  }
  return out;
}

const minutes = (t: unknown) => {
  const m = /^(\d{2}):(\d{2})/.exec(String(t ?? ""));
  return m ? Number(m[1]) * 60 + Number(m[2]) : null;
};
const dayNum = (d: unknown) => {
  const t = Date.parse(`${String(d ?? "").slice(0, 10)}T00:00:00Z`);
  return Number.isNaN(t) ? null : t / 86_400_000;
};

const FUNCS: Record<string, (a: unknown, b: unknown) => number | null> = {
  // Overnight shifts wrap past midnight.
  hours: (a, b) => { const s = minutes(a), e = minutes(b); return s === null || e === null ? null : ((e - s + 1440) % 1440) / 60; },
  // Inclusive day count, so a one-day leave is 1.
  days: (a, b) => { const s = dayNum(a), e = dayNum(b); return s === null || e === null || e < s ? null : e - s + 1; },
};

/** Field keys an expression reads, for validation. */
export function calcInputs(expr: string) {
  evalCalc(expr, {}); // throws on malformed expressions
  return tokenize(expr).filter((t) => /^[a-z_]/.test(t) && !Object.hasOwn(FUNCS, t)).map((t) => t.replace(/\?$/, ""));
}

/** Evaluates against a record; null when an input is missing or the maths is undefined. */
export function evalCalc(expr: string, data: Values): number | null {
  const toks = tokenize(expr);
  let i = 0;
  const peek = () => toks[i];
  const expect = (t: string) => { if (toks[i++] !== t) bad(expr); };
  const ident = () => { const t = toks[i++]; if (!t || !/^[a-z_]/.test(t)) bad(expr); return t!; };
  const num = (k: string) => {
    const opt = k.endsWith("?");
    const v = data[opt ? k.slice(0, -1) : k];
    if (v === undefined || v === null || v === "") return opt ? 0 : null;
    const n = Number(v);
    return Number.isFinite(n) ? n : null;
  };
  const atom = (): number | null => {
    const t = toks[i++];
    if (t === undefined) return bad(expr);
    if (t === "(") { const v = sum(); expect(")"); return v; }
    if (t === "-") { const v = atom(); return v === null ? null : -v; }
    if (/^\d/.test(t)) return Number(t);
    if (Object.hasOwn(FUNCS, t)) {
      expect("("); const a = ident(); expect(","); const b = ident(); expect(")");
      return FUNCS[t]!(data[a], data[b]);
    }
    if (!/^[a-z_]/.test(t)) return bad(expr);
    return num(t);
  };
  const product = (): number | null => {
    let v = atom();
    while (peek() === "*" || peek() === "/") {
      const op = toks[i++], r = atom();
      v = v === null || r === null ? null : op === "*" ? v * r : r === 0 ? null : v / r;
    }
    return v;
  };
  const sum = (): number | null => {
    let v = product();
    while (peek() === "+" || peek() === "-") {
      const op = toks[i++], r = product();
      v = v === null || r === null ? null : op === "+" ? v + r : v - r;
    }
    return v;
  };
  const v = sum();
  if (i !== toks.length) bad(expr);
  return v === null || !Number.isFinite(v) ? null : Math.round(v * 100) / 100;
}
