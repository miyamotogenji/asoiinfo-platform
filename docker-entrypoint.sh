#!/bin/bash
set -e

cd /var/www/html

# Generate app key if missing
php artisan key:generate --no-interaction --force 2>/dev/null || true

# Run migrations (safe to run multiple times)
php artisan migrate --force --no-interaction

# Seed only if users table is empty
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | grep -E '^[0-9]+$' | tail -1)
if [ -z "$USER_COUNT" ] || [ "$USER_COUNT" = "0" ]; then
    echo "Seeding initial data..."
    php artisan db:seed --force --no-interaction || true
fi

# Cache for performance
php artisan config:cache  || true
php artisan route:cache   || true
php artisan view:cache    || true

echo "Starting Apache..."
apache2-foreground
