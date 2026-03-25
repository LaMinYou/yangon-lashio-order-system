# ===============================
# Stage 1: Composer / PHP Dependencies
# ===============================
FROM composer:latest AS vendor

# Install PHP extensions required for Composer dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip unzip git \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install gd zip bcmath intl

WORKDIR /app

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# ===============================
# Stage 2: Frontend Build
# ===============================
FROM node:20-alpine AS frontend
WORKDIR /app

# Copy all frontend files and build assets
COPY . .
RUN npm install && npm run build

# ===============================
# Stage 3: Final Production Image
# ===============================
FROM php:8.3-fpm-alpine

# Install runtime PHP extensions for Laravel
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip unzip git \
    oniguruma-dev \
    icu-dev \
    bash \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo_mysql mbstring zip intl bcmath gd

WORKDIR /var/www

# Copy application code
COPY . .

# Copy Composer vendor from Stage 1
COPY --from=vendor /app/vendor ./vendor

# Copy built frontend assets from Stage 2
COPY --from=frontend /app/public/build ./public/build

# Set permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]