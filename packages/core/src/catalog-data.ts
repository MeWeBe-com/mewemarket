// Launch catalogue (BRIEF.md §3a). Seeded idempotently by seed.ts.
// Hosted apps: licence checked against the allowlist (MIT, Apache-2.0, BSD, AGPL/GPL hosted unmodified with source link).
// Excluded after licence check: Invoice Ninja (Elastic License), Akaunting and Outline (BSL), n8n (Sustainable Use).

export type Tier = "native" | "schema" | "hosted" | "tool";

export type CatalogCategory = { slug: string; name: string; icon: string; blurb: string };

// The first eight keep the legacy site's categories (and their URLs) alive.
export const CATEGORIES: CatalogCategory[] = [
  { slug: "business", name: "Business", icon: "briefcase", blurb: "Run day-to-day operations, projects and admin." },
  { slug: "application", name: "Application", icon: "app-window", blurb: "Utilities and productivity apps for any team." },
  { slug: "customer-service", name: "Customer Service", icon: "headset", blurb: "Bookings, support desks and customer communication." },
  { slug: "education", name: "Education", icon: "graduation-cap", blurb: "Courses, students, attendance and training." },
  { slug: "finance", name: "Finance", icon: "chart-line", blurb: "Invoicing, expenses, payroll and purchasing." },
  { slug: "legal", name: "Legal", icon: "scale", blurb: "Contracts, matters and e-signatures." },
  { slug: "logistics", name: "Logistics", icon: "truck", blurb: "Inventory, warehouses and shipments." },
  { slug: "marketing", name: "Marketing", icon: "megaphone", blurb: "Campaigns, events, newsletters and surveys." },
  { slug: "sales", name: "Sales", icon: "handshake", blurb: "CRM, pipelines and deal tracking." },
  { slug: "hr", name: "HR & Team", icon: "users", blurb: "People, leave, time tracking and hiring." },
  { slug: "healthcare", name: "Healthcare", icon: "stethoscope", blurb: "Clinics, patients and appointments." },
  { slug: "hospitality", name: "Hospitality", icon: "bed", blurb: "Hotels, rooms and reservations." },
  { slug: "developer", name: "Developer & Free Tools", icon: "code", blurb: "Free tools for builders. No sign-up needed." },
];

export type CatalogEntry = {
  slug: string;
  name: string;
  tagline: string;
  description: string;
  tier: Tier;
  category: string;
  features: string[];
  license?: string;
  sourceUrl?: string;
  poweredBy?: string;
  legacyProductIds?: number[];
};

export const CATALOG: CatalogEntry[] = [
  // --- Flagship native apps ---
  {
    slug: "crm", name: "CRM & Pipeline", tier: "native", category: "sales", legacyProductIds: [20, 39],
    tagline: "Contacts, companies and deals in one visual pipeline.",
    description: "Track every customer conversation and deal. Drag deals between stages, set follow-ups, and see your forecast at a glance.",
    features: ["Contacts and companies", "Multiple pipelines with kanban", "Calls, meetings and notes timeline", "Follow-up reminders", "Deal forecast chart", "AI lead scoring and email drafts"],
  },
  {
    slug: "invoices", name: "Invoices & Quotes", tier: "native", category: "finance", legacyProductIds: [23],
    tagline: "Branded invoices that get paid online.",
    description: "Create quotes and invoices in seconds, send them by email with a Stripe payment link, and watch them mark themselves paid.",
    features: ["Quotes that convert to invoices", "Stripe payment links", "Recurring invoices", "Overdue reminders", "Taxes, discounts and multi-currency", "Branded PDF"],
  },
  {
    slug: "projects", name: "Projects & Tasks", tier: "native", category: "business", legacyProductIds: [36, 45],
    tagline: "Boards, lists and time tracking that bills itself.",
    description: "Plan projects on boards or lists, assign tasks, track time and turn billable hours into invoices.",
    features: ["Kanban and list views", "Subtasks, priorities and due dates", "My tasks view", "Time tracker", "Bill hours to an invoice"],
  },
  {
    slug: "inventory", name: "Inventory & Orders", tier: "native", category: "logistics", legacyProductIds: [21, 22, 29, 43],
    tagline: "Stock, locations and orders without the spreadsheet.",
    description: "Know what you have and where. Manage products, stock movements, purchase and sales orders, with low-stock alerts.",
    features: ["Products and SKUs", "Multiple stock locations", "Purchase and sales orders", "Low-stock alerts", "Barcode and QR labels"],
  },
  {
    slug: "team-hr", name: "Team & HR", tier: "native", category: "hr", legacyProductIds: [37],
    tagline: "Directory, leave, timesheets and holidays.",
    description: "Keep your team organised: employee records, leave requests with approvals, a shared leave calendar and timesheets.",
    features: ["Employee directory", "Leave requests and approvals", "Leave and holiday calendar", "Timesheets"],
  },
  {
    slug: "bookings", name: "Bookings & Scheduling", tier: "native", category: "customer-service",
    tagline: "A public booking page with reminders and deposits.",
    description: "Let customers book your services online, based on staff availability, with email reminders and optional deposits.",
    features: ["Public booking page", "Staff availability", "Confirmation and reminder emails", "Calendar invites", "Stripe deposits"],
  },

  // --- Catalogue apps on the records engine ---
  {
    slug: "expense-tracker", name: "Expense Tracker", tier: "schema", category: "finance", legacyProductIds: [25],
    tagline: "Snap receipts, approve expenses, reimburse faster.",
    description: "Staff submit expenses with receipts; AI reads the receipt, managers approve, finance exports.",
    features: ["Receipt capture with AI extraction", "Approval workflow", "Categories and budgets", "CSV export"],
  },
  {
    slug: "purchase-orders", name: "Purchase Orders", tier: "schema", category: "finance", legacyProductIds: [17],
    tagline: "Request, approve and track supplier orders.",
    description: "Raise purchase orders, route them for approval and track delivery against suppliers.",
    features: ["Suppliers", "PO approval flow", "Delivery tracking", "Links to inventory"],
  },
  {
    slug: "payroll-attendance", name: "Payroll & Attendance", tier: "schema", category: "finance", legacyProductIds: [16],
    tagline: "Attendance and payroll records in one place.",
    description: "Record attendance, overtime and pay runs, and keep payslip records for every employee.",
    features: ["Clock in and out", "Overtime rules", "Pay run records", "Payslip PDFs"],
  },
  {
    slug: "event-management", name: "Event Management", tier: "schema", category: "marketing", legacyProductIds: [18],
    tagline: "Plan events, sell tickets, check in guests.",
    description: "Manage events from planning to check-in: attendees, tickets, sessions and follow-ups.",
    features: ["Events and sessions", "Attendee registration", "Ticket types", "Check-in list"],
  },
  {
    slug: "clinic", name: "Clinic & Patients", tier: "schema", category: "healthcare", legacyProductIds: [10, 24, 44],
    tagline: "Patients, appointments and visit notes for small clinics.",
    description: "Register patients, book appointments with the right specialist and keep visit notes, all in one place.",
    features: ["Patient records", "Doctor availability", "Appointment booking", "Visit notes", "Billing via Invoices"],
  },
  {
    slug: "hotel", name: "Hotel & Rooms", tier: "schema", category: "hospitality", legacyProductIds: [26],
    tagline: "Rooms, reservations and housekeeping.",
    description: "Manage room inventory, reservations, check-ins and housekeeping status for small hotels and guesthouses.",
    features: ["Rooms and rates", "Reservation calendar", "Check-in and check-out", "Housekeeping board"],
  },
  {
    slug: "helpdesk", name: "Helpdesk", tier: "schema", category: "customer-service",
    tagline: "Tickets with priorities, SLAs and AI replies.",
    description: "Collect customer requests as tickets, assign them, track SLAs and let AI draft the replies.",
    features: ["Tickets and priorities", "Assignment and SLAs", "AI reply drafts", "Customer history from CRM"],
  },
  {
    slug: "contracts", name: "Contracts", tier: "schema", category: "legal",
    tagline: "Every contract, renewal and obligation tracked.",
    description: "Store contracts, track renewal dates and obligations, and get reminded before anything lapses.",
    features: ["Contract register", "Renewal reminders", "AI clause summary", "Link to clients and suppliers"],
  },
  {
    slug: "legal-matters", name: "Legal Matters", tier: "schema", category: "legal",
    tagline: "Matters, deadlines and billable time for small firms.",
    description: "Track client matters, court and filing deadlines, documents and billable time.",
    features: ["Matters and clients", "Deadline calendar", "Document links", "Billable time to invoices"],
  },
  {
    slug: "courses", name: "Courses & Students", tier: "schema", category: "education",
    tagline: "Courses, enrolments and attendance.",
    description: "Run courses or classes: students, enrolments, attendance and progress.",
    features: ["Courses and classes", "Student enrolment", "Attendance", "Progress tracking"],
  },
  {
    slug: "shipments", name: "Shipments", tier: "schema", category: "logistics",
    tagline: "Track shipments from dispatch to delivery.",
    description: "Log shipments, carriers and tracking numbers, and keep customers updated automatically.",
    features: ["Shipments and carriers", "Status timeline", "Customer notifications", "Links to orders"],
  },
  {
    slug: "campaigns", name: "Campaigns", tier: "schema", category: "marketing",
    tagline: "Plan campaigns and measure what worked.",
    description: "Plan marketing campaigns, content and budgets, and track leads back to each campaign.",
    features: ["Campaign calendar", "Content planner", "Budget tracking", "Lead attribution"],
  },
  {
    slug: "recruiting", name: "Recruiting", tier: "schema", category: "hr",
    tagline: "Jobs, candidates and interview pipelines.",
    description: "Post roles, track candidates through interview stages and collect feedback from your team.",
    features: ["Job openings", "Candidate pipeline", "Interview feedback", "AI CV summary"],
  },
  {
    slug: "asset-register", name: "Asset Register", tier: "schema", category: "business",
    tagline: "Equipment, assignments and maintenance.",
    description: "Track company equipment, who has it, and when it is due for service.",
    features: ["Assets and categories", "Check-out to staff", "Maintenance schedule", "QR asset tags"],
  },

  // --- Hosted open-source apps ---
  {
    slug: "kanboard", name: "Kanboard", tier: "hosted", category: "business", legacyProductIds: [41],
    license: "MIT", sourceUrl: "https://github.com/kanboard/kanboard", poweredBy: "Kanboard",
    tagline: "Minimal open-source kanban project management.",
    description: "Kanboard focuses on simplicity: visualise work, limit work in progress and move tasks with drag and drop.",
    features: ["Kanban boards", "Swimlanes and WIP limits", "Subtasks", "Time tracking"],
  },
  {
    slug: "jorani", name: "Jorani Leave Management", tier: "hosted", category: "hr", legacyProductIds: [42],
    license: "AGPL-3.0", sourceUrl: "https://github.com/bbalet/jorani", poweredBy: "Jorani",
    tagline: "Open-source leave and overtime management.",
    description: "Jorani handles leave requests, approvals and overtime with a clear calendar for managers and staff.",
    features: ["Leave requests", "Manager approvals", "Overtime", "Team calendar"],
  },
  {
    slug: "kimai", name: "Kimai Time Tracking", tier: "hosted", category: "hr", legacyProductIds: [11],
    license: "AGPL-3.0", sourceUrl: "https://github.com/kimai/kimai", poweredBy: "Kimai",
    tagline: "Professional open-source time tracking.",
    description: "Kimai tracks working time per customer, project and activity, with reports and invoice export.",
    features: ["Timesheets", "Customers, projects and activities", "Reports", "Invoice export"],
  },
  {
    slug: "cal-com", name: "Cal.com Scheduling", tier: "hosted", category: "customer-service",
    license: "AGPL-3.0", sourceUrl: "https://github.com/calcom/cal.com", poweredBy: "Cal.com",
    tagline: "Open-source scheduling infrastructure.",
    description: "Booking links, round-robin team scheduling and calendar sync.",
    features: ["Booking links", "Team scheduling", "Calendar sync", "Workflows"],
  },
  {
    slug: "chatwoot", name: "Chatwoot Support Inbox", tier: "hosted", category: "customer-service",
    license: "MIT", sourceUrl: "https://github.com/chatwoot/chatwoot", poweredBy: "Chatwoot",
    tagline: "Shared inbox for chat, email and social.",
    description: "Answer customers across website chat, email and social channels from one shared inbox.",
    features: ["Website live chat", "Shared inbox", "Canned responses", "Reports"],
  },
  {
    slug: "jitsi-meet", name: "Jitsi Meet", tier: "hosted", category: "application", legacyProductIds: [14, 32, 33, 40],
    license: "Apache-2.0", sourceUrl: "https://github.com/jitsi/jitsi-meet", poweredBy: "Jitsi",
    tagline: "Secure video meetings and screen sharing.",
    description: "Private video calls with screen sharing, recording and no accounts required for guests.",
    features: ["Video meetings", "Screen sharing", "Guest links", "Chat and reactions"],
  },
  {
    slug: "excalidraw", name: "Excalidraw Whiteboard", tier: "hosted", category: "application", legacyProductIds: [35, 38],
    license: "MIT", sourceUrl: "https://github.com/excalidraw/excalidraw", poweredBy: "Excalidraw",
    tagline: "Hand-drawn style whiteboard and wireframes.",
    description: "Sketch diagrams, wireframes and ideas together on an infinite canvas.",
    features: ["Infinite canvas", "Shape libraries", "Export PNG and SVG", "Live collaboration"],
  },
  {
    slug: "snipe-it", name: "Snipe-IT Asset Management", tier: "hosted", category: "business",
    license: "AGPL-3.0", sourceUrl: "https://github.com/snipe/snipe-it", poweredBy: "Snipe-IT",
    tagline: "IT asset and licence management.",
    description: "Track hardware, software licences and accessories, and who has them.",
    features: ["Hardware assets", "Licence seats", "Check-in and check-out", "Audit reports"],
  },
  {
    slug: "bookstack", name: "BookStack Wiki", tier: "hosted", category: "application",
    license: "MIT", sourceUrl: "https://github.com/BookStackApp/BookStack", poweredBy: "BookStack",
    tagline: "A simple, structured company wiki.",
    description: "Organise company knowledge into shelves, books and pages with a friendly editor.",
    features: ["Shelves, books and pages", "WYSIWYG and Markdown", "Search", "Permissions"],
  },
  {
    slug: "uptime-kuma", name: "Uptime Kuma", tier: "hosted", category: "application", legacyProductIds: [27],
    license: "MIT", sourceUrl: "https://github.com/louislam/uptime-kuma", poweredBy: "Uptime Kuma",
    tagline: "Website and server uptime monitoring.",
    description: "Monitor websites, APIs and servers with alerts and a public status page.",
    features: ["HTTP, ping and port checks", "Alerts", "Status pages", "Response time charts"],
  },
  {
    slug: "documenso", name: "Documenso e-Signature", tier: "hosted", category: "legal",
    license: "AGPL-3.0", sourceUrl: "https://github.com/documenso/documenso", poweredBy: "Documenso",
    tagline: "Open-source document signing.",
    description: "Send documents for signature and keep a signed audit trail.",
    features: ["Send for signature", "Templates", "Audit trail", "Signed PDF"],
  },
  {
    slug: "listmonk", name: "Listmonk Newsletters", tier: "hosted", category: "marketing",
    license: "AGPL-3.0", sourceUrl: "https://github.com/knadh/listmonk", poweredBy: "listmonk",
    tagline: "High-performance newsletter and mailing lists.",
    description: "Manage subscribers and send newsletters and campaigns at scale.",
    features: ["Lists and subscribers", "Campaigns", "Templates", "Analytics"],
  },

  // --- Free tools (no sign-up) ---
  {
    slug: "invoice-generator", name: "Free Invoice Generator", tier: "tool", category: "developer", legacyProductIds: [15],
    tagline: "Make a professional PDF invoice in a minute.",
    description: "Fill in your details and download a clean PDF invoice. No sign-up needed.",
    features: ["PDF download", "Taxes and discounts", "Your logo", "Any currency"],
  },
  {
    slug: "qr-code-generator", name: "QR Code Generator", tier: "tool", category: "developer", legacyProductIds: [12],
    tagline: "Generate QR codes for links, Wi-Fi and contacts.",
    description: "Create QR codes and download them as PNG or SVG.",
    features: ["Links, text, Wi-Fi, vCard", "PNG and SVG", "Custom colours"],
  },
  {
    slug: "timestamp-converter", name: "Timestamp Converter", tier: "tool", category: "developer", legacyProductIds: [19],
    tagline: "Convert Unix timestamps and dates instantly.",
    description: "Convert between Unix time, ISO 8601 and human-readable dates in any timezone.",
    features: ["Seconds and milliseconds", "Any timezone", "ISO 8601", "Copy with one click"],
  },
  {
    slug: "db-diagram", name: "DB Diagram", tier: "tool", category: "developer", legacyProductIds: [46],
    tagline: "Draw database diagrams from code.",
    description: "Write tables in DBML and get an instant diagram you can export as PNG or SQL.",
    features: ["DBML editor", "Live diagram", "Export PNG and SQL", "Relationships"],
  },
];
