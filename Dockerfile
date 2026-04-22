FROM php:8.2-cli

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

# Laravel required directories
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

RUN chmod -R 777 storage bootstrap/cache

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# IMPORTANT: only optimize (NO DB calls here)
RUN php artisan optimize:clear

# Start Laravel server
CMD php artisan serve --host=0.0.0.0 --port=10000