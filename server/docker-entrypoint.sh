#!/bin/sh
set -e

if [ -z "$TTYD_AUTH" ]; then
  TTYD_AUTH="admin:1234"
fi

# run ttyd
ttyd -p 8090 -c $TTYD_AUTH /usr/bin/fish &

# final step
echo "ServerName localhost" >> /etc/apache2/apache2.conf
exec docker-php-entrypoint "$@"