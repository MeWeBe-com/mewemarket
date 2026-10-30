import { defineConfig } from "@playwright/test";

// Runs against a dev or production server already listening on E2E_URL.
export default defineConfig({
  testDir: "./e2e",
  timeout: 120_000,
  fullyParallel: false,
  // Tracing injects a DOM snapshotter that can trip React hydration checks, so only trace the retry of a failed test.
  retries: 1,
  workers: 1, // tests share the "acme" workspace, so files run one at a time
  use: { baseURL: process.env.E2E_URL ?? "http://localhost:3000", channel: process.env.E2E_CHANNEL ?? "chrome", trace: "on-first-retry" },
});
