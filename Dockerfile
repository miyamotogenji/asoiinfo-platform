FROM php:8.2-cli

# ── System dependencies ────────────────────────────────────────────────────────
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libxml2-dev libzip-dev libonig-dev \
    libpq-dev libsqlite3-dev sqlite3 \
    libicu-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
        pdo pdo_pgsql pdo_sqlite \
        mbstring zip pcntl bcmath intl gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ── Composer ───────────────────────────────────────────────────────────────────
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ── PHP dependencies ───────────────────────────────────────────────────────────
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --no-autoloader

# ── Application source ─────────────────────────────────────────────────────────
COPY . .

# ── Optimised autoloader (includes app/ classes) ──────────────────────────────
RUN composer dump-autoload --optimize --no-interaction --no-scripts

# ── Permissions ───────────────────────────────────────────────────────────────
RUN mkdir -p storage/framework/{sessions,views,cache/data} storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# ── Entrypoint (strip Windows CRLF) ───────────────────────────────────────────
COPY docker-entrypoint.sh /entrypoint.sh
RUN sed -i 's/\r$//' /entrypoint.sh && chmod +x /entrypoint.sh

EXPOSE 10000
CMD ["/entrypoint.sh"]
