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

# Copiar primero solo composer.json y composer.lock
COPY composer.json composer.lock* ./

# Instalar dependencias de PHP (sin scripts para evitar errores)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts || \
    (echo "Warning: composer install failed, trying with scripts..." && \
     composer install --no-dev --optimize-autoloader --no-interaction || exit 1)

# Copiar archivos de Node
COPY package.json package-lock.json* ./

# Instalar dependencias de Node
RUN if [ -f package.json ]; then \
        npm ci --only=production=false || npm install; \
    fi

# Copiar el resto de archivos del proyecto
COPY . /var/www/html/

# Verificar y mover contenido si está en subdirectorio (contexto Docker desde directorio padre)
RUN if [ -d /var/www/html/writer-site ] && [ ! -f /var/www/html/artisan ]; then \
        echo "Moving content from writer-site subdirectory..."; \
        cd /var/www/html/writer-site; \
        find . -mindepth 1 -maxdepth 1 ! -name '.' -exec mv -t /var/www/html/ {} + 2>/dev/null || \
        (shopt -s dotglob && mv * /var/www/html/ 2>/dev/null || true); \
        cd /var/www/html; \
        rmdir writer-site 2>/dev/null || true; \
        echo "Content moved successfully"; \
    fi

# Verificar que artisan existe después del movimiento
RUN if [ ! -f /var/www/html/artisan ]; then \
        echo "ERROR: artisan file not found"; \
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
RUN if [ -f package.json ]; then \
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
