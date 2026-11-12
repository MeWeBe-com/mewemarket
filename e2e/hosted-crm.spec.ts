import { expect, test } from "@playwright/test";

// The hosted CRM (Twenty) shown inside the workspace, signed in. Needs a Twenty server configured for the
// app under test (TWENTY_* in .env) and the seeded "acme" owner; skipped otherwise. Locally, the app and
// Twenty must share a site (e.g. mewemarket.test and *.crm.mewemarket.test) for the sign-in cookie to work.
const EMAIL = process.env.E2E_EMAIL ?? "owner@example.com";
const PASSWORD = process.env.E2E_PASSWORD ?? "supersecret123";

test.skip(!process.env.E2E_HOSTED_CRM, "set E2E_HOSTED_CRM=1 when a Twenty server is configured");

test("the CRM opens inside the workspace, already signed in", async ({ page }) => {
  await page.goto("/sign-in");
  await page.getByLabel("Email").fill(EMAIL);
  await page.locator("input[name=password]").fill(PASSWORD);
  await page.getByRole("button", { name: "Sign in", exact: true }).click();
  await page.waitForURL(/\/acme(\/|$)/);

  // Add it from the App Store the first time; afterwards just open it.
  await page.goto("/acme/apps?app=crm");
  const add = page.locator("#crm").getByRole("button", { name: "Add app" });
  if (await add.count()) {
    await add.click();
    await page.waitForURL(/\/acme\/crm$/, { timeout: 120_000 });
  } else {
    await page.goto("/acme/crm");
  }

  // Twenty's own navigation, inside the frame: the person landed in Acme's CRM without a second sign-in.
  const crm = page.frameLocator('iframe[title="CRM"]');
  await expect(crm.getByText("Opportunities").first()).toBeVisible({ timeout: 90_000 });
  await expect(page.getByRole("link", { name: /Powered by Twenty/ })).toHaveAttribute("href", /github\.com\/twentyhq\/twenty/);
  expect(new URL(page.url()).pathname).toBe("/acme/crm");

  // "Open in new tab" lands in the same CRM, signed in.
  const [tab] = await Promise.all([page.waitForEvent("popup"), page.getByRole("link", { name: /Open in new tab/ }).click()]);
  await expect(tab.getByText("Opportunities").first()).toBeVisible({ timeout: 90_000 });
  expect(new URL(tab.url()).hostname).toMatch(/^acme\./);
});
