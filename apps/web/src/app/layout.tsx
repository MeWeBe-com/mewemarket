import type { Metadata } from "next";
import "./globals.css";

export const metadata: Metadata = {
  metadataBase: new URL(process.env.APP_URL ?? "https://mewemarket.com"),
  title: { default: "MeweMarket — Every business app, ready for your AI agent", template: "%s · MeweMarket" },
  description:
    "CRM, invoicing, projects, inventory, HR, bookings and dozens more apps in one workspace your team and your AI agents can run via MCP and API.",
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en">
      <body className="min-h-dvh antialiased font-sans">{children}</body>
    </html>
  );
}
