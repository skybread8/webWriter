#!/bin/bash
set -e

# Cambiar al directorio de trabajo
cd /var/www/html || exit 1

# Crear directorios necesarios si no existen (CRÍTICO: antes de cualquier operación de Laravel)
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p storage/app/public
mkdir -p bootstrap/cache
mkdir -p database

# Establecer permisos CRÍTICOS primero (antes de que Laravel intente escribir)
chown -R www-data:www-data storage bootstrap/cache database 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chmod -R 777 storage/logs 2>/dev/null || true
chmod -R 775 storage/app/public 2>/dev/null || true

# Crear enlace simbólico de storage (importante para que las imágenes se sirvan)
echo "=== Creating storage symlink ==="
# Eliminar enlace roto o directorio existente si es necesario
if [ -L public/storage ] && [ ! -e public/storage ]; then
    echo "Removing broken symlink..."
    rm -f public/storage
elif [ -d public/storage ] && [ ! -L public/storage ]; then
    echo "Removing existing directory (should be symlink)..."
    rm -rf public/storage
fi

# Crear el enlace simbólico
if [ ! -L public/storage ] && [ ! -d public/storage ]; then
    echo "Creating storage symlink..."
    php artisan storage:link 2>&1 || {
        echo "artisan storage:link failed, trying manual link..."
        ln -sfn ../storage/app/public public/storage 2>/dev/null || {
            echo "Manual link also failed, trying absolute path..."
            ln -sfn /var/www/html/storage/app/public /var/www/html/public/storage 2>/dev/null || true
        }
    }
fi

# Verificar y establecer permisos
if [ -L public/storage ] || [ -d public/storage ]; then
    echo "✓ Storage symlink exists"
    chown -h www-data:www-data public/storage 2>/dev/null || true
    ls -la public/storage | head -3
else
    echo "✗ WARNING: Storage symlink could not be created!"
    echo "Images may not be accessible"
fi
echo "=============================="

# Actualizar .env con variables de entorno actuales (importante: Render.com pasa variables en runtime)
if [ -f .env ]; then
    echo "Updating .env file with current environment variables..."
    
    # Prioridad: DATABASE_URL (Render.com) > DB_URL > variables individuales
    if [ -n "$DATABASE_URL" ]; then
        # Render.com proporciona DATABASE_URL, Laravel usa DB_URL
        echo "DATABASE_URL detected, setting DB_URL for Laravel..."
        (grep -q "^DB_URL=" .env && sed -i "s|^DB_URL=.*|DB_URL=${DATABASE_URL}|" .env || echo "DB_URL=${DATABASE_URL}" >> .env)
        # Asegurar que DB_CONNECTION=pgsql cuando hay DATABASE_URL
        (grep -q "^DB_CONNECTION=" .env && sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=pgsql|" .env || echo "DB_CONNECTION=pgsql" >> .env)
    elif [ -n "$DB_URL" ]; then
        # Si hay DB_URL directamente, usarla
        (grep -q "^DB_URL=" .env && sed -i "s|^DB_URL=.*|DB_URL=${DB_URL}|" .env || echo "DB_URL=${DB_URL}" >> .env)
        (grep -q "^DB_CONNECTION=" .env && sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=pgsql|" .env || echo "DB_CONNECTION=pgsql" >> .env)
    else
        # Usar variables individuales si no hay URL
        [ -n "$DB_CONNECTION" ] && (grep -q "^DB_CONNECTION=" .env && sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION}|" .env || echo "DB_CONNECTION=${DB_CONNECTION}" >> .env)
        [ -n "$DB_HOST" ] && (grep -q "^DB_HOST=" .env && sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST}|" .env || echo "DB_HOST=${DB_HOST}" >> .env)
        [ -n "$DB_PORT" ] && (grep -q "^DB_PORT=" .env && sed -i "s|^DB_PORT=.*|DB_PORT=${DB_PORT}|" .env || echo "DB_PORT=${DB_PORT}" >> .env)
        [ -n "$DB_DATABASE" ] && (grep -q "^DB_DATABASE=" .env && sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|" .env || echo "DB_DATABASE=${DB_DATABASE}" >> .env)
        [ -n "$DB_USERNAME" ] && (grep -q "^DB_USERNAME=" .env && sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME}|" .env || echo "DB_USERNAME=${DB_USERNAME}" >> .env)
        [ -n "$DB_PASSWORD" ] && (grep -q "^DB_PASSWORD=" .env && sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|" .env || echo "DB_PASSWORD=${DB_PASSWORD}" >> .env)
        [ -n "$DB_SSLMODE" ] && (grep -q "^DB_SSLMODE=" .env && sed -i "s|^DB_SSLMODE=.*|DB_SSLMODE=${DB_SSLMODE}|" .env || echo "DB_SSLMODE=${DB_SSLMODE}" >> .env)
    fi
    
    # Actualizar otras variables importantes
    [ -n "$APP_KEY" ] && (grep -q "^APP_KEY=" .env && sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env || echo "APP_KEY=${APP_KEY}" >> .env)
    if [ -n "$APP_URL" ]; then
        # Asegurar que APP_URL use HTTPS si no lo especifica
        APP_URL_CLEAN=$(echo "$APP_URL" | sed 's|^http://|https://|')
        (grep -q "^APP_URL=" .env && sed -i "s|^APP_URL=.*|APP_URL=${APP_URL_CLEAN}|" .env || echo "APP_URL=${APP_URL_CLEAN}" >> .env)
    fi
    [ -n "$SESSION_DRIVER" ] && (grep -q "^SESSION_DRIVER=" .env && sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=${SESSION_DRIVER}|" .env || echo "SESSION_DRIVER=${SESSION_DRIVER}" >> .env)
    [ -n "$CACHE_DRIVER" ] && (grep -q "^CACHE_DRIVER=" .env && sed -i "s|^CACHE_DRIVER=.*|CACHE_DRIVER=${CACHE_DRIVER}|" .env || echo "CACHE_DRIVER=${CACHE_DRIVER}" >> .env)
    
    echo ".env file updated"
else
    echo "WARNING: .env file not found!"
fi

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
    elif [ "$DB_CONN" = "pgsql" ] || [ -n "$DB_HOST" ] || [ -n "$DB_URL" ] || [ -n "$DATABASE_URL" ]; then
        echo "PostgreSQL configuration detected. Verifying connection settings..."
        if [ -z "$DB_HOST" ] && [ -z "$DB_URL" ] && [ -z "$DATABASE_URL" ] && ! grep -q "^DB_HOST=" .env 2>/dev/null && ! grep -q "^DB_URL=" .env 2>/dev/null; then
            echo "WARNING: PostgreSQL selected but DB_HOST, DB_URL, or DATABASE_URL not configured!"
            echo "Please configure DATABASE_URL (preferred) or DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD in Render.com"
        else
            echo "PostgreSQL configuration looks good"
            if [ -n "$DATABASE_URL" ] || grep -q "^DB_URL=" .env 2>/dev/null; then
                echo "Using database URL connection (DATABASE_URL/DB_URL)"
            fi
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

# Verificar que los assets compilados existan
echo "=== Checking Build Assets ==="
if [ -d public/build ] && [ -f public/build/manifest.json ]; then
    echo "✓ Build assets found in public/build/"
    echo "✓ manifest.json exists"
    echo "manifest.json content:"
    cat public/build/manifest.json
    echo ""
    echo "Build directory contents:"
    ls -la public/build/
    echo ""
    echo "Checking if assets are accessible..."
    if [ -d public/build/assets ]; then
        echo "✓ public/build/assets/ directory exists"
        ls -la public/build/assets/ | head -5
    else
        echo "✗ WARNING: public/build/assets/ directory not found"
    fi
else
    echo "✗ ERROR: Build assets not found!"
    echo "The application will not display correctly."
    echo "Expected: public/build/manifest.json"
    if [ -d public/build ]; then
        echo "public/build/ exists but manifest.json is missing"
        ls -la public/build/ 2>/dev/null || echo "public/build/ is empty"
    else
        echo "public/build/ directory does not exist"
        echo "Attempting to rebuild assets..."
        if [ -f package.json ]; then
            npm install 2>&1 | head -20
            npm run build 2>&1 || echo "Build failed"
        fi
    fi
fi
echo "=============================="

# Mostrar configuración de base de datos para debugging (sin mostrar contraseña)
echo "=== Database Configuration ==="
grep "^DB_" .env | sed 's/DB_PASSWORD=.*/DB_PASSWORD=***HIDDEN***/' | sed 's/DB_URL=.*:\/\/[^:]*:[^@]*@/DB_URL=***HIDDEN***@/' || echo "No DB configuration found in .env"
echo "=============================="

# Limpiar TODOS los cachés de forma agresiva (importante para que detecte assets nuevos)
echo "=== Clearing all Laravel caches ==="
php artisan optimize:clear || true
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true
php artisan event:clear || true
# Limpiar también cachés de archivos compilados
rm -rf bootstrap/cache/*.php 2>/dev/null || true
rm -rf storage/framework/views/*.php 2>/dev/null || true
echo "All caches cleared"
echo "=============================="

# Optimizar para producción (después de limpiar)
echo "=== Optimizing for production ==="
php artisan config:cache || echo "Warning: Config cache failed"
php artisan route:cache || echo "Warning: Route cache failed"
# NO cachear vistas en producción - pueden tener referencias a assets que cambian
# php artisan view:cache || echo "Warning: View cache failed"
echo "Optimization complete"
echo "=============================="

# Verificar permisos finales (incluyendo public/build para assets y storage/app/public para imágenes)
chown -R www-data:www-data storage bootstrap/cache database public/build 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chmod -R 777 storage/logs 2>/dev/null || true
chmod -R 775 storage/app/public 2>/dev/null || true
chmod -R 755 public/build 2>/dev/null || true

# Verificar que el enlace simbólico de storage existe (CRÍTICO para imágenes)
echo "=== Verifying storage symlink ==="
if [ -L public/storage ] || [ -d public/storage ]; then
    echo "✓ Storage symlink exists"
    ls -la public/storage | head -3
else
    echo "⚠️  WARNING: Storage symlink not found, creating..."
    php artisan storage:link || {
        echo "artisan storage:link failed, trying manual link..."
        rm -rf public/storage 2>/dev/null || true
        ln -sfn ../storage/app/public public/storage 2>/dev/null || true
        chown -h www-data:www-data public/storage 2>/dev/null || true
    }
    if [ -L public/storage ] || [ -d public/storage ]; then
        echo "✓ Storage symlink created successfully"
    else
        echo "✗ ERROR: Failed to create storage symlink!"
    fi
fi
echo "=============================="

echo "Starting Apache..."
# Iniciar Apache
exec apache2-foreground
