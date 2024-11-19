FROM php:8.3.2-apache

COPY . /var/www/html
# Install mysqli extension
RUN docker-php-ext-install mysqli
# Dockerfile example
RUN mkdir -p /var/www/html/uploads
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R g+rw /var/www/html