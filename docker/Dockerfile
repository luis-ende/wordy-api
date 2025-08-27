FROM php:8.4-apache

# Enable rewrite
RUN a2enmod rewrite

COPY ./sqlite/schema.sql schema.sql

# Install MySQL extensions (pdo_mysql + mysqli for compatibility)
RUN apt-get update && apt-get install -y sqlite3 \
    && mkdir -p /var/www/db \
    && rm -f /var/www/db/wordy.db \
    && touch /var/www/db/wordy.db \
    && sqlite3 /var/www/db/wordy.db < schema.sql \
    && rm -rf /var/lib/apt/lists/*

RUN chown -R www-data:www-data /var/www/db

# Copy in our own VirtualHost config
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Install Xdebug via PECL
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Copy a custom Xdebug configuration
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini