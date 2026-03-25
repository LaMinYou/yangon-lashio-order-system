# Use PHP 8.3 FPM Alpine
FROM php:8.4-fpm-alpine

# 1. Install Node.js (needed for Vite/Tailwind)
COPY --from=node:20-alpine /usr/lib /usr/lib
COPY --from=node:20-alpine /usr/local/share /usr/local/share
COPY --from=node:20-alpine /usr/local/lib /usr/local/lib
COPY --from=node:20-alpine /usr/local/bin /usr/local/bin

# 2. Install system dependencies for PHP extensions
RUN apk add --no-cache \
    git curl libpng-dev libxml2-dev zip unzip oniguruma-dev libzip-dev icu-dev

# 3. Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# 4. Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Setup working directory
WORKDIR /var/www
COPY . /var/www

# 6. INSTALL PHP DEPENDENCIES (Fixes your error)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 7. INSTALL NODE & BUILD ASSETS (Fixes CSS/JS issues)
RUN npm install && npm run build

# 8. Set correct permissions for Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# ... (after your existing RUN apk add)
RUN apk add --no-cache netcat-openbsd

# ... (after your existing RUN chown/chmod)
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Change EXPOSE to match your serve port
EXPOSE 8000

# Use the entrypoint script instead of a direct CMD
ENTRYPOINT ["entrypoint.sh"]