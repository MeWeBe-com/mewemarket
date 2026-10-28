export type Provider = "google" | "facebook" | "github";

export function enabledProviders() {
  const p: Provider[] = [];
  if (process.env.GOOGLE_CLIENT_ID) p.push("google");
  if (process.env.FACEBOOK_CLIENT_ID) p.push("facebook");
  if (process.env.GITHUB_CLIENT_ID) p.push("github");
  return p;
}
