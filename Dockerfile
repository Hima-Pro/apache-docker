FROM php:7.4-apache

# install php extensions
# COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
# RUN install-php-extensions pcntl mysqli

# configure php and project files
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./htdocs /var/www/html
WORKDIR /var/www/html

# update pkgs
RUN apt-get update

# install some pkgs 
RUN apt-get install -y \
  sudo dialog software-properties-common \
  git nmap openssl openssh-server \
  nano curl zip wget screen fish neofetch

# setup linux user with "admin" as a name and "changeme" as a password
RUN useradd -rm -d /home/admin -s /usr/bin/fish -g root -G sudo -p $(openssl passwd -1 changeme) admin

# enable apache rewrite mod
RUN a2enmod rewrite

# final step
EXPOSE 22
RUN apt-get autoclean && apt-get autoremove -y
COPY ./docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["apache2-foreground"]