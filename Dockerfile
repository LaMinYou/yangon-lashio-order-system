# Stage 1: PHP Dependencies
FROM composer:latest as vendor
WORKDIR /app
COPY composer.json composer.lock ./
# We ignore platform reqs here because we install them in the final stage
RUN composer install --no-dev --no-scripts --no-autoloader --ignore-platform-reqs

# Stage 2: Node Dependencies & Build
FROM node:20-alpine as frontend
WORKDIR /app
COPY package.json package-lock.json vite.config.js tailwind.config.js* postcss.config.js* ./ 
COPY resources ./resources
COPY public ./public
RUN npm install && npm run build

# Stage 3: Final Production Image
FROM php:8.3-fpm-alpine

# Install system dependencies using APK (Alpine's manager)
RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    oniguruma-dev \
    icu-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    bash

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip intl bcmath gd

WORKDIR /var/www

# Copy code
COPY . .

# Copy vendor from Stage 1 and built assets from Stage 2
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

# Generate the final autoloader
COPY --from=vendor /usr/bin/composer /usr/bin/composer
RUN composer dump-autoload --optimize --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]