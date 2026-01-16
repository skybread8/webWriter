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

# Crear script de inicio directamente en el contenedor
RUN cat > /usr/local/bin/start.sh << 'EOF'
#!/bin/bash
set -e

# Cambiar al directorio de trabajo
cd /var/www/html

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

# Ejecutar migraciones solo si la variable de entorno está configurada
if [ "$RUN_MIGRATIONS" = "true" ]; then
    cd /var/www/html && php artisan migrate --force
fi

# Limpiar cachés
cd /var/www/html && php artisan config:clear
cd /var/www/html && php artisan cache:clear
cd /var/www/html && php artisan view:clear
cd /var/www/html && php artisan route:clear

# Optimizar para producción
cd /var/www/html && php artisan config:cache
cd /var/www/html && php artisan route:cache
cd /var/www/html && php artisan view:cache

# Iniciar Apache
exec apache2-foreground
EOF
RUN chmod +x /usr/local/bin/start.sh

# Copiar primero solo composer.json (y composer.lock si existe)
COPY composer.json* ./

# Instalar dependencias de PHP (sin dev para producción)
RUN if [ -f composer.json ]; then \
        composer install --no-dev --optimize-autoloader --no-interaction --no-scripts; \
    fi

# Copiar archivos de Node (package.json y package-lock.json si existen)
COPY package*.json ./

# Instalar dependencias de Node
RUN if [ -f package.json ]; then \
        npm ci --only=production=false; \
    fi

# Copiar el resto de archivos del proyecto
COPY . /var/www/html

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

# Ejecutar scripts de post-instalación de Composer (después de copiar todos los archivos)
RUN if [ -f composer.json ]; then \
        composer dump-autoload --optimize; \
    fi

# Compilar assets para producción
RUN if [ -f package.json ]; then \
        npm run build; \
    fi

# Limpiar node_modules y archivos innecesarios después de compilar para reducir tamaño
RUN rm -rf node_modules \
    && rm -rf /root/.composer/cache \
    && rm -rf /root/.npm \
    && apt-get purge -y git curl \
    && apt-get autoremove -y

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
