import { app, entity } from "./define";

// Batch A: business, finance, sales, legal, logistics, property and general productivity apps.
export const BATCH_A = [
  // ---------------------------------------------------------------- business
  app({
    slug: "asset-register", name: "Asset Register", category: "business",
    tagline: "Know what equipment you own, where it is and who has it.",
    description: "Record every laptop, tool, vehicle and piece of furniture your business owns. Track who it is assigned to, its value and when it needs servicing.",
    features: ["Asset list with purchase cost and current value", "Assignments to staff and locations", "Service and repair log", "Warranty and service dates on a calendar", "Asset value totals", "CSV import and export"],
    entities: [
      entity("asset", "Asset", "Assets", ["name*", "asset_tag", "category:select=IT equipment|Furniture|Vehicle|Tools|Machinery|Other", "serial_number", "location:ref=location", "assigned_to", "purchase_date:date", "purchase_cost:money", "current_value:money", "warranty_until:date"], { calendar: "warranty_until", totals: ["purchase_cost", "current_value"] }),
      entity("location", "Location", "Locations", ["name*", "address:long", "contact_person", "phone:phone"]),
      entity("service", "Service record", "Service records", ["summary*", "asset*:ref=asset", "date*:date", "type:select=Inspection|Repair|Upgrade|Cleaning|Other", "cost:money", "done_by", "next_due:date", "notes:long"], { calendar: "next_due", totals: ["cost"] }),
    ],
  }),
  app({
    slug: "kanban-board", name: "Kanban Board", category: "business",
    tagline: "Simple boards and cards to see work move from start to finish.",
    description: "Create boards for any kind of work and move cards across columns as things progress. Add due dates, owners and checklists to keep everyone on track.",
    features: ["Multiple boards", "Cards you drag between columns", "Owners, labels and priorities", "Due dates on a calendar", "Comments on each card", "CSV export"],
    entities: [
      entity("card", "Card", "Cards", ["title*", "board*:ref=board", "column*:select=Backlog|To do|Doing|Waiting|Done", "priority:select=Low|Normal|High|Urgent", "label:select=Feature|Fix|Admin|Idea|Other", "owner", "due_date:date", "estimate_hours:number", "description:long"], { board: "column", calendar: "due_date", totals: ["estimate_hours"] }),
      entity("board", "Board", "Boards", ["name*", "purpose:long", "owner", "status:select=Active|Paused|Archived"]),
      entity("comment", "Comment", "Comments", ["text*:long", "card*:ref=card", "author", "posted_at:datetime"], { title: "text" }),
    ],
  }),
  app({
    slug: "time-tracking", name: "Time Tracking", category: "business",
    tagline: "Log hours against clients and projects and see what to bill.",
    description: "Record time spent for each client and project, mark what is billable, and see total hours and value at a glance.",
    features: ["Clients and projects with hourly rates", "Time entries with start date and hours", "Billable and non-billable time", "Time calendar", "Hours and value totals", "CSV export for invoicing"],
    entities: [
      entity("time_entry", "Time entry", "Time entries", ["description*", "project*:ref=project", "date*:date", "start_time:time", "hours*:number", "activity:select=Meeting|Design|Development|Admin|Support|Travel|Other", "billable:bool", "amount:money", "person"], { calendar: "date", totals: ["hours", "amount"] }),
      entity("project", "Project", "Projects", ["name*", "client*:ref=client", "hourly_rate:money", "budget_hours:number", "status:select=Active|On hold|Finished", "deadline:date"], { board: "status", totals: ["budget_hours"] }),
      entity("client", "Client", "Clients", ["name*", "contact_name", "email:email", "phone:phone", "default_rate:money", "notes:long"]),
    ],
  }),
  app({
    slug: "meeting-notes", name: "Meeting Notes", category: "business",
    tagline: "Agendas, notes and action items from every meeting.",
    description: "Keep a record of each meeting with its agenda, decisions and notes. Track the action items that come out of it until they are done.",
    features: ["Meetings on a calendar", "Agenda, notes and decisions", "Action items with owners and due dates", "Action item status board", "Recurring meeting series"],
    entities: [
      entity("meeting", "Meeting", "Meetings", ["title*", "series:ref=series", "when*:datetime", "location", "attendees:long", "agenda:long", "notes:long", "decisions:long"], { calendar: "when" }),
      entity("action", "Action item", "Action items", ["task*", "meeting:ref=meeting", "owner", "due_date:date", "status*:select=Open|In progress|Done|Dropped", "notes:long"], { board: "status", calendar: "due_date" }),
      entity("series", "Meeting series", "Meeting series", ["name*", "frequency:select=Weekly|Fortnightly|Monthly|Quarterly|Ad hoc", "chair", "purpose:long"]),
    ],
  }),
  app({
    slug: "okr-goals", name: "Goals & OKRs", category: "business",
    tagline: "Set objectives, measure key results and check in on progress.",
    description: "Write down what your team wants to achieve each quarter and the numbers that prove it. Record regular check-ins so progress never goes stale.",
    features: ["Objectives by quarter and owner", "Key results with start, target and current values", "Progress status board", "Weekly check-ins with confidence ratings", "Check-in calendar"],
    entities: [
      entity("objective", "Objective", "Objectives", ["title*", "quarter*:select=Q1|Q2|Q3|Q4", "year:number", "owner", "team", "status*:select=Not started|On track|At risk|Off track|Achieved", "why_it_matters:long"], { board: "status" }),
      entity("key_result", "Key result", "Key results", ["title*", "objective*:ref=objective", "start_value:number", "target_value:number", "current_value:number", "unit", "owner", "due_date:date"], { calendar: "due_date" }),
      entity("check_in", "Check-in", "Check-ins", ["key_result*:ref=key_result", "date*:date", "value:number", "confidence:rating", "comment:long"], { title: "key_result", calendar: "date" }),
    ],
  }),
  app({
    slug: "risk-register", name: "Risk Register", category: "business",
    tagline: "List business risks, score them and track what you are doing about them.",
    description: "Write down what could go wrong, how likely and how serious it is, and who owns it. Record the steps you take to reduce each risk and when to review it.",
    features: ["Risks with likelihood and impact", "Risk owners and review dates", "Status board from identified to closed", "Mitigation actions with costs", "Review calendar"],
    entities: [
      entity("risk", "Risk", "Risks", ["title*", "category:select=Financial|Operational|Legal|Reputation|Health & safety|IT & data|Other", "likelihood:select=Rare|Unlikely|Possible|Likely|Almost certain", "impact:select=Minor|Moderate|Major|Severe", "owner", "status*:select=Identified|Assessing|Mitigating|Accepted|Closed", "next_review:date", "description:long"], { board: "status", calendar: "next_review" }),
      entity("mitigation", "Mitigation", "Mitigations", ["action*", "risk*:ref=risk", "owner", "due_date:date", "cost:money", "done:bool", "notes:long"], { calendar: "due_date", totals: ["cost"] }),
    ],
  }),
  app({
    slug: "event-planner", name: "Event Planner", category: "business",
    tagline: "Plan events with guests, tasks and a running budget.",
    description: "Organise launches, workshops and staff parties in one place. Keep the guest list, to-do list and costs together for each event.",
    features: ["Events on a calendar", "Guest list with RSVP status", "Event to-do board", "Budget items with estimated and actual costs", "Cost totals per event"],
    entities: [
      entity("event", "Event", "Events", ["name*", "date*:date", "venue", "capacity:number", "status:select=Idea|Planning|Confirmed|Done|Cancelled", "budget:money", "description:long"], { board: "status", calendar: "date", totals: ["budget"] }),
      entity("guest", "Guest", "Guests", ["name*", "event*:ref=event", "email:email", "phone:phone", "rsvp:select=Invited|Attending|Declined|No reply", "dietary_needs"], { board: "rsvp" }),
      entity("event_task", "Task", "Tasks", ["task*", "event*:ref=event", "owner", "due_date:date", "status*:select=To do|Doing|Done"], { board: "status", calendar: "due_date" }),
      entity("cost", "Cost", "Costs", ["item*", "event*:ref=event", "supplier", "estimated:money", "actual:money", "paid:bool"], { totals: ["estimated", "actual"] }),
    ],
  }),
  app({
    slug: "training-records", name: "Training Records", category: "business",
    tagline: "Track courses, certificates and when they expire.",
    description: "Keep a record of the training each staff member has completed and the certificates they hold. See at a glance what is due for renewal.",
    features: ["Course catalogue with providers and costs", "Training records per person", "Certificate expiry dates on a calendar", "Booking status board", "Training spend totals"],
    entities: [
      entity("record", "Training record", "Training records", ["person*", "course*:ref=course", "status*:select=Planned|Booked|Completed|Expired", "completed_on:date", "expires_on:date", "cost:money", "certificate_number", "notes:long"], { title: "person", board: "status", calendar: "expires_on", totals: ["cost"] }),
      entity("course", "Course", "Courses", ["name*", "provider", "type:select=Health & safety|Compliance|Technical|Soft skills|Induction|Other", "duration_hours:number", "valid_for_months:number", "price:money", "website:url"]),
    ],
  }),

  // ---------------------------------------------------------------- finance
  app({
    slug: "expense-tracker", name: "Expense Tracker", category: "finance",
    tagline: "Record business spending and see where the money goes.",
    description: "Log every business expense with its category, payment method and receipt reference. Group expenses into claims and see totals by status.",
    features: ["Expenses with categories and payment methods", "Expense claims with approval board", "Spending calendar", "Tax amounts recorded separately", "Spending totals", "CSV export for your accountant"],
    entities: [
      entity("expense", "Expense", "Expenses", ["description*", "date*:date", "amount*:money", "tax:money", "category*:select=Travel|Meals|Office|Software|Equipment|Marketing|Utilities|Other", "payee", "method:select=Card|Cash|Bank transfer|Personal (reimburse)", "claim:ref=claim", "receipt_ref", "billable:bool"], { calendar: "date", totals: ["amount", "tax"] }),
      entity("claim", "Expense claim", "Expense claims", ["title*", "employee*", "submitted_on:date", "status*:select=Draft|Submitted|Approved|Paid|Rejected", "total:money", "notes:long"], { board: "status", totals: ["total"] }),
    ],
  }),
  app({
    slug: "purchase-orders", name: "Purchase Orders", category: "finance",
    tagline: "Raise, approve and receive purchase orders with line items.",
    description: "Create purchase orders for your suppliers with itemised lines, follow them through approval and delivery, and record supplier bills against them.",
    features: ["Purchase orders with line items", "Approval and delivery status board", "Supplier list", "Expected delivery dates on a calendar", "Supplier bills linked to orders", "Order value totals"],
    entities: [
      entity("order", "Purchase order", "Purchase orders", ["number*", "supplier*:ref=supplier", "order_date*:date", "expected_date:date", "status*:select=Draft|Awaiting approval|Approved|Sent|Part received|Received|Cancelled", "requested_by", "items:lines", "delivery_address:long", "notes:long"], { board: "status", calendar: "expected_date", totals: ["items"] }),
      entity("supplier", "Supplier", "Suppliers", ["name*", "contact_name", "email:email", "phone:phone", "payment_terms:select=On order|7 days|14 days|30 days|60 days", "address:long"]),
      entity("bill", "Supplier bill", "Supplier bills", ["bill_number*", "order:ref=order", "supplier*:ref=supplier", "bill_date:date", "due_date:date", "amount:money", "paid:bool"], { calendar: "due_date", totals: ["amount"] }),
    ],
  }),
  app({
    slug: "budget-planner", name: "Budget Planner", category: "finance",
    tagline: "Set a budget for each category and compare it with what you spend.",
    description: "Plan monthly or yearly budgets by category, then record actual spending and income against them to see whether you are on target.",
    features: ["Budgets by period", "Budget lines per category with planned amounts", "Actual income and spending entries", "Planned versus actual totals", "Transaction calendar"],
    entities: [
      entity("budget", "Budget", "Budgets", ["name*", "period:select=Monthly|Quarterly|Yearly", "start_date:date", "end_date:date", "owner", "notes:long"]),
      entity("budget_line", "Budget line", "Budget lines", ["category*", "budget*:ref=budget", "type:select=Income|Expense", "planned:money", "notes"], { totals: ["planned"] }),
      entity("actual", "Actual", "Actuals", ["description*", "budget_line*:ref=budget_line", "date*:date", "amount*:money", "reference"], { calendar: "date", totals: ["amount"] }),
    ],
  }),
  app({
    slug: "bank-reconciliation", name: "Bank Reconciliation", category: "finance",
    tagline: "Tick off bank statement lines against your own records.",
    description: "Import or type your bank statement lines, match each one to a record in your books, and see what still needs checking at month end.",
    features: ["Bank accounts with opening balances", "Statement lines with money in and out", "Matched, unmatched and query status board", "Month-end reconciliation periods", "Balance totals", "CSV import of statements"],
    entities: [
      entity("statement_line", "Statement line", "Statement lines", ["description*", "account*:ref=account", "date*:date", "money_in:money", "money_out:money", "status*:select=Unmatched|Matched|Query|Ignored", "matched_to", "period:ref=period", "notes"], { board: "status", calendar: "date", totals: ["money_in", "money_out"] }),
      entity("account", "Bank account", "Bank accounts", ["name*", "bank", "last_four_digits", "currency:select=USD|EUR|GBP|CAD|AUD|Other", "opening_balance:money"], { totals: ["opening_balance"] }),
      entity("period", "Reconciliation", "Reconciliations", ["name*", "account*:ref=account", "period_end*:date", "statement_balance:money", "book_balance:money", "status:select=Open|Reconciled|Signed off", "reconciled_by"], { calendar: "period_end" }),
    ],
  }),
  app({
    slug: "recurring-bills", name: "Subscriptions & Bills", category: "finance",
    tagline: "Never miss a renewal or a regular bill again.",
    description: "List every subscription, utility and regular bill with how often it renews and what it costs. Record each payment and see upcoming renewals on a calendar.",
    features: ["Subscriptions and bills with billing frequency", "Next renewal dates on a calendar", "Active, paused and cancelled board", "Payment history", "Monthly cost totals"],
    entities: [
      entity("subscription", "Subscription", "Subscriptions", ["name*", "vendor", "category:select=Software|Utilities|Insurance|Rent|Phone & internet|Membership|Other", "amount*:money", "frequency*:select=Weekly|Monthly|Quarterly|Yearly", "next_renewal:date", "status*:select=Active|Trial|Paused|Cancelled", "owner", "auto_renews:bool", "notes:long"], { board: "status", calendar: "next_renewal", totals: ["amount"] }),
      entity("bill_payment", "Payment", "Payments", ["subscription*:ref=subscription", "date*:date", "amount*:money", "method:select=Card|Direct debit|Bank transfer|Other", "reference"], { title: "subscription", calendar: "date", totals: ["amount"] }),
    ],
  }),
  app({
    slug: "petty-cash", name: "Petty Cash", category: "finance",
    tagline: "Keep the cash box honest with a simple in-and-out log.",
    description: "Record every top-up and every small cash payment from your petty cash box, and do regular counts to check the cash matches the log.",
    features: ["Cash floats for each box or site", "Cash in and cash out entries", "Receipt references", "Cash count records with differences", "Totals for money in and out"],
    entities: [
      entity("entry", "Cash entry", "Cash entries", ["description*", "float*:ref=float", "date*:date", "type*:select=Top-up|Payment|Refund", "amount*:money", "category:select=Postage|Supplies|Refreshments|Travel|Cleaning|Other", "paid_to", "receipt_ref"], { calendar: "date", totals: ["amount"] }),
      entity("float", "Cash float", "Cash floats", ["name*", "location", "custodian", "float_amount:money"], { totals: ["float_amount"] }),
      entity("count", "Cash count", "Cash counts", ["float*:ref=float", "date*:date", "counted_amount:money", "expected_amount:money", "counted_by", "notes:long"], { title: "float", calendar: "date" }),
    ],
  }),
  app({
    slug: "loans", name: "Loan Tracker", category: "finance",
    tagline: "Track business loans, repayments and what is still owed.",
    description: "Keep every loan, overdraft or equipment finance agreement in one place. Record repayments and see upcoming payment dates.",
    features: ["Loans with lender, rate and term", "Repayment schedule on a calendar", "Principal and interest split", "Loan status board", "Outstanding and repaid totals"],
    entities: [
      entity("loan", "Loan", "Loans", ["name*", "lender*:ref=lender", "type:select=Term loan|Overdraft|Equipment finance|Credit line|Director loan|Other", "principal:money", "interest_rate:percent", "start_date:date", "end_date:date", "monthly_payment:money", "status*:select=Applied|Active|Paid off|Defaulted"], { board: "status", calendar: "end_date", totals: ["principal", "monthly_payment"] }),
      entity("repayment", "Repayment", "Repayments", ["loan*:ref=loan", "due_date*:date", "principal_part:money", "interest_part:money", "paid:bool", "paid_on:date"], { title: "loan", calendar: "due_date", totals: ["principal_part", "interest_part"] }),
      entity("lender", "Lender", "Lenders", ["name*", "contact_name", "email:email", "phone:phone", "notes:long"]),
    ],
  }),
  app({
    slug: "grants", name: "Grant Tracker", category: "finance",
    tagline: "Find, apply for and report on grants and funding.",
    description: "Keep track of funding opportunities, applications and deadlines. Once funded, record how the money is spent and when reports are due.",
    features: ["Funders and opportunities", "Application pipeline board", "Deadlines on a calendar", "Grant spending records", "Requested and awarded totals"],
    entities: [
      entity("application", "Application", "Applications", ["title*", "funder*:ref=funder", "deadline:date", "amount_requested:money", "amount_awarded:money", "status*:select=Researching|Writing|Submitted|Awarded|Declined|Closed", "lead_person", "report_due:date", "notes:long"], { board: "status", calendar: "deadline", totals: ["amount_requested", "amount_awarded"] }),
      entity("funder", "Funder", "Funders", ["name*", "type:select=Government|Foundation|Corporate|Local council|Other", "website:url", "contact_name", "email:email", "focus_areas:long"]),
      entity("grant_spend", "Grant spending", "Grant spending", ["description*", "application*:ref=application", "date*:date", "amount*:money", "budget_category", "receipt_ref"], { calendar: "date", totals: ["amount"] }),
    ],
  }),

  // ---------------------------------------------------------------- sales
  app({
    slug: "sales-leads", name: "Sales Leads", category: "sales",
    tagline: "Capture new leads and work them until they buy or drop out.",
    description: "Collect leads from every source, score how promising they are, and move them through a simple qualification board with follow-ups on a calendar.",
    features: ["Leads with source and score", "Qualification board", "Follow-up tasks on a calendar", "Lead sources with cost tracking", "Estimated value totals", "CSV import"],
    entities: [
      entity("lead", "Lead", "Leads", ["name*", "company", "email:email", "phone:phone", "source:ref=source", "status*:select=New|Contacted|Qualified|Unqualified|Converted", "score:rating", "estimated_value:money", "owner", "notes:long"], { board: "status", totals: ["estimated_value"] }),
      entity("follow_up", "Follow-up", "Follow-ups", ["subject*", "lead*:ref=lead", "due*:datetime", "type:select=Call|Email|Meeting|Visit", "done:bool", "outcome:long"], { calendar: "due" }),
      entity("source", "Lead source", "Lead sources", ["name*", "channel:select=Website|Referral|Event|Advert|Social|Cold outreach|Other", "monthly_cost:money", "notes:long"], { totals: ["monthly_cost"] }),
    ],
  }),
  app({
    slug: "sales-commissions", name: "Sales Commissions", category: "sales",
    tagline: "Work out who earned what on every sale.",
    description: "Record closed sales against each salesperson and commission plan, then track which commissions are approved and paid.",
    features: ["Salespeople and commission plans", "Closed sales with commission amounts", "Approval and payout status board", "Sale date calendar", "Sales and commission totals"],
    entities: [
      entity("sale", "Sale", "Sales", ["reference*", "salesperson*:ref=salesperson", "customer", "close_date*:date", "sale_value*:money", "commission:money", "status*:select=Pending|Approved|Paid|Clawed back", "notes:long"], { board: "status", calendar: "close_date", totals: ["sale_value", "commission"] }),
      entity("salesperson", "Salesperson", "Salespeople", ["name*", "email:email", "plan:ref=plan", "region", "active:bool"]),
      entity("plan", "Commission plan", "Commission plans", ["name*", "rate:percent", "quota:money", "bonus_above_quota:percent", "description:long"]),
    ],
  }),
  app({
    slug: "sales-territories", name: "Sales Territories", category: "sales",
    tagline: "Divide up regions and accounts so every rep knows their patch.",
    description: "Define sales territories, assign reps and accounts to them, and log visits so you can see coverage across every area.",
    features: ["Territories with assigned reps", "Accounts by territory", "Account visit log on a calendar", "Account tier and potential", "Annual potential totals"],
    entities: [
      entity("territory", "Territory", "Territories", ["name*", "region", "rep", "postcodes:long", "annual_target:money"], { totals: ["annual_target"] }),
      entity("account", "Account", "Accounts", ["name*", "territory*:ref=territory", "tier:select=A|B|C", "city", "phone:phone", "annual_potential:money", "last_visit:date"], { totals: ["annual_potential"] }),
      entity("visit", "Visit", "Visits", ["account*:ref=account", "date*:date", "rep", "purpose:select=Prospecting|Review|Order|Complaint|Other", "outcome:long"], { title: "account", calendar: "date" }),
    ],
  }),
  app({
    slug: "affiliate-partners", name: "Affiliate Partners", category: "sales",
    tagline: "Track partners, the sales they refer and what you owe them.",
    description: "Manage your affiliates and referral partners, record the sales they bring in, and keep track of payouts owed and paid.",
    features: ["Partner directory with commission rates", "Partner onboarding board", "Referred sales with commission", "Payout records", "Referred revenue and payout totals"],
    entities: [
      entity("partner", "Partner", "Partners", ["name*", "email:email", "website:url", "referral_code", "commission_rate:percent", "status*:select=Applied|Approved|Active|Paused|Ended", "joined_on:date"], { board: "status" }),
      entity("referral", "Referral", "Referrals", ["customer*", "partner*:ref=partner", "date*:date", "order_value:money", "commission:money", "status:select=Pending|Confirmed|Rejected"], { calendar: "date", totals: ["order_value", "commission"] }),
      entity("payout", "Payout", "Payouts", ["partner*:ref=partner", "date*:date", "amount*:money", "reference", "period"], { title: "partner", calendar: "date", totals: ["amount"] }),
    ],
  }),
  app({
    slug: "price-lists", name: "Price Lists", category: "sales",
    tagline: "One place for your products, prices and customer discounts.",
    description: "Keep a clear catalogue of products and services with standard prices, and set special price lists for different customer groups.",
    features: ["Product and service catalogue", "Cost, price and margin fields", "Price lists for customer groups", "Special prices with valid-until dates", "CSV import and export"],
    entities: [
      entity("item", "Item", "Items", ["name*", "code", "category", "unit:select=Each|Hour|Day|Month|Kg|Metre|Box", "cost:money", "price*:money", "tax_rate:percent", "active:bool", "description:long"]),
      entity("price_list", "Price list", "Price lists", ["name*", "customer_group", "discount:percent", "valid_from:date", "valid_until:date"], { calendar: "valid_until" }),
      entity("special_price", "Special price", "Special prices", ["item*:ref=item", "price_list*:ref=price_list", "price*:money", "min_quantity:number"], { title: "item" }),
    ],
  }),
  app({
    slug: "trade-shows", name: "Trade Shows", category: "sales",
    tagline: "Plan exhibitions and follow up on the leads you meet.",
    description: "Track the trade shows and fairs you attend, what they cost, and every contact collected at the stand so nobody is forgotten afterwards.",
    features: ["Shows on a calendar", "Planning status board", "Stand, travel and booking costs", "Contacts met at each show", "Cost and pipeline totals"],
    entities: [
      entity("show", "Show", "Shows", ["name*", "venue", "city", "start_date*:date", "end_date:date", "status*:select=Considering|Booked|Preparing|Attended|Skipped", "stand_cost:money", "travel_cost:money", "notes:long"], { board: "status", calendar: "start_date", totals: ["stand_cost", "travel_cost"] }),
      entity("contact", "Show contact", "Show contacts", ["name*", "show*:ref=show", "company", "email:email", "phone:phone", "interest:rating", "potential_value:money", "follow_up_by:date", "notes:long"], { calendar: "follow_up_by", totals: ["potential_value"] }),
    ],
  }),
  app({
    slug: "sales-targets", name: "Sales Targets", category: "sales",
    tagline: "Set monthly targets and track results against them.",
    description: "Give each person or team a sales target for the month or quarter, record results as they come in, and compare progress side by side.",
    features: ["Targets per person and period", "Result entries by date", "Target status board", "Target and achieved totals", "CSV export for reporting"],
    entities: [
      entity("target", "Target", "Targets", ["name*", "person", "team", "period*:select=Monthly|Quarterly|Yearly", "start_date:date", "target_amount*:money", "achieved:money", "status:select=On track|Behind|Hit|Missed"], { board: "status", totals: ["target_amount", "achieved"] }),
      entity("result", "Result", "Results", ["description*", "target*:ref=target", "date*:date", "amount*:money", "units:number"], { calendar: "date", totals: ["amount", "units"] }),
    ],
  }),

  // ---------------------------------------------------------------- legal
  app({
    slug: "contracts", name: "Contracts", category: "legal",
    tagline: "Every contract, its key dates and renewals in one place.",
    description: "Store the key details of every contract with customers, suppliers and staff. Get a clear view of what is due for renewal or ending soon.",
    features: ["Contracts with parties, values and terms", "Contract lifecycle board", "Renewal and end dates on a calendar", "Obligations with due dates", "Contract value totals"],
    entities: [
      entity("contract", "Contract", "Contracts", ["title*", "party*:ref=party", "type:select=Customer|Supplier|Employment|Lease|Partnership|Service|Other", "status*:select=Draft|In review|Signed|Active|Expiring|Ended", "start_date:date", "end_date:date", "renewal_date:date", "value:money", "auto_renews:bool", "summary:long"], { board: "status", calendar: "renewal_date", totals: ["value"] }),
      entity("party", "Party", "Parties", ["name*", "type:select=Company|Individual|Public body", "contact_name", "email:email", "address:long"]),
      entity("obligation", "Obligation", "Obligations", ["description*", "contract*:ref=contract", "owner", "due_date:date", "done:bool"], { calendar: "due_date" }),
    ],
  }),
  app({
    slug: "legal-matters", name: "Legal Matters", category: "legal",
    tagline: "Track disputes, claims and legal work from opening to close.",
    description: "Keep each legal matter organised with its parties, key dates, costs and notes, and see every open matter on a single board.",
    features: ["Matters with type, priority and status", "Matter status board", "Key dates and hearings on a calendar", "Legal costs per matter", "Cost and exposure totals"],
    entities: [
      entity("matter", "Matter", "Matters", ["title*", "reference", "type:select=Dispute|Claim|Employment|Regulatory|Property|Corporate|Other", "status*:select=Open|Investigating|In negotiation|In court|Settled|Closed", "priority:select=Low|Medium|High", "opposing_party", "lawyer", "opened_on:date", "estimated_exposure:money", "summary:long"], { board: "status", totals: ["estimated_exposure"] }),
      entity("key_date", "Key date", "Key dates", ["title*", "matter*:ref=matter", "date*:datetime", "type:select=Hearing|Deadline|Meeting|Filing|Other", "notes:long"], { calendar: "date" }),
      entity("cost", "Legal cost", "Legal costs", ["description*", "matter*:ref=matter", "date*:date", "amount*:money", "paid_to", "paid:bool"], { calendar: "date", totals: ["amount"] }),
    ],
  }),
  app({
    slug: "nda-tracker", name: "NDA Tracker", category: "legal",
    tagline: "Know who has signed an NDA, for what and until when.",
    description: "Log every non-disclosure agreement with the other party, the purpose and the expiry date, so you know exactly what is covered.",
    features: ["NDAs with mutual or one-way type", "Signing status board", "Expiry dates on a calendar", "Counterparty list", "CSV export"],
    entities: [
      entity("nda", "NDA", "NDAs", ["title*", "counterparty*:ref=counterparty", "type:select=Mutual|We disclose|They disclose", "purpose:long", "status*:select=Requested|Sent|Signed|Expired|Terminated", "signed_on:date", "expires_on:date", "signed_by", "document_ref"], { board: "status", calendar: "expires_on" }),
      entity("counterparty", "Counterparty", "Counterparties", ["name*", "contact_name", "email:email", "phone:phone", "country"]),
    ],
  }),
  app({
    slug: "compliance-checklist", name: "Compliance Checklist", category: "legal",
    tagline: "Stay on top of licences, filings and regular checks.",
    description: "List the rules and obligations that apply to your business, schedule each check or filing, and record evidence when it is done.",
    features: ["Requirements by area", "Scheduled checks on a calendar", "Check status board", "Evidence notes and sign-off", "Recurring frequency for each requirement"],
    entities: [
      entity("requirement", "Requirement", "Requirements", ["name*", "area:select=Tax|Health & safety|Data protection|Employment|Licensing|Environmental|Other", "frequency:select=One-off|Monthly|Quarterly|Yearly", "owner", "regulator", "description:long"]),
      entity("check", "Check", "Checks", ["requirement*:ref=requirement", "due_date*:date", "status*:select=Upcoming|In progress|Done|Overdue|Not applicable", "completed_on:date", "signed_off_by", "evidence:long"], { title: "requirement", board: "status", calendar: "due_date" }),
    ],
  }),
  app({
    slug: "ip-register", name: "IP & Trademark Register", category: "legal",
    tagline: "Keep track of your trademarks, patents, designs and domains.",
    description: "Record each piece of intellectual property you own with its registration numbers, territories and renewal dates, and the fees paid to keep it.",
    features: ["Trademarks, patents, designs and domains", "Application status board", "Renewal dates on a calendar", "Renewal and filing fees", "Fee totals"],
    entities: [
      entity("ip_right", "IP right", "IP rights", ["name*", "type*:select=Trademark|Patent|Design|Copyright|Domain name", "registration_number", "territory", "status*:select=Idea|Filed|Pending|Registered|Lapsed|Abandoned", "filed_on:date", "renewal_date:date", "owner", "notes:long"], { board: "status", calendar: "renewal_date" }),
      entity("fee", "Fee", "Fees", ["description*", "ip_right*:ref=ip_right", "date*:date", "amount*:money", "paid_to"], { calendar: "date", totals: ["amount"] }),
    ],
  }),
  app({
    slug: "document-register", name: "Document Register", category: "legal",
    tagline: "Know which version of each important document is current.",
    description: "Keep a register of your important documents with owners, versions and where each one is stored. Plan reviews so nothing goes out of date.",
    features: ["Documents with type, owner and storage location", "Version history", "Approval status board", "Review dates on a calendar", "CSV export"],
    entities: [
      entity("document", "Document", "Documents", ["title*", "reference", "type:select=Policy|Procedure|Form|Certificate|Agreement|Report|Other", "owner", "status*:select=Draft|In review|Approved|Superseded|Archived", "current_version", "stored_at:url", "next_review:date", "confidential:bool"], { board: "status", calendar: "next_review" }),
      entity("version", "Version", "Versions", ["version*", "document*:ref=document", "date*:date", "author", "changes:long"], { calendar: "date" }),
    ],
  }),
  app({
    slug: "policy-library", name: "Policy Library", category: "legal",
    tagline: "Publish company policies and record who has read them.",
    description: "Write and store your workplace policies in one place, and keep a record of which staff have read and accepted each one.",
    features: ["Policies with full text", "Policy categories and owners", "Draft-to-published board", "Staff acknowledgements", "Review dates on a calendar"],
    entities: [
      entity("policy", "Policy", "Policies", ["title*", "category:select=HR|Health & safety|IT|Finance|Conduct|Data|Other", "owner", "status*:select=Draft|Published|Under review|Retired", "effective_from:date", "review_by:date", "body:long"], { board: "status", calendar: "review_by" }),
      entity("acknowledgement", "Acknowledgement", "Acknowledgements", ["person*", "policy*:ref=policy", "accepted_on*:date", "notes"], { calendar: "accepted_on" }),
    ],
  }),

  // ---------------------------------------------------------------- logistics
  app({
    slug: "shipments", name: "Shipments", category: "logistics",
    tagline: "Follow every parcel and pallet from dispatch to delivery.",
    description: "Log outgoing and incoming shipments with carrier, tracking number and costs, and see where each one is on a simple status board.",
    features: ["Shipments with tracking numbers", "Status board from booked to delivered", "Expected delivery dates on a calendar", "Carriers list", "Packages per shipment", "Shipping cost totals"],
    entities: [
      entity("shipment", "Shipment", "Shipments", ["reference*", "direction:select=Outbound|Inbound|Return", "carrier:ref=carrier", "tracking_number", "recipient", "destination:long", "ship_date:date", "expected_delivery:date", "status*:select=Booked|Collected|In transit|Delayed|Delivered|Exception", "cost:money"], { board: "status", calendar: "expected_delivery", totals: ["cost"] }),
      entity("package", "Package", "Packages", ["label*", "shipment*:ref=shipment", "weight_kg:number", "dimensions", "contents:long"], { totals: ["weight_kg"] }),
      entity("carrier", "Carrier", "Carriers", ["name*", "account_number", "phone:phone", "website:url", "rating:rating"]),
    ],
  }),
  app({
    slug: "fleet-vehicles", name: "Fleet & Vehicles", category: "logistics",
    tagline: "Vehicles, drivers, fuel and servicing in one place.",
    description: "Keep track of every company vehicle with its driver, mileage, fuel costs and service history, and never miss an insurance or inspection date.",
    features: ["Vehicle list with registration and driver", "Fuel log with litres and cost", "Service and repair history", "Insurance and inspection dates on a calendar", "Fuel and maintenance totals"],
    entities: [
      entity("vehicle", "Vehicle", "Vehicles", ["registration*", "make_model", "type:select=Car|Van|Truck|Motorbike|Other", "driver:ref=driver", "mileage:number", "status:select=In use|Spare|In repair|Sold", "insurance_due:date", "inspection_due:date"], { board: "status", calendar: "inspection_due" }),
      entity("driver", "Driver", "Drivers", ["name*", "phone:phone", "licence_number", "licence_expiry:date"], { calendar: "licence_expiry" }),
      entity("fuel", "Fuel entry", "Fuel log", ["vehicle*:ref=vehicle", "date*:date", "litres:number", "cost*:money", "odometer:number"], { title: "vehicle", calendar: "date", totals: ["litres", "cost"] }),
      entity("maintenance", "Maintenance", "Maintenance", ["work_done*", "vehicle*:ref=vehicle", "date*:date", "garage", "cost:money", "next_service:date"], { calendar: "date", totals: ["cost"] }),
    ],
  }),
  app({
    slug: "warehouse-bins", name: "Warehouse Bins", category: "logistics",
    tagline: "Know exactly which shelf and bin every item lives in.",
    description: "Map out your warehouse zones and bin locations, record which items are in each bin, and log stock moves between locations.",
    features: ["Zones and bin locations", "Stock per bin with quantities", "Stock movement log", "Bin capacity tracking", "Quantity totals"],
    entities: [
      entity("bin", "Bin", "Bins", ["code*", "zone*:ref=zone", "aisle", "shelf", "capacity:number", "type:select=Shelf|Pallet|Floor|Cold|Hazardous"]),
      entity("zone", "Zone", "Zones", ["name*", "purpose:select=Receiving|Storage|Picking|Packing|Dispatch|Returns", "notes:long"]),
      entity("bin_stock", "Bin stock", "Bin stock", ["item*", "bin*:ref=bin", "sku", "quantity*:number", "last_counted:date"], { totals: ["quantity"] }),
      entity("move", "Stock move", "Stock moves", ["item*", "from_bin:ref=bin", "to_bin:ref=bin", "quantity*:number", "moved_at:datetime", "moved_by"], { calendar: "moved_at", totals: ["quantity"] }),
    ],
  }),
  app({
    slug: "delivery-routes", name: "Delivery Routes", category: "logistics",
    tagline: "Plan daily delivery runs and record each drop.",
    description: "Group your deliveries into routes for each driver and day, set the order of stops, and record whether each drop was completed.",
    features: ["Routes by date and driver", "Stops with address and time window", "Delivery status board", "Route calendar", "Parcel and distance totals"],
    entities: [
      entity("route", "Route", "Routes", ["name*", "date*:date", "driver", "vehicle", "distance_km:number", "status:select=Planned|Out for delivery|Completed"], { board: "status", calendar: "date", totals: ["distance_km"] }),
      entity("stop", "Stop", "Stops", ["customer*", "route*:ref=route", "stop_order:number", "address*:long", "phone:phone", "window_from:time", "window_to:time", "parcels:number", "status*:select=Pending|Delivered|Failed|Rescheduled", "notes"], { board: "status", totals: ["parcels"] }),
    ],
  }),
  app({
    slug: "returns-rma", name: "Returns (RMA)", category: "logistics",
    tagline: "Handle customer returns from request to refund.",
    description: "Log each return request with its reason and items, track it through receiving and inspection, and record the outcome as refund, repair or replacement.",
    features: ["Return requests with RMA numbers", "Return status board", "Returned items with condition", "Refund amounts", "Received dates on a calendar"],
    entities: [
      entity("rma", "Return", "Returns", ["rma_number*", "customer*", "order_number", "reason:select=Damaged|Wrong item|Not as described|Faulty|Changed mind|Other", "status*:select=Requested|Approved|Received|Inspected|Refunded|Replaced|Rejected", "requested_on:date", "received_on:date", "refund_amount:money", "notes:long"], { board: "status", calendar: "received_on", totals: ["refund_amount"] }),
      entity("return_item", "Returned item", "Returned items", ["item*", "rma*:ref=rma", "sku", "quantity:number", "condition:select=Resellable|Repairable|Scrap", "restocked:bool"], { totals: ["quantity"] }),
    ],
  }),
  app({
    slug: "supplier-scorecard", name: "Supplier Scorecard", category: "logistics",
    tagline: "Rate suppliers on delivery, quality and price.",
    description: "Score your suppliers after each delivery or review, record problems, and see which suppliers you can rely on.",
    features: ["Supplier list with categories", "Reviews with star ratings", "Supplier issues board", "Review calendar", "Issue cost totals"],
    entities: [
      entity("supplier", "Supplier", "Suppliers", ["name*", "category", "contact_name", "email:email", "phone:phone", "status:select=Approved|On trial|On watch|Blocked", "overall_rating:rating"], { board: "status" }),
      entity("review", "Review", "Reviews", ["supplier*:ref=supplier", "date*:date", "on_time:rating", "quality:rating", "price:rating", "communication:rating", "comments:long"], { title: "supplier", calendar: "date" }),
      entity("issue", "Issue", "Issues", ["summary*", "supplier*:ref=supplier", "date:date", "type:select=Late|Damaged|Wrong item|Short|Invoice error|Other", "cost_impact:money", "status*:select=Open|Raised with supplier|Resolved"], { board: "status", totals: ["cost_impact"] }),
    ],
  }),
  app({
    slug: "freight-quotes", name: "Freight Quotes", category: "logistics",
    tagline: "Compare carrier quotes and book the best one.",
    description: "Record freight requests, collect quotes from several carriers, and compare prices and transit times before booking.",
    features: ["Freight requests with origin and destination", "Quotes from multiple carriers", "Request status board", "Pickup dates on a calendar", "Quoted price totals"],
    entities: [
      entity("request", "Freight request", "Freight requests", ["reference*", "origin*", "destination*", "pickup_date:date", "weight_kg:number", "pallets:number", "mode:select=Road|Sea|Air|Rail|Courier", "status*:select=Gathering quotes|Booked|Shipped|Cancelled", "notes:long"], { board: "status", calendar: "pickup_date", totals: ["weight_kg", "pallets"] }),
      entity("quote", "Quote", "Quotes", ["carrier*", "request*:ref=request", "price*:money", "transit_days:number", "valid_until:date", "chosen:bool", "notes"], { title: "carrier", totals: ["price"] }),
    ],
  }),

  // ---------------------------------------------------------------- property
  app({
    slug: "property-listings", name: "Property Listings", category: "property",
    tagline: "Manage properties for sale or rent and the people interested.",
    description: "Keep every listing with its price, features and status, and record enquiries and offers from buyers and renters.",
    features: ["Listings with price, bedrooms and size", "Listing status board", "Enquiries from buyers and renters", "Offers with amounts", "Listing value totals"],
    entities: [
      entity("listing", "Listing", "Listings", ["title*", "address*:long", "type:select=House|Apartment|Commercial|Land|Other", "deal_type:select=For sale|For rent", "price:money", "bedrooms:number", "size_sqm:number", "status*:select=Preparing|Live|Under offer|Sold|Let|Withdrawn", "listed_on:date", "description:long"], { board: "status", calendar: "listed_on", totals: ["price"] }),
      entity("enquiry", "Enquiry", "Enquiries", ["name*", "listing*:ref=listing", "email:email", "phone:phone", "date:date", "budget:money", "notes:long"], { calendar: "date" }),
      entity("offer", "Offer", "Offers", ["buyer*", "listing*:ref=listing", "amount*:money", "date*:date", "status*:select=Received|Countered|Accepted|Rejected|Withdrawn", "conditions:long"], { board: "status", totals: ["amount"] }),
    ],
  }),
  app({
    slug: "tenants-leases", name: "Tenants & Leases", category: "property",
    tagline: "Tenants, units and lease terms for every property you manage.",
    description: "Record your properties and units, the tenants who live or trade there, and each lease with its rent, deposit and key dates.",
    features: ["Properties and units", "Tenant directory", "Leases with rent and deposit", "Lease end dates on a calendar", "Lease status board", "Monthly rent totals"],
    entities: [
      entity("lease", "Lease", "Leases", ["reference*", "unit*:ref=unit", "tenant*:ref=tenant", "start_date*:date", "end_date:date", "monthly_rent*:money", "deposit:money", "status*:select=Draft|Active|Notice given|Ended|Renewed", "terms:long"], { board: "status", calendar: "end_date", totals: ["monthly_rent", "deposit"] }),
      entity("tenant", "Tenant", "Tenants", ["name*", "email:email", "phone:phone", "emergency_contact", "notes:long"]),
      entity("unit", "Unit", "Units", ["name*", "property*:ref=property", "bedrooms:number", "size_sqm:number", "status:select=Occupied|Vacant|Under repair"], { board: "status" }),
      entity("property", "Property", "Properties", ["name*", "address*:long", "type:select=Residential|Commercial|Mixed use", "owner", "purchase_price:money"], { totals: ["purchase_price"] }),
    ],
  }),
  app({
    slug: "maintenance-requests", name: "Maintenance Requests", category: "property",
    tagline: "Log repairs, assign contractors and close jobs out.",
    description: "Capture each repair or maintenance request with its location and urgency, assign a contractor, and track the job and its cost to completion.",
    features: ["Requests with priority and location", "Job status board", "Contractor directory", "Scheduled visits on a calendar", "Repair cost totals"],
    entities: [
      entity("request", "Request", "Requests", ["title*", "property*", "unit", "reported_by", "reported_on:date", "category:select=Plumbing|Electrical|Heating|Appliance|Structural|Pest|Other", "priority*:select=Low|Normal|Urgent|Emergency", "status*:select=New|Assigned|Scheduled|In progress|Done|Cancelled", "contractor:ref=contractor", "scheduled_for:datetime"], { board: "status", calendar: "scheduled_for" }),
      entity("contractor", "Contractor", "Contractors", ["name*", "trade", "phone:phone", "email:email", "hourly_rate:money", "rating:rating"]),
      entity("work_log", "Work log", "Work logs", ["summary*", "request*:ref=request", "date*:date", "hours:number", "cost:money", "notes:long"], { calendar: "date", totals: ["hours", "cost"] }),
    ],
  }),
  app({
    slug: "rent-collection", name: "Rent Collection", category: "property",
    tagline: "See who has paid, who is late and what is outstanding.",
    description: "Set the rent due for each tenancy, record payments as they arrive, and keep a clear list of arrears to follow up.",
    features: ["Rent charges by tenancy and month", "Due dates on a calendar", "Paid, part-paid and late board", "Payment records", "Rent due and received totals"],
    entities: [
      entity("charge", "Rent charge", "Rent charges", ["period*", "tenancy*:ref=tenancy", "due_date*:date", "amount*:money", "status*:select=Due|Paid|Part paid|Late|Written off"], { board: "status", calendar: "due_date", totals: ["amount"] }),
      entity("rent_payment", "Payment", "Payments", ["tenancy*:ref=tenancy", "charge:ref=charge", "date*:date", "amount*:money", "method:select=Bank transfer|Standing order|Card|Cash|Cheque", "reference"], { title: "tenancy", calendar: "date", totals: ["amount"] }),
      entity("tenancy", "Tenancy", "Tenancies", ["name*", "tenant_name", "property_address:long", "monthly_rent:money", "rent_day:number", "phone:phone", "email:email"], { totals: ["monthly_rent"] }),
    ],
  }),
  app({
    slug: "property-viewings", name: "Property Viewings", category: "property",
    tagline: "Book viewings and capture feedback from every visit.",
    description: "Schedule property viewings with prospective buyers or tenants, assign an agent, and record feedback and interest after each visit.",
    features: ["Viewings on a calendar", "Viewing status board", "Prospects with budget and requirements", "Feedback and interest rating", "Property list"],
    entities: [
      entity("viewing", "Viewing", "Viewings", ["prospect*:ref=prospect", "property*:ref=property", "when*:datetime", "agent", "status*:select=Requested|Confirmed|Done|No-show|Cancelled", "interest:rating", "feedback:long"], { title: "prospect", board: "status", calendar: "when" }),
      entity("prospect", "Prospect", "Prospects", ["name*", "email:email", "phone:phone", "looking_to:select=Buy|Rent", "budget:money", "requirements:long"]),
      entity("property", "Property", "Properties", ["address*", "type:select=House|Apartment|Commercial|Other", "asking_price:money", "available:bool"]),
    ],
  }),
  app({
    slug: "property-inspections", name: "Property Inspections", category: "property",
    tagline: "Move-in, move-out and routine inspections, room by room.",
    description: "Plan inspections for each property, record the condition of every room, and note issues that need follow-up work.",
    features: ["Inspections on a calendar", "Inspection type and status board", "Room-by-room condition ratings", "Follow-up flags", "Inspection history per property"],
    entities: [
      entity("inspection", "Inspection", "Inspections", ["property*", "type*:select=Move-in|Routine|Move-out|Safety", "date*:date", "inspector", "tenant", "status*:select=Scheduled|Done|Report sent|Cancelled", "summary:long"], { title: "property", board: "status", calendar: "date" }),
      entity("room_check", "Room check", "Room checks", ["room*", "inspection*:ref=inspection", "condition:rating", "cleanliness:rating", "needs_work:bool", "notes:long"]),
    ],
  }),
  app({
    slug: "utility-meters", name: "Utility Meters", category: "property",
    tagline: "Record meter readings and utility costs for each property.",
    description: "Keep a list of the gas, electricity and water meters at each property, log readings over time and record the bills they produce.",
    features: ["Meters by property and utility", "Meter readings by date", "Utility bills with amounts", "Reading calendar", "Usage and cost totals"],
    entities: [
      entity("meter", "Meter", "Meters", ["serial_number*", "property*", "utility*:select=Electricity|Gas|Water|Heat|Other", "supplier", "location"]),
      entity("reading", "Reading", "Readings", ["meter*:ref=meter", "date*:date", "value*:number", "usage:number", "taken_by", "type:select=Actual|Estimated"], { title: "meter", calendar: "date", totals: ["usage"] }),
      entity("utility_bill", "Utility bill", "Utility bills", ["reference*", "meter*:ref=meter", "period_from:date", "period_to:date", "amount*:money", "paid:bool", "recharged_to_tenant:bool"], { calendar: "period_to", totals: ["amount"] }),
    ],
  }),

  // ---------------------------------------------------------------- application
  app({
    slug: "wiki", name: "Team Wiki", category: "application",
    tagline: "A simple knowledge base your whole team can write in.",
    description: "Organise how-tos, processes and reference notes into spaces and pages so everyone can find answers without asking around.",
    features: ["Spaces to group related pages", "Pages with long-form text", "Draft and published status", "Page owners and last-reviewed dates", "Search and CSV export"],
    entities: [
      entity("page", "Page", "Pages", ["title*", "space*:ref=space", "status*:select=Draft|Published|Needs update|Archived", "owner", "tags", "last_reviewed:date", "body:long"], { board: "status", calendar: "last_reviewed" }),
      entity("space", "Space", "Spaces", ["name*", "description:long", "owner", "visibility:select=Everyone|Team only"]),
    ],
  }),
  app({
    slug: "bug-tracker", name: "Bug Tracker", category: "application",
    tagline: "Report, prioritise and fix bugs in your software or website.",
    description: "Log each bug with steps to reproduce, severity and who is fixing it, and follow it across a board until it is released.",
    features: ["Bug reports with severity and steps to reproduce", "Fix status board", "Components and releases", "Release dates on a calendar", "Estimate totals"],
    entities: [
      entity("bug", "Bug", "Bugs", ["title*", "component:ref=component", "release:ref=release", "severity*:select=Minor|Major|Critical|Blocker", "status*:select=New|Confirmed|In progress|In review|Fixed|Won't fix", "reported_by", "assignee", "estimate_hours:number", "steps_to_reproduce:long"], { board: "status", totals: ["estimate_hours"] }),
      entity("component", "Component", "Components", ["name*", "owner", "description:long"]),
      entity("release", "Release", "Releases", ["version*", "release_date:date", "status:select=Planned|In testing|Released", "notes:long"], { calendar: "release_date" }),
    ],
  }),
  app({
    slug: "notes", name: "Notes", category: "application",
    tagline: "Quick notes in notebooks, easy to find again.",
    description: "Jot down ideas, call notes and reminders, file them into notebooks, and pin the ones you need most.",
    features: ["Notebooks to organise notes", "Long-form notes with tags", "Pinned notes", "Reminder dates on a calendar", "CSV export"],
    entities: [
      entity("note", "Note", "Notes", ["title*", "notebook:ref=notebook", "body:long", "tags", "pinned:bool", "remind_on:date", "colour:select=None|Yellow|Green|Blue|Pink"], { calendar: "remind_on" }),
      entity("notebook", "Notebook", "Notebooks", ["name*", "description:long", "archived:bool"]),
    ],
  }),
  app({
    slug: "bookmarks", name: "Bookmarks", category: "application",
    tagline: "Save useful links for your team in tidy collections.",
    description: "Collect the websites, tools and resources your team uses, group them into collections, and rate the most useful ones.",
    features: ["Links with titles and descriptions", "Collections", "Ratings and favourites", "Read-later status", "CSV import and export"],
    entities: [
      entity("bookmark", "Bookmark", "Bookmarks", ["title*", "url*:url", "collection:ref=collection", "description:long", "tags", "rating:rating", "favourite:bool", "status:select=To read|Read|Reference"], { board: "status" }),
      entity("collection", "Collection", "Collections", ["name*", "description:long", "owner", "shared:bool"]),
    ],
  }),
  app({
    slug: "habit-tracker", name: "Habit Tracker", category: "application",
    tagline: "Build good routines by checking them off each day.",
    description: "Set the habits you want to keep, such as daily planning or weekly reviews, and log each time you do them to see your streaks.",
    features: ["Habits with frequency and goal", "Daily check-ins on a calendar", "Minutes or count per check-in", "Mood rating", "Totals per habit"],
    entities: [
      entity("habit", "Habit", "Habits", ["name*", "frequency*:select=Daily|Weekdays|Weekly|Monthly", "goal_per_period:number", "area:select=Work|Health|Learning|Finance|Personal", "started_on:date", "active:bool"]),
      entity("check_in", "Check-in", "Check-ins", ["habit*:ref=habit", "date*:date", "done:bool", "amount:number", "mood:rating", "note"], { title: "habit", calendar: "date", totals: ["amount"] }),
    ],
  }),
  app({
    slug: "reading-list", name: "Reading List", category: "application",
    tagline: "Track the books and articles your team wants to read.",
    description: "Keep a shared list of books, articles and courses, track what is being read and by whom, and leave ratings and key takeaways.",
    features: ["Books and articles with authors", "To read, reading and finished board", "Ratings and takeaways", "Finish dates on a calendar", "Page count totals"],
    entities: [
      entity("item", "Reading item", "Reading items", ["title*", "author", "type:select=Book|Article|Report|Course|Podcast", "shelf:ref=shelf", "status*:select=To read|Reading|Finished|Abandoned", "reader", "pages:number", "finished_on:date", "rating:rating", "takeaways:long"], { board: "status", calendar: "finished_on", totals: ["pages"] }),
      entity("shelf", "Shelf", "Shelves", ["name*", "description:long"]),
    ],
  }),
];
