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
    zip \
    unzip \
    ca-certificates \
    gnupg \
    && mkdir -p /etc/apt/keyrings \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_20.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip \
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

# Crear directorios necesarios si no existen
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p storage/app/public
mkdir -p bootstrap/cache

# Establecer permisos ANTES de crear .env (importante para que Laravel pueda escribir)
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage/logs 2>/dev/null || true

# Crear archivo .env si no existe (usando variables de entorno de Render.com)
if [ ! -f .env ]; then
    echo "Creating .env file from environment variables..."
    cat > .env << ENVEOF
APP_NAME="${APP_NAME:-Laravel}"
APP_ENV="${APP_ENV:-production}"
APP_KEY="${APP_KEY:-}"
APP_DEBUG="${APP_DEBUG:-false}"
APP_URL="${APP_URL:-http://localhost}"

LOG_CHANNEL=stack
LOG_LEVEL="${LOG_LEVEL:-error}"

DB_CONNECTION="${DB_CONNECTION:-sqlite}"
DB_DATABASE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
ENVEOF
    # Añadir más variables si existen
    [ -n "$DB_HOST" ] && echo "DB_HOST=${DB_HOST}" >> .env
    [ -n "$DB_PORT" ] && echo "DB_PORT=${DB_PORT}" >> .env
    [ -n "$DB_DATABASE" ] && sed -i "s|DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|" .env 2>/dev/null || echo "DB_DATABASE=${DB_DATABASE}" >> .env
    [ -n "$DB_USERNAME" ] && echo "DB_USERNAME=${DB_USERNAME}" >> .env
    [ -n "$DB_PASSWORD" ] && echo "DB_PASSWORD=${DB_PASSWORD}" >> .env
    [ -n "$STRIPE_SECRET" ] && echo "STRIPE_SECRET=${STRIPE_SECRET}" >> .env
    [ -n "$MAIL_MAILER" ] && echo "MAIL_MAILER=${MAIL_MAILER}" >> .env
    [ -n "$MAIL_HOST" ] && echo "MAIL_HOST=${MAIL_HOST}" >> .env
    [ -n "$MAIL_PORT" ] && echo "MAIL_PORT=${MAIL_PORT}" >> .env
    [ -n "$MAIL_USERNAME" ] && echo "MAIL_USERNAME=${MAIL_USERNAME}" >> .env
    [ -n "$MAIL_PASSWORD" ] && echo "MAIL_PASSWORD=${MAIL_PASSWORD}" >> .env
    [ -n "$MAIL_ENCRYPTION" ] && echo "MAIL_ENCRYPTION=${MAIL_ENCRYPTION}" >> .env
    [ -n "$MAIL_FROM_ADDRESS" ] && echo "MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS}" >> .env
    [ -n "$MAIL_FROM_NAME" ] && echo "MAIL_FROM_NAME=${MAIL_FROM_NAME}" >> .env
    [ -n "$APP_LOCALE" ] && echo "APP_LOCALE=${APP_LOCALE}" >> .env
    [ -n "$APP_FALLBACK_LOCALE" ] && echo "APP_FALLBACK_LOCALE=${APP_FALLBACK_LOCALE}" >> .env
fi

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

# Ejecutar scripts de Composer que requieren Laravel configurado
php artisan package:discover --ansi || echo "Warning: Package discovery failed"

# Ejecutar migraciones solo si la variable de entorno está configurada
if [ "$RUN_MIGRATIONS" = "true" ]; then
    php artisan migrate --force || echo "Warning: Migrations failed, continuing..."
fi

# Limpiar cachés
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

# Optimizar para producción (con manejo de errores mejorado)
php artisan config:cache || echo "Warning: Config cache failed"
php artisan route:cache || echo "Warning: Route cache failed"
php artisan view:cache || echo "Warning: View cache failed - this is usually OK if views are not pre-compiled"

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

# Instalar dependencias de Node
RUN if [ -f package.json ] && [ -s package.json ] && [ "$(cat package.json)" != "{}" ]; then \
        npm ci --only=production=false || npm install; \
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

# Compilar assets para producción
RUN if [ -f package.json ] && [ -s package.json ] && [ "$(cat package.json)" != "{}" ]; then \
        npm run build || echo "Warning: Build failed"; \
    fi

# Limpiar archivos innecesarios para reducir tamaño de imagen
RUN rm -rf node_modules \
    && rm -rf /root/.composer/cache \
    && rm -rf /root/.npm \
    && apt-get purge -y git curl gnupg \
    && apt-get autoremove -y \
    && apt-get clean

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
