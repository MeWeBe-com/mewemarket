import { app } from "./define";

// Open-source products run as their own service and shown inside the workspace (see ../hosted/).
export const HOSTED_APPS = [
  app({
    slug: "crm", name: "CRM", category: "sales", kind: "hosted", entities: [], legacyProductIds: [20, 39],
    hosted: { provider: "twenty", poweredBy: "Twenty", license: "AGPL-3.0", sourceUrl: "https://github.com/twentyhq/twenty" },
    tagline: "A full CRM for your team: people, companies, deals, tasks and notes.",
    description: "A complete, modern CRM inside your workspace, powered by the open-source Twenty CRM. Track people and companies, run your sales pipeline, keep notes, tasks and emails on every record, add your own fields and views, and work together with your team. Your team signs in once to MeweMarket.",
    features: ["People, companies and opportunities", "Pipeline (kanban) and table views with filters", "Notes, tasks and a timeline on every record", "Custom objects and fields", "Import from CSV", "Each company's data kept separate", "One sign-in through MeweMarket"],
  }),
  app({
    slug: "invoices", name: "Invoices", category: "finance", kind: "hosted", entities: [], legacyProductIds: [23],
    hosted: { provider: "invoiceshelf", poweredBy: "InvoiceShelf", license: "AGPL-3.0", sourceUrl: "https://github.com/InvoiceShelf/InvoiceShelf" },
    tagline: "Invoices, estimates, payments and expenses, with reports.",
    description: "Full invoicing for your company, powered by the open-source InvoiceShelf. Send professional invoices and estimates, set up recurring invoices, record payments and expenses, keep a customer and item list, and see sales, expense and profit reports. Your team signs in once to MeweMarket.",
    features: ["Invoices and estimates with PDF", "Recurring invoices", "Payments and expenses", "Customers and items", "Taxes and multiple currencies", "Sales, expense, tax and profit & loss reports", "Each company's data kept separate", "One sign-in through MeweMarket"],
  }),
  app({
    slug: "projects", name: "Projects", category: "business", kind: "hosted", entities: [], legacyProductIds: [36, 45],
    hosted: { provider: "plane", poweredBy: "Plane", license: "AGPL-3.0", sourceUrl: "https://github.com/makeplane/plane" },
    tagline: "Projects, work items, cycles and modules for your team.",
    description: "Full project management for your company, powered by the open-source Plane. Plan projects, track work items on boards, lists, calendars and spreadsheets, run sprints with cycles, group work into modules, and write pages and docs together. Your team signs in once to MeweMarket.",
    features: ["Projects with work items, sub-items and labels", "Board, list, calendar and spreadsheet views", "Cycles (sprints) and modules", "Pages for docs and notes", "Filters, saved views and analytics", "Each company's data kept separate", "One sign-in through MeweMarket"],
  }),
  app({
    slug: "helpdesk", name: "Helpdesk", category: "customer-service", kind: "hosted", entities: [],
    hosted: { provider: "chatwoot", poweredBy: "Chatwoot", license: "MIT", sourceUrl: "https://github.com/chatwoot/chatwoot" },
    tagline: "A shared inbox for customer conversations: email, live chat and more.",
    description: "A full customer support desk for your company, powered by the open-source Chatwoot. Bring email, website live chat and other channels into one shared inbox, assign conversations to your team, reply with canned responses, keep a contact list and see support reports. Your team signs in once to MeweMarket.",
    features: ["Shared inbox for email, live chat and more", "Website chat widget", "Assign, label and prioritise conversations", "Canned responses and private notes", "Contacts and conversation history", "Support reports", "Each company's data kept separate", "One sign-in through MeweMarket"],
  }),
  app({
    slug: "e-signatures", name: "E-Signatures", category: "legal", kind: "hosted", entities: [],
    hosted: { provider: "documenso", poweredBy: "Documenso", license: "AGPL-3.0", sourceUrl: "https://github.com/documenso/documenso" },
    tagline: "Send documents for signature and track who has signed.",
    description: "Electronic signatures for your company, powered by the open-source Documenso. Upload a PDF, place signature, date and text fields, send it to one or more signers by email, and follow its progress until everyone has signed. Signed documents are sealed with a digital certificate. Your team signs in once to MeweMarket.",
    features: ["Upload PDFs and place signature fields", "Several signers, in order or all at once", "Email requests, reminders and completion notices", "Templates for documents you send often", "Signed PDFs sealed with a certificate, with an audit log", "Each company's documents kept separate", "One sign-in through MeweMarket"],
  }),
  app({
    slug: "bookings", name: "Bookings", category: "customer-service", kind: "hosted", entities: [],
    hosted: { provider: "easyappointments", poweredBy: "Easy!Appointments", license: "GPL-3.0", sourceUrl: "https://github.com/alextselegidis/easyappointments" },
    tagline: "Online appointment booking with your own public booking page.",
    description: "Let customers book appointments online, powered by the open-source Easy!Appointments. Set up your services, staff and working hours, share your booking page at mewemarket.com/your-company/book, and manage every appointment on a shared calendar. Your team signs in once to MeweMarket.",
    features: ["Public booking page at mewemarket.com/your-company/book", "Services with durations and prices", "Staff working hours, breaks and days off", "Shared appointment calendar", "Customer list", "Email confirmations", "Each company's data kept separate", "One sign-in through MeweMarket"],
  }),
  app({
    slug: "ai-chat", name: "AI Chat", category: "ai", kind: "hosted", entities: [],
    hosted: { provider: "openwebui", poweredBy: "Open WebUI", license: "Open WebUI License (BSD-3 based)", sourceUrl: "https://github.com/open-webui/open-webui" },
    tagline: "A private ChatGPT-style assistant for your team, using your own Claude or OpenAI key.",
    description: "A private AI chat for your whole team, powered by the open-source Open WebUI. Ask questions, draft and rewrite text, summarise documents and images you upload, save prompts your team reuses, and build custom assistants with your own instructions. It uses your company's own Claude or OpenAI key, which stays in MeweMarket, and your plan's monthly AI messages. Your team signs in once to MeweMarket.",
    features: ["ChatGPT-style chat with history and search", "Uses your company's own Claude or OpenAI key", "Upload documents and images to discuss", "Shared prompts and custom assistants for your team", "Each person's chats are private", "Monthly AI messages from your plan", "One sign-in through MeweMarket"],
  }),
];
