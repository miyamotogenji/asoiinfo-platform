#!/bin/bash
set -e
cd /var/www/html

echo "=== ASOIINFO Startup ==="

# ── 1. Build .env from Render environment variables ──────────────
cat > .env <<EOF
APP_NAME="${APP_NAME:-ASOIINFO Platform}"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY:-}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}

LOG_CHANNEL=${LOG_CHANNEL:-stderr}
LOG_LEVEL=error

DB_CONNECTION=${DB_CONNECTION:-pgsql}
DB_HOST=${DB_HOST:-127.0.0.1}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE:-asoiinfo_db}
DB_USERNAME=${DB_USERNAME:-asoiinfo_db_user}
DB_PASSWORD=${DB_PASSWORD:-}

SESSION_DRIVER=${SESSION_DRIVER:-cookie}
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
CACHE_STORE=${CACHE_STORE:-database}
QUEUE_CONNECTION=sync
TRUSTED_PROXIES=*
EOF

echo "✓ .env written"

# ── 2. Generate APP_KEY only if not provided ──────────────────────
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force --no-interaction
    echo "✓ APP_KEY generated"
else
    echo "✓ APP_KEY from environment"
fi

# ── 3. Clear any stale cache ──────────────────────────────────────
php artisan config:clear  2>/dev/null || true
php artisan cache:clear   2>/dev/null || true
php artisan route:clear   2>/dev/null || true
php artisan view:clear    2>/dev/null || true
echo "✓ Cache cleared"

# ── 4. Run migrations ─────────────────────────────────────────────
echo "Running migrations..."
php artisan migrate --force --no-interaction
echo "✓ Migrations done"

# ── 5. Seed only if users table is empty ─────────────────────────
USERS=$(php -r "
require '/var/www/html/vendor/autoload.php';
\$app = require '/var/www/html/bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
echo \App\Models\User::count();
" 2>/dev/null || echo "0")

if [ "$USERS" = "0" ] || [ -z "$USERS" ]; then
    echo "Seeding database..."
    php artisan db:seed --force --no-interaction 2>&1 || echo "Seed skipped (already has data)"
fi
echo "✓ Seed check done"

# ── 6. Cache config & routes for production ───────────────────────
php artisan config:cache  2>/dev/null && echo "✓ Config cached" || echo "Config cache skipped"
php artisan route:cache   2>/dev/null && echo "✓ Routes cached" || echo "Route cache skipped"
php artisan view:cache    2>/dev/null && echo "✓ Views cached"  || echo "View cache skipped"

echo "=== Starting Apache ==="
exec apache2-foreground
