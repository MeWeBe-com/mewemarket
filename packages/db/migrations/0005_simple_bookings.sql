-- "bookings" now belongs to the hosted Bookings app (Easy!Appointments); the built-in records app moves to "simple-bookings".
INSERT INTO "catalog_apps" ("id", "slug", "name", "tagline", "description", "tier", "category", "tags", "icon", "screenshots", "status", "definition", "license", "source_url", "powered_by", "version", "install_count")
SELECT 'simple-bookings', 'simple-bookings', 'Simple Bookings', "tagline", "description", "tier", "category", "tags", "icon", "screenshots", "status", "definition", "license", "source_url", "powered_by", "version", "install_count"
FROM "catalog_apps" WHERE "id" = 'bookings'
ON CONFLICT DO NOTHING;--> statement-breakpoint
UPDATE "installed_apps" SET "catalog_app_id" = 'simple-bookings' WHERE "catalog_app_id" = 'bookings';--> statement-breakpoint
UPDATE "records" SET "app" = 'simple-bookings' WHERE "app" = 'bookings';--> statement-breakpoint
UPDATE "catalog_apps" SET "install_count" = 0 WHERE "id" = 'bookings';
