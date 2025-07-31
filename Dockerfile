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

# Create a basic .env file for build process
RUN cp .env.example .env || echo "APP_NAME=Laravel" > .env
RUN echo "APP_ENV=production" >> .env
RUN echo "APP_KEY=" >> .env
RUN echo "APP_DEBUG=false" >> .env
RUN echo "APP_URL=http://localhost" >> .env

# Install dependencies without running scripts first to avoid errors
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist
# Now run scripts and optimize autoloader for production
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Generate application key
RUN php artisan key:generate --no-interaction

# Skip all artisan cache commands during build - they'll run at startup
# This prevents build-time errors with missing environment variables

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
    && docker-php-ext-install gd pdo pdo_mysql bcmath exif \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy application files from the backend-builder stage
COPY --from=backend-builder /app .

# Remove the build .env and let Render provide the real one
RUN rm -f .env

# Set correct permissions for storage and bootstrap/cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configure Apache to use the public directory and enable URL rewriting
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Expose port 80 and start apache
EXPOSE 80
CMD ["apache2-foreground"]