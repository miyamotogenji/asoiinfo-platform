FROM php:8.2-cli

# System deps
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libxml2-dev libzip-dev \
    libonig-dev libpq-dev libsqlite3-dev sqlite3 \
    && docker-php-ext-install pdo pdo_pgsql pdo_sqlite \
       mbstring zip exif pcntl bcmath gd opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy source
COPY . .

# Pre-generate bootstrap caches (uses dummy .env so artisan can bootstrap)
RUN cp .env.example .env \
    && php artisan package:discover --ansi || true \
    && php artisan config:clear || true \
    && rm -f .env

# Permissions (running as root in Docker, storage must be writable)
RUN mkdir -p storage/framework/{sessions,views,cache/data} storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# Strip CRLF from entrypoint (Windows -> Linux line endings)
COPY docker-entrypoint.sh /entrypoint.sh
RUN sed -i 's/\r$//' /entrypoint.sh && chmod +x /entrypoint.sh

EXPOSE 80
CMD ["/entrypoint.sh"]
