import { app, entity } from "./define";

// Catalogue batch B: hr, healthcare, hospitality, education, customer-service, marketing, community.
export const BATCH_B = [
  // ───────────── HR ─────────────
  app({
    slug: "payroll-attendance", name: "Payroll & Attendance", category: "hr",
    tagline: "Clock-ins, hours worked and pay runs in one place.",
    description: "Record daily attendance for each employee, total up hours and overtime, and keep a simple record of every pay run with gross pay, deductions and net pay.",
    features: ["Employee list with pay rates", "Daily attendance with hours and overtime", "Attendance calendar", "Pay run records with gross, deductions and net", "Hour and pay totals", "CSV export for your accountant"],
    entities: [
      entity("employee", "Employee", "Employees", ["name*", "employee_number", "job_title", "pay_type:select=Hourly|Salaried", "hourly_rate:money", "monthly_salary:money", "start_date:date", "status:select=Active|On leave|Left"]),
      entity("attendance", "Attendance", "Attendance", ["employee*:ref=employee", "date*:date", "clock_in:time", "clock_out:time", "hours_worked:number", "overtime_hours:number", "status:select=Present|Late|Absent|Holiday|Sick", "notes"], { title: "employee", calendar: "date", totals: ["hours_worked", "overtime_hours"] }),
      entity("pay_run", "Pay run", "Pay runs", ["employee*:ref=employee", "period_start*:date", "period_end*:date", "gross_pay*:money", "deductions:money", "net_pay:money", "pay_date:date", "status*:select=Draft|Approved|Paid"], { title: "employee", board: "status", calendar: "pay_date", totals: ["gross_pay", "deductions", "net_pay"] }),
    ],
  }),
  app({
    slug: "leave-management", name: "Leave Management", category: "hr",
    tagline: "Leave requests, approvals and a team absence calendar.",
    description: "Set up your leave types and allowances, let managers approve or reject requests on a board, and see who is away on a shared calendar.",
    features: ["Employees with yearly allowances", "Leave types such as annual, sick and unpaid", "Request approval board", "Team absence calendar", "Days taken totals", "Public holiday list"],
    entities: [
      entity("employee", "Employee", "Employees", ["name*", "email:email", "department:select=Management|Sales|Operations|Finance|Support|Other", "manager", "annual_allowance_days:number", "start_date:date", "status:select=Active|Left"], { totals: ["annual_allowance_days"] }),
      entity("leave_type", "Leave type", "Leave types", ["name*", "paid:bool", "needs_approval:bool", "default_days_per_year:number", "notes:long"]),
      entity("request", "Leave request", "Leave requests", ["employee*:ref=employee", "leave_type*:ref=leave_type", "start_date*:date", "end_date*:date", "days*:number", "half_day:bool", "status*:select=Requested|Approved|Rejected|Cancelled", "approved_by", "reason:long"], { title: "employee", board: "status", calendar: "start_date", totals: ["days"] }),
      entity("holiday", "Public holiday", "Public holidays", ["name*", "date*:date", "region"], { calendar: "date" }),
    ],
  }),
  app({
    slug: "recruiting", name: "Recruiting", category: "hr",
    tagline: "Job openings and candidates moving through your hiring stages.",
    description: "Post your open roles, track every applicant from first application to offer on a hiring board, and keep interview notes and scores together.",
    features: ["Job openings with salary range and status", "Candidate pipeline board", "Interview schedule calendar", "Interview scores and notes", "Source tracking for applicants"],
    entities: [
      entity("job", "Job opening", "Job openings", ["title*", "department", "location", "employment_type:select=Full-time|Part-time|Contract|Temporary|Internship", "salary_from:money", "salary_to:money", "openings:number", "closing_date:date", "status*:select=Draft|Open|On hold|Filled|Closed"], { board: "status", calendar: "closing_date", totals: ["openings"] }),
      entity("candidate", "Candidate", "Candidates", ["name*", "job*:ref=job", "email:email", "phone:phone", "source:select=Job board|Referral|Website|Agency|Social media|Other", "stage*:select=Applied|Screening|Interview|Offer|Hired|Rejected", "cv_link:url", "rating:rating", "notes:long"], { board: "stage" }),
      entity("interview", "Interview", "Interviews", ["candidate*:ref=candidate", "when*:datetime", "interviewer", "format:select=Phone|Video|In person", "score:rating", "recommendation:select=Strong yes|Yes|No|Strong no", "feedback:long"], { title: "candidate", calendar: "when" }),
    ],
  }),
  app({
    slug: "onboarding", name: "Employee Onboarding", category: "hr",
    tagline: "Checklists that get every new starter set up properly.",
    description: "Track each new hire's start date and work through their onboarding tasks, from contracts and equipment to training and first-week meetings.",
    features: ["New starters with start dates", "Onboarding task board", "Due dates on a calendar", "Task owners and categories", "Equipment issued log"],
    entities: [
      entity("new_hire", "New hire", "New hires", ["name*", "job_title", "manager", "start_date*:date", "email:email", "status*:select=Offer accepted|Pre-start|First week|Settling in|Complete"], { board: "status", calendar: "start_date" }),
      entity("task", "Onboarding task", "Onboarding tasks", ["title*", "new_hire*:ref=new_hire", "category:select=Paperwork|IT & equipment|Training|Introductions|Policies|Other", "owner", "due_date:date", "status*:select=To do|In progress|Done", "notes:long"], { board: "status", calendar: "due_date" }),
      entity("equipment", "Equipment issued", "Equipment issued", ["item*", "new_hire*:ref=new_hire", "serial_number", "value:money", "issued_on:date", "returned:bool"], { totals: ["value"] }),
    ],
  }),
  app({
    slug: "performance-reviews", name: "Performance Reviews", category: "hr",
    tagline: "Review cycles, goals and feedback for every team member.",
    description: "Run regular reviews with ratings and written feedback, set goals with target dates, and keep a history of each person's progress.",
    features: ["Review records with ratings", "Review status board", "Goals with progress and target dates", "Goal calendar", "One-to-one meeting notes"],
    entities: [
      entity("employee", "Employee", "Employees", ["name*", "job_title", "department", "manager", "start_date:date"]),
      entity("review", "Review", "Reviews", ["employee*:ref=employee", "period*", "reviewer", "review_date:date", "overall_rating:rating", "strengths:long", "improvements:long", "status*:select=Scheduled|Self review|Manager review|Completed"], { title: "employee", board: "status", calendar: "review_date" }),
      entity("goal", "Goal", "Goals", ["title*", "employee*:ref=employee", "target_date:date", "progress:percent", "status*:select=Not started|On track|At risk|Achieved|Dropped", "details:long"], { board: "status", calendar: "target_date" }),
      entity("one_to_one", "One-to-one", "One-to-ones", ["employee*:ref=employee", "date*:date", "topics:long", "actions:long"], { title: "employee", calendar: "date" }),
    ],
  }),
  app({
    slug: "shift-rota", name: "Shift Rota", category: "hr",
    tagline: "Plan staff shifts and swaps on a simple calendar.",
    description: "Build your weekly rota by adding shifts for each staff member, handle swap requests, and see total scheduled hours at a glance.",
    features: ["Staff list with roles and contracted hours", "Shift calendar", "Shift status board", "Swap requests with approval status", "Scheduled hour totals"],
    entities: [
      entity("staff", "Staff member", "Staff", ["name*", "role:select=Manager|Supervisor|Team member|Trainee", "phone:phone", "contracted_hours:number", "hourly_rate:money", "status:select=Active|Inactive"]),
      entity("shift", "Shift", "Shifts", ["staff*:ref=staff", "date*:date", "start_time*:time", "end_time*:time", "hours:number", "location", "status*:select=Draft|Published|Worked|Missed"], { title: "staff", board: "status", calendar: "date", totals: ["hours"] }),
      entity("swap", "Swap request", "Swap requests", ["shift*:ref=shift", "requested_by*:ref=staff", "cover_by:ref=staff", "reason", "status*:select=Requested|Approved|Declined"], { title: "shift", board: "status" }),
    ],
  }),
  app({
    slug: "expense-claims", name: "Expense Claims", category: "hr",
    tagline: "Staff expenses submitted, approved and reimbursed.",
    description: "Staff log expense claims with itemised costs and receipts, managers approve them on a board, and you can see what is still to be reimbursed.",
    features: ["Itemised expense claims", "Approval board from submitted to reimbursed", "Expense categories", "Mileage log", "Claim totals by status", "CSV export"],
    entities: [
      entity("claim", "Expense claim", "Expense claims", ["reference*", "employee*", "date*:date", "category:select=Travel|Meals|Accommodation|Supplies|Training|Other", "items:lines", "receipt_link:url", "status*:select=Draft|Submitted|Approved|Rejected|Reimbursed", "notes:long"], { board: "status", calendar: "date", totals: ["items"] }),
      entity("mileage", "Mileage trip", "Mileage", ["purpose*", "employee*", "date*:date", "from_place", "to_place", "miles:number", "rate_per_mile:money", "amount:money"], { calendar: "date", totals: ["miles", "amount"] }),
    ],
  }),

  // ───────────── Healthcare ─────────────
  app({
    slug: "clinic", name: "Clinic Records", category: "healthcare",
    tagline: "Patients, appointments and visit notes for a small clinic.",
    description: "Keep patient details, book appointments on a calendar, and record each visit with notes and prescriptions given. A record-keeping tool for your practice.",
    features: ["Patient records with contact details", "Appointment calendar and status board", "Visit notes with diagnosis and fees", "Prescription records", "Fee totals"],
    entities: [
      entity("patient", "Patient", "Patients", ["name*", "date_of_birth:date", "gender:select=Female|Male|Other|Prefer not to say", "phone:phone", "email:email", "address:long", "allergies:long", "emergency_contact"]),
      entity("appointment", "Appointment", "Appointments", ["patient*:ref=patient", "when*:datetime", "practitioner", "reason", "status*:select=Booked|Arrived|Seen|Cancelled|No-show"], { title: "patient", board: "status", calendar: "when" }),
      entity("visit", "Visit", "Visits", ["patient*:ref=patient", "date*:date", "practitioner", "complaint", "diagnosis:long", "treatment:long", "fee:money", "follow_up_date:date"], { title: "patient", calendar: "date", totals: ["fee"] }),
      entity("prescription", "Prescription", "Prescriptions", ["medicine*", "patient*:ref=patient", "visit:ref=visit", "dosage", "frequency", "duration_days:number", "issued_on:date"], { calendar: "issued_on" }),
    ],
  }),
  app({
    slug: "dental", name: "Dental Practice", category: "healthcare",
    tagline: "Patients, chair appointments and treatment plans.",
    description: "Manage your dental patients, book appointments by chair and dentist, and track treatment plans with itemised costs from proposed to completed.",
    features: ["Patient list with recall dates", "Appointment calendar", "Treatment plans with itemised costs", "Treatment status board", "Recall reminders on a calendar"],
    entities: [
      entity("patient", "Patient", "Patients", ["name*", "date_of_birth:date", "phone:phone", "email:email", "last_check_up:date", "next_recall:date", "medical_notes:long"], { calendar: "next_recall" }),
      entity("appointment", "Appointment", "Appointments", ["patient*:ref=patient", "when*:datetime", "dentist", "chair:select=Chair 1|Chair 2|Chair 3|Hygienist", "type:select=Check-up|Cleaning|Filling|Extraction|Root canal|Crown|Other", "status*:select=Booked|Confirmed|Completed|Cancelled|No-show"], { title: "patient", board: "status", calendar: "when" }),
      entity("treatment_plan", "Treatment plan", "Treatment plans", ["title*", "patient*:ref=patient", "dentist", "items:lines", "status*:select=Proposed|Accepted|In progress|Completed|Declined", "start_date:date", "notes:long"], { board: "status", totals: ["items"] }),
    ],
  }),
  app({
    slug: "vet-clinic", name: "Vet Clinic", category: "healthcare",
    tagline: "Pets, owners, visits and vaccination due dates.",
    description: "Keep records for every animal and its owner, book appointments, log consultations and charges, and see which vaccinations are coming due.",
    features: ["Owners and their pets", "Appointment calendar and board", "Consultation notes with charges", "Vaccination records with due dates", "Charge totals"],
    entities: [
      entity("owner", "Owner", "Owners", ["name*", "phone:phone", "email:email", "address:long"]),
      entity("pet", "Pet", "Pets", ["name*", "owner*:ref=owner", "species:select=Dog|Cat|Rabbit|Bird|Reptile|Horse|Other", "breed", "date_of_birth:date", "weight_kg:number", "microchip_number", "notes:long"]),
      entity("appointment", "Appointment", "Appointments", ["pet*:ref=pet", "when*:datetime", "vet", "reason", "status*:select=Booked|Checked in|Seen|Cancelled|No-show"], { title: "pet", board: "status", calendar: "when" }),
      entity("consultation", "Consultation", "Consultations", ["pet*:ref=pet", "date*:date", "vet", "findings:long", "treatment:long", "charges:lines"], { title: "pet", calendar: "date", totals: ["charges"] }),
      entity("vaccination", "Vaccination", "Vaccinations", ["vaccine*", "pet*:ref=pet", "given_on:date", "next_due:date", "batch_number"], { calendar: "next_due" }),
    ],
  }),
  app({
    slug: "physiotherapy", name: "Physiotherapy Practice", category: "healthcare",
    tagline: "Clients, treatment courses and session notes.",
    description: "Track each client's condition and course of treatment, book sessions, and record what was done and how they are progressing.",
    features: ["Client records with referral source", "Treatment courses with session counts", "Session calendar and status board", "Pain scores and progress notes", "Session fee totals"],
    entities: [
      entity("client", "Client", "Clients", ["name*", "date_of_birth:date", "phone:phone", "email:email", "referred_by", "medical_history:long"]),
      entity("course", "Treatment course", "Treatment courses", ["condition*", "client*:ref=client", "therapist", "start_date:date", "sessions_planned:number", "status*:select=Assessment|Active|Discharged|Paused", "goals:long"], { board: "status", totals: ["sessions_planned"] }),
      entity("session", "Session", "Sessions", ["client*:ref=client", "course:ref=course", "when*:datetime", "status*:select=Booked|Attended|Cancelled|No-show", "pain_score:number", "treatment_notes:long", "fee:money"], { title: "client", board: "status", calendar: "when", totals: ["fee"] }),
    ],
  }),
  app({
    slug: "pharmacy-stock", name: "Pharmacy Stock", category: "healthcare",
    tagline: "Medicine stock, batches and expiry dates under control.",
    description: "Track your medicines and products by batch, see which stock is close to expiry on a calendar, and record deliveries from suppliers.",
    features: ["Product list with reorder levels", "Batches with expiry dates", "Expiry calendar", "Supplier deliveries with line items", "Stock quantity and value totals"],
    entities: [
      entity("product", "Product", "Products", ["name*", "strength", "form:select=Tablet|Capsule|Liquid|Cream|Injection|Inhaler|Other", "pack_size", "reorder_level:number", "cost_price:money", "sale_price:money", "prescription_only:bool"]),
      entity("batch", "Batch", "Batches", ["batch_number*", "product*:ref=product", "quantity:number", "expiry_date*:date", "location", "status:select=In stock|Low|Expired|Returned"], { calendar: "expiry_date", totals: ["quantity"] }),
      entity("supplier", "Supplier", "Suppliers", ["name*", "contact_name", "phone:phone", "email:email", "account_number"]),
      entity("delivery", "Delivery", "Deliveries", ["reference*", "supplier*:ref=supplier", "date*:date", "items:lines", "status*:select=Ordered|Received|Checked|Disputed"], { board: "status", calendar: "date", totals: ["items"] }),
    ],
  }),
  app({
    slug: "lab-results", name: "Lab Samples & Results", category: "healthcare",
    tagline: "Track samples from collection to reported result.",
    description: "Log each sample against a patient and test, follow it through the lab on a board, and record results and when they were reported.",
    features: ["Test catalogue with prices and turnaround", "Sample tracking board", "Collection calendar", "Result records with reference ranges", "Test fee totals"],
    entities: [
      entity("test", "Test", "Tests", ["name*", "code", "sample_type:select=Blood|Urine|Swab|Tissue|Other", "turnaround_days:number", "price:money"]),
      entity("patient", "Patient", "Patients", ["name*", "date_of_birth:date", "phone:phone", "referring_doctor"]),
      entity("sample", "Sample", "Samples", ["sample_id*", "patient*:ref=patient", "test*:ref=test", "collected_at*:datetime", "status*:select=Collected|Received|Testing|Reported|Rejected", "priority:select=Routine|Urgent", "fee:money"], { board: "status", calendar: "collected_at", totals: ["fee"] }),
      entity("result", "Result", "Results", ["sample*:ref=sample", "value", "unit", "reference_range", "flag:select=Normal|High|Low|Abnormal", "reported_on:date", "comments:long"], { title: "sample", calendar: "reported_on" }),
    ],
  }),
  app({
    slug: "care-home", name: "Care Home Records", category: "healthcare",
    tagline: "Residents, daily care notes and family contacts.",
    description: "Keep resident details and room allocations, log daily care notes and activities, and record incidents with follow-up actions.",
    features: ["Resident list with rooms and care level", "Daily care log calendar", "Incident records with status board", "Family and next-of-kin contacts", "Activity schedule"],
    entities: [
      entity("resident", "Resident", "Residents", ["name*", "room", "date_of_birth:date", "admitted_on:date", "care_level:select=Residential|Nursing|Dementia|Respite", "gp", "dietary_needs:long", "status:select=Resident|Hospital|Left"]),
      entity("care_note", "Care note", "Care notes", ["resident*:ref=resident", "when*:datetime", "carer", "category:select=Personal care|Meals|Medication round|Mobility|Mood|Other", "note*:long"], { title: "resident", calendar: "when" }),
      entity("incident", "Incident", "Incidents", ["summary*", "resident:ref=resident", "when*:datetime", "type:select=Fall|Injury|Behaviour|Missing item|Other", "action_taken:long", "status*:select=Reported|Investigating|Closed"], { board: "status", calendar: "when" }),
      entity("contact", "Family contact", "Family contacts", ["name*", "resident*:ref=resident", "relationship", "phone:phone", "email:email", "next_of_kin:bool"]),
    ],
  }),

  // ───────────── Hospitality ─────────────
  app({
    slug: "hotel", name: "Hotel & Guesthouse", category: "hospitality",
    tagline: "Rooms, guests, reservations and housekeeping.",
    description: "See every reservation on a calendar, manage your rooms and rates, keep a guest list, and track housekeeping jobs room by room.",
    features: ["Rooms with type, rate and status", "Reservation calendar and status board", "Guest list with stay history", "Housekeeping task board", "Reservation value totals"],
    entities: [
      entity("room", "Room", "Rooms", ["number*", "type:select=Single|Double|Twin|Family|Suite", "floor", "capacity:number", "nightly_rate:money", "status:select=Available|Occupied|Cleaning|Out of service"], { board: "status" }),
      entity("guest", "Guest", "Guests", ["name*", "email:email", "phone:phone", "country", "vip:bool", "notes:long"]),
      entity("reservation", "Reservation", "Reservations", ["guest*:ref=guest", "room:ref=room", "check_in*:date", "check_out*:date", "guests_count:number", "source:select=Direct|Phone|Walk-in|Travel agent|Online|Other", "amount:money", "status*:select=Enquiry|Confirmed|Checked in|Checked out|Cancelled"], { title: "guest", board: "status", calendar: "check_in", totals: ["amount"] }),
      entity("housekeeping", "Housekeeping task", "Housekeeping", ["room*:ref=room", "date*:date", "task:select=Full clean|Turndown|Linen change|Deep clean|Repair", "assigned_to", "status*:select=To do|In progress|Done|Inspected"], { title: "room", board: "status", calendar: "date" }),
    ],
  }),
  app({
    slug: "restaurant-reservations", name: "Restaurant Reservations", category: "hospitality",
    tagline: "Table bookings, covers and regulars in one book.",
    description: "Take table bookings with party size and time, see the day's covers on a calendar, and remember your regular diners and their preferences.",
    features: ["Booking calendar with times", "Booking status board", "Tables with seats and area", "Diner list with preferences", "Cover totals"],
    entities: [
      entity("booking", "Booking", "Bookings", ["diner*:ref=diner", "when*:datetime", "party_size*:number", "table:ref=table", "occasion:select=None|Birthday|Anniversary|Business|Other", "status*:select=Requested|Confirmed|Seated|Completed|Cancelled|No-show", "notes:long"], { title: "diner", board: "status", calendar: "when", totals: ["party_size"] }),
      entity("table", "Table", "Tables", ["name*", "seats:number", "area:select=Main room|Window|Bar|Terrace|Private room"], { totals: ["seats"] }),
      entity("diner", "Diner", "Diners", ["name*", "phone:phone", "email:email", "dietary_notes", "regular:bool", "visits:number"]),
    ],
  }),
  app({
    slug: "recipe-costing", name: "Menu & Recipe Costing", category: "hospitality",
    tagline: "Know what every dish costs to make and what it earns.",
    description: "Keep your ingredient prices up to date, cost each recipe line by line, and compare dish cost against menu price.",
    features: ["Ingredient list with unit costs", "Recipes with itemised ingredient costs", "Menu items with price and food cost", "Menu sections and availability", "Cost totals per recipe"],
    entities: [
      entity("ingredient", "Ingredient", "Ingredients", ["name*", "unit:select=kg|g|litre|ml|each|pack", "cost_per_unit:money", "supplier", "allergen:select=None|Gluten|Dairy|Nuts|Egg|Fish|Shellfish|Soy|Other"]),
      entity("recipe", "Recipe", "Recipes", ["name*", "portions:number", "ingredients:lines", "prep_minutes:number", "method:long"], { totals: ["ingredients"] }),
      entity("menu_item", "Menu item", "Menu items", ["name*", "recipe:ref=recipe", "section:select=Starters|Mains|Sides|Desserts|Drinks|Specials", "price:money", "food_cost:money", "available:bool", "description:long"], { totals: ["price"] }),
    ],
  }),
  app({
    slug: "table-orders", name: "Table Orders", category: "hospitality",
    tagline: "Take orders by table and follow them from kitchen to bill.",
    description: "Record each table's order with itemised dishes, move it from ordered to served on a kitchen board, and total up the day's takings.",
    features: ["Orders with itemised dishes", "Kitchen status board", "Tables and servers", "Order time calendar", "Takings totals", "CSV export"],
    entities: [
      entity("order", "Order", "Orders", ["number*", "table*:ref=table", "server", "placed_at*:datetime", "items:lines", "status*:select=Ordered|Preparing|Ready|Served|Paid|Cancelled", "notes:long"], { board: "status", calendar: "placed_at", totals: ["items"] }),
      entity("table", "Table", "Tables", ["name*", "seats:number", "area"]),
      entity("dish", "Dish", "Dishes", ["name*", "course:select=Starter|Main|Side|Dessert|Drink", "price:money", "available:bool"]),
    ],
  }),
  app({
    slug: "catering", name: "Catering Jobs", category: "hospitality",
    tagline: "Quotes, event menus and staffing for every catering job.",
    description: "Track catering enquiries through to delivery, price each job with itemised menus, and plan staff for each event.",
    features: ["Job pipeline board from enquiry to done", "Event calendar", "Itemised quotes per job", "Client list", "Staff assignments per event", "Job value totals"],
    entities: [
      entity("job", "Catering job", "Catering jobs", ["title*", "client*:ref=client", "event_date*:date", "venue", "guest_count:number", "menu:lines", "deposit:money", "status*:select=Enquiry|Quoted|Booked|Delivered|Invoiced|Lost", "dietary_notes:long"], { board: "status", calendar: "event_date", totals: ["menu", "deposit", "guest_count"] }),
      entity("client", "Client", "Clients", ["name*", "company", "email:email", "phone:phone", "notes:long"]),
      entity("staffing", "Staff assignment", "Staff assignments", ["staff_name*", "job*:ref=job", "role:select=Chef|Server|Bartender|Driver|Supervisor", "hours:number", "pay:money"], { totals: ["hours", "pay"] }),
    ],
  }),
  app({
    slug: "gym-membership", name: "Gym & Fitness Studio", category: "hospitality",
    tagline: "Members, plans, classes and check-ins.",
    description: "Manage members and their plans, schedule classes with capacity, and log check-ins and class bookings.",
    features: ["Members with plan and renewal date", "Membership plans with prices", "Class timetable calendar", "Class bookings and attendance", "Renewal calendar"],
    entities: [
      entity("member", "Member", "Members", ["name*", "email:email", "phone:phone", "plan:ref=plan", "joined_on:date", "renewal_date:date", "status:select=Active|Frozen|Expired|Cancelled", "health_notes:long"], { board: "status", calendar: "renewal_date" }),
      entity("plan", "Plan", "Plans", ["name*", "monthly_price:money", "length_months:number", "classes_included:bool", "description:long"]),
      entity("class_session", "Class", "Classes", ["name*", "when*:datetime", "instructor", "capacity:number", "room"], { calendar: "when" }),
      entity("booking", "Class booking", "Class bookings", ["member*:ref=member", "class_session*:ref=class_session", "status*:select=Booked|Attended|Cancelled|No-show"], { title: "member", board: "status" }),
    ],
  }),
  app({
    slug: "salon", name: "Salon & Spa", category: "hospitality",
    tagline: "Appointments, treatments and client history for your salon.",
    description: "Book clients in with the right stylist and treatment, keep notes on colours and preferences, and track the retail products you sell.",
    features: ["Appointment calendar and status board", "Treatment menu with prices and times", "Client history and preferences", "Retail product stock", "Takings totals"],
    entities: [
      entity("appointment", "Appointment", "Appointments", ["client*:ref=client", "treatment:ref=treatment", "stylist", "when*:datetime", "price:money", "status*:select=Booked|Confirmed|Completed|Cancelled|No-show", "notes:long"], { title: "client", board: "status", calendar: "when", totals: ["price"] }),
      entity("treatment", "Treatment", "Treatments", ["name*", "category:select=Hair|Colour|Nails|Beauty|Massage|Other", "duration_minutes:number", "price:money"]),
      entity("client", "Client", "Clients", ["name*", "phone:phone", "email:email", "birthday:date", "colour_formula", "preferences:long"]),
      entity("product", "Retail product", "Retail products", ["name*", "brand", "stock:number", "cost:money", "price:money"], { totals: ["stock"] }),
    ],
  }),

  // ───────────── Education ─────────────
  app({
    slug: "courses", name: "Courses & Enrolments", category: "education",
    tagline: "Run courses, sessions and student enrolments.",
    description: "List your courses with dates and fees, enrol students, schedule sessions on a calendar, and track who has paid and completed.",
    features: ["Course catalogue with fees and capacity", "Student enrolments with status board", "Session calendar", "Completion and payment tracking", "Fee totals"],
    entities: [
      entity("course", "Course", "Courses", ["title*", "instructor", "level:select=Beginner|Intermediate|Advanced", "start_date:date", "end_date:date", "capacity:number", "fee:money", "delivery:select=In person|Online|Blended", "description:long"], { calendar: "start_date" }),
      entity("student", "Student", "Students", ["name*", "email:email", "phone:phone", "company", "notes:long"]),
      entity("enrolment", "Enrolment", "Enrolments", ["student*:ref=student", "course*:ref=course", "enrolled_on:date", "amount_paid:money", "status*:select=Enquired|Enrolled|In progress|Completed|Withdrawn", "certificate_issued:bool"], { title: "student", board: "status", totals: ["amount_paid"] }),
      entity("session", "Session", "Sessions", ["topic*", "course*:ref=course", "when*:datetime", "location", "attendees:number"], { calendar: "when", totals: ["attendees"] }),
    ],
  }),
  app({
    slug: "school", name: "School Records", category: "education",
    tagline: "Students, classes, attendance and grades.",
    description: "Keep student and guardian details, organise classes, take daily attendance, and record grades for each assessment.",
    features: ["Student records with guardian contacts", "Classes with teachers and rooms", "Daily attendance calendar", "Grades by subject and term", "Attendance status tracking"],
    entities: [
      entity("student", "Student", "Students", ["name*", "date_of_birth:date", "class_group:ref=class_group", "guardian_name", "guardian_phone:phone", "guardian_email:email", "medical_notes:long", "status:select=Enrolled|Left|Graduated"]),
      entity("class_group", "Class", "Classes", ["name*", "year_level", "teacher", "room", "capacity:number"]),
      entity("attendance", "Attendance", "Attendance", ["student*:ref=student", "date*:date", "status*:select=Present|Late|Absent|Excused", "note"], { title: "student", board: "status", calendar: "date" }),
      entity("grade", "Grade", "Grades", ["student*:ref=student", "subject*:select=English|Maths|Science|History|Geography|Languages|Arts|PE|Other", "assessment", "term:select=Term 1|Term 2|Term 3|Term 4", "score:number", "grade", "date:date", "comments:long"], { title: "student", calendar: "date" }),
    ],
  }),
  app({
    slug: "tutoring", name: "Tutoring", category: "education",
    tagline: "Students, lessons and lesson packages for tutors.",
    description: "Schedule one-to-one or group lessons, keep notes on each student's progress, and track lesson packages and payments received.",
    features: ["Student list with subjects and goals", "Lesson calendar and status board", "Lesson notes and homework", "Lesson packages with hours", "Fee and hour totals"],
    entities: [
      entity("student", "Student", "Students", ["name*", "parent_name", "phone:phone", "email:email", "subject", "level", "goals:long"]),
      entity("lesson", "Lesson", "Lessons", ["student*:ref=student", "when*:datetime", "duration_hours:number", "subject", "status*:select=Scheduled|Completed|Cancelled|No-show", "fee:money", "notes:long", "homework:long"], { title: "student", board: "status", calendar: "when", totals: ["duration_hours", "fee"] }),
      entity("package", "Lesson package", "Lesson packages", ["name*", "student*:ref=student", "hours_bought:number", "amount_paid:money", "purchased_on:date", "expires_on:date"], { calendar: "expires_on", totals: ["hours_bought", "amount_paid"] }),
    ],
  }),
  app({
    slug: "library-loans", name: "Library Loans", category: "education",
    tagline: "A catalogue of items and who has borrowed what.",
    description: "Catalogue your books and other items, register borrowers, and track loans with due dates so you can see what is overdue.",
    features: ["Item catalogue with copies and location", "Borrower register", "Loans board from out to returned", "Due date calendar", "Fines totals"],
    entities: [
      entity("item", "Item", "Items", ["title*", "author", "isbn", "type:select=Book|Magazine|DVD|Audiobook|Equipment|Other", "copies:number", "shelf_location", "status:select=Available|On loan|Lost|Withdrawn"], { totals: ["copies"] }),
      entity("borrower", "Borrower", "Borrowers", ["name*", "card_number", "email:email", "phone:phone", "type:select=Student|Staff|Member|Guest"]),
      entity("loan", "Loan", "Loans", ["item*:ref=item", "borrower*:ref=borrower", "borrowed_on*:date", "due_on*:date", "returned_on:date", "status*:select=On loan|Overdue|Returned|Lost", "fine:money"], { title: "item", board: "status", calendar: "due_on", totals: ["fine"] }),
    ],
  }),
  app({
    slug: "exam-scheduler", name: "Exam Scheduler", category: "education",
    tagline: "Exam timetables, rooms, invigilators and entries.",
    description: "Plan your exam timetable on a calendar, assign rooms and invigilators, and track which candidates are entered for each paper.",
    features: ["Exam timetable calendar", "Rooms with seat capacity", "Invigilator assignments", "Candidate entries with access arrangements", "Exam status board"],
    entities: [
      entity("exam", "Exam", "Exams", ["paper*", "subject", "when*:datetime", "duration_minutes:number", "room:ref=room", "invigilator", "status*:select=Planned|Confirmed|Sat|Marked"], { board: "status", calendar: "when" }),
      entity("room", "Room", "Rooms", ["name*", "seats:number", "building"], { totals: ["seats"] }),
      entity("entry", "Candidate entry", "Candidate entries", ["candidate_name*", "candidate_number", "exam*:ref=exam", "extra_time:bool", "access_arrangements:long", "attended:bool"]),
    ],
  }),
  app({
    slug: "driving-school", name: "Driving School", category: "education",
    tagline: "Pupils, lessons, instructors and test dates.",
    description: "Book driving lessons for each pupil with their instructor, track progress towards the test, and keep a record of test dates and results.",
    features: ["Pupil list with progress stage", "Lesson calendar", "Instructor and vehicle details", "Test bookings and results", "Lesson fee totals"],
    entities: [
      entity("pupil", "Pupil", "Pupils", ["name*", "phone:phone", "email:email", "licence_number", "transmission:select=Manual|Automatic", "stage*:select=Beginner|Developing|Test ready|Passed|Inactive", "notes:long"], { board: "stage" }),
      entity("instructor", "Instructor", "Instructors", ["name*", "phone:phone", "vehicle", "registration"]),
      entity("lesson", "Lesson", "Lessons", ["pupil*:ref=pupil", "instructor:ref=instructor", "when*:datetime", "hours:number", "fee:money", "status*:select=Booked|Completed|Cancelled", "feedback:long"], { title: "pupil", board: "status", calendar: "when", totals: ["hours", "fee"] }),
      entity("test", "Driving test", "Driving tests", ["pupil*:ref=pupil", "date*:date", "test_centre", "result:select=Booked|Passed|Failed|Cancelled", "faults:number"], { title: "pupil", calendar: "date" }),
    ],
  }),
  app({
    slug: "music-lessons", name: "Music Lessons", category: "education",
    tagline: "Students, weekly lessons, grades and recitals.",
    description: "Organise lessons for each student and instrument, record practice notes and grade exams, and plan recitals.",
    features: ["Students with instrument and level", "Lesson calendar and status board", "Grade exam records", "Recital planner", "Term fee totals"],
    entities: [
      entity("student", "Student", "Students", ["name*", "instrument:select=Piano|Guitar|Violin|Voice|Drums|Flute|Other", "level", "parent_name", "phone:phone", "email:email", "term_fee:money"], { totals: ["term_fee"] }),
      entity("lesson", "Lesson", "Lessons", ["student*:ref=student", "when*:datetime", "teacher", "status*:select=Scheduled|Taught|Cancelled|Make-up needed", "pieces_covered", "practice_notes:long"], { title: "student", board: "status", calendar: "when" }),
      entity("exam", "Grade exam", "Grade exams", ["student*:ref=student", "grade_level*", "exam_date:date", "result:select=Entered|Pass|Merit|Distinction|Not passed", "mark:number"], { title: "student", calendar: "exam_date" }),
      entity("recital", "Recital", "Recitals", ["name*", "date*:date", "venue", "performers:number", "notes:long"], { calendar: "date" }),
    ],
  }),

  // ───────────── Customer service ─────────────
  app({
    slug: "helpdesk", name: "Helpdesk", category: "customer-service",
    tagline: "Support tickets, customers and a knowledge base.",
    description: "Log every customer request as a ticket, work them on a board by status and priority, and write help articles for common questions.",
    features: ["Ticket board by status", "Priorities, channels and assignees", "Customer list", "Knowledge base articles", "Ticket replies log", "Due date calendar"],
    entities: [
      entity("ticket", "Ticket", "Tickets", ["subject*", "customer*:ref=customer", "channel:select=Email|Phone|Web form|Chat|In person", "priority:select=Low|Normal|High|Urgent", "status*:select=New|Open|Waiting on customer|Resolved|Closed", "assignee", "due_date:date", "description:long"], { board: "status", calendar: "due_date" }),
      entity("customer", "Customer", "Customers", ["name*", "email:email", "phone:phone", "company", "plan", "notes:long"]),
      entity("reply", "Reply", "Replies", ["ticket*:ref=ticket", "when*:datetime", "author", "internal_note:bool", "message*:long"], { title: "ticket", calendar: "when" }),
      entity("article", "Knowledge article", "Knowledge articles", ["title*", "category:select=Getting started|Account|Billing|Troubleshooting|How-to|Other", "status*:select=Draft|Published|Archived", "body:long", "helpful_votes:number"], { board: "status" }),
    ],
  }),
  app({
    slug: "complaints", name: "Complaints Log", category: "customer-service",
    tagline: "Record, investigate and resolve customer complaints.",
    description: "Log each complaint with its category and severity, track it through investigation to resolution, and record any goodwill given.",
    features: ["Complaint board from received to closed", "Categories and severity", "Response due dates on a calendar", "Actions taken log", "Goodwill and refund totals"],
    entities: [
      entity("complaint", "Complaint", "Complaints", ["summary*", "customer_name*", "email:email", "phone:phone", "received_on*:date", "category:select=Product|Service|Staff|Delivery|Billing|Other", "severity:select=Low|Medium|High", "status*:select=Received|Investigating|Responded|Resolved|Closed", "response_due:date", "goodwill:money"], { board: "status", calendar: "response_due", totals: ["goodwill"] }),
      entity("action", "Action", "Actions", ["description*", "complaint*:ref=complaint", "owner", "due_date:date", "done:bool", "outcome:long"], { calendar: "due_date" }),
    ],
  }),
  app({
    slug: "warranty-claims", name: "Warranty Claims", category: "customer-service",
    tagline: "Products sold, warranties and claims from start to finish.",
    description: "Record what each customer bought and when the warranty ends, then handle claims from submission through repair, replacement or refund.",
    features: ["Registered products with warranty end dates", "Claim board by status", "Warranty expiry calendar", "Repair and replacement costs", "Customer list"],
    entities: [
      entity("customer", "Customer", "Customers", ["name*", "email:email", "phone:phone", "address:long"]),
      entity("registration", "Product registration", "Product registrations", ["serial_number*", "customer*:ref=customer", "product", "purchase_date:date", "warranty_ends:date", "purchase_price:money"], { calendar: "warranty_ends" }),
      entity("claim", "Claim", "Claims", ["reference*", "registration*:ref=registration", "reported_on*:date", "fault:long", "status*:select=Submitted|Assessing|Approved|Repairing|Replaced|Refunded|Rejected", "resolution:select=Repair|Replace|Refund|None", "cost:money"], { board: "status", calendar: "reported_on", totals: ["cost"] }),
    ],
  }),
  app({
    slug: "field-service", name: "Field Service Jobs", category: "customer-service",
    tagline: "Schedule call-outs, technicians and parts used on site.",
    description: "Book jobs at customer sites, assign technicians, move jobs through a board from booked to completed, and record parts and labour.",
    features: ["Job board from booked to invoiced", "Visit calendar", "Customer sites with access notes", "Parts and labour line items", "Technician list", "Job value totals"],
    entities: [
      entity("job", "Job", "Jobs", ["title*", "site*:ref=site", "technician:ref=technician", "scheduled_for*:datetime", "type:select=Installation|Repair|Maintenance|Inspection|Emergency", "priority:select=Low|Normal|High|Emergency", "status*:select=Booked|En route|On site|Completed|Invoiced|Cancelled", "parts_and_labour:lines", "work_notes:long"], { board: "status", calendar: "scheduled_for", totals: ["parts_and_labour"] }),
      entity("site", "Site", "Sites", ["name*", "customer_name", "address*:long", "contact_phone:phone", "access_notes:long"]),
      entity("technician", "Technician", "Technicians", ["name*", "phone:phone", "skills", "van_registration", "active:bool"]),
    ],
  }),
  app({
    slug: "feedback-surveys", name: "Feedback & Surveys", category: "customer-service",
    tagline: "Collect survey responses and act on what customers say.",
    description: "Set up surveys, record each response with scores and comments, and turn feedback into follow-up actions you can track.",
    features: ["Surveys with purpose and dates", "Responses with ratings and comments", "Response calendar", "Follow-up board", "CSV import of responses"],
    entities: [
      entity("survey", "Survey", "Surveys", ["name*", "purpose:long", "start_date:date", "end_date:date", "status*:select=Draft|Live|Closed"], { board: "status" }),
      entity("response", "Response", "Responses", ["respondent*", "survey*:ref=survey", "date*:date", "satisfaction:rating", "would_recommend_score:number", "comments:long", "follow_up_needed:bool"], { calendar: "date" }),
      entity("follow_up", "Follow-up", "Follow-ups", ["title*", "response:ref=response", "owner", "due_date:date", "status*:select=To do|In progress|Done"], { board: "status", calendar: "due_date" }),
    ],
  }),
  app({
    slug: "returns", name: "Returns & Exchanges", category: "customer-service",
    tagline: "Track returned goods from request to refund or exchange.",
    description: "Log each return with its items and reason, follow it on a board from requested to closed, and see refund totals.",
    features: ["Return requests with itemised goods", "Return status board", "Return reasons and condition", "Received date calendar", "Refund totals"],
    entities: [
      entity("return_request", "Return", "Returns", ["reference*", "customer*", "order_number", "requested_on*:date", "items:lines", "reason:select=Faulty|Wrong item|Wrong size|Changed mind|Damaged in transit|Other", "outcome:select=Refund|Exchange|Store credit|Rejected", "status*:select=Requested|Approved|Received|Inspected|Closed"], { board: "status", calendar: "requested_on", totals: ["items"] }),
      entity("inspection", "Inspection", "Inspections", ["return_request*:ref=return_request", "inspected_on:date", "condition:select=As new|Used|Damaged|Missing parts", "restock:bool", "refund_amount:money", "notes:long"], { title: "return_request", totals: ["refund_amount"] }),
    ],
  }),
  app({
    slug: "service-contracts", name: "Service Contracts", category: "customer-service",
    tagline: "Maintenance agreements, renewal dates and scheduled visits.",
    description: "Keep every service or maintenance agreement in one list, see renewals coming up, and plan the visits each contract includes.",
    features: ["Contracts with value and renewal dates", "Renewal calendar", "Contract status board", "Scheduled service visits", "Contract value totals"],
    entities: [
      entity("client", "Client", "Clients", ["name*", "contact_name", "email:email", "phone:phone", "address:long"]),
      entity("contract", "Contract", "Contracts", ["title*", "client*:ref=client", "start_date:date", "renewal_date*:date", "annual_value:money", "visits_per_year:number", "status*:select=Draft|Active|Renewal due|Expired|Cancelled", "terms:long"], { board: "status", calendar: "renewal_date", totals: ["annual_value"] }),
      entity("visit", "Service visit", "Service visits", ["contract*:ref=contract", "date*:date", "engineer", "status*:select=Planned|Done|Missed", "report:long"], { title: "contract", board: "status", calendar: "date" }),
    ],
  }),

  // ───────────── Marketing ─────────────
  app({
    slug: "event-management", name: "Event Management", category: "marketing",
    tagline: "Plan events, venues, attendees and budgets.",
    description: "Plan each event from idea to wrap-up, keep a guest and attendee list with ticket status, and track budget items so you know what it really cost.",
    features: ["Event planning board", "Event calendar", "Attendee list with ticket types and check-in", "Budget lines per event", "Venue details", "Ticket and budget totals"],
    entities: [
      entity("event", "Event", "Events", ["name*", "date*:date", "venue:ref=venue", "type:select=Launch|Workshop|Conference|Networking|Webinar|Party|Other", "capacity:number", "budget:lines", "status*:select=Idea|Planning|Confirmed|Live|Done|Cancelled", "notes:long"], { board: "status", calendar: "date", totals: ["budget"] }),
      entity("venue", "Venue", "Venues", ["name*", "address:long", "capacity:number", "contact_name", "phone:phone", "hire_cost:money"]),
      entity("attendee", "Attendee", "Attendees", ["name*", "event*:ref=event", "email:email", "company", "ticket_type:select=Free|Standard|VIP|Speaker|Staff", "ticket_price:money", "status*:select=Invited|Registered|Attended|No-show|Cancelled"], { board: "status", totals: ["ticket_price"] }),
    ],
  }),
  app({
    slug: "campaigns", name: "Marketing Campaigns", category: "marketing",
    tagline: "Plan campaigns, track spend and record results.",
    description: "Keep every marketing campaign in one place with its channel, budget and dates, track spend as it happens, and record leads and sales it brought in.",
    features: ["Campaign board from planned to finished", "Campaign calendar", "Spend log by channel", "Results with leads and revenue", "Budget, spend and revenue totals"],
    entities: [
      entity("campaign", "Campaign", "Campaigns", ["name*", "channel:select=Social|Email|Search ads|Print|Radio|Events|Partnerships|Other", "goal", "start_date:date", "end_date:date", "budget:money", "owner", "status*:select=Planned|Running|Paused|Finished"], { board: "status", calendar: "start_date", totals: ["budget"] }),
      entity("spend", "Spend", "Spend", ["description*", "campaign*:ref=campaign", "date*:date", "amount*:money", "supplier"], { calendar: "date", totals: ["amount"] }),
      entity("result", "Result", "Results", ["campaign*:ref=campaign", "period*", "impressions:number", "clicks:number", "leads:number", "sales:number", "revenue:money", "notes:long"], { title: "campaign", totals: ["impressions", "clicks", "leads", "revenue"] }),
    ],
  }),
  app({
    slug: "mailing-lists", name: "Mailing Lists", category: "marketing",
    tagline: "Subscribers, lists and consent records kept tidy.",
    description: "Keep your subscribers and the lists they belong to, record when and how they gave consent, and import or export lists as CSV for your mailing tool.",
    features: ["Subscriber records with consent date and source", "Multiple lists with purpose", "List memberships", "Unsubscribe status tracking", "CSV import and export"],
    entities: [
      entity("subscriber", "Subscriber", "Subscribers", ["email*:email", "name", "source:select=Website form|Event|In store|Import|Referral|Other", "consent_given_on:date", "status*:select=Subscribed|Unsubscribed|Bounced|Pending", "tags", "notes:long"], { board: "status" }),
      entity("list", "List", "Lists", ["name*", "purpose:long", "owner", "created_on:date"]),
      entity("membership", "List membership", "List memberships", ["subscriber*:ref=subscriber", "list*:ref=list", "joined_on:date", "active:bool"], { title: "subscriber" }),
    ],
  }),
  app({
    slug: "social-media-calendar", name: "Social Media Calendar", category: "marketing",
    tagline: "Plan, draft and schedule your social posts.",
    description: "Plan posts for each channel on a calendar, move them from idea to published on a board, and note how each post performed.",
    features: ["Post calendar by date and time", "Post status board", "Channels and content themes", "Performance notes with likes and shares", "Engagement totals"],
    entities: [
      entity("post", "Post", "Posts", ["title*", "channel*:select=Facebook|Instagram|LinkedIn|X|TikTok|YouTube|Pinterest|Other", "publish_at:datetime", "theme:ref=theme", "caption:long", "media_link:url", "status*:select=Idea|Drafting|Approved|Scheduled|Published", "likes:number", "shares:number", "comments:number"], { board: "status", calendar: "publish_at", totals: ["likes", "shares", "comments"] }),
      entity("theme", "Content theme", "Content themes", ["name*", "description:long", "hashtags"]),
    ],
  }),
  app({
    slug: "content-calendar", name: "Content Calendar", category: "marketing",
    tagline: "Blog posts, videos and newsletters from idea to published.",
    description: "Plan articles, videos and other content with writers, due dates and target keywords, and move each piece through your editorial workflow.",
    features: ["Content pipeline board", "Publish date calendar", "Writers and editors", "Target keyword and word count", "Word count totals"],
    entities: [
      entity("piece", "Content piece", "Content pieces", ["title*", "format:select=Blog post|Video|Newsletter|Podcast|Case study|Guide", "author:ref=author", "target_keyword", "word_count:number", "due_date:date", "publish_date:date", "status*:select=Idea|Briefed|Writing|Editing|Scheduled|Published", "link:url"], { board: "status", calendar: "publish_date", totals: ["word_count"] }),
      entity("author", "Author", "Authors", ["name*", "email:email", "role:select=Writer|Editor|Freelancer|Guest", "rate_per_piece:money"]),
    ],
  }),
  app({
    slug: "influencer-outreach", name: "Influencer Outreach", category: "marketing",
    tagline: "Creators, outreach status and collaboration results.",
    description: "Keep a list of creators with their audience size, track outreach from first contact to agreed deal, and record what each collaboration delivered.",
    features: ["Creator list with platform and followers", "Outreach board", "Collaboration fees and dates", "Results with reach and clicks", "Fee and reach totals"],
    entities: [
      entity("creator", "Creator", "Creators", ["name*", "platform:select=Instagram|TikTok|YouTube|Blog|Podcast|Other", "handle", "followers:number", "niche", "email:email", "outreach_status*:select=Prospect|Contacted|Replied|Negotiating|Agreed|Declined"], { board: "outreach_status", totals: [] }),
      entity("collaboration", "Collaboration", "Collaborations", ["title*", "creator*:ref=creator", "deliverables:long", "go_live_date:date", "fee:money", "status*:select=Agreed|In production|Live|Completed|Cancelled", "reach:number", "clicks:number"], { board: "status", calendar: "go_live_date", totals: ["fee", "reach", "clicks"] }),
    ],
  }),
  app({
    slug: "seo-keywords", name: "SEO Keyword Tracker", category: "marketing",
    tagline: "Target keywords, page mapping and ranking checks.",
    description: "List the keywords you want to rank for, match them to pages on your site, and log your position each time you check.",
    features: ["Keyword list with volume and difficulty", "Pages mapped to keywords", "Ranking checks over time", "Optimisation task board", "Search volume totals"],
    entities: [
      entity("keyword", "Keyword", "Keywords", ["phrase*", "monthly_volume:number", "difficulty:select=Easy|Medium|Hard", "intent:select=Informational|Commercial|Local|Brand", "target_page:ref=page", "priority:select=Low|Medium|High"], { totals: ["monthly_volume"] }),
      entity("page", "Page", "Pages", ["url*:url", "title", "status*:select=To write|To optimise|Optimised|Needs refresh", "last_updated:date"], { board: "status" }),
      entity("ranking", "Ranking check", "Ranking checks", ["keyword*:ref=keyword", "checked_on*:date", "position:number", "notes"], { title: "keyword", calendar: "checked_on" }),
    ],
  }),

  // ───────────── Community ─────────────
  app({
    slug: "volunteers", name: "Volunteer Management", category: "community",
    tagline: "Volunteers, shifts and hours given.",
    description: "Keep a register of volunteers and their skills, schedule them onto shifts, and record the hours they give.",
    features: ["Volunteer register with skills and checks", "Shift calendar", "Shift sign-up status board", "Hours logged per volunteer", "Hour totals"],
    entities: [
      entity("volunteer", "Volunteer", "Volunteers", ["name*", "email:email", "phone:phone", "skills", "availability", "background_check_done:bool", "joined_on:date", "status:select=Active|Paused|Left"]),
      entity("shift", "Shift", "Shifts", ["role*", "when*:datetime", "location", "volunteers_needed:number", "status*:select=Open|Filled|Done|Cancelled"], { board: "status", calendar: "when", totals: ["volunteers_needed"] }),
      entity("hours", "Hours log", "Hours log", ["volunteer*:ref=volunteer", "shift:ref=shift", "date*:date", "hours*:number", "notes"], { title: "volunteer", calendar: "date", totals: ["hours"] }),
    ],
  }),
  app({
    slug: "donations", name: "Donors & Donations", category: "community",
    tagline: "Every donor and gift recorded, with thank-you tracking.",
    description: "Keep a record of your donors, log each gift with its method and purpose, note whether gift aid or tax receipts apply, and track thank-yous.",
    features: ["Donor records with type and contact details", "Donations log with methods and funds", "Donation calendar", "Thank-you tracking", "Donation totals", "CSV export"],
    entities: [
      entity("donor", "Donor", "Donors", ["name*", "type:select=Individual|Business|Trust|Church|Other", "email:email", "phone:phone", "address:long", "first_gift_on:date", "notes:long"]),
      entity("donation", "Donation", "Donations", ["donor*:ref=donor", "date*:date", "amount*:money", "method:select=Cash|Cheque|Bank transfer|Card|Standing order|Other", "fund:select=General|Building|Appeal|Restricted|Other", "tax_receipt_eligible:bool", "thanked:bool"], { title: "donor", calendar: "date", totals: ["amount"] }),
      entity("pledge", "Pledge", "Pledges", ["donor*:ref=donor", "amount_pledged*:money", "frequency:select=One-off|Monthly|Quarterly|Yearly", "start_date:date", "status*:select=Pledged|Active|Fulfilled|Lapsed"], { title: "donor", board: "status", totals: ["amount_pledged"] }),
    ],
  }),
  app({
    slug: "membership-dues", name: "Members & Dues", category: "community",
    tagline: "Membership records, renewals and dues paid.",
    description: "Keep your membership list with categories and renewal dates, record dues received, and see who is due to renew.",
    features: ["Member register with category", "Renewal date calendar", "Membership status board", "Dues received log", "Dues totals"],
    entities: [
      entity("member", "Member", "Members", ["name*", "member_number", "email:email", "phone:phone", "category:ref=category", "joined_on:date", "renewal_date:date", "status*:select=Active|Due|Lapsed|Honorary|Resigned"], { board: "status", calendar: "renewal_date" }),
      entity("category", "Membership category", "Membership categories", ["name*", "annual_fee:money", "description:long"]),
      entity("due", "Dues payment", "Dues payments", ["member*:ref=member", "date*:date", "amount*:money", "period", "method:select=Cash|Cheque|Bank transfer|Card|Other"], { title: "member", calendar: "date", totals: ["amount"] }),
    ],
  }),
  app({
    slug: "church", name: "Church Administration", category: "community",
    tagline: "Congregation, services, groups and giving.",
    description: "Keep a directory of your congregation and households, plan services and rotas, organise small groups, and record weekly offerings.",
    features: ["Congregation directory", "Service calendar with rota roles", "Small groups and leaders", "Weekly offering records", "Attendance and giving totals"],
    entities: [
      entity("person", "Person", "People", ["name*", "household", "email:email", "phone:phone", "birthday:date", "membership:select=Visitor|Regular|Member|Leader", "group:ref=group", "notes:long"]),
      entity("service", "Service", "Services", ["title*", "when*:datetime", "preacher", "worship_leader", "readings", "attendance:number", "notes:long"], { calendar: "when", totals: ["attendance"] }),
      entity("group", "Group", "Groups", ["name*", "leader", "meeting_day:select=Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday", "meeting_time:time", "location"]),
      entity("offering", "Offering", "Offerings", ["service*:ref=service", "date*:date", "amount*:money", "counted_by", "fund:select=General|Missions|Building|Benevolence|Other"], { title: "service", calendar: "date", totals: ["amount"] }),
    ],
  }),
  app({
    slug: "fundraising", name: "Fundraising Campaigns", category: "community",
    tagline: "Appeals with targets, activities and money raised.",
    description: "Set up fundraising appeals with targets and deadlines, plan the activities behind them, and log money raised against each one.",
    features: ["Appeals with target and deadline", "Appeal status board", "Fundraising activity calendar", "Income log per appeal", "Target and raised totals"],
    entities: [
      entity("appeal", "Appeal", "Appeals", ["name*", "target:money", "start_date:date", "end_date:date", "lead", "status*:select=Planning|Live|Target reached|Closed", "story:long"], { board: "status", calendar: "end_date", totals: ["target"] }),
      entity("activity", "Activity", "Activities", ["title*", "appeal*:ref=appeal", "date*:date", "type:select=Event|Sponsored challenge|Collection|Sale|Online page|Other", "organiser", "costs:money"], { calendar: "date", totals: ["costs"] }),
      entity("income", "Income", "Income", ["source*", "appeal*:ref=appeal", "activity:ref=activity", "date*:date", "amount*:money"], { calendar: "date", totals: ["amount"] }),
    ],
  }),
  app({
    slug: "sports-club", name: "Sports Club", category: "community",
    tagline: "Players, teams, fixtures and match results.",
    description: "Register players and teams, schedule fixtures and training on a calendar, and record results and match fees.",
    features: ["Player register with emergency contacts", "Teams with coaches", "Fixture and training calendar", "Match results", "Match fee totals"],
    entities: [
      entity("player", "Player", "Players", ["name*", "team:ref=team", "date_of_birth:date", "position", "phone:phone", "emergency_contact", "registered:bool", "medical_notes:long"]),
      entity("team", "Team", "Teams", ["name*", "age_group", "coach", "league"]),
      entity("fixture", "Fixture", "Fixtures", ["opponent*", "team*:ref=team", "when*:datetime", "venue:select=Home|Away|Neutral", "type:select=League|Cup|Friendly|Training", "result:select=Not played|Win|Draw|Loss|Postponed", "score", "match_fees:money"], { board: "result", calendar: "when", totals: ["match_fees"] }),
    ],
  }),
  app({
    slug: "grant-applications", name: "Grant Applications", category: "community",
    tagline: "Funders, applications, deadlines and reporting.",
    description: "Keep a list of funders, track each grant application from research to decision, and stay on top of the reports you owe after an award.",
    features: ["Funder list with focus areas", "Application board from research to awarded", "Deadline calendar", "Amounts requested and awarded", "Reporting due dates"],
    entities: [
      entity("funder", "Funder", "Funders", ["name*", "type:select=Trust|Foundation|Government|Business|Lottery|Other", "focus_areas:long", "website:url", "contact_name", "email:email"]),
      entity("application", "Application", "Applications", ["project*", "funder*:ref=funder", "deadline*:date", "amount_requested:money", "amount_awarded:money", "status*:select=Researching|Drafting|Submitted|Awarded|Declined|Withdrawn", "decision_date:date", "notes:long"], { board: "status", calendar: "deadline", totals: ["amount_requested", "amount_awarded"] }),
      entity("report", "Grant report", "Grant reports", ["title*", "application*:ref=application", "due_date*:date", "submitted:bool", "notes:long"], { calendar: "due_date" }),
    ],
  }),
];
