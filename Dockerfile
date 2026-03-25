# Stage 1: PHP Dependencies
FROM composer:latest as vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --ignore-platform-reqs

# Stage 2: Node Dependencies
FROM node:20-alpine as frontend
WORKDIR /app
COPY package.json package-lock.json vite.config.js tailwind.config.js* postcss.config.js* ./ 
COPY resources ./resources
COPY public ./public
RUN npm install && npm run build

# Stage 3: Final Production Image (UPGRADED TO 8.4)
FROM php:8.4-fpm-alpine

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

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip intl bcmath gd

WORKDIR /var/www
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build
COPY --from=vendor /usr/bin/composer /usr/bin/composer

# Added --ignore-platform-reqs just to be extra safe during the dump
RUN composer dump-autoload --optimize --no-dev --ignore-platform-reqs

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]