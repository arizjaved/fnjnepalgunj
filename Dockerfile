# Stage 1: Build Frontend Assets
# This stage uses a Node.js image to install npm dependencies and build the assets.
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Build Backend Dependencies
# This stage uses a Composer image to install PHP dependencies.
FROM composer:2 AS backend-builder
WORKDIR /app
COPY --from=frontend-builder /app/public/build ./public/build
COPY . .
# Install dependencies without running scripts first to avoid errors with missing .env
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist
# Now run scripts and optimize autoloader for production
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Optimize Laravel for production
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Stage 3: Production Image
# This is the final, lean image that will be deployed.
FROM php:8.2-apache
WORKDIR /var/www/html

# Install required PHP extensions for Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath exif

# Copy application files from the backend-builder stage
COPY --from=backend-builder /app .

# Set correct permissions for storage and bootstrap/cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configure Apache to use the public directory and enable URL rewriting
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Expose port 80 and start apache
EXPOSE 80

