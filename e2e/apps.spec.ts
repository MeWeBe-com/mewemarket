import { expect, test } from "@playwright/test";

// Needs the seeded test account (see docs/PLAN.md): owner of workspace "acme".
const EMAIL = process.env.E2E_EMAIL ?? "owner@example.com";
const PASSWORD = process.env.E2E_PASSWORD ?? "supersecret123";

test("add an app, create, edit, move, search, import and delete records", async ({ page }) => {
  const errors: string[] = [];
  page.on("pageerror", (e) => errors.push(e.message));

  await page.goto("/sign-in");
  await page.getByLabel("Email").fill(EMAIL);
  await page.locator("input[name=password]").fill(PASSWORD);
  await page.getByRole("button", { name: "Sign in", exact: true }).click();
  await page.waitForURL(/\/acme(\/|$)/);

  // Start clean: remove the app if a previous run left it.
  await page.goto("/acme/bug-tracker");
  if (new URL(page.url()).pathname === "/acme/bug-tracker") {
    await page.getByText("Remove app").click();
    await page.getByLabel(/also delete all/i).check();
    await page.getByRole("button", { name: /^Remove /i }).click();
    await page.waitForURL(/\/apps/);
  }

  await page.goto("/acme/apps?q=bug");
  const card = page.locator("li#bug-tracker");
  await card.getByLabel("with sample data").uncheck();
  await card.getByRole("button", { name: "Add app" }).click();
  await page.waitForURL(/\/acme\/bug-tracker$/);
  await expect(page.getByRole("link", { name: "Bug Tracker" }).first()).toBeVisible();

  // First entity of the app.
  const entityLink = page.locator('nav[aria-label$="sections"] a').nth(1);
  await entityLink.click();
  await page.waitForURL(/\/acme\/bug-tracker\/[a-z_]+$/);
  await page.getByRole("link", { name: /^New / }).click();
  const title = page.locator("form input[type=text]").first();
  await title.fill("Login button broken");
  // Fill any other required text inputs.
  for (const input of await page.locator("form input[required][type=text]").all()) if (!(await input.inputValue())) await input.fill("x");
  await page.getByRole("button", { name: /^Create/ }).click();
  await page.waitForURL(/\/acme\/bug-tracker\/[a-z_]+$/);
  await expect(page.getByRole("link", { name: "Login button broken" })).toBeVisible();

  // Validation: an empty required title is rejected.
  await page.getByRole("link", { name: /^New / }).click();
  await page.locator("form input[required]").first().evaluate((el: HTMLInputElement) => el.removeAttribute("required"));
  await page.getByRole("button", { name: /^Create/ }).click();
  await expect(page.getByText(/is required/).first()).toBeVisible();
  await page.goBack();

  // Edit.
  await page.goto(page.url().replace(/\/new.*$/, ""));
  await page.getByRole("link", { name: "Login button broken" }).click();
  await page.locator("form input[type=text]").first().fill("Login button fixed");
  await page.getByRole("button", { name: "Save changes" }).click();
  await expect(page.getByRole("link", { name: "Login button fixed" })).toBeVisible();

  // Board move via the card's select, if this entity has a board.
  const board = page.getByRole("tab", { name: "board" });
  if (await board.count()) {
    await board.click();
    const move = page.getByLabel("Move Login button fixed");
    await expect(move).toBeVisible();
    const options = await move.locator("option").allTextContents();
    await move.selectOption(options[options.length - 1]!);
    await page.waitForTimeout(1000);
    await page.reload();
    await expect(page.getByLabel("Move Login button fixed")).toHaveValue(options[options.length - 1]!);
    await page.getByRole("tab", { name: "table" }).click();
    await page.waitForURL(/view=table/);
  }

  // Search.
  await page.getByLabel("Search").fill("fixed");
  await page.getByRole("button", { name: "Apply" }).click();
  await expect(page.getByRole("link", { name: "Login button fixed" })).toBeVisible();
  await page.getByLabel("Search").fill("zzzz-nothing");
  await page.getByRole("button", { name: "Apply" }).click();
  await expect(page.getByText(/match\./)).toBeVisible();
  await page.getByRole("link", { name: "Clear" }).click();

  // CSV import using the first column's label.
  const header = (await page.locator("thead th").first().textContent())!.replace(/[↑↓]/g, "").trim();
  await page.getByRole("button", { name: "Import CSV" }).click();
  await page.locator('input[type=file]').setInputFiles({ name: "x.csv", mimeType: "text/csv", buffer: Buffer.from(`${header}\nImported one\nImported two\n`) });
  await page.getByRole("button", { name: "Import", exact: true }).click();
  await expect(page.getByText(/Imported \d+ records/)).toBeVisible();

  // Delete.
  page.on("dialog", (d) => d.accept());
  await page.goto(page.url());
  await page.getByRole("link", { name: "Login button fixed" }).click();
  await page.getByRole("button", { name: "Delete" }).click();
  await page.waitForURL(/\/acme\/bug-tracker\/[a-z_]+$/);
  await expect(page.getByRole("link", { name: "Login button fixed" })).toHaveCount(0);

  expect(errors).toEqual([]);
});

test("invoice line items total and print view", async ({ page }) => {
  await page.goto("/sign-in");
  await page.getByLabel("Email").fill(EMAIL);
  await page.locator("input[name=password]").fill(PASSWORD);
  await page.getByRole("button", { name: "Sign in", exact: true }).click();
  await page.waitForURL(/\/acme(\/|$)/);
  await page.goto("/acme/quick-invoices/invoice/new");
  await page.getByLabel("Number").fill("INV-E2E");
  await page.getByLabel("Client").selectOption({ index: 1 });
  await page.getByLabel("Issue date").fill("2026-10-29");
  await page.getByLabel("Description").first().fill("Design work");
  await page.getByLabel("Quantity").first().fill("3");
  await page.getByLabel("Price").first().fill("100");
  await page.getByRole("button", { name: "+ Add line" }).click();
  await page.getByLabel("Description").nth(1).fill("Hosting");
  await page.getByLabel("Quantity").nth(1).fill("1");
  await page.getByLabel("Price").nth(1).fill("50");
  await expect(page.getByText("Subtotal $350.00")).toBeVisible();
  await page.getByLabel("Tax rate").fill("10");
  await page.getByRole("button", { name: /^Create/ }).click();
  await page.getByRole("link", { name: "INV-E2E" }).first().click();
  await page.waitForURL(/\/invoice\/[0-9a-f-]{36}$/);
  const id = page.url().split("/").pop();
  await page.goto(`/acme/quick-invoices/invoice/${id}/print`);
  await expect(page.getByText("$385.00")).toBeVisible();
  await expect(page.getByText("Tax (10%)")).toBeVisible();
  page.on("dialog", (d) => d.accept());
  await page.goto(`/acme/quick-invoices/invoice/${id}`);
  await page.getByRole("button", { name: "Delete" }).click();
  await page.waitForURL(/\/invoice$/);
});

test("links between apps: a project's client is a Contacts & Deals company", async ({ page }) => {
  await page.goto("/sign-in");
  await page.getByLabel("Email").fill(EMAIL);
  await page.locator("input[name=password]").fill(PASSWORD);
  await page.getByRole("button", { name: "Sign in", exact: true }).click();
  await page.waitForURL(/\/acme(\/|$)/);
  // acme has Contacts & Deals and Simple Projects but not Team & HR.
  await page.goto("/acme/simple-projects/task/new");
  await expect(page.getByRole("link", { name: "Add the app" })).toHaveAttribute("href", /app=team-hr/);
  await page.goto("/acme/simple-projects/project/new");
  await page.getByLabel("Name").fill("E2E linked project");
  const client = page.getByLabel("Client");
  await client.selectOption({ index: 1 });
  const company = (await client.locator("option:checked").textContent())!.trim();
  await page.getByRole("button", { name: /^Create/ }).click();
  await page.waitForURL(/\/project$/);
  await expect(page.getByRole("row", { name: /E2E linked project/ })).toContainText(company);
  // The company page lists the project from the other app.
  await page.goto("/acme/contacts/company");
  await page.getByRole("link", { name: company, exact: true }).first().click();
  await expect(page.getByText(/Projects in Simple Projects/)).toBeVisible();
  await page.getByRole("link", { name: "E2E linked project" }).click();
  await page.waitForURL(/\/acme\/simple-projects\/project\/[0-9a-f-]{36}$/);
  page.on("dialog", (d) => d.accept());
  await page.getByRole("button", { name: "Delete" }).click();
  await page.waitForURL(/\/project$/);
});

test("public pages and free tools load without errors", async ({ page }) => {
  const errors: string[] = [];
  page.on("pageerror", (e) => errors.push(`${page.url()}: ${e.message}`));
  for (const p of ["/", "/apps", "/apps/category/healthcare", "/apps/crm", "/apps/hotel", "/pricing", "/about", "/contact", "/tools"]) {
    const res = await page.goto(p);
    expect(res?.status(), p).toBe(200);
  }
  await page.goto("/tools/json-formatter");
  await page.locator("textarea").first().fill('{"a":1,"b":[1,2]}');
  await page.getByRole("button", { name: "Format" }).click();
  await expect(page.locator("body")).toContainText('"b": [');
  expect(errors).toEqual([]);
});

test("no horizontal scrolling at phone width", async ({ browser }) => {
  const page = await browser.newPage({ viewport: { width: 390, height: 844 } });
  const wide: string[] = [];
  for (const p of ["/", "/apps", "/apps/hotel", "/pricing", "/tools", "/tools/invoice-generator", "/tools/loan-calculator", "/tools/db-diagram", "/tools/whiteboard"]) {
    await page.goto(p);
    await page.waitForLoadState("networkidle");
    const w = await page.evaluate(() => document.documentElement.scrollWidth);
    if (w > 392) wide.push(`${p}: ${w}px`);
  }
  expect(wide).toEqual([]);
});
