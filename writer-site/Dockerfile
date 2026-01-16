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
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
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
EOF
RUN chmod +x /usr/local/bin/start.sh

# Copiar archivos del proyecto (usando .dockerignore para excluir archivos innecesarios)
COPY . /var/www/html

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Instalar dependencias de PHP (sin dev para producción)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Instalar dependencias de Node
RUN npm ci --only=production=false

# Compilar assets para producción
RUN npm run build

# Limpiar node_modules después de compilar (opcional, para reducir tamaño)
RUN rm -rf node_modules

# Configurar Apache para escuchar en el puerto 10000 (puerto estándar de Render.com)
RUN echo "Listen 10000" >> /etc/apache2/ports.conf

# Configurar VirtualHost para el puerto 10000
RUN echo '<VirtualHost *:10000>\n\
    ServerAdmin webmaster@localhost\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Exponer puerto 10000
EXPOSE 10000

# Comando de inicio
CMD ["/usr/local/bin/start.sh"]
