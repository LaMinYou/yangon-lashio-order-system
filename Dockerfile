# Stage 1: PHP Dependencies
FROM composer:latest as vendor
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --ignore-platform-reqs

# Stage 2: Node Dependencies & Build
FROM node:20-alpine as frontend
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./ 
# Copy tailwind/resources if needed
COPY resources ./resources 
RUN npm install && npm run build

# Stage 3: Final Production Image
FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    oniguruma-dev \
    icu-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip intl bcmath gd

WORKDIR /var/www

# Copy code and results from previous stages
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 8000

# Using artisan serve for simplicity, but consider Nginx for true production
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]