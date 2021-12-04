FROM php:8.0-apache

RUN apt-get update \
  && a2enmod rewrite

# Copy Apache VHost
COPY docker/apache2.conf /etc/apache2/sites-available/advent_of_code.conf
RUN a2ensite advent_of_code.conf
