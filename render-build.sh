#!/usr/bin/env bash
set -e

echo "=== Installing PHP dependencies ==="
composer install --no-dev --optimize-autoloader --no-interaction

echo "=== Setting up environment ==="
cp .env.example .env
php artisan key:generate

echo "=== Setting up SQLite database ==="
mkdir -p /var/data
touch /var/data/database.sqlite

# Point DB to persistent disk
sed -i 's|DB_DATABASE=.*|DB_DATABASE=/var/data/database.sqlite|g' .env

echo "=== Running migrations and seeders ==="
php artisan migrate --force
php artisan db:seed --force

echo "=== Caching config/routes/views ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Creating storage link ==="
php artisan storage:link || true

echo "=== Build complete ==="
