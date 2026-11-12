// Shapes shared by the hosted-app providers.

export type HostedTenant = { id: string; externalId: string; subdomain: string; url: string };

/** How to put a person into the product, signed in: a one-time URL, or session cookies for the SSO bridge. */
export type SignIn =
  | { kind: "url"; url: string }
  | {
      kind: "cookies";
      /** The product's address; the bridge runs on its origin. */
      base: string;
      /** Where to go after signing in (an absolute path on that origin). */
      path: string;
      /** Cookie path, for products under a path on a shared host (default "/"). */
      cookiePath?: string;
      cookies: { name: string; value: string; httpOnly: boolean }[];
    };

export type ProductRole = "admin" | "member";

export interface HostedProvider {
  /** Server has the product configured (the App Store hides the app otherwise). */
  configured(): boolean;
  /** "provider": one product account per person across all their companies; "tenant": one per company. */
  accountScope: "provider" | "tenant";
  createTenant(ws: { slug: string; name: string; currency: string }): Promise<Omit<HostedTenant, "id">>;
  deleteTenant(t: HostedTenant): Promise<void>;
  addMember(t: HostedTenant, login: string, password: string, name: string, role: ProductRole): Promise<string>;
  setRole(t: HostedTenant, memberId: string, role: ProductRole): Promise<void>;
  /** `account` is the person's stored sign-in for this product, when there is one. */
  removeMember(t: HostedTenant, memberId: string, account: { login: string; password: string } | null): Promise<void>;
  signIn(t: HostedTenant, login: string, password: string, memberId: string): Promise<SignIn>;
  /** Optional: remove people in the tenant that MeweMarket doesn't know about (`keep`: its member ids there). */
  reconcile?(t: HostedTenant, keep: string[]): Promise<void>;
}
