FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip git curl zip libzip-dev libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql zip

WORKDIR /app

COPY composer.json composer.lock ./

RUN mkdir -p bootstrap/cache \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs \
    && chmod -R 777 bootstrap/cache storage

RUN composer install --no-dev --no-interaction --prefer-dist

COPY . .

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000