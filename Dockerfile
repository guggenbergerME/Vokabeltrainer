FROM php:8.2-apache

# Apache Rewrite aktivieren (falls später gebraucht)
RUN a2enmod rewrite

# App-Code in das Apache-Verzeichnis kopieren
COPY app/ /var/www/html/

# Rechte setzen
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
