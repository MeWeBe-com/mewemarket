import { expect, test } from "@playwright/test";

const EMAIL = process.env.E2E_EMAIL ?? "owner@example.com";
const PASSWORD = process.env.E2E_PASSWORD ?? "supersecret123";

test("add the AI Assistant in one click and set it up", async ({ page }) => {
  const errors: string[] = [];
  page.on("pageerror", (e) => errors.push(e.message));

  await page.goto("/sign-in");
  await page.getByLabel("Email").fill(EMAIL);
  await page.locator("input[name=password]").fill(PASSWORD);
  await page.getByRole("button", { name: "Sign in", exact: true }).click();
  await page.waitForURL(/\/acme(\/|$)/);

  // Start clean.
  await page.goto("/acme/ai-assistant");
  if (new URL(page.url()).pathname === "/acme/ai-assistant") {
    await page.getByText("Remove app").click();
    await page.getByRole("button", { name: "Remove AI Assistant" }).click();
    await page.waitForURL(/\/apps/);
  }

  await page.goto("/acme/apps?q=assistant");
  const card = page.locator("li#ai-assistant");
  await expect(card.getByText("Free, uses your own AI key")).toBeVisible();
  await card.getByRole("button", { name: "Add app" }).click();
  await page.waitForURL(/\/acme\/ai-assistant$/);

  await expect(page.getByText(/Ask Assistant anything/)).toBeVisible();
  await expect(page.getByLabel("Message Assistant")).toBeDisabled();

  // A made-up key is checked with the provider and refused, so nothing is saved.
  await page.locator("input[name=api_key]").fill("sk-ant-not-a-real-key");
  await page.getByRole("button", { name: "Save settings" }).click();
  await expect(page.getByText(/rejected this API key/)).toBeVisible({ timeout: 20_000 });
  await expect(page.getByLabel("Message Assistant")).toBeDisabled();

  expect(errors).toEqual([]);
});
