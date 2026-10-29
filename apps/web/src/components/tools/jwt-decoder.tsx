"use client";
import { useState } from "react";
import { Alert } from "@/components/ui";
import { Output, TextArea } from "./shared";

const part = (s: string) => {
  let b = s.replace(/-/g, "+").replace(/_/g, "/"); while (b.length % 4) b += "=";
  const bin = atob(b); return JSON.parse(new TextDecoder().decode(Uint8Array.from(bin, (c) => c.charCodeAt(0))));
};
const SAMPLE = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkphbmUgRG9lIiwiaWF0IjoxNzAwMDAwMDAwLCJleHAiOjE5MDAwMDAwMDB9.signature";

export default function JwtDecoder() {
  const [tok, setTok] = useState(SAMPLE);
  let header: unknown, payload: Record<string, unknown> | null = null, err = "";
  try { const p = tok.trim().split("."); if (p.length < 2) throw 0; header = part(p[0]!); payload = part(p[1]!); } catch { err = "This does not look like a valid JWT."; }
  const exp = typeof payload?.exp === "number" ? new Date(payload.exp * 1000) : null;
  const iat = typeof payload?.iat === "number" ? new Date(payload.iat * 1000) : null;
  return (
    <div className="space-y-4">
      <label className="block space-y-1.5"><span className="text-sm font-medium">Token</span><TextArea className="min-h-28 break-all" value={tok} onChange={(e) => setTok(e.target.value)} /></label>
      {err ? <Alert>{err}</Alert> : (
        <>
          {exp && <Alert tone={exp.getTime() > Date.now() ? "success" : "error"}>{exp.getTime() > Date.now() ? "Not expired. Expires" : "Expired on"} {exp.toLocaleString()}</Alert>}
          {iat && <p className="text-sm text-[var(--muted)]">Issued {iat.toLocaleString()}</p>}
          <div className="grid gap-4 md:grid-cols-2">
            <Output label="Header" value={JSON.stringify(header, null, 2)} />
            <Output label="Payload" value={JSON.stringify(payload, null, 2)} />
          </div>
          <p className="text-xs text-[var(--muted)]">The signature is not checked. Never paste production secrets into any website.</p>
        </>
      )}
    </div>
  );
}
