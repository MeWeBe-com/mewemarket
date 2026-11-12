import { app, entity } from "./define";

// The six flagship apps (formerly "native"), now on the records engine.
export const CORE_SUITE = [
  app({
    slug: "contacts", name: "Contacts & Deals", category: "sales",
    tagline: "A simple list of contacts, companies and deals with a pipeline board.",
    description: "Track every customer and deal. Drag deals between stages, log calls and meetings, and see the value of your pipeline at a glance.",
    features: ["Contacts and companies", "Deal pipeline board", "Activity log for calls, meetings and emails", "Follow-up dates on a calendar", "Pipeline value totals", "CSV import and export"],
    entities: [
      entity("deal", "Deal", "Deals", ["name*", "company:ref=company", "contact:ref=contact", "value:money", "stage*:select=Lead|Qualified|Proposal|Negotiation|Won|Lost", "expected_close:date", "owner:ref=team-hr.employee", "notes:long"], { board: "stage", calendar: "expected_close", totals: ["value"] }),
      entity("contact", "Contact", "Contacts", ["name*", "email:email", "phone:phone", "company:ref=company", "job_title", "status:select=Lead|Customer|Partner|Inactive", "notes:long"]),
      entity("company", "Company", "Companies", ["name*", "website:url", "industry", "phone:phone", "city", "country", "size:select=1-10|11-50|51-200|201-1000|1000+"]),
      entity("activity", "Activity", "Activities", ["subject*", "type:select=Call|Meeting|Email|Task", "contact:ref=contact", "deal:ref=deal", "due:datetime", "done:bool", "notes:long"], { calendar: "due" }),
    ],
  }),
  app({
    slug: "quick-invoices", name: "Quick Invoices", category: "finance",
    tagline: "Simple quotes and invoices with line items and totals.",
    description: "Create quotes and invoices with line items, taxes and due dates, track what's paid and what's overdue, and print or save them as PDF.",
    features: ["Quotes and invoices with line items", "Paid, sent and overdue tracking", "Client list", "Printable invoice view", "Totals per status", "CSV export"],
    entities: [
      entity("invoice", "Invoice", "Invoices", ["number*", "client*:ref=client", "issue_date*:date", "due_date:date", "status*:select=Draft|Sent|Paid|Overdue|Cancelled", "items:lines", "tax_rate:percent", "notes:long"], { board: "status", calendar: "due_date", totals: ["items"] }),
      entity("quote", "Quote", "Quotes", ["number*", "client*:ref=client", "issue_date*:date", "valid_until:date", "status*:select=Draft|Sent|Accepted|Declined", "items:lines", "tax_rate:percent", "notes:long"], { board: "status", totals: ["items"] }),
      entity("client", "Client", "Clients", ["name*", "email:email", "phone:phone", "address:long", "tax_id"]),
      entity("payment", "Payment", "Payments", ["reference*", "invoice:ref=invoice", "amount*:money", "date*:date", "method:select=Bank transfer|Card|Cash|Cheque|Other"], { totals: ["amount"], calendar: "date" }),
    ],
  }),
  app({
    slug: "simple-projects", name: "Simple Projects", category: "business",
    tagline: "Simple boards, lists and time tracking for projects.",
    description: "Plan projects, assign tasks on a kanban board, set due dates and priorities, and log time against each task.",
    features: ["Projects with status and deadlines", "Kanban task board", "Priorities and due dates", "Task calendar", "Time log with hour totals"],
    entities: [
      entity("task", "Task", "Tasks", ["title*", "project:ref=project", "status*:select=To do|In progress|Review|Done", "priority:select=Low|Medium|High|Urgent", "assignee:ref=team-hr.employee", "due:date", "description:long"], { board: "status", calendar: "due" }),
      entity("project", "Project", "Projects", ["name*", "client:ref=contacts.company", "status*:select=Planned|Active|On hold|Completed", "start:date", "deadline:date", "budget:money", "description:long"], { board: "status", totals: ["budget"] }),
      entity("time_entry", "Time entry", "Time log", ["description*", "task:ref=task", "date*:date", "hours*:number", "billable:bool"], { totals: ["hours"], calendar: "date" }),
    ],
  }),
  app({
    slug: "inventory", name: "Inventory & Orders", category: "logistics", legacyProductIds: [21, 22, 29, 43],
    tagline: "Stock, suppliers and orders without the spreadsheet.",
    description: "Know what you have and where. Manage products and stock levels, suppliers, purchase orders and sales orders.",
    features: ["Products, SKUs and stock levels", "Reorder levels", "Suppliers", "Purchase and sales orders with line items", "Stock value totals"],
    entities: [
      entity("product", "Product", "Products", ["name*", "sku", "category", "quantity:number", "reorder_level:number", "cost:money", "price:money", "location", "supplier:ref=supplier"], { totals: ["quantity"] }),
      entity("supplier", "Supplier", "Suppliers", ["name*", "contact_name", "email:email", "phone:phone", "address:long"]),
      entity("purchase_order", "Purchase order", "Purchase orders", ["number*", "supplier*:ref=supplier", "date*:date", "status*:select=Draft|Ordered|Received|Cancelled", "items:lines"], { board: "status", totals: ["items"] }),
      entity("sales_order", "Sales order", "Sales orders", ["number*", "customer*", "date*:date", "status*:select=New|Packed|Shipped|Delivered|Cancelled", "items:lines"], { board: "status", totals: ["items"] }),
    ],
  }),
  app({
    slug: "team-hr", name: "Team & HR", category: "hr", legacyProductIds: [37],
    tagline: "Employee directory, leave requests and timesheets.",
    description: "Keep employee records in one place, handle leave requests with approval status, and track timesheets and holidays.",
    features: ["Employee directory", "Leave requests with approval status", "Leave calendar", "Timesheets with hour totals", "Public holidays"],
    entities: [
      entity("employee", "Employee", "Employees", ["name*", "email:email", "phone:phone", "job_title", "department:select=Management|Sales|Operations|Finance|Engineering|Support|Other", "start_date:date", "status:select=Active|On leave|Left", "salary:money"]),
      entity("leave", "Leave request", "Leave requests", ["employee*:ref=employee", "type*:select=Annual|Sick|Unpaid|Parental|Other", "start*:date", "end*:date", "days:number", "status*:select=Requested|Approved|Rejected", "reason:long"], { title: "employee", board: "status", calendar: "start", totals: ["days"], calc: { days: "days(start, end)" } }),
      entity("timesheet", "Timesheet", "Timesheets", ["employee*:ref=employee", "date*:date", "hours*:number", "project:ref=simple-projects.project", "notes"], { title: "employee", calendar: "date", totals: ["hours"] }),
      entity("holiday", "Holiday", "Holidays", ["name*", "date*:date"], { calendar: "date" }),
    ],
  }),
  app({
    slug: "simple-bookings", name: "Simple Bookings", category: "customer-service",
    tagline: "Simple appointments, services and staff calendars.",
    description: "Manage your services, staff and customer appointments on a shared calendar, and track bookings from request to completion.",
    features: ["Services with prices and durations", "Appointment calendar", "Booking status board", "Customer list", "Staff assignments"],
    entities: [
      entity("appointment", "Appointment", "Appointments", ["customer*:ref=customer", "service:ref=service", "staff:ref=team-hr.employee", "when*:datetime", "status*:select=Requested|Confirmed|Completed|Cancelled|No-show", "price:money", "notes:long"], { title: "customer", board: "status", calendar: "when", totals: ["price"] }),
      entity("service", "Service", "Services", ["name*", "duration_minutes:number", "price:money", "description:long"]),
      entity("customer", "Customer", "Customers", ["name*", "email:email", "phone:phone", "notes:long"]),
    ],
  }),
];
