"use client";
import dynamic from "next/dynamic";
import type { ComponentType } from "react";

const loading = () => <p className="py-10 text-center text-sm text-[var(--muted)]">Loading tool...</p>;
const d = (load: () => Promise<{ default: ComponentType }>) => dynamic(load, { ssr: false, loading });

export const TOOL_COMPONENTS: Record<string, ComponentType> = {
  "age-calculator": d(() => import("./age-calculator")),
  "base64": d(() => import("./base64")),
  "case-converter": d(() => import("./case-converter")),
  "color-converter": d(() => import("./color-converter")),
  "csv-to-json": d(() => import("./csv-to-json")),
  "date-difference": d(() => import("./date-difference")),
  "db-diagram": d(() => import("./db-diagram")),
  "hash-generator": d(() => import("./hash-generator")),
  "invoice-generator": d(() => import("./invoice-generator")),
  "json-formatter": d(() => import("./json-formatter")),
  "jwt-decoder": d(() => import("./jwt-decoder")),
  "loan-calculator": d(() => import("./loan-calculator")),
  "lorem-ipsum": d(() => import("./lorem-ipsum")),
  "markdown-preview": d(() => import("./markdown-preview")),
  "password-generator": d(() => import("./password-generator")),
  "percentage-calculator": d(() => import("./percentage-calculator")),
  "pomodoro-timer": d(() => import("./pomodoro-timer")),
  "profit-margin-calculator": d(() => import("./profit-margin-calculator")),
  "qr-code-generator": d(() => import("./qr-code-generator")),
  "regex-tester": d(() => import("./regex-tester")),
  "slug-generator": d(() => import("./slug-generator")),
  "text-diff": d(() => import("./text-diff")),
  "timestamp-converter": d(() => import("./timestamp-converter")),
  "timezone-converter": d(() => import("./timezone-converter")),
  "unit-converter": d(() => import("./unit-converter")),
  "url-encoder": d(() => import("./url-encoder")),
  "uuid-generator": d(() => import("./uuid-generator")),
  "vat-calculator": d(() => import("./vat-calculator")),
  "video-meeting": d(() => import("./video-meeting")),
  "whiteboard": d(() => import("./whiteboard")),
  "word-counter": d(() => import("./word-counter")),
};
