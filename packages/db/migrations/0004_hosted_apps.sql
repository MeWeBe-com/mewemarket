CREATE TABLE "hosted_accounts" (
	"id" text PRIMARY KEY NOT NULL,
	"provider" text NOT NULL,
	"user_id" text NOT NULL,
	"scope" text DEFAULT '' NOT NULL,
	"login" text NOT NULL,
	"password_enc" text NOT NULL,
	"created_at" timestamp with time zone DEFAULT now() NOT NULL
);
--> statement-breakpoint
CREATE TABLE "hosted_members" (
	"tenant_id" text NOT NULL,
	"user_id" text NOT NULL,
	"external_member_id" text NOT NULL,
	"role" text NOT NULL,
	"created_at" timestamp with time zone DEFAULT now() NOT NULL,
	CONSTRAINT "hosted_members_tenant_id_user_id_pk" PRIMARY KEY("tenant_id","user_id")
);
--> statement-breakpoint
CREATE TABLE "hosted_tenants" (
	"id" text PRIMARY KEY NOT NULL,
	"workspace_id" text NOT NULL,
	"provider" text NOT NULL,
	"external_id" text NOT NULL,
	"subdomain" text NOT NULL,
	"url" text NOT NULL,
	"created_at" timestamp with time zone DEFAULT now() NOT NULL
);
--> statement-breakpoint
ALTER TABLE "hosted_accounts" ADD CONSTRAINT "hosted_accounts_user_id_users_id_fk" FOREIGN KEY ("user_id") REFERENCES "public"."users"("id") ON DELETE cascade ON UPDATE no action;--> statement-breakpoint
ALTER TABLE "hosted_members" ADD CONSTRAINT "hosted_members_tenant_id_hosted_tenants_id_fk" FOREIGN KEY ("tenant_id") REFERENCES "public"."hosted_tenants"("id") ON DELETE cascade ON UPDATE no action;--> statement-breakpoint
ALTER TABLE "hosted_members" ADD CONSTRAINT "hosted_members_user_id_users_id_fk" FOREIGN KEY ("user_id") REFERENCES "public"."users"("id") ON DELETE cascade ON UPDATE no action;--> statement-breakpoint
ALTER TABLE "hosted_tenants" ADD CONSTRAINT "hosted_tenants_workspace_id_workspaces_id_fk" FOREIGN KEY ("workspace_id") REFERENCES "public"."workspaces"("id") ON DELETE cascade ON UPDATE no action;--> statement-breakpoint
CREATE UNIQUE INDEX "hosted_account_provider_user_uq" ON "hosted_accounts" USING btree ("provider","user_id","scope");--> statement-breakpoint
CREATE UNIQUE INDEX "hosted_tenant_ws_provider_uq" ON "hosted_tenants" USING btree ("workspace_id","provider");
--> statement-breakpoint
-- "crm" now belongs to a hosted app; the built-in records app moves to "contacts".
INSERT INTO "catalog_apps" ("id", "slug", "name", "tagline", "description", "tier", "category", "tags", "icon", "screenshots", "status", "definition", "license", "source_url", "powered_by", "version", "install_count")
SELECT 'contacts', 'contacts', 'Contacts & Deals', "tagline", "description", "tier", "category", "tags", "icon", "screenshots", "status", "definition", "license", "source_url", "powered_by", "version", "install_count"
FROM "catalog_apps" WHERE "id" = 'crm'
ON CONFLICT DO NOTHING;--> statement-breakpoint
UPDATE "installed_apps" SET "catalog_app_id" = 'contacts' WHERE "catalog_app_id" = 'crm';--> statement-breakpoint
UPDATE "records" SET "app" = 'contacts' WHERE "app" = 'crm';--> statement-breakpoint
UPDATE "catalog_apps" SET "install_count" = 0 WHERE "id" = 'crm';
--> statement-breakpoint
-- "invoices" now belongs to a hosted app; the built-in records app moves to "quick-invoices".
INSERT INTO "catalog_apps" ("id", "slug", "name", "tagline", "description", "tier", "category", "tags", "icon", "screenshots", "status", "definition", "license", "source_url", "powered_by", "version", "install_count")
SELECT 'quick-invoices', 'quick-invoices', 'Quick Invoices', "tagline", "description", "tier", "category", "tags", "icon", "screenshots", "status", "definition", "license", "source_url", "powered_by", "version", "install_count"
FROM "catalog_apps" WHERE "id" = 'invoices'
ON CONFLICT DO NOTHING;--> statement-breakpoint
UPDATE "installed_apps" SET "catalog_app_id" = 'quick-invoices' WHERE "catalog_app_id" = 'invoices';--> statement-breakpoint
UPDATE "records" SET "app" = 'quick-invoices' WHERE "app" = 'invoices';--> statement-breakpoint
UPDATE "catalog_apps" SET "install_count" = 0 WHERE "id" = 'invoices';
--> statement-breakpoint
-- "projects" now belongs to a hosted app; the built-in records app moves to "simple-projects".
INSERT INTO "catalog_apps" ("id", "slug", "name", "tagline", "description", "tier", "category", "tags", "icon", "screenshots", "status", "definition", "license", "source_url", "powered_by", "version", "install_count")
SELECT 'simple-projects', 'simple-projects', 'Simple Projects', "tagline", "description", "tier", "category", "tags", "icon", "screenshots", "status", "definition", "license", "source_url", "powered_by", "version", "install_count"
FROM "catalog_apps" WHERE "id" = 'projects'
ON CONFLICT DO NOTHING;--> statement-breakpoint
UPDATE "installed_apps" SET "catalog_app_id" = 'simple-projects' WHERE "catalog_app_id" = 'projects';--> statement-breakpoint
UPDATE "records" SET "app" = 'simple-projects' WHERE "app" = 'projects';--> statement-breakpoint
UPDATE "catalog_apps" SET "install_count" = 0 WHERE "id" = 'projects';
--> statement-breakpoint
-- "helpdesk" now belongs to a hosted app; the built-in records app moves to "simple-helpdesk".
INSERT INTO "catalog_apps" ("id", "slug", "name", "tagline", "description", "tier", "category", "tags", "icon", "screenshots", "status", "definition", "license", "source_url", "powered_by", "version", "install_count")
SELECT 'simple-helpdesk', 'simple-helpdesk', 'Simple Helpdesk', "tagline", "description", "tier", "category", "tags", "icon", "screenshots", "status", "definition", "license", "source_url", "powered_by", "version", "install_count"
FROM "catalog_apps" WHERE "id" = 'helpdesk'
ON CONFLICT DO NOTHING;--> statement-breakpoint
UPDATE "installed_apps" SET "catalog_app_id" = 'simple-helpdesk' WHERE "catalog_app_id" = 'helpdesk';--> statement-breakpoint
UPDATE "records" SET "app" = 'simple-helpdesk' WHERE "app" = 'helpdesk';--> statement-breakpoint
UPDATE "catalog_apps" SET "install_count" = 0 WHERE "id" = 'helpdesk';
