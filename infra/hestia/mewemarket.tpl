#=========================================================================#
# MeweMarket — HestiaCP nginx PROXY template, HTTP (port 80)              #
# Proxies everything to the Next.js app run by PM2 as "mewemarket" on     #
# 127.0.0.1:35300. Copy to /usr/local/hestia/data/templates/web/nginx/    #
# and apply to mewemarket.com only:                                       #
#   v-change-web-domain-proxy-tpl saasthemes mewemarket.com mewemarket    #
# Roll back: v-change-web-domain-proxy-tpl saasthemes mewemarket.com default
#=========================================================================#

server {
    listen      %ip%:%proxy_port%;
    server_name %domain_idn% %alias_idn%;
    error_log   /var/log/%web_system%/domains/%domain%.error.log error;

    include %home%/%user%/conf/web/%domain%/nginx.forcessl.conf*;

    client_max_body_size 20m;

    location ~ /\.(?!well-known\/) {
        deny all;
        return 404;
    }

    location /_next/static/ {
        proxy_pass         http://127.0.0.1:35300;
        proxy_http_version 1.1;
        proxy_set_header   Host              $host;
        proxy_set_header   X-Real-IP         $remote_addr;
        proxy_set_header   X-Forwarded-For   $proxy_add_x_forwarded_for;
        proxy_set_header   X-Forwarded-Proto $scheme;
        expires            365d;
        add_header         Cache-Control "public, max-age=31536000, immutable";
        access_log         off;
    }

    # Video-meeting signalling is a long-lived event stream: no buffering, long timeouts.
    location /api/meet/ {
        proxy_pass         http://127.0.0.1:35300;
        proxy_http_version 1.1;
        proxy_set_header   Host              $host;
        proxy_set_header   X-Real-IP         $remote_addr;
        proxy_set_header   X-Forwarded-For   $proxy_add_x_forwarded_for;
        proxy_set_header   X-Forwarded-Proto $scheme;
        proxy_set_header   Connection        "";
        proxy_buffering    off;
        proxy_cache        off;
        gzip               off;
        proxy_read_timeout 1h;
    }

    location / {
        proxy_pass         http://127.0.0.1:35300;
        proxy_set_header   Accept-Encoding   "";
        proxy_http_version 1.1;
        proxy_set_header   Host              $host;
        proxy_set_header   X-Real-IP         $remote_addr;
        proxy_set_header   X-Forwarded-For   $proxy_add_x_forwarded_for;
        proxy_set_header   X-Forwarded-Proto $scheme;
        proxy_set_header   X-Forwarded-Host  $host;
        proxy_set_header   Upgrade           $http_upgrade;
        proxy_set_header   Connection        "upgrade";
        proxy_read_timeout 120s;
        proxy_send_timeout 120s;
        proxy_buffering    on;
    }

    location /error/ {
        alias %home%/%user%/web/%domain%/document_errors/;
    }

    # Per-domain includes: Let's Encrypt, and the mewebe-seo insights block (/insights/, llms.txt, verification files).
    include %home%/%user%/conf/web/%domain%/nginx.conf_*;
}
