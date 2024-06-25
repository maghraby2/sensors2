# Use the nginx-php-fpm base image
FROM richarvey/nginx-php-fpm:1.7.2

# Set working directory
WORKDIR /var/www/html

# Copy the application code to the container
COPY . .

# Install dependencies and Composer
RUN apk add --no-cache git unzip curl php8 php8-phar php8-openssl \
    && curl -sS https://getcomposer.org/installer | php8 \
    && mv composer.phar /usr/local/bin/composer \
    && composer install --no-dev --optimize-autoloader \
    && apk del git unzip curl

# Set permissions for Laravel
RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache

# Environment variables
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy custom nginx configuration
COPY docker/nginx/default.conf /etc/nginx/sites-available/default

# Expose port 80
EXPOSE 80

# Start the container
CMD ["/start.sh"]