export function enabledProviders() {
  const p: ("google" | "github")[] = [];
  if (process.env.GOOGLE_CLIENT_ID) p.push("google");
  if (process.env.GITHUB_CLIENT_ID) p.push("github");
  return p;
}
