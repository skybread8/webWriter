# Usar imagen base de PHP con Apache
FROM php:8.2-apache

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libsqlite3-dev \
    libpq-dev \
    zip \
    unzip \
    ca-certificates \
    gnupg \
    && mkdir -p /etc/apt/keyrings \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_20.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_mysql pdo_sqlite pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Configurar Apache para Laravel
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear script de inicio
RUN cat > /usr/local/bin/start.sh << 'EOF'
#!/bin/bash
set -e

# Cambiar al directorio de trabajo
cd /var/www/html || exit 1

# Verificar que artisan existe
if [ ! -f artisan ]; then
    echo "ERROR: artisan file not found in /var/www/html"
    ls -la /var/www/html | head -20
    exit 1
fi

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

# Crear o actualizar archivo .env con variables de entorno de Render.com
echo "Creating/updating .env file from environment variables..."

# Crear archivo .env base
cat > .env << ENVEOF
APP_NAME="${APP_NAME:-Laravel}"
APP_ENV="${APP_ENV:-production}"
APP_KEY="${APP_KEY:-}"
APP_DEBUG="${APP_DEBUG:-false}"
APP_URL="${APP_URL:-https://localhost}"

LOG_CHANNEL=stack
LOG_LEVEL="${LOG_LEVEL:-error}"

DB_CONNECTION="${DB_CONNECTION:-pgsql}"
ENVEOF

# Añadir variables de base de datos (siempre, para asegurar que estén actualizadas)
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

# Añadir otras variables opcionales
[ -n "$STRIPE_SECRET" ] && (grep -q "^STRIPE_SECRET=" .env && sed -i "s|^STRIPE_SECRET=.*|STRIPE_SECRET=${STRIPE_SECRET}|" .env || echo "STRIPE_SECRET=${STRIPE_SECRET}" >> .env)
[ -n "$SESSION_DRIVER" ] && (grep -q "^SESSION_DRIVER=" .env && sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=${SESSION_DRIVER}|" .env || echo "SESSION_DRIVER=${SESSION_DRIVER}" >> .env)
[ -n "$CACHE_DRIVER" ] && (grep -q "^CACHE_DRIVER=" .env && sed -i "s|^CACHE_DRIVER=.*|CACHE_DRIVER=${CACHE_DRIVER}|" .env || echo "CACHE_DRIVER=${CACHE_DRIVER}" >> .env)
[ -n "$QUEUE_CONNECTION" ] && (grep -q "^QUEUE_CONNECTION=" .env && sed -i "s|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=${QUEUE_CONNECTION}|" .env || echo "QUEUE_CONNECTION=${QUEUE_CONNECTION}" >> .env)
[ -n "$MAIL_MAILER" ] && (grep -q "^MAIL_MAILER=" .env && sed -i "s|^MAIL_MAILER=.*|MAIL_MAILER=${MAIL_MAILER}|" .env || echo "MAIL_MAILER=${MAIL_MAILER}" >> .env)
[ -n "$MAIL_HOST" ] && (grep -q "^MAIL_HOST=" .env && sed -i "s|^MAIL_HOST=.*|MAIL_HOST=${MAIL_HOST}|" .env || echo "MAIL_HOST=${MAIL_HOST}" >> .env)
[ -n "$MAIL_PORT" ] && (grep -q "^MAIL_PORT=" .env && sed -i "s|^MAIL_PORT=.*|MAIL_PORT=${MAIL_PORT}|" .env || echo "MAIL_PORT=${MAIL_PORT}" >> .env)
[ -n "$MAIL_USERNAME" ] && (grep -q "^MAIL_USERNAME=" .env && sed -i "s|^MAIL_USERNAME=.*|MAIL_USERNAME=${MAIL_USERNAME}|" .env || echo "MAIL_USERNAME=${MAIL_USERNAME}" >> .env)
[ -n "$MAIL_PASSWORD" ] && (grep -q "^MAIL_PASSWORD=" .env && sed -i "s|^MAIL_PASSWORD=.*|MAIL_PASSWORD=${MAIL_PASSWORD}|" .env || echo "MAIL_PASSWORD=${MAIL_PASSWORD}" >> .env)
[ -n "$MAIL_ENCRYPTION" ] && (grep -q "^MAIL_ENCRYPTION=" .env && sed -i "s|^MAIL_ENCRYPTION=.*|MAIL_ENCRYPTION=${MAIL_ENCRYPTION}|" .env || echo "MAIL_ENCRYPTION=${MAIL_ENCRYPTION}" >> .env)
[ -n "$MAIL_FROM_ADDRESS" ] && (grep -q "^MAIL_FROM_ADDRESS=" .env && sed -i "s|^MAIL_FROM_ADDRESS=.*|MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS}|" .env || echo "MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS}" >> .env)
[ -n "$MAIL_FROM_NAME" ] && (grep -q "^MAIL_FROM_NAME=" .env && sed -i "s|^MAIL_FROM_NAME=.*|MAIL_FROM_NAME=${MAIL_FROM_NAME}|" .env || echo "MAIL_FROM_NAME=${MAIL_FROM_NAME}" >> .env)
[ -n "$APP_LOCALE" ] && (grep -q "^APP_LOCALE=" .env && sed -i "s|^APP_LOCALE=.*|APP_LOCALE=${APP_LOCALE}|" .env || echo "APP_LOCALE=${APP_LOCALE}" >> .env)
[ -n "$APP_FALLBACK_LOCALE" ] && (grep -q "^APP_FALLBACK_LOCALE=" .env && sed -i "s|^APP_FALLBACK_LOCALE=.*|APP_FALLBACK_LOCALE=${APP_FALLBACK_LOCALE}|" .env || echo "APP_FALLBACK_LOCALE=${APP_FALLBACK_LOCALE}" >> .env)

echo ".env file created/updated successfully"

# Establecer permisos en .env
chown www-data:www-data .env 2>/dev/null || true
chmod 644 .env 2>/dev/null || true

# Verificar que APP_KEY esté configurada correctamente
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null || [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "APP_KEY not set or invalid. Generating one..."
    php artisan key:generate --force 2>&1 || {
        echo "Failed to generate APP_KEY with artisan, trying alternative method..."
        # Generar clave manualmente si artisan falla
        KEY=$(php -r "echo 'base64:'.base64_encode(random_bytes(32));")
        if grep -q "APP_KEY=" .env; then
            sed -i "s|APP_KEY=.*|APP_KEY=${KEY}|" .env 2>/dev/null || \
            sed -i "s|^APP_KEY=.*|APP_KEY=${KEY}|" .env
        else
            echo "APP_KEY=${KEY}" >> .env
        fi
        echo "APP_KEY generated successfully"
    }
fi

# Asegurar permisos finales después de todas las operaciones
chown -R www-data:www-data storage bootstrap/cache .env 2>/dev/null || true
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage/logs 2>/dev/null || true
chmod 644 .env 2>/dev/null || true

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

# Ejecutar scripts de Composer que requieren Laravel configurado
php artisan package:discover --ansi || echo "Warning: Package discovery failed"

# Ejecutar migraciones solo si la variable de entorno está configurada
if [ "$RUN_MIGRATIONS" = "true" ]; then
    php artisan migrate --force || echo "Warning: Migrations failed, continuing..."
fi

# Limpiar TODOS los cachés ANTES de optimizar (importante para que lea el .env actualizado)
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

# Verificar que los assets compilados existan
echo "=== Checking Build Assets ==="
if [ -d public/build ] && [ -f public/build/manifest.json ]; then
    echo "✓ Build assets found in public/build/"
    ls -la public/build/ | head -5
else
    echo "⚠ WARNING: Build assets not found!"
fi
echo "=============================="

# Mostrar configuración de base de datos para debugging (sin mostrar contraseña)
echo "=== Database Configuration ==="
grep "^DB_" .env | sed 's/DB_PASSWORD=.*/DB_PASSWORD=***HIDDEN***/' | sed 's/DB_URL=.*:\/\/[^:]*:[^@]*@/DB_URL=***HIDDEN***@/' || echo "No DB configuration found in .env"
echo "=============================="

# Optimizar para producción (con manejo de errores mejorado)
echo "=== Optimizing for production ==="
php artisan config:cache || echo "Warning: Config cache failed"
php artisan route:cache || echo "Warning: Route cache failed"
# NO cachear vistas - pueden tener referencias a assets que necesitan actualizarse
# php artisan view:cache || echo "Warning: View cache failed"
echo "Optimization complete"
echo "=============================="

# Verificar permisos finales
chown -R www-data:www-data storage bootstrap/cache database 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chmod -R 777 storage/logs 2>/dev/null || true

echo "Starting Apache..."
# Iniciar Apache
exec apache2-foreground
EOF
RUN chmod +x /usr/local/bin/start.sh

# Crear wrapper para artisan (por si Render.com intenta ejecutarlo)
RUN cat > /usr/local/bin/artisan << 'EOF'
#!/bin/bash
cd /var/www/html
exec php artisan "$@"
EOF
RUN chmod +x /usr/local/bin/artisan

# Copiar todo el contenido a un directorio temporal
COPY . /tmp/build/

# Detectar estructura y copiar archivos necesarios para composer/npm
RUN if [ -f /tmp/build/composer.json ]; then \
        # Contexto en la raíz del proyecto (writer-site/)
        echo "Build context: project root (writer-site/)"; \
        cp /tmp/build/composer.json /tmp/build/composer.lock* ./ 2>/dev/null || true; \
        cp /tmp/build/package.json /tmp/build/package-lock.json* ./ 2>/dev/null || true; \
    elif [ -f /tmp/build/writer-site/composer.json ]; then \
        # Contexto en el directorio padre
        echo "Build context: parent directory"; \
        cp /tmp/build/writer-site/composer.json /tmp/build/writer-site/composer.lock* ./ 2>/dev/null || true; \
        cp /tmp/build/writer-site/package.json /tmp/build/writer-site/package-lock.json* ./ 2>/dev/null || true; \
    else \
        echo "ERROR: composer.json not found in /tmp/build/"; \
        echo "Contents of /tmp/build/:"; \
        ls -la /tmp/build/ | head -20; \
        exit 1; \
    fi

# Instalar dependencias de PHP (sin scripts para evitar errores)
RUN if [ -f composer.json ]; then \
        composer install --no-dev --optimize-autoloader --no-interaction --no-scripts || \
        (echo "Warning: composer install failed, trying with scripts..." && \
         composer install --no-dev --optimize-autoloader --no-interaction || exit 1); \
    else \
        echo "ERROR: composer.json not found after copy"; \
        exit 1; \
    fi

# Instalar dependencias de Node (incluyendo devDependencies para poder compilar assets)
RUN if [ -f package.json ] && [ -s package.json ] && [ "$(cat package.json)" != "{}" ]; then \
        echo "Installing Node dependencies (including devDependencies for build)..."; \
        npm ci || npm install; \
        echo "Node dependencies installed"; \
    else \
        echo "Skipping Node installation (no valid package.json found)"; \
    fi

# Copiar el resto de archivos del proyecto al directorio final
RUN if [ -f /tmp/build/composer.json ]; then \
        # Contexto en la raíz (writer-site/)
        echo "Copying files from project root..."; \
        cp -r /tmp/build/. /var/www/html/ 2>/dev/null || \
        (cp -r /tmp/build/* /var/www/html/ 2>/dev/null && \
         cp -r /tmp/build/.[!.]* /var/www/html/ 2>/dev/null || true); \
    elif [ -f /tmp/build/writer-site/composer.json ]; then \
        # Contexto en el directorio padre
        echo "Copying files from writer-site subdirectory..."; \
        cp -r /tmp/build/writer-site/. /var/www/html/ 2>/dev/null || \
        (cp -r /tmp/build/writer-site/* /var/www/html/ 2>/dev/null && \
         cp -r /tmp/build/writer-site/.[!.]* /var/www/html/ 2>/dev/null || true); \
    else \
        echo "ERROR: Could not determine build structure"; \
        echo "Contents of /tmp/build:"; \
        ls -la /tmp/build/ | head -20; \
        echo "Looking for composer.json..."; \
        find /tmp/build -name "composer.json" -type f 2>/dev/null | head -5; \
        exit 1; \
    fi

# Verificar que artisan existe y establecer permisos
RUN if [ ! -f /var/www/html/artisan ]; then \
        echo "ERROR: artisan file not found after copy"; \
        echo "Contents of /var/www/html:"; \
        ls -la /var/www/html/ | head -20; \
        echo "Looking for artisan in subdirectories..."; \
        find /var/www/html -name "artisan" -type f 2>/dev/null | head -5 || echo "No artisan found"; \
        echo "Contents of /tmp/build (before cleanup):"; \
        ls -la /tmp/build/ | head -20; \
        if [ -d /tmp/build/writer-site ]; then \
            echo "Contents of /tmp/build/writer-site:"; \
            ls -la /tmp/build/writer-site/ | head -20; \
        fi; \
        exit 1; \
    fi && \
    chmod +x /var/www/html/artisan && \
    echo "artisan file found and made executable" && \
    rm -rf /tmp/build

# Crear directorios necesarios y establecer permisos
RUN mkdir -p /var/www/html/storage/framework/cache/data \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/storage/app/public \
    && mkdir -p /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Regenerar autoloader optimizado (sin scripts - se ejecutarán en start.sh)
RUN composer dump-autoload --optimize --no-scripts || true

# Compilar assets para producción (después de copiar todos los archivos)
RUN if [ -f package.json ] && [ -s package.json ] && [ "$(cat package.json)" != "{}" ]; then \
        echo "=== Building assets for production ==="; \
        echo "Checking required files..."; \
        [ -f vite.config.js ] && echo "✓ vite.config.js found" || echo "✗ vite.config.js missing"; \
        [ -f tailwind.config.js ] && echo "✓ tailwind.config.js found" || echo "✗ tailwind.config.js missing"; \
        [ -f postcss.config.js ] && echo "✓ postcss.config.js found" || echo "✗ postcss.config.js missing"; \
        [ -d resources ] && echo "✓ resources/ directory found" || echo "✗ resources/ directory missing"; \
        [ -d resources/css ] && echo "✓ resources/css/ directory found" || echo "✗ resources/css/ directory missing"; \
        [ -d resources/js ] && echo "✓ resources/js/ directory found" || echo "✗ resources/js/ directory missing"; \
        echo "Removing old build directory if exists..."; \
        rm -rf public/build public/hot 2>/dev/null || true; \
        echo "Running npm run build..."; \
        NODE_ENV=production npm run build 2>&1 || (echo "ERROR: Build failed!" && exit 1); \
        echo "=== Build completed ==="; \
        echo "Checking build output..."; \
        if [ -d public/build ]; then \
            echo "✓ public/build/ directory exists"; \
            ls -la public/build/; \
            if [ -f public/build/manifest.json ]; then \
                echo "✓ manifest.json found"; \
                echo "manifest.json content:"; \
                cat public/build/manifest.json; \
            else \
                echo "✗ ERROR: manifest.json not found in public/build/"; \
                exit 1; \
            fi; \
        else \
            echo "✗ ERROR: public/build/ directory not created"; \
            exit 1; \
        fi; \
    else \
        echo "Skipping asset build (no valid package.json)"; \
    fi

# Asegurar permisos en los assets compilados y directorio public
RUN if [ -d public/build ]; then \
        chown -R www-data:www-data public/build public; \
        chmod -R 755 public/build public; \
        echo "Build assets permissions set"; \
        echo "Build directory contents:"; \
        ls -la public/build/ | head -10; \
    else \
        echo "ERROR: public/build/ directory does not exist!"; \
        exit 1; \
    fi

# Limpiar archivos innecesarios para reducir tamaño de imagen (pero mantener public/build)
RUN echo "Cleaning up unnecessary files (keeping public/build)..."; \
    rm -rf node_modules \
    && rm -rf /root/.composer/cache \
    && rm -rf /root/.npm \
    && apt-get purge -y git curl gnupg \
    && apt-get autoremove -y \
    && apt-get clean; \
    echo "Verifying public/build still exists after cleanup..."; \
    if [ -d public/build ] && [ -f public/build/manifest.json ]; then \
        echo "✓ public/build/ and manifest.json preserved"; \
        ls -la public/build/ | head -5; \
    else \
        echo "✗ ERROR: public/build/ was removed during cleanup!"; \
        exit 1; \
    fi

# Configurar Apache para escuchar en el puerto 10000 (puerto estándar de Render.com)
RUN echo "Listen 10000" >> /etc/apache2/ports.conf

# Configurar VirtualHost para el puerto 10000
RUN cat > /etc/apache2/sites-available/000-default.conf << 'APACHE_EOF'
ServerName localhost

<VirtualHost *:10000>
    ServerAdmin webmaster@localhost
    ServerName localhost
    DocumentRoot /var/www/html/public
    
    <Directory /var/www/html/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
        DirectoryIndex index.php index.html
    </Directory>
    
    # Denegar acceso al directorio raíz del proyecto
    <Directory /var/www/html>
        Options -Indexes
        AllowOverride None
        Require all denied
    </Directory>
    
    # Permitir acceso solo a public/
    <DirectoryMatch "^/var/www/html/(?!public)">
        Require all denied
    </DirectoryMatch>
    
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
    
    # PHP configuration
    <FilesMatch \.php$>
        SetHandler application/x-httpd-php
    </FilesMatch>
</VirtualHost>
APACHE_EOF

# Exponer puerto 10000
EXPOSE 10000

# Comando de inicio
CMD ["/usr/local/bin/start.sh"]
