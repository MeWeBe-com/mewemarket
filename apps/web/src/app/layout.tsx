import type { Metadata } from "next";
import localFont from "next/font/local";
import { ThemeProvider } from "next-themes";
import "./globals.css";
import { ConsentAndAnalytics } from "@/components/site/consent";

// Fonts ship with the app (@fontsource-variable), so builds never download from Google Fonts,
// which refuses some build machines (GitHub runners) and broke builds.
const inter = localFont({
  src: "../../node_modules/@fontsource-variable/inter/files/inter-latin-wght-normal.woff2",
  weight: "100 900", variable: "--font-inter", display: "swap",
});
const display = localFont({
  src: "../../node_modules/@fontsource-variable/plus-jakarta-sans/files/plus-jakarta-sans-latin-wght-normal.woff2",
  weight: "200 800", variable: "--font-jakarta", display: "swap",
});

export const metadata: Metadata = {
  metadataBase: new URL(process.env.APP_URL ?? "https://mewemarket.com"),
  title: { default: "MeweMarket: 100+ business apps in one workspace", template: "%s · MeweMarket" },
  description:
    "CRM, invoicing, projects, inventory, HR, bookings and dozens more apps in one workspace. Over 100 business apps and free tools on one subscription.",
  openGraph: { siteName: "MeweMarket", type: "website" },
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en" suppressHydrationWarning className={`${inter.variable} ${display.variable}`}>
      <body className="min-h-dvh font-sans antialiased">
        <ThemeProvider attribute="class" defaultTheme="system" enableSystem disableTransitionOnChange>
          {children}
          <ConsentAndAnalytics />
        </ThemeProvider>
      </body>
    </html>
  );
}
