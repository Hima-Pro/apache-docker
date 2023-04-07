#!/bin/sh
set -e
echo "ServerName localhost" >> /etc/apache2/apache2.conf
exec docker-php-entrypoint "$@"