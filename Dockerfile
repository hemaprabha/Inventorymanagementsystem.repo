FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# 🔥 FIX: create ALL required Laravel directories
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache# 🔥 FIX: give permissions

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Clear cached config (important)
RUN rm -rf bootstrap/cache/*.php

EXPOSE 10000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000