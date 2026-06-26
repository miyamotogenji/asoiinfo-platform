#!/bin/bash
cd /var/www/html

echo "=============================="
echo " ASOIINFO Platform - Startup"
echo "=============================="

# ── 1. APP_KEY ────────────────────────────────────────────────────────────────
if [ -z "$APP_KEY" ]; then
  APP_KEY=$(php -r "echo 'base64:'.base64_encode(random_bytes(32));")
  echo "[ok] APP_KEY generated"
else
  echo "[ok] APP_KEY from environment"
fi

# ── 2. Write .env ─────────────────────────────────────────────────────────────
cat > .env <<ENVEOF
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
ENVEOF
echo "[ok] .env written"

# ── 3. Discover packages (needed once at startup) ─────────────────────────────
php artisan package:discover --ansi 2>&1 || echo "[skip] package:discover"

# ── 4. Clear stale caches ─────────────────────────────────────────────────────
php artisan config:clear 2>&1 || echo "[skip] config:clear"
php artisan route:clear  2>&1 || echo "[skip] route:clear"
php artisan view:clear   2>&1 || echo "[skip] view:clear"

# ── 5. Migrate ────────────────────────────────────────────────────────────────
echo "[...] Running migrations..."
php artisan migrate --force --no-interaction 2>&1 || echo "[WARN] Migrations failed"

# ── 6. Seed if users table empty ──────────────────────────────────────────────
USER_COUNT=$(php -r "
try {
  \$pdo = new PDO(
    'pgsql:host='.(getenv('DB_HOST')?:'dpg-d8sqptvavr4c73arvuq0-a').';port='.(getenv('DB_PORT')?:'5432').';dbname='.(getenv('DB_DATABASE')?:'asoiinfo_db'),
    getenv('DB_USERNAME')?:'asoiinfo_db_user',
    getenv('DB_PASSWORD')?:'3rnRd1xnZdM6NZA3Tqcgq6e8lKHx2wJa',
    [PDO::ATTR_TIMEOUT=>5]
  );
  echo (int)\$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
} catch(Exception \$e) { echo 0; }
" 2>/dev/null || echo 0)
echo "[info] Users in DB: $USER_COUNT"
if [ "$USER_COUNT" = "0" ]; then
  php artisan db:seed --force --no-interaction 2>&1 || echo "[warn] Seed failed"
fi

# ── 7. Cache config/routes for performance ────────────────────────────────────
php artisan config:cache 2>&1 || echo "[skip] config:cache"
php artisan route:cache  2>&1 || echo "[skip] route:cache"

# ── 8. Start server ───────────────────────────────────────────────────────────
APP_PORT=${PORT:-10000}
echo "=============================="
echo " Starting on port ${APP_PORT}"
echo "=============================="
exec php artisan serve --host=0.0.0.0 --port=${APP_PORT}
