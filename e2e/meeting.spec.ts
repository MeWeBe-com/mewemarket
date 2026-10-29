import { chromium, expect, test } from "@playwright/test";

// Two browsers with fake cameras join the same room and see each other's video.
test("video meeting connects two people in the page", async ({ baseURL }) => {
  const browser = await chromium.launch({ channel: "chrome", args: ["--use-fake-ui-for-media-stream", "--use-fake-device-for-media-stream"] });
  const room = `E2E${Date.now()}`;
  const open = async (name: string) => {
    const ctx = await browser.newContext({ permissions: ["camera", "microphone"] });
    const page = await ctx.newPage();
    await page.goto(`${baseURL}/tools/video-meeting?room=${room}`);
    await page.getByLabel("Your name").fill(name);
    await page.getByRole("button", { name: "Join meeting" }).click();
    return page;
  };
  const a = await open("Alice");
  await expect(a.getByText("Waiting for others")).toBeVisible();
  const b = await open("Bob");
  await expect(a.getByText("2 people")).toBeVisible({ timeout: 15_000 });
  await expect(a.getByText("Bob", { exact: true })).toBeVisible();
  await expect(b.getByText("Alice", { exact: true })).toBeVisible();
  // Remote video is actually playing frames.
  const playing = (p: typeof a) => p.waitForFunction(() => [...document.querySelectorAll("video")].filter((v) => !v.muted && v.videoWidth > 0).length === 1, null, { timeout: 15_000 });
  await playing(a);
  await playing(b);
  expect(a.url()).toContain("/tools/video-meeting");
  await b.getByRole("button", { name: "Leave" }).click();
  await expect(a.getByText("Waiting for others")).toBeVisible({ timeout: 10_000 });
  await browser.close();
});
