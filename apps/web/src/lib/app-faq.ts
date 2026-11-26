// Questions and answers for the vertical app pages people search for by name (charter growth lane 1).
// Every answer must match the app's live definition in packages/core/src/apps/*.ts and the limits in plans.ts.
// Do not add claims about features the app does not have (online payments, SMS, Gift Aid filing, eMAR, etc.).

export type Faq = { q: string; a: string };

const FREE_PLAN = "The Free plan covers 3 users, any 3 apps and 1,000 records, with no card. Paid plans start at $19 a month and every new workspace gets a 14-day Business trial.";
const FROM_SPREADSHEET = "Save your sheet as CSV (up to 5 MB) and use Import CSV on the list. The first row must hold the column names, which are matched to the fields by name. You can export any list back to CSV at any time.";

export const APP_FAQ: Record<string, Faq[]> = {
  church: [
    { q: "Is this church management software free?", a: `Yes for small churches. ${FREE_PLAN}` },
    { q: "What can we keep track of?", a: "A congregation directory with households, contact details, birthdays and membership status (visitor, regular, member, leader); services with preacher, worship leader, readings and attendance; small groups with leader, meeting day, time and place; and weekly offerings by fund (General, Missions, Building, Benevolence) with who counted them." },
    { q: "Can we move our member list over from a spreadsheet?", a: FROM_SPREADSHEET },
    { q: "Does it take online giving?", a: "No. It records offerings and shows totals by service and fund; it does not process card or online donations." },
    { q: "Who can see the data?", a: "Only the people you invite to your workspace. Each workspace is private to your church." },
  ],
  "driving-school": [
    { q: "What does the driving school app do?", a: "It keeps a pupil list with licence number, manual or automatic, and a progress board from Beginner to Test ready to Passed; books lessons on a calendar with instructor, hours, fee, status and feedback; and records driving tests with test centre, result and number of faults." },
    { q: "Does it work for a single instructor?", a: `Yes. Add yourself as the only instructor and your car's registration. ${FREE_PLAN}` },
    { q: "Can pupils book lessons themselves?", a: "Not in this app. You or your office book lessons; pupils do not get a booking page." },
    { q: "Can I bring my pupils over from a spreadsheet?", a: FROM_SPREADSHEET },
    { q: "Can I see what I have earned?", a: "Lesson fees are totalled, so you can see the value of lessons booked and completed." },
  ],
  donations: [
    { q: "Is this donor management software free for small charities?", a: `Yes. ${FREE_PLAN}` },
    { q: "What does it record?", a: "Donors (individual, business, trust, church), each gift with date, amount, method (cash, cheque, bank transfer, card, standing order) and fund (general, building, appeal, restricted), pledges with frequency and status, and whether each donor has been thanked." },
    { q: "Does it handle Gift Aid?", a: "You can mark each gift as eligible for Gift Aid or a tax receipt and export the list to CSV. It does not submit Gift Aid claims to HMRC for you." },
    { q: "Can I import donors from a spreadsheet?", a: FROM_SPREADSHEET },
    { q: "Does it take donations online?", a: "No. It is a record of donors and gifts; it does not process payments." },
  ],
  "care-home": [
    { q: "What does the care home records app cover?", a: "Residents with room, date of birth, admission date, care level (residential, nursing, dementia, respite), GP and dietary needs; daily care notes by category (personal care, meals, medication round, mobility, mood); incidents such as falls with action taken and a status board; and family contacts with next of kin marked." },
    { q: "Is it an eMAR or clinical system?", a: "No. It is a simple records tool for notes, incidents and contacts. It does not manage prescriptions or medication administration, so check it meets your regulator's record-keeping requirements before relying on it." },
    { q: "Can several carers use it?", a: `Yes. Invite each carer to your workspace; every care note has a carer field for who wrote it. ${FREE_PLAN}` },
    { q: "Can we import residents from a spreadsheet?", a: FROM_SPREADSHEET },
    { q: "Who can see resident information?", a: "Only the people you invite to your workspace. Each workspace is private to your home." },
  ],
  catering: [
    { q: "What does the catering jobs app do?", a: "It tracks each job from enquiry to quoted, booked, delivered and invoiced on a status board and an event calendar. Each job holds the client, event date, venue, guest count, an itemised menu, the deposit and dietary notes. Staff assignments record who works each event (chef, server, bartender, driver, supervisor), their hours and pay." },
    { q: "Can I price a job?", a: "Yes. The menu is a list of items with prices, and the app totals the menu, deposits and guest numbers across jobs, so you can see the value of work booked." },
    { q: "Does it send invoices or take payments?", a: "No. The catering app marks a job as Invoiced; it does not create invoices or take card payments." },
    { q: "Can I import my clients from a spreadsheet?", a: FROM_SPREADSHEET },
    { q: "Is there a free plan?", a: FREE_PLAN },
  ],
  salon: [
    { q: "Is this salon appointment software free?", a: `Yes for small salons. ${FREE_PLAN}` },
    { q: "What can I keep track of?", a: "Appointments on a calendar and a status board (booked, confirmed, completed, cancelled, no-show) with client, treatment, stylist and price; a treatment menu with category, duration and price; client records with birthday, colour formula and preferences; and retail products with stock, cost and price." },
    { q: "Can clients book online?", a: "Not in this app. You or your team book appointments; clients do not get a booking page." },
    { q: "Does it send appointment reminders?", a: "No. It does not send texts or emails to clients." },
    { q: "Can I bring my client list over from a spreadsheet?", a: FROM_SPREADSHEET },
  ],
  dental: [
    { q: "What does the dental practice app cover?", a: "Patients with date of birth, contact details, last check-up and next recall date (shown on a recall calendar); appointments by dentist and chair (Chair 1–3, Hygienist) with type and status; and treatment plans with itemised costs that move from proposed to accepted, in progress and completed." },
    { q: "Is it full practice management software?", a: "No. It is a records and scheduling tool. It does not handle clinical charting, X-rays, NHS claims or card payments, and it does not send recall reminders, so check it meets your regulator's record-keeping requirements before relying on it." },
    { q: "Can several dentists and staff use it?", a: `Yes. Invite each person to your workspace; appointments and plans have a dentist field. ${FREE_PLAN}` },
    { q: "Can we import patients from a spreadsheet?", a: FROM_SPREADSHEET },
    { q: "Who can see patient information?", a: "Only the people you invite to your workspace. Each workspace is private to your practice." },
  ],
  clinic: [
    { q: "What does the clinic records app do?", a: "It keeps patient records (date of birth, contact details, address, allergies, emergency contact), books appointments on a calendar with a status board (booked, arrived, seen, cancelled, no-show), records each visit with complaint, diagnosis, treatment, fee and follow-up date, and logs prescriptions given with dosage, frequency and duration." },
    { q: "Is it an electronic health record system?", a: "No. It is a simple record-keeping tool for a small practice. It does not send prescriptions to pharmacies, connect to labs or handle insurance claims, so check it meets your local record-keeping rules before relying on it." },
    { q: "Can I see what the clinic has earned?", a: "Visit fees are totalled, so you can see fees recorded over time." },
    { q: "Can I import patients from a spreadsheet?", a: FROM_SPREADSHEET },
    { q: "Is there a free plan?", a: FREE_PLAN },
  ],
  "gym-membership": [
    { q: "Is this gym membership software free?", a: `Yes for small gyms and studios. ${FREE_PLAN}` },
    { q: "What can I keep track of?", a: "Members with plan, join date, renewal date and status (active, frozen, expired, cancelled) on a board and a renewal calendar; membership plans with monthly price, length and whether classes are included; a class timetable with instructor, capacity and room; and class bookings marked booked, attended, cancelled or no-show." },
    { q: "Can members book classes online?", a: "Not in this app. You or your staff record class bookings; members do not get a booking page or a member app." },
    { q: "Does it take membership payments?", a: "No. Plans record the price, but the app does not collect card payments or direct debits." },
    { q: "Can I import my members from a spreadsheet?", a: FROM_SPREADSHEET },
  ],
  hotel: [
    { q: "Is this hotel and guesthouse software free?", a: `Yes for small guesthouses and B&Bs. ${FREE_PLAN}` },
    { q: "What does it cover?", a: "Rooms with type, floor, capacity, nightly rate and status (available, occupied, cleaning, out of service); a guest list; reservations with check-in and check-out dates, number of guests, source and amount on a calendar and a status board from enquiry to checked out; and housekeeping tasks room by room." },
    { q: "Does it connect to Booking.com or Airbnb?", a: "No. There is no channel manager and no online booking engine; you enter reservations yourself and mark where each one came from." },
    { q: "Does it take payments?", a: "No. Reservations record the amount, and the app totals reservation value, but it does not take card payments." },
    { q: "Can I import guests from a spreadsheet?", a: FROM_SPREADSHEET },
  ],
  tutoring: [
    { q: "Is this tutoring software free?", a: `Yes for independent tutors. ${FREE_PLAN}` },
    { q: "What can I keep track of?", a: "Students with parent name, subject, level and goals; lessons on a calendar and a status board (scheduled, completed, cancelled, no-show) with duration, fee, lesson notes and homework; and lesson packages with hours bought, amount paid and expiry date." },
    { q: "Can I see hours taught and fees?", a: "Yes. Lesson hours and fees are totalled, and so are package hours and amounts paid." },
    { q: "Can parents or students book lessons themselves?", a: "Not in this app. You schedule the lessons; students and parents do not get a booking page." },
    { q: "Can I import my students from a spreadsheet?", a: FROM_SPREADSHEET },
  ],
  school: [
    { q: "What does the school records app do?", a: "It keeps student records with date of birth, class, guardian contact details, medical notes and status; classes with year level, teacher, room and capacity; daily attendance marked present, late, absent or excused on a calendar; and grades by subject, assessment and term with score and comments." },
    { q: "Is it free for a small school?", a: `There is a free plan. ${FREE_PLAN} A school with more than 3 staff users or more than 1,000 records will need a paid plan.` },
    { q: "Is it a full school management information system?", a: "No. It does not do timetabling, fees, report cards or parent messaging, so check it meets your local record-keeping rules before relying on it." },
    { q: "Can we import students from a spreadsheet?", a: FROM_SPREADSHEET },
    { q: "Who can see student information?", a: "Only the people you invite to your workspace. Each workspace is private to your school." },
  ],
  "music-lessons": [
    { q: "Is this music teacher software free?", a: `Yes for independent teachers. ${FREE_PLAN}` },
    { q: "What can I keep track of?", a: "Students with instrument, level, parent contact and term fee; lessons on a calendar and a status board (scheduled, taught, cancelled, make-up needed) with pieces covered and practice notes; grade exams with date, result and mark; and recitals with venue and number of performers." },
    { q: "Can I see which lessons need a make-up?", a: "Yes. Make-up needed is a lesson status, so those lessons are grouped on the board." },
    { q: "Does it take payments or send reminders?", a: "No. It records term fees and totals them, but it does not take payments or send messages to students or parents." },
    { q: "Can I import my students from a spreadsheet?", a: FROM_SPREADSHEET },
  ],
  volunteers: [
    { q: "Is this volunteer management software free?", a: `Yes for small charities and groups. ${FREE_PLAN}` },
    { q: "What does it record?", a: "A volunteer register with skills, availability, join date, status and whether a background check is done; shifts with role, time, location and volunteers needed on a calendar and a status board (open, filled, done, cancelled); and an hours log per volunteer and shift." },
    { q: "Can I report volunteer hours?", a: "Yes. Hours are totalled across the log, and you can export it to CSV." },
    { q: "Can volunteers sign up for shifts themselves?", a: "Not in this app. You assign volunteers; they do not get a sign-up page." },
    { q: "Can I import volunteers from a spreadsheet?", a: FROM_SPREADSHEET },
  ],
};
