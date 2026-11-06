/** Only same-site paths are allowed as a post-login destination ("//evil.com" and "/\evil.com" are other sites). */
export function safeNext(next: string | null | undefined, fallback = "/dashboard") {
  return next && next.startsWith("/") && !/^\/[/\\]/.test(next) ? next : fallback;
}
