FROM php:8.2-cli

WORKDIR /app

COPY . .

# Create required Laravel folders
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Set permissions
RUN chmod -R 777 storage bootstrap/cache

# Install dependencies (skip scripts)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Clear caches
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan view:clear

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000