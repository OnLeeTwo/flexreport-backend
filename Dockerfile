FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpq-dev unzip zip nginx supervisor

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Copy nginx config
COPY ./docker/nginx.conf /etc/nginx/sites-available/default

# Copy supervisord config
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port 8080 (Cloud Run expects this)
EXPOSE 8080

# Start nginx and php-fpm using supervisor
CMD ["/usr/bin/supervisord"]
