#!/bin/bash
set -e

# Cambiar al directorio de trabajo
cd /var/www/html || exit 1

# Crear directorios necesarios si no existen (CRÍTICO: antes de cualquier operación de Laravel)
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache
mkdir -p database

# Establecer permisos CRÍTICOS primero (antes de que Laravel intente escribir)
chown -R www-data:www-data storage bootstrap/cache database 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chmod -R 777 storage/logs 2>/dev/null || true

# Verificar configuración de base de datos
if [ -f .env ]; then
    DB_CONN=$(grep "^DB_CONNECTION=" .env 2>/dev/null | cut -d '=' -f2 | tr -d '"' | tr -d "'" | xargs || echo "")
    
    if [ "$DB_CONN" = "sqlite" ]; then
        echo "SQLite detected. Creating database file..."
        DB_PATH=$(grep "^DB_DATABASE=" .env 2>/dev/null | cut -d '=' -f2 | tr -d '"' | tr -d "'" | xargs || echo "/var/www/html/database/database.sqlite")
        DB_DIR=$(dirname "$DB_PATH")
        
        mkdir -p "$DB_DIR" 2>/dev/null || true
        touch "$DB_PATH" 2>/dev/null || true
        chown www-data:www-data "$DB_PATH" 2>/dev/null || true
        chmod 664 "$DB_PATH" 2>/dev/null || true
        chown -R www-data:www-data "$DB_DIR" 2>/dev/null || true
        chmod -R 775 "$DB_DIR" 2>/dev/null || true
        echo "SQLite database ready at $DB_PATH"
    elif [ "$DB_CONN" = "pgsql" ] || [ -n "$DB_HOST" ] || [ -n "$DB_URL" ]; then
        echo "PostgreSQL configuration detected. Verifying connection settings..."
        if [ -z "$DB_HOST" ] && [ -z "$DB_URL" ] && ! grep -q "^DB_HOST=" .env 2>/dev/null && ! grep -q "^DB_URL=" .env 2>/dev/null; then
            echo "WARNING: PostgreSQL selected but DB_HOST or DB_URL not configured!"
            echo "Please configure DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD in Render.com"
        else
            echo "PostgreSQL configuration looks good"
        fi
    else
        echo "WARNING: No database connection configured!"
        echo "Please set DB_CONNECTION=pgsql and PostgreSQL credentials in Render.com"
    fi
fi

# Asegurar que el archivo de log existe y tiene permisos correctos
touch storage/logs/laravel.log 2>/dev/null || true
chown www-data:www-data storage/logs/laravel.log 2>/dev/null || true
chmod 666 storage/logs/laravel.log 2>/dev/null || true

# Ejecutar migraciones solo si la variable de entorno está configurada
if [ "$RUN_MIGRATIONS" = "true" ]; then
    php artisan migrate --force || echo "Warning: Migrations failed"
fi

# Limpiar cachés
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

# Optimizar para producción
php artisan config:cache || echo "Warning: Config cache failed"
php artisan route:cache || echo "Warning: Route cache failed"
php artisan view:cache || echo "Warning: View cache failed"

# Verificar permisos finales
chown -R www-data:www-data storage bootstrap/cache database 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chmod -R 777 storage/logs 2>/dev/null || true

echo "Starting Apache..."
# Iniciar Apache
exec apache2-foreground
