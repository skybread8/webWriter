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

# Crear base de datos SQLite si no existe (solo si DB_CONNECTION=sqlite)
if [ -f .env ]; then
    if grep -q "DB_CONNECTION=sqlite" .env 2>/dev/null || [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
        DB_PATH=$(grep "DB_DATABASE=" .env 2>/dev/null | cut -d '=' -f2 | tr -d '"' | tr -d "'" | xargs || echo "/var/www/html/database/database.sqlite")
        DB_DIR=$(dirname "$DB_PATH")
        
        echo "SQLite database path: $DB_PATH"
        echo "SQLite database directory: $DB_DIR"
        
        # Crear directorio si no existe
        mkdir -p "$DB_DIR" 2>/dev/null || true
        
        # Crear archivo de base de datos si no existe
        if [ ! -f "$DB_PATH" ]; then
            echo "Creating SQLite database file at $DB_PATH..."
            touch "$DB_PATH" 2>/dev/null || {
                echo "Warning: Could not create database file at $DB_PATH, trying default location..."
                touch /var/www/html/database/database.sqlite 2>/dev/null || true
                DB_PATH="/var/www/html/database/database.sqlite"
            }
        fi
        
        # Establecer permisos en el archivo de base de datos
        chown www-data:www-data "$DB_PATH" 2>/dev/null || true
        chmod 664 "$DB_PATH" 2>/dev/null || true
        chown -R www-data:www-data "$DB_DIR" 2>/dev/null || true
        chmod -R 775 "$DB_DIR" 2>/dev/null || true
        echo "SQLite database ready at $DB_PATH"
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
