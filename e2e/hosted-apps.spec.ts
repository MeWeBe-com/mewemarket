import { expect, test } from "@playwright/test";

// The full open-source apps shown inside the workspace, signed in. Each needs its service configured for the
// app under test (see docs/DEPLOY.md, "Hosted apps") and runs only when listed in E2E_HOSTED, e.g.
// E2E_HOSTED=crm,invoices,projects,helpdesk,e-signatures. Locally the app and the services must share a site (e.g.
// mewemarket.test, *.crm.mewemarket.test, invoices.mewemarket.test) so the sign-in cookies work in the frame.
const EMAIL = process.env.E2E_EMAIL ?? "owner@example.com";
const PASSWORD = process.env.E2E_PASSWORD ?? "supersecret123";
const ENABLED = new Set((process.env.E2E_HOSTED ?? "").split(",").filter(Boolean));

// slug, name, text the product shows once signed in, source link
const APPS = [
  ["crm", "CRM", "Opportunities", /twentyhq\/twenty/],
  ["invoices", "Invoices", "Recurring Invoices", /InvoiceShelf\/InvoiceShelf/],
  ["projects", "Projects", "Projects", /makeplane\/plane/],
  ["helpdesk", "Helpdesk", "Conversations", /chatwoot\/chatwoot/],
  ["e-signatures", "E-Signatures", "Documents", /documenso\/documenso/],
] as const;

for (const [slug, name, signedInText, source] of APPS) {
  test(`${name} opens inside the workspace, already signed in`, async ({ page }) => {
    test.skip(!ENABLED.has(slug), `add ${slug} to E2E_HOSTED when its service is configured`);
    await page.goto("/sign-in");
    await page.getByLabel("Email").fill(EMAIL);
    await page.locator("input[name=password]").fill(PASSWORD);
    await page.getByRole("button", { name: "Sign in", exact: true }).click();
    await page.waitForURL(/\/acme(\/|$)/);

    // Add it from the App Store the first time; afterwards just open it.
    await page.goto(`/acme/apps?app=${slug}`);
    const add = page.locator(`#${slug}`).getByRole("button", { name: "Add app" });
    if (await add.count()) {
      await add.click();
      await page.waitForURL(new RegExp(`/acme/${slug}$`), { timeout: 120_000 });
    } else {
      await page.goto(`/acme/${slug}`);
    }

    // The product's own screen, inside the frame: the person landed in Acme's copy without a second sign-in.
    const frame = page.frameLocator(`iframe[title="${name}"]`);
    await expect(frame.getByText(signedInText).first()).toBeVisible({ timeout: 90_000 });
    await expect(page.getByRole("link", { name: /Powered by/ })).toHaveAttribute("href", source);
    expect(new URL(page.url()).pathname).toBe(`/acme/${slug}`);

    // "Open in new tab" lands in the same app, signed in.
    const [tab] = await Promise.all([page.waitForEvent("popup"), page.getByRole("link", { name: /Open in new tab/ }).click()]);
    await expect(tab.getByText(signedInText).first()).toBeVisible({ timeout: 90_000 });
  });
}
