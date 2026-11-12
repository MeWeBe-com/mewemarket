#!/usr/bin/env bash
# One-time setup of the hosted apps' platform accounts (safe to run again). Run from the repo root after
# `docker compose up -d`, with .env filled in (see docs/DEPLOY.md, "Hosted apps"). Twenty needs nothing
# here: MeweMarket creates its platform account on first use.
#   bash infra/hosted-setup.sh [invoiceshelf] [chatwoot] [plane]
set -euo pipefail
cd "$(dirname "$0")/.."
set -a; . ./.env; set +a
apps=("$@"); [ ${#apps[@]} -eq 0 ] && apps=(invoiceshelf chatwoot plane)

for app in "${apps[@]}"; do case "$app" in

invoiceshelf)
  echo "== InvoiceShelf: tables, then the platform account (the install's owner)"
  docker compose exec -T invoiceshelf php artisan migrate --seed --force >/dev/null
  docker compose exec -T -e PE="$INVOICESHELF_PLATFORM_EMAIL" -e PP="$INVOICESHELF_PLATFORM_PASSWORD" invoiceshelf php artisan tinker --execute='
    App\Models\Setting::setSetting("profile_complete", "COMPLETED");
    $u = App\Models\User::where("email", getenv("PE"))->first() ?? App\Models\User::where("email", "admin@invoiceshelf.com")->first();
    $u->email = getenv("PE"); $u->password = getenv("PP"); $u->name = "MeweMarket"; $u->save();
    App\Models\Company::where("owner_id", $u->id)->orderBy("id")->first()?->update(["name" => "MeweMarket (platform)"]);
    echo "platform user {$u->id}\n";'
  ;;

chatwoot)
  echo "== Chatwoot: database, super admin and the platform-app token"
  docker compose run --rm chatwoot bundle exec rails db:chatwoot_prepare >/dev/null
  token=$(docker compose exec -T -e PE="${CHATWOOT_PLATFORM_EMAIL:-platform@${INVOICESHELF_HOST#invoices.}}" chatwoot bundle exec rails runner '
    SuperAdmin.find_or_create_by!(email: ENV["PE"]) { |s| s.name = "MeweMarket"; s.password = SecureRandom.base64(24) + "aA1!"; s.confirmed_at = Time.now }
    ::Redis::Alfred.delete(::Redis::Alfred::CHATWOOT_INSTALLATION_ONBOARDING)
    print PlatformApp.find_or_create_by!(name: "mewemarket").access_token.token' | tail -1)
  echo "Put this in .env:  CHATWOOT_PLATFORM_TOKEN=$token"
  ;;

plane)
  echo "== Plane: instance admin (MeweMarket's platform account), then public sign-up off"
  base="${PLANE_INTERNAL_URL:-http://127.0.0.1:3230}"; host=$(echo "$PLANE_URL" | sed -E 's#^https?://##; s#/.*##')
  jar=$(mktemp); trap 'rm -f "$jar"' EXIT
  hdr=(-H "Host: $host" -H "Origin: $PLANE_URL" -H "Referer: $PLANE_URL/" -H "X-Forwarded-Proto: ${PLANE_URL%%:*}")
  csrf=$(curl -sf "${hdr[@]}" -c "$jar" -b "$jar" "$base/auth/get-csrf-token/" | python3 -c 'import json,sys; print(json.load(sys.stdin)["csrf_token"])')
  # Creates the admin on a fresh instance; afterwards it's refused, so sign in instead.
  loc=$(curl -s -o /dev/null -w '%{redirect_url}' "${hdr[@]}" -c "$jar" -b "$jar" -X POST "$base/api/instances/admins/sign-up/" \
    --data-urlencode "csrfmiddlewaretoken=$csrf" --data-urlencode "email=$PLANE_PLATFORM_EMAIL" --data-urlencode "password=$PLANE_PLATFORM_PASSWORD" \
    --data-urlencode "first_name=MeweMarket" --data-urlencode "company_name=MeweMarket")
  if echo "$loc" | grep -q error_code; then
    loc=$(curl -s -o /dev/null -w '%{redirect_url}' "${hdr[@]}" -c "$jar" -b "$jar" -X POST "$base/api/instances/admins/sign-in/" \
      --data-urlencode "csrfmiddlewaretoken=$csrf" --data-urlencode "email=$PLANE_PLATFORM_EMAIL" --data-urlencode "password=$PLANE_PLATFORM_PASSWORD")
  fi
  echo "admin: ${loc:-ok}"
  ctok=$(awk '$6=="csrftoken"{print $7}' "$jar" | tail -1)
  curl -sf "${hdr[@]}" -c "$jar" -b "$jar" -X PATCH "$base/api/instances/configurations/" -H "X-CSRFToken: $ctok" -H 'Content-Type: application/json' \
    -d '{"ENABLE_SIGNUP":"0"}' >/dev/null && echo "public sign-up: off"
  ;;

*) echo "unknown app: $app" >&2; exit 1 ;;
esac; done
