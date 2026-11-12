#=========================================================================#
# MeweMarket AI Chat (Open WebUI) — HestiaCP nginx PROXY template, HTTP (port 80).
# Sends everything to HTTPS. Pair with mewemarket-ai-chat.stpl.
#=========================================================================#

server {
    listen      %ip%:%proxy_port%;
    server_name %domain_idn% %alias_idn%;
    error_log   /var/log/%web_system%/domains/%domain%.error.log error;

    location /.well-known/acme-challenge/ {
        root %docroot%;
    }

    location / {
        return 301 https://$host$request_uri;
    }
}
