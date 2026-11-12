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
];
