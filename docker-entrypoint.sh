#!/bin/bash
cd /var/www/html

echo "=============================="
echo " ASOIINFO Platform - Startup"
echo "=============================="

# ── 1. Write .env (echo-based, no heredoc) ───────────────────────────────────
{
  echo "APP_NAME=${APP_NAME:-ASOIINFO Platform}"
  echo "APP_ENV=${APP_ENV:-production}"
  echo "APP_KEY=${APP_KEY:-}"
  echo "APP_DEBUG=${APP_DEBUG:-false}"
  echo "APP_URL=${APP_URL:-http://localhost}"
  echo "LOG_CHANNEL=${LOG_CHANNEL:-stderr}"
  echo "LOG_LEVEL=error"
  echo "DB_CONNECTION=${DB_CONNECTION:-pgsql}"
  echo "DB_HOST=${DB_HOST:-127.0.0.1}"
  echo "DB_PORT=${DB_PORT:-5432}"
  echo "DB_DATABASE=${DB_DATABASE:-asoiinfo_db}"
  echo "DB_USERNAME=${DB_USERNAME:-asoiinfo_db_user}"
  echo "DB_PASSWORD=${DB_PASSWORD:-}"
  echo "SESSION_DRIVER=${SESSION_DRIVER:-cookie}"
  echo "SESSION_LIFETIME=120"
  echo "SESSION_SECURE_COOKIE=true"
  echo "CACHE_STORE=${CACHE_STORE:-database}"
  echo "QUEUE_CONNECTION=sync"
  echo "TRUSTED_PROXIES=*"
} > .env
echo "[ok] .env written"
echo "     DB_HOST=${DB_HOST:-127.0.0.1}  DB=${DB_DATABASE:-asoiinfo_db}"

# ── 2. Generate APP_KEY if not provided ──────────────────────────────────────
if [ -z "$APP_KEY" ]; then
  php artisan key:generate --force --no-interaction 2>&1 && echo "[ok] APP_KEY generated" || echo "[warn] key:generate failed"
else
  echo "[ok] APP_KEY set by Render"
fi

# ── 3. Clear stale cache (all non-fatal) ─────────────────────────────────────
php artisan config:clear 2>/dev/null && echo "[ok] config cleared"  || echo "[skip] config:clear"
php artisan route:clear  2>/dev/null && echo "[ok] route cleared"   || echo "[skip] route:clear"
php artisan view:clear   2>/dev/null && echo "[ok] view cleared"    || echo "[skip] view:clear"

# ── 4. Migrate (NON-FATAL so Apache always starts — error visible in logs) ───
echo "[...] Running migrations..."
if php artisan migrate --force --no-interaction 2>&1; then
  echo "[ok] Migrations complete"
else
  echo "[WARN] Migrations FAILED — app may have DB errors"
  echo "       DB_HOST=${DB_HOST:-unset}  DB_PORT=${DB_PORT:-unset}"
  echo "       DB_DATABASE=${DB_DATABASE:-unset}  DB_USERNAME=${DB_USERNAME:-unset}"
fi

# ── 5. Seed only if users table is empty ────────────────────────────────────
USER_COUNT=$(php -r "
try {
  \$h  = getenv('DB_HOST')     ?: '127.0.0.1';
  \$p  = getenv('DB_PORT')     ?: '5432';
  \$db = getenv('DB_DATABASE') ?: 'asoiinfo_db';
  \$u  = getenv('DB_USERNAME') ?: 'asoiinfo_db_user';
  \$pw = getenv('DB_PASSWORD') ?: '';
  \$pdo = new PDO(\"pgsql:host=\$h;port=\$p;dbname=\$db\", \$u, \$pw, [PDO::ATTR_TIMEOUT => 5]);
  echo (int)\$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
} catch(Exception \$e){ echo 0; }
" 2>/dev/null)
USER_COUNT="${USER_COUNT:-0}"
echo "[info] User count: $USER_COUNT"

if [ "$USER_COUNT" = "0" ]; then
  echo "[...] Seeding database..."
  php artisan db:seed --force --no-interaction 2>&1 && echo "[ok] Seeded" || echo "[warn] Seed skipped"
fi

# ── 6. Cache for production ──────────────────────────────────────────────────
php artisan config:cache 2>/dev/null && echo "[ok] config cached" || echo "[skip] config:cache"
php artisan route:cache  2>/dev/null && echo "[ok] route cached"  || echo "[skip] route:cache"
php artisan view:cache   2>/dev/null && echo "[ok] view cached"   || echo "[skip] view:cache"

echo "=============================="
echo " Starting Apache..."
echo "=============================="
exec apache2-foreground
