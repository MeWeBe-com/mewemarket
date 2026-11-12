<?php
// MeweMarket multi-company router for Easy!Appointments, mounted as the app's config.php: one container, one
// database per company. Company "acme" lives at <EA_PUBLIC_BASE>/acme/ (its own origin, e.g.
// https://book.mewemarket.com/acme/, never MeweMarket's origin) in database ea_t_acme; unknown companies get
// 404. Started by start.sh, which points the app's own config at the constants defined here.
// Platform-only operations (header X-Platform-Key == EA_PLATFORM_KEY) are handled here before the app boots.
// Path-based companies: the reverse proxy maps https://<booking host>/<slug>/* to this container with the prefix
// stripped, and names the company in X-Ea-Tenant. That header is trusted only with the proxy's shared secret
// (X-Ea-Proxy-Key) or the platform key; a request without them is refused, so the container must not be public.
$isPlatform = isset($_SERVER['HTTP_X_PLATFORM_KEY']) && hash_equals((string) getenv('EA_PLATFORM_KEY'), $_SERVER['HTTP_X_PLATFORM_KEY']);
$isProxy = isset($_SERVER['HTTP_X_EA_PROXY_KEY']) && hash_equals((string) getenv('EA_PROXY_KEY'), $_SERVER['HTTP_X_EA_PROXY_KEY']);
if (PHP_SAPI === 'cli') { $slug = getenv('EA_TENANT') ?: 'none'; }
elseif (!($isPlatform || $isProxy) || !preg_match('/^[a-z0-9][a-z0-9-]{0,40}$/', $_SERVER['HTTP_X_EA_TENANT'] ?? '')) { http_response_code(404); exit('Unknown company'); }
else { $slug = $_SERVER['HTTP_X_EA_TENANT']; }
define('EA_PREFIX', '/' . $slug);
define('EA_BASE_URL', rtrim((string) getenv('EA_PUBLIC_BASE'), '/') . EA_PREFIX . '/');
$db = 'ea_t_' . str_replace('-', '_', $slug);
$sessDir = '/var/www/html/storage/sessions/' . $db;
$pdo = fn () => new PDO('mysql:host=' . getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$path = preg_replace('#^/index\.php#', '', parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
if (PHP_SAPI !== 'cli') {
    if (str_starts_with($path, '/__platform/')) {
        if (!$isPlatform) { http_response_code(403); exit; }
        header('content-type: application/json');
        if ($path === '/__platform/create') { $pdo()->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4"); @mkdir($sessDir, 0770, true); exit('{"ok":true}'); }
        if ($path === '/__platform/drop') { $pdo()->exec("DROP DATABASE IF EXISTS `$db`"); array_map('unlink', glob("$sessDir/*") ?: []); @rmdir($sessDir); exit('{"ok":true}'); }
        if ($path === '/__platform/end-sessions') { // ends every open session of one user in this company
            $uid = (int) ($_GET['user_id'] ?? 0); $n = 0;
            foreach (glob("$sessDir/ea_session*") ?: [] as $f) { if (preg_match('/user_id\|(i:' . $uid . ';|s:\d+:"' . $uid . '";)/', (string) @file_get_contents($f))) { unlink($f); $n++; } }
            exit(json_encode(['ended' => $n]));
        }
        if ($path === '/__platform/set-role') { // admin <-> provider (Easy!Appointments has no role-change API)
            $uid = (int) ($_GET['user_id'] ?? 0); $role = ($_GET['role'] ?? '') === 'admin' ? 'admin' : 'provider';
            $c = $pdo(); $c->exec("USE `$db`");
            $c->prepare("UPDATE ea_users SET id_roles = (SELECT id FROM ea_roles WHERE slug = ?) WHERE id = ? AND id_roles IN (SELECT id FROM ea_roles WHERE slug IN ('admin','provider'))")->execute([$role, $uid]);
            if ($role === 'provider') $c->prepare("UPDATE ea_user_settings SET working_plan = COALESCE(working_plan, (SELECT value FROM ea_settings WHERE name = 'company_working_plan')) WHERE id_users = ?")->execute([$uid]);
            $n = 0; foreach (glob("$sessDir/ea_session*") ?: [] as $f) { if (preg_match('/user_id\\|i:' . $uid . ';/', (string) @file_get_contents($f))) { unlink($f); $n++; } }
            exit(json_encode(['ok' => true, 'ended' => $n]));
        }
        http_response_code(404); exit;
    }
    $exists = $pdo()->query("SELECT 1 FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = " . $pdo()->quote($db))->fetchColumn();
    if (!$exists) { http_response_code(404); exit('Unknown company'); }
    // Only the platform may run the installer (otherwise anyone could claim a fresh company).
    if (preg_match('#^/installation#', $path) && !$isPlatform) { http_response_code(403); exit; }
}
define('EA_TENANT_DB', $db);
define('EA_DB_HOST', (string) getenv('DB_HOST'));
define('EA_DB_USERNAME', (string) getenv('DB_USERNAME'));
define('EA_DB_PASSWORD', (string) getenv('DB_PASSWORD'));
define('EA_SESS_DIR', $sessDir);
class Config {
    const BASE_URL = 'http://localhost';
    const LANGUAGE = 'english';
    const DEBUG_MODE = false;
    const DB_HOST = EA_DB_HOST;
    const DB_NAME = EA_TENANT_DB;
    const DB_USERNAME = EA_DB_USERNAME;
    const DB_PASSWORD = EA_DB_PASSWORD;
    const GOOGLE_SYNC_FEATURE = false;
    const GOOGLE_CLIENT_ID = '';
    const GOOGLE_CLIENT_SECRET = '';
}
