FROM php:8.2-apache

# MySQL PDO-Treiber installieren
RUN docker-php-ext-install pdo pdo_mysql

# (Optional) Apache-Module aktivieren
RUN a2enmod rewrite

# App in den Container kopieren
COPY app/ /var/www/html/

# Rechte setzen
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
