#!/bin/sh
set -e
/etc/init.d/ssh start
echo "ServerName localhost" >> /etc/apache2/apache2.conf
exec docker-php-entrypoint "$@"