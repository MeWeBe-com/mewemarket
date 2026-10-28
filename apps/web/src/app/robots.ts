import type { MetadataRoute } from "next";

export default function robots(): MetadataRoute.Robots {
  const base = process.env.APP_URL ?? "https://mewemarket.com";
  return {
    rules: [{ userAgent: "*", allow: "/", disallow: ["/w/", "/api/", "/account", "/dashboard", "/onboarding", "/invite/"] }],
    sitemap: `${base}/sitemap.xml`,
  };
}
