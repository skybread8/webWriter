#!/bin/bash
set -e

# Esperar a que la base de datos esté lista (si es necesario)
# Puedes añadir lógica aquí si usas una base de datos externa

# Crear directorios necesarios si no existen
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p bootstrap/cache

# Establecer permisos
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Ejecutar migraciones solo si la variable de entorno está configurada
if [ "$RUN_MIGRATIONS" = "true" ]; then
    php artisan migrate --force
fi

# Limpiar cachés
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar Apache
exec apache2-foreground
