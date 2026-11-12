// Shapes shared by the hosted-app providers.

export type HostedTenant = { id: string; externalId: string; subdomain: string; url: string };

/** How to put a person into the product, signed in: a one-time URL, or session cookies for the SSO bridge. */
export type SignIn =
  | { kind: "url"; url: string }
  | { kind: "cookies"; base: string; path: string; cookies: { name: string; value: string; httpOnly: boolean }[] };

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
}
