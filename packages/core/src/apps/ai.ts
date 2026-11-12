import { app } from "./define";

// Apps with their own screen. They read the workspace's records but store none of their own.
export const AI_APPS = [
  app({
    slug: "ai-assistant", name: "AI Assistant", category: "ai", kind: "assistant", entities: [],
    tagline: "Ask questions about your business and get answers from your own data.",
    description: "Chat with an AI that knows your workspace. Ask about deals, invoices, tasks or stock and it looks up your records to answer, with links to each one. Uses your own Claude or OpenAI API key.",
    features: ["Answers from your own records", "Works across every installed app", "Links to the records it used", "Your company instructions and tone", "Bring your own Claude or OpenAI key", "Read-only: it never changes your data"],
  }),
];
