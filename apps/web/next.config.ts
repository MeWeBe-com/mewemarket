import type { NextConfig } from "next";

const config: NextConfig = {
  transpilePackages: ["@mewe/db"],
  poweredByHeader: false,
  // Legacy CodeIgniter URLs → new structure (keeps old SEO value).
  async redirects() {
    return [
      { source: "/products/:path*", destination: "/apps", permanent: true },
      { source: "/category/:path*", destination: "/apps", permanent: true },
      { source: "/insights/:slug.html", destination: "/insights/:slug", permanent: true },
    ];
  },
};

export default config;
