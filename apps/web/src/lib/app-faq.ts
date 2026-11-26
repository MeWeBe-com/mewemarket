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
};
