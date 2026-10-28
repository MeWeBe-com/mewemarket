"use client";
import { magicLinkClient, organizationClient, twoFactorClient } from "better-auth/client/plugins";
import { createAuthClient } from "better-auth/react";
import { ac, roles } from "./permissions";

export const authClient = createAuthClient({
  plugins: [
    organizationClient({ ac, roles }),
    magicLinkClient(),
    twoFactorClient({ onTwoFactorRedirect: () => { window.location.href = "/two-factor"; } }),
  ],
});
