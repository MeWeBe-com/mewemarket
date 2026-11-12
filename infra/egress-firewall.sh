#!/usr/bin/env bash
# Stops MeweMarket's containers (the hosted apps and their databases, all on the docker-compose network bridge
# "mewe-br", 172.30.0.0/16) from reaching the server itself or any private, loopback or cloud-metadata address.
# They can still reach each other on that network and the public internet (customers' webhooks, email, etc.).
# This closes server-side request forgery through any product's webhooks, integrations or URL fetches, whatever
# that product's own checks do.
#
# Idempotent; run as root after Docker starts (installed as a boot service by `--install`):
#   bash infra/egress-firewall.sh            # apply now
#   bash infra/egress-firewall.sh --install  # apply now and at every boot
#   bash infra/egress-firewall.sh --remove   # take it off
set -euo pipefail
BR=${BRIDGE:-mewe-br}
NET=${SUBNET:-172.30.0.0/16}
# Host ports the containers may still use, e.g. "587" when this server's own mail (Hestia/Exim) is their SMTP.
ALLOW_HOST_PORTS=${ALLOW_HOST_PORTS:-}
BLOCK="10.0.0.0/8 172.16.0.0/12 192.168.0.0/16 169.254.0.0/16 100.64.0.0/10 127.0.0.0/8 0.0.0.0/8 224.0.0.0/4 240.0.0.0/4"

ipt() { iptables -w "$@"; }
hook() { ipt -C "$1" "${@:2}" 2>/dev/null || ipt -I "$1" 1 "${@:2}"; }

remove() {
  ipt -D DOCKER-USER -i "$BR" -j MEWE-EGRESS 2>/dev/null || true
  ipt -D INPUT -i "$BR" -j MEWE-HOST 2>/dev/null || true
  for c in MEWE-EGRESS MEWE-HOST; do ipt -F "$c" 2>/dev/null || true; ipt -X "$c" 2>/dev/null || true; done
}

if [ "${1:-}" = "--remove" ]; then remove; echo "removed"; exit 0; fi

# Traffic the containers send through the host to other networks.
ipt -N MEWE-EGRESS 2>/dev/null || ipt -F MEWE-EGRESS
ipt -A MEWE-EGRESS -m conntrack --ctstate ESTABLISHED,RELATED -j RETURN
ipt -A MEWE-EGRESS -d "$NET" -j RETURN
for n in $BLOCK; do ipt -A MEWE-EGRESS -d "$n" -j REJECT --reject-with icmp-net-prohibited; done
ipt -A MEWE-EGRESS -j RETURN
ipt -N DOCKER-USER 2>/dev/null || true
hook DOCKER-USER -i "$BR" -j MEWE-EGRESS

# Traffic the containers send to the host itself (its own services: MeweMarket, SSH, Hestia, other sites).
ipt -N MEWE-HOST 2>/dev/null || ipt -F MEWE-HOST
ipt -A MEWE-HOST -m conntrack --ctstate ESTABLISHED,RELATED -j ACCEPT
for port in $ALLOW_HOST_PORTS; do ipt -A MEWE-HOST -p tcp --dport "$port" -j ACCEPT; done
ipt -A MEWE-HOST -j REJECT --reject-with icmp-port-unreachable
hook INPUT -i "$BR" -j MEWE-HOST

echo "egress firewall on for $BR ($NET)"

if [ "${1:-}" = "--install" ]; then
  cp "$0" /usr/local/sbin/mewemarket-egress-firewall && chmod 755 /usr/local/sbin/mewemarket-egress-firewall
  cat > /etc/systemd/system/mewemarket-egress-firewall.service <<'UNIT'
[Unit]
Description=MeweMarket container egress firewall
After=docker.service
Requires=docker.service

[Service]
Type=oneshot
RemainAfterExit=yes
ExecStart=/usr/local/sbin/mewemarket-egress-firewall
ExecStop=/usr/local/sbin/mewemarket-egress-firewall --remove

[Install]
WantedBy=multi-user.target
UNIT
  systemctl daemon-reload && systemctl enable --now mewemarket-egress-firewall.service
  echo "installed as mewemarket-egress-firewall.service"
fi
