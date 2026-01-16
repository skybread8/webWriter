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

# Establecer permisos
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

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

# Optimizar para producción
php artisan config:cache || echo "Warning: Config cache failed"
php artisan route:cache || echo "Warning: Route cache failed"
php artisan view:cache || echo "Warning: View cache failed"

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
        shopt -s dotglob; \
        cp -r /tmp/build/* /var/www/html/ 2>/dev/null || true; \
        cp -r /tmp/build/.[!.]* /var/www/html/ 2>/dev/null || true; \
    elif [ -f /tmp/build/writer-site/composer.json ]; then \
        # Contexto en el directorio padre
        echo "Copying files from writer-site subdirectory..."; \
        shopt -s dotglob; \
        cp -r /tmp/build/writer-site/* /var/www/html/ 2>/dev/null || true; \
        cp -r /tmp/build/writer-site/.[!.]* /var/www/html/ 2>/dev/null || true; \
    fi && \
    rm -rf /tmp/build

# Verificar que artisan existe después de copiar
RUN if [ ! -f /var/www/html/artisan ]; then \
        echo "ERROR: artisan file not found after copy"; \
        echo "Contents of /var/www/html:"; \
        ls -la /var/www/html/ | head -20; \
        find /var/www/html -name "artisan" -type f 2>/dev/null | head -5 || echo "No artisan found"; \
        exit 1; \
    fi && \
    chmod +x /var/www/html/artisan && \
    echo "artisan file found and made executable"

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
<VirtualHost *:10000>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/public
    
    <Directory /var/www/html/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
APACHE_EOF

# Exponer puerto 10000
EXPOSE 10000

# Comando de inicio
CMD ["/usr/local/bin/start.sh"]
