"use client";
import { useEffect, useState } from "react";
import { Output, TextArea } from "./shared";

const ALGS = ["SHA-1", "SHA-256", "SHA-384", "SHA-512"] as const;

export default function HashGenerator() {
  const [text, setText] = useState("hello");
  const [hashes, setHashes] = useState<Record<string, string>>({});
  useEffect(() => {
    let live = true;
    const data = new TextEncoder().encode(text);
    Promise.all(ALGS.map(async (a) => [a, Array.from(new Uint8Array(await crypto.subtle.digest(a, data)), (b) => b.toString(16).padStart(2, "0")).join("")] as const))
      .then((r) => live && setHashes(Object.fromEntries(r)))
      .catch(() => live && setHashes({}));
    return () => { live = false; };
  }, [text]);
  return (
    <div className="space-y-4">
      <label className="block space-y-1.5"><span className="text-sm font-medium">Text</span><TextArea className="min-h-28" value={text} onChange={(e) => setText(e.target.value)} /></label>
      {typeof crypto !== "undefined" && !crypto.subtle && <p className="text-sm text-red-600">Hashing needs a secure (https) page.</p>}
      {ALGS.map((a) => <Output key={a} label={a} value={hashes[a] ?? ""} />)}
    </div>
  );
}
