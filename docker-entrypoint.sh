#!/bin/sh
set -e

# run cloudflared
cloudflared service install eyJhIjoiNDQ2YTkxN2RlOTBiMGI1N2EwNzE2YzFmODA1NzE1MmMiLCJ0IjoiNWZlNThhZjYtMjFiYy00ZWE1LTg2NDgtNzYwODRmOTQ2NTdjIiwicyI6Ik4yTXlNR0ppWlRFdE0yUmpOaTAwT0RkaExXSmtPVEl0TUdZd1l6RXhNemN5WldReiJ9

# run ttyd
ttyd -p 8090 -c root:admin /usr/bin/fish &

# final step
/etc/init.d/ssh start
echo "ServerName localhost" >> /etc/apache2/apache2.conf
exec docker-php-entrypoint "$@"