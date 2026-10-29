"use client";
import { TOOL_COMPONENTS } from "./registry";

export default function ToolMount({ slug }: { slug: string }) {
  const C = TOOL_COMPONENTS[slug];
  return C ? <C /> : <p className="text-sm text-[var(--muted)]">This tool is not available yet.</p>;
}
