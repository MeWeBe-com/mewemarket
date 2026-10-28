import type { Metadata } from "next";
import { Inter } from "next/font/google";
import { ThemeProvider } from "next-themes";
import "./globals.css";

const inter = Inter({ subsets: ["latin"], variable: "--font-inter", display: "swap" });

export const metadata: Metadata = {
  metadataBase: new URL(process.env.APP_URL ?? "https://mewemarket.com"),
  title: { default: "MeweMarket: every business app, ready for your AI assistant", template: "%s · MeweMarket" },
  description:
    "CRM, invoicing, projects, inventory, HR, bookings and dozens more apps in one workspace. Use it in your browser, or ask Claude, ChatGPT or Gemini to do the work for you.",
  openGraph: { siteName: "MeweMarket", type: "website" },
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en" suppressHydrationWarning className={inter.variable}>
      <body className="min-h-dvh font-sans antialiased">
        <ThemeProvider attribute="class" defaultTheme="system" enableSystem disableTransitionOnChange>
          {children}
        </ThemeProvider>
      </body>
    </html>
  );
}
