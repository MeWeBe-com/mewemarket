import {
  AppWindow, Award, BadgeDollarSign, Banknote, Barcode, Bed, BookOpen, Bookmark, Boxes, Briefcase, Bug, Building2, Calculator, Calendar,
  CalendarCheck, Car, ChartLine, ChefHat, ClipboardCheck, ClipboardList, Clock, Code, Coffee, Contact, CreditCard, Dog, Dumbbell, FileSignature,
  FileText, Fingerprint, FolderKanban, Gavel, Gift, GraduationCap, Hammer, HandCoins, HandHeart, Handshake, HardHat, Hash, Headset, HeartHandshake,
  HeartPulse, Home, IdCard, KeyRound, Landmark, LayoutGrid, Library, Link2, ListChecks, Mail, MapPin, Megaphone, MessageSquare, Microscope,
  Music, Notebook, Package, Palette, PartyPopper, Percent, PiggyBank, Plane, QrCode, Receipt, Scale, Scissors, Shield, ShoppingCart, Smile,
  Sparkles, Star, Stethoscope, Store, Tag, Target, Ticket, Timer, Truck, Type, Users, Utensils, Video, Wallet, Warehouse, Wrench,
  type LucideIcon, type LucideProps,
} from "lucide-react";

// One colour per category, so apps read as families across the site and the workspace.
export const CATEGORY_TONE: Record<string, { from: string; to: string; soft: string; text: string }> = {
  business: { from: "#6366f1", to: "#8b5cf6", soft: "#eef2ff", text: "#4f46e5" },
  application: { from: "#0ea5e9", to: "#6366f1", soft: "#e0f2fe", text: "#0369a1" },
  "customer-service": { from: "#06b6d4", to: "#0ea5e9", soft: "#ecfeff", text: "#0e7490" },
  education: { from: "#f59e0b", to: "#f97316", soft: "#fffbeb", text: "#b45309" },
  finance: { from: "#10b981", to: "#059669", soft: "#ecfdf5", text: "#047857" },
  legal: { from: "#64748b", to: "#334155", soft: "#f1f5f9", text: "#334155" },
  logistics: { from: "#f97316", to: "#ef4444", soft: "#fff7ed", text: "#c2410c" },
  marketing: { from: "#ec4899", to: "#f43f5e", soft: "#fdf2f8", text: "#be185d" },
  sales: { from: "#8b5cf6", to: "#d946ef", soft: "#f5f3ff", text: "#6d28d9" },
  hr: { from: "#14b8a6", to: "#06b6d4", soft: "#f0fdfa", text: "#0f766e" },
  healthcare: { from: "#ef4444", to: "#f43f5e", soft: "#fef2f2", text: "#b91c1c" },
  hospitality: { from: "#eab308", to: "#f59e0b", soft: "#fefce8", text: "#a16207" },
  property: { from: "#84cc16", to: "#22c55e", soft: "#f7fee7", text: "#4d7c0f" },
  community: { from: "#f43f5e", to: "#ec4899", soft: "#fff1f2", text: "#be123c" },
  developer: { from: "#3b82f6", to: "#1d4ed8", soft: "#eff6ff", text: "#1d4ed8" },
};
export const tone = (category?: string | null) => CATEGORY_TONE[category ?? ""] ?? CATEGORY_TONE.business!;

// First match wins; checked against "slug name".
const MATCH: [RegExp, LucideIcon][] = [
  [/crm|pipeline|deal/, Handshake], [/invoice|quote|billing/, Receipt], [/project|kanban|task/, FolderKanban], [/inventory|stock/, Boxes],
  [/warehouse/, Warehouse], [/payroll|salary/, Banknote], [/expense|claim/, Wallet], [/budget/, PiggyBank], [/bank|reconcil/, Landmark],
  [/petty|cash/, HandCoins], [/purchase|procure|supplier/, ShoppingCart], [/\bpos\b|shop|store|retail/, Store], [/tax|vat|percent|margin/, Percent],
  [/loan|calculator|mortgage/, Calculator], [/subscription|recurring|credit/, CreditCard], [/affiliate|commission/, BadgeDollarSign],
  [/\bhr\b|team|staff|employee|people/, Users], [/leave|holiday|absence/, Plane], [/time|timesheet|attendance|clock/, Clock], [/shift|rota/, CalendarCheck],
  [/recruit|hiring|applicant|job/, IdCard], [/training|course|learning|lesson/, GraduationCap], [/school|student|exam|class/, BookOpen],
  [/library|book/, Library], [/clinic|patient|medical|doctor/, Stethoscope], [/dental|dentist/, Smile], [/vet|pet|animal/, Dog],
  [/pharma|\blab\b|sample/, Microscope], [/care|health|therapy|physio/, HeartPulse], [/gym|fitness|sport/, Dumbbell], [/salon|beauty|barber|spa/, Scissors],
  [/hotel|guest|room|hostel/, Bed], [/restaurant|menu|table|kitchen|recipe/, Utensils], [/catering|chef/, ChefHat], [/cafe|coffee/, Coffee],
  [/event|party|wedding/, PartyPopper], [/ticket/, Ticket], [/booking|appointment|schedul|calendar/, Calendar],
  [/property|tenant|lease|landlord|rental|real-estate/, Home], [/facility|building|office|desk/, Building2], [/maintenance|repair|asset|equipment/, Wrench],
  [/construction|building-site|contractor/, HardHat], [/workshop|trade|joinery/, Hammer], [/fleet|vehicle|\bcars?\b|mileage|driver/, Car],
  [/shipment|delivery|courier|logistic|freight/, Truck], [/parcel|order|package/, Package], [/barcode|sku/, Barcode],
  [/contract|signature|e-sign/, FileSignature], [/legal|matter|\bcases?\b|court/, Gavel], [/compliance|policy|risk|gdpr|audit|security/, Shield],
  [/campaign|marketing|\bads\b/, Megaphone], [/newsletter|email|mail/, Mail], [/survey|feedback|poll|review/, MessageSquare], [/social|influencer|brand/, Sparkles],
  [/donor|donation|fundrais|charity/, HandHeart], [/volunteer|member|club|community|church/, HeartHandshake], [/grant/, Gift], [/award|certificate/, Award],
  [/support|helpdesk|ticketing|customer/, Headset], [/contact|address/, Contact], [/visitor|reception|access/, Fingerprint], [/password|\bkeys?\b/, KeyRound],
  [/bug|issue|defect/, Bug], [/wiki|knowledge|doc/, FileText], [/note|journal/, Notebook], [/bookmark|link/, Bookmark], [/goal|okr|target/, Target],
  [/checklist|inspection|quality/, ClipboardCheck], [/form|register|log/, ClipboardList], [/todo|list/, ListChecks], [/rating|testimonial/, Star],
  [/music|band|studio/, Music], [/design|colour|color|palette/, Palette], [/location|map|route/, MapPin], [/\btags?\b|label/, Tag],
  [/qr/, QrCode], [/video|meeting/, Video], [/pomodoro|timer|countdown/, Timer], [/hash|uuid|base64|jwt|encod/, Hash], [/url|slug/, Link2],
  [/text|case|word|lorem|markdown/, Type], [/json|csv|regex|code|diagram|database/, Code], [/whiteboard|draw/, Palette], [/\bage\b|date|zone|timestamp/, Calendar],
  [/unit|convert/, Calculator], [/finance|account/, ChartLine], [/sales/, Handshake],
];
const CATEGORY_ICON: Record<string, LucideIcon> = {
  business: Briefcase, application: AppWindow, "customer-service": Headset, education: GraduationCap, finance: ChartLine, legal: Scale,
  logistics: Truck, marketing: Megaphone, sales: Handshake, hr: Users, healthcare: Stethoscope, hospitality: Bed, property: Building2,
  community: HeartHandshake, developer: Code,
};

// Where keywords guess wrong.
const OVERRIDE: Record<string, LucideIcon> = {
  "ai-assistant": Sparkles,
  bookings: Calendar, wiki: BookOpen, bookmarks: Bookmark, "habit-tracker": ListChecks, onboarding: ClipboardCheck,
  "restaurant-reservations": Utensils, catering: ChefHat, "library-loans": Library, helpdesk: Headset, "warranty-claims": Shield,
  "field-service": Wrench, returns: Package, "returns-rma": Package, "trade-shows": Ticket, "ip-register": Award, "nda-tracker": FileSignature,
  "sales-territories": MapPin, "price-lists": Tag, fundraising: HandHeart, "seo-keywords": Target, "json-formatter": Code, "case-converter": Type,
  "markdown-preview": FileText, "driving-school": Car, "music-lessons": Music, "freight-quotes": Truck, "supplier-scorecard": Star,
  "rent-collection": HandCoins, "property-inspections": ClipboardCheck, "performance-reviews": Star, "utility-meters": Building2, "age-calculator": Calendar,
};

export function iconFor(slug: string, name = "", category?: string | null): LucideIcon {
  if (OVERRIDE[slug]) return OVERRIDE[slug];
  const key = `${slug} ${name}`.toLowerCase();
  return MATCH.find(([re]) => re.test(key))?.[1] ?? CATEGORY_ICON[category ?? ""] ?? LayoutGrid;
}

const SIZES = { sm: ["size-7 rounded-lg", 15], md: ["size-10 rounded-xl", 20], lg: ["size-14 rounded-2xl", 28], xl: ["size-20 rounded-3xl", 40] } as const;

/** Gradient tile with the app's icon, coloured by category. */
export function AppIcon({ slug, name, category, size = "md", className = "" }: { slug: string; name?: string; category?: string | null; size?: keyof typeof SIZES; className?: string }) {
  const Icon = iconFor(slug, name, category);
  const t = tone(category);
  const [box, px] = SIZES[size];
  return (
    <span aria-hidden className={`grid shrink-0 place-items-center text-white shadow-sm ring-1 ring-black/5 ${box} ${className}`}
      style={{ backgroundImage: `linear-gradient(135deg, ${t.from}, ${t.to})`, boxShadow: `0 6px 16px -6px ${t.from}99, inset 0 1px 0 #ffffff40` }}>
      <Icon size={px} strokeWidth={2} />
    </span>
  );
}

export function CategoryIcon({ category, ...p }: { category: string } & LucideProps) {
  const Icon = CATEGORY_ICON[category] ?? LayoutGrid;
  return <Icon {...p} />;
}
