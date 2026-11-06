import type { MetadataRoute } from "next";

export default function robots(): MetadataRoute.Robots {
  const base = process.env.APP_URL ?? "https://mewemarket.com";
  return {
    rules: [{ userAgent: "*", allow: "/", disallow: ["/w/", "/api/", "/account", "/dashboard", "/onboarding", "/invite/", "/_staged_insights/"] }],
    // /insights/ is published by the separate SEO pipeline and served straight from disk by nginx.
    sitemap: [`${base}/sitemap.xml`, `${base}/insights/sitemap.xml`],
  };
}
