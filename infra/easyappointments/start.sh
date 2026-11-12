#!/bin/sh
F=/var/www/html/application/config/config.php
# Per-company session folder, no IP pinning (sign-in happens server-side), base URL and cookie path under /<slug>/book.
sed -i "s#^\$config\['sess_save_path'\].*#\$config['sess_save_path'] = EA_SESS_DIR;#; s#^\$config\['sess_match_ip'\].*#\$config['sess_match_ip'] = false;#; s#^\$config\['base_url'\] = rtrim(.*#\$config['base_url'] = rtrim(EA_BASE_URL, '/');#; s#^\$config\['cookie_path'\].*#\$config['cookie_path'] = EA_PREFIX . '/';#" $F
grep -nE "^\\\$config\['(sess_save_path|sess_match_ip|base_url|cookie_path)'\]" $F
chown -R www-data /var/www/html/storage
exec apache2-foreground
