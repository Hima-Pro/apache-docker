FROM php:7.4-apache

# Setup packages and php extensions
ARG PKGS
ARG EXTS
RUN apt-get update
RUN apt-get install -y \
  sudo dialog software-properties-common \
  git fish nmap net-tools curl zip wget supervisor locales cron
RUN bash -c "apt-get install -y nano $PKGS"
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN bash -c "install-php-extensions zip gd $EXTS"

# Setup Apache server
RUN a2enmod rewrite
RUN a2enmod proxy
RUN a2enmod proxy_http
COPY server/site.conf /etc/apache2/sites-available/site.conf
RUN a2ensite site.conf
RUN a2dissite 000-default.conf

# configure php and project files
COPY ./htdocs /var/www/html
WORKDIR /var/www/html
RUN chown www-data:www-data /var/www/html/index.php
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
  echo "upload_max_filesize = 1024M" > "$PHP_INI_DIR/conf.d/uploads.ini" && \
  echo "post_max_size = 1024M" >> "$PHP_INI_DIR/conf.d/uploads.ini"

# install ttyd
RUN wget https://github.com/tsl0922/ttyd/releases/download/1.7.3/ttyd.x86_64 -O /usr/bin/ttyd 
RUN chmod 777 /usr/bin/ttyd

# final step
RUN apt-get autoclean && apt-get autoremove -y
COPY server /server
RUN chmod +x /server/*
COPY /server/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
ENTRYPOINT ["/server/entrypoint.sh"]
CMD ["/usr/bin/supervisord"]