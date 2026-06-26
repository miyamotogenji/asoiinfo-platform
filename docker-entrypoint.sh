#!/bin/bash
cd /var/www/html

echo "=============================="
echo " ASOIINFO Platform - Startup"
echo "=============================="

# ── 1. Generate APP_KEY if missing ────────────────────────────────────────────
if [ -z "$APP_KEY" ]; then
  APP_KEY=$(php -r "echo 'base64:'.base64_encode(random_bytes(32));")
  echo "[ok] APP_KEY generated"
else
  echo "[ok] APP_KEY from environment"
fi

# ── 2. Write .env ─────────────────────────────────────────────────────────────
cat > .env <<EOF
APP_NAME=${APP_NAME:-ASOIINFO Platform}
APP_ENV=${APP_ENV:-production}
APP_KEY=$APP_KEY
APP_DEBUG=true
APP_URL=${APP_URL:-https://asoiinfo-platform-1.onrender.com}
LOG_CHANNEL=${LOG_CHANNEL:-stderr}
LOG_LEVEL=debug
DB_CONNECTION=${DB_CONNECTION:-pgsql}
DB_HOST=${DB_HOST:-dpg-d8sqptvavr4c73arvuq0-a}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE:-asoiinfo_db}
DB_USERNAME=${DB_USERNAME:-asoiinfo_db_user}
DB_PASSWORD=${DB_PASSWORD:-3rnRd1xnZdM6NZA3Tqcgq6e8lKHx2wJa}
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
CACHE_STORE=file
QUEUE_CONNECTION=sync
TRUSTED_PROXIES=*
EOF
echo "[ok] .env written"

# ── 3. Clear old caches ───────────────────────────────────────────────────────
php artisan config:clear || echo "[skip] config:clear"
php artisan route:clear  || echo "[skip] route:clear"
php artisan view:clear   || echo "[skip] view:clear"

# ── 4. Migrate (non-fatal) ────────────────────────────────────────────────────
echo "[...] Migrating..."
php artisan migrate --force --no-interaction 2>&1 || echo "[WARN] Migrations failed"

# ── 5. Seed if users table is empty ───────────────────────────────────────────
USER_COUNT=$(php -r "
try {
  \$pdo = new PDO(
    'pgsql:host=' . (getenv('DB_HOST') ?: 'dpg-d8sqptvavr4c73arvuq0-a') . ';port=' . (getenv('DB_PORT') ?: '5432') . ';dbname=' . (getenv('DB_DATABASE') ?: 'asoiinfo_db'),
    getenv('DB_USERNAME') ?: 'asoiinfo_db_user',
    getenv('DB_PASSWORD') ?: '3rnRd1xnZdM6NZA3Tqcgq6e8lKHx2wJa',
    [PDO::ATTR_TIMEOUT => 5]
  );
  echo (int)\$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
} catch(Exception \$e) { echo 0; }
" 2>/dev/null || echo 0)
echo "[info] Users: $USER_COUNT"
if [ "$USER_COUNT" = "0" ]; then
  php artisan db:seed --force --no-interaction 2>&1 || echo "[warn] Seed failed"
fi

# ── 6. Cache for performance ──────────────────────────────────────────────────
php artisan config:cache || echo "[skip] config:cache"
php artisan route:cache  || echo "[skip] route:cache"

APP_PORT=${PORT:-80}
echo "=============================="
echo " Starting PHP server on :${APP_PORT}"
echo "=============================="
exec php artisan serve --host=0.0.0.0 --port=${APP_PORT}
