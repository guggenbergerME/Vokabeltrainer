FROM php:8.2-apache

# MySQL PDO-Treiber installieren
RUN docker-php-ext-install pdo pdo_mysql

# UTF-8 & locale
RUN apt-get update && apt-get install -y locales \
    && sed -i '/de_DE.UTF-8/s/^# //g' /etc/locale.gen \
    && locale-gen

ENV LANG=de_DE.UTF-8 \
    LANGUAGE=de_DE:de \
    LC_ALL=de_DE.UTF-8

# Apache Rewrite aktivieren (optional)
RUN a2enmod rewrite

# App-Code in den Container kopieren
COPY app/ /var/www/html/

# Rechte setzen
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
