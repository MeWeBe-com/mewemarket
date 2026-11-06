CREATE EXTENSION IF NOT EXISTS pg_trgm;--> statement-breakpoint
CREATE TABLE "records" (
	"id" text PRIMARY KEY NOT NULL,
	"workspace_id" text NOT NULL,
	"app" text NOT NULL,
	"entity" text NOT NULL,
	"data" jsonb DEFAULT '{}'::jsonb NOT NULL,
	"search" text DEFAULT '' NOT NULL,
	"created_by" text,
	"updated_by" text,
	"created_at" timestamp with time zone DEFAULT now() NOT NULL,
	"updated_at" timestamp with time zone DEFAULT now() NOT NULL
);
--> statement-breakpoint
ALTER TABLE "records" ADD CONSTRAINT "records_workspace_id_workspaces_id_fk" FOREIGN KEY ("workspace_id") REFERENCES "public"."workspaces"("id") ON DELETE cascade ON UPDATE no action;--> statement-breakpoint
CREATE INDEX "records_ws_app_entity_idx" ON "records" USING btree ("workspace_id","app","entity","created_at");--> statement-breakpoint
CREATE INDEX IF NOT EXISTS "records_search_trgm_idx" ON "records" USING gin ("search" gin_trgm_ops);
