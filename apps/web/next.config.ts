import type { NextConfig } from "next";

const config: NextConfig = {
  transpilePackages: ["@mewe/db", "@mewe/core"],
  poweredByHeader: false,
  // Lets a second dev server run beside the main build (e.g. NEXT_DIST_DIR=.next-test).
  distDir: process.env.NEXT_DIST_DIR || ".next",
  // Legacy CodeIgniter URLs → new structure (keeps old SEO value).
  // Product ids and old /apps/<dir>/... demo folders are mapped in code (products route, apps/[slug] routes).
  async redirects() {
    return [
      { source: "/category/ViewCategory/:id/:slug/:page*", destination: "/apps/category/:slug", permanent: true },
      { source: "/category/:path*", destination: "/apps", permanent: true },
      { source: "/ai", destination: "/", permanent: true },
      { source: "/users/register", destination: "/sign-up", permanent: true },
      { source: "/users/ForgetPassword", destination: "/forgot-password", permanent: true },
      { source: "/users/Support", destination: "/contact", permanent: true },
      { source: "/users/:path*", destination: "/sign-in", permanent: true },
      // Insights are paused until the quality-gated pipeline ships (M10).
      { source: "/insights/:path*", destination: "/", permanent: false },
    ];
  },
};

export default config;
