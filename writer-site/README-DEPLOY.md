# Guía de Despliegue en Render.com

Esta guía te ayudará a desplegar el proyecto Laravel en Render.com usando Docker.

## Requisitos Previos

1. Cuenta en Render.com
2. Repositorio Git (GitHub, GitLab, etc.)
3. Variables de entorno configuradas

## Pasos para Desplegar

### 1. Preparar el Repositorio

Asegúrate de que todos los archivos estén commitados y subidos a tu repositorio:

```bash
git add .
git commit -m "Preparar para despliegue en Render"
git push
```

### 2. Crear un Nuevo Servicio Web en Render.com

1. Ve a tu dashboard de Render.com
2. Haz clic en "New +" y selecciona "Web Service"
3. Conecta tu repositorio Git
4. Configura el servicio:
   - **Name**: `writer-site` (o el nombre que prefieras)
   - **Environment**: `Docker`
   - **Region**: Elige la región más cercana a tus usuarios
   - **Branch**: `main` (o la rama que uses)
   - **Dockerfile Path**: `./Dockerfile`
   - **Docker Context**: `.` (punto)

### 3. Configurar Variables de Entorno

En la sección "Environment" de Render.com, añade las siguientes variables:

#### Variables Obligatorias

```
APP_NAME=Kevin Pérez Alarcón
APP_ENV=production
APP_KEY=base64:TU_CLAVE_AQUI
APP_DEBUG=false
APP_URL=https://tu-dominio.onrender.com
LOG_LEVEL=error
```

#### Base de Datos

Si usas SQLite (por defecto):
```
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
```

Si usas PostgreSQL (recomendado para producción):
```
DB_CONNECTION=pgsql
DB_HOST=tu-host-postgresql.render.com
DB_PORT=5432
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña
```

#### Stripe (para pagos)

```
STRIPE_KEY=pk_live_tu_clave_publica
STRIPE_SECRET=sk_live_tu_clave_secreta
STRIPE_WEBHOOK_SECRET=whsec_tu_secreto_webhook
```

#### Mail (opcional)

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_usuario
MAIL_PASSWORD=tu_contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tudominio.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### Otras Variables

```
SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### 4. Generar APP_KEY

Si no tienes una `APP_KEY`, puedes generarla localmente:

```bash
php artisan key:generate --show
```

O Render.com puede generarla automáticamente si añades este script en "Build Command" (aunque no es necesario con Docker).

### 5. Configurar Base de Datos

#### Opción A: SQLite (Simple, para empezar)

1. En Render.com, crea un "Disk" (volumen persistente)
2. Monta el disco en `/var/www/html/database`
3. Crea el archivo `database.sqlite`:
   ```bash
   touch database/database.sqlite
   ```

#### Opción B: PostgreSQL (Recomendado para producción)

1. En Render.com, crea un nuevo "PostgreSQL" database
2. Copia las credenciales de conexión
3. Añádelas como variables de entorno (ver arriba)
4. Asegúrate de que `DB_CONNECTION=pgsql` esté configurado

### 6. Ejecutar Migraciones

Para ejecutar migraciones automáticamente en el despliegue, añade esta variable:

```
RUN_MIGRATIONS=true
```

O ejecuta las migraciones manualmente desde el shell de Render.com:

```bash
php artisan migrate --force
```

### 7. Configurar Storage Público

Para que las imágenes se muestren correctamente:

1. Crea un "Disk" (volumen persistente) en Render.com
2. Monta el disco en `/var/www/html/storage/app/public`
3. Ejecuta el comando para crear el enlace simbólico:
   ```bash
   php artisan storage:link
   ```

### 8. Desplegar

1. Haz clic en "Create Web Service"
2. Render.com comenzará a construir la imagen Docker
3. El proceso puede tardar varios minutos la primera vez
4. Una vez completado, tu aplicación estará disponible en `https://tu-servicio.onrender.com`

## Comandos Útiles en Render.com

### Shell de Render.com

Puedes acceder al shell de tu servicio para ejecutar comandos:

```bash
# Ejecutar migraciones
php artisan migrate --force

# Crear enlace de storage
php artisan storage:link

# Limpiar cachés
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Crear usuario admin
php artisan tinker
>>> User::create(['name' => 'Kevin', 'email' => 'kevin@example.com', 'password' => Hash::make('kevin123')]);
```

## Solución de Problemas

### Error: "No application encryption key has been specified"

Asegúrate de que `APP_KEY` esté configurado en las variables de entorno.

### Error: "SQLSTATE[HY000] [14] unable to open database file"

Para SQLite, asegúrate de que:
1. El disco esté montado correctamente
2. Los permisos sean correctos (775)
3. El archivo `database.sqlite` exista

### Las imágenes no se muestran

1. Verifica que el enlace simbólico esté creado: `php artisan storage:link`
2. Asegúrate de que el disco de storage esté montado correctamente
3. Verifica los permisos: `chmod -R 775 storage`

### Error 500 en producción

1. Revisa los logs en Render.com
2. Verifica que `APP_DEBUG=false` en producción
3. Asegúrate de que todas las variables de entorno estén configuradas
4. Ejecuta `php artisan config:clear` y `php artisan config:cache`

## Optimizaciones Adicionales

### Usar PostgreSQL en lugar de SQLite

Para producción, se recomienda usar PostgreSQL:

1. Crea una base de datos PostgreSQL en Render.com
2. Actualiza las variables de entorno
3. Ejecuta las migraciones

### Configurar CDN para Assets

Considera usar un CDN para servir los assets estáticos más rápido.

### Configurar Queue Worker (Opcional)

Si necesitas procesar trabajos en segundo plano:

1. Crea un nuevo "Background Worker" en Render.com
2. Configura el comando: `php artisan queue:work`
3. Asegúrate de que `QUEUE_CONNECTION` esté configurado

## Notas Importantes

- El puerto 10000 es el puerto estándar de Render.com y ya está configurado en el Dockerfile
- Los archivos en `storage/` y `bootstrap/cache/` deben tener permisos de escritura
- Las variables de entorno son sensibles, no las compartas públicamente
- Render.com ofrece un plan gratuito con limitaciones (se duerme después de 15 minutos de inactividad)

## Soporte

Si encuentras problemas, revisa:
1. Los logs de Render.com
2. Los logs de Laravel en `storage/logs/laravel.log`
3. La documentación de Render.com: https://render.com/docs
