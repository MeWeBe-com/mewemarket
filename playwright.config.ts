import { defineConfig } from "@playwright/test";

// Runs against a dev or production server already listening on E2E_URL.
export default defineConfig({
  testDir: "./e2e",
  timeout: 120_000,
  fullyParallel: false,
  use: { baseURL: process.env.E2E_URL ?? "http://localhost:3000", channel: process.env.E2E_CHANNEL ?? "chrome", trace: "retain-on-failure" },
});
