# Use the official PHP 8.2 FPM Alpine image as the base image
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk --no-cache add \
    postgresql-dev \
    libzip-dev \
    libpng \
    libpng-dev \
    oniguruma-dev \
    freetype \
    libjpeg-turbo \
    libjpeg-turbo-dev \
    libwebp \
    libwebp-dev \
    zlib-dev \
    nginx \
    nodejs \
    npm \
    autoconf \
    g++ \
    make \
    pkgconfig

# Install additional PHP extensions
RUN docker-php-ext-install pdo_pgsql zip exif gd

# Set the working directory
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install npm packages
RUN apk --no-cache add \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev \
    zlib-dev \
    && npm install -g npm

# Copy Laravel files
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Nginx configuration
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Expose ports
EXPOSE 9000
