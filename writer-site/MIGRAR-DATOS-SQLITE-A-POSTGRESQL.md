# 📦 Migrar Datos de SQLite a PostgreSQL

Esta guía te ayudará a migrar todos los datos de tu base de datos SQLite local a PostgreSQL en Render.com.

## 📋 Requisitos Previos

1. Tener acceso a tu base de datos SQLite local (`database/database.sqlite`)
2. Tener configurada la conexión a PostgreSQL en Render.com
3. Haber ejecutado las migraciones en PostgreSQL (tablas creadas)

## 🚀 Pasos para Migrar

### Paso 1: Preparar el Entorno Local

1. **Asegúrate de tener ambas conexiones configuradas** en tu `.env` local:

```env
# SQLite (origen)
DB_CONNECTION_SQLITE=sqlite
DB_DATABASE_SQLITE=/ruta/completa/a/writer-site/database/database.sqlite

# PostgreSQL (destino)
DB_CONNECTION=pgsql
DB_HOST=tu-host-postgresql.render.com
DB_PORT=5432
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña
DB_SSLMODE=require
```

### Paso 2: Ejecutar Migraciones en PostgreSQL

Primero, asegúrate de que todas las tablas existan en PostgreSQL:

```bash
# Conectar a PostgreSQL y ejecutar migraciones
php artisan migrate --database=pgsql
```

O si ya tienes PostgreSQL configurado como conexión por defecto:

```bash
php artisan migrate
```

### Paso 3: Ejecutar el Comando de Migración

Ejecuta el comando que hemos creado:

```bash
php artisan db:migrate-from-sqlite
```

O si tu SQLite está en otra ubicación:

```bash
php artisan db:migrate-from-sqlite --sqlite-path=/ruta/a/database.sqlite
```

Si las tablas ya tienen datos y quieres añadir más:

```bash
php artisan db:migrate-from-sqlite --force
```

### Paso 4: Verificar los Datos

Después de la migración, verifica que los datos se hayan migrado correctamente:

```bash
# Verificar usuarios
php artisan tinker
>>> DB::table('users')->count()
>>> DB::table('books')->count()
>>> DB::table('site_settings')->count()
```

## 📁 Migrar Archivos de Storage

Los archivos de imágenes y otros assets en `storage/app/public` **NO se migran automáticamente**. Tienes dos opciones:

### Opción A: Subir Archivos Manualmente

1. Comprime la carpeta `storage/app/public`:
```bash
cd writer-site
tar -czf storage-backup.tar.gz storage/app/public
```

2. Sube el archivo a Render.com usando el panel de administración o SFTP

3. Descomprime en el servidor:
```bash
tar -xzf storage-backup.tar.gz
```

### Opción B: Usar un Servicio de Almacenamiento en la Nube

Considera usar S3, Cloudinary, o similar para almacenar imágenes en producción.

## 🔍 Tablas que se Migran

El comando migra las siguientes tablas en este orden (respetando foreign keys):

1. `users` - Usuarios y administradores
2. `site_settings` - Configuración del sitio
3. `pages` - Páginas estáticas
4. `books` - Libros
5. `testimonials` - Testimonios
6. `blog_posts` - Posts del blog
7. `orders` - Pedidos
8. `order_items` - Items de pedidos
9. `reviews` - Reseñas de libros

## ⚠️ Notas Importantes

1. **Foreign Keys**: El comando migra las tablas en un orden que respeta las foreign keys, pero si hay problemas, puedes ejecutar el comando varias veces (usa `--force`).

2. **IDs**: Los IDs se mantienen iguales si es posible, pero si hay conflictos, PostgreSQL generará nuevos IDs.

3. **Timestamps**: Las fechas de creación y actualización se mantienen.

4. **Contraseñas**: Las contraseñas hasheadas se migran tal cual, así que seguirán funcionando.

5. **Imágenes**: Las rutas de imágenes en la base de datos se mantienen, pero necesitas subir los archivos físicos por separado.

## 🐛 Solución de Problemas

### Error: "Table does not exist in PostgreSQL"

Ejecuta las migraciones primero:
```bash
php artisan migrate
```

### Error: "Connection refused"

Verifica que las credenciales de PostgreSQL en `.env` sean correctas.

### Error: "Duplicate key violation"

Usa `--force` para intentar insertar de nuevo, o limpia las tablas primero:
```bash
php artisan migrate:fresh
php artisan db:migrate-from-sqlite
```

### Algunos registros no se migran

El comando muestra errores detallados. Revisa los mensajes y ajusta los datos problemáticos manualmente si es necesario.

## ✅ Verificación Final

Después de migrar, verifica:

1. **Usuarios**: Puedes iniciar sesión con las mismas credenciales
2. **Libros**: Aparecen en la tienda
3. **Configuración**: El sitio muestra la configuración correcta
4. **Pedidos**: Los pedidos históricos están disponibles
5. **Reseñas**: Las reseñas aprobadas se muestran

## 🎉 ¡Listo!

Una vez completada la migración, tu aplicación en Render.com tendrá todos los datos de SQLite. Asegúrate de:

- Configurar `APP_URL` con HTTPS
- Subir los archivos de storage si es necesario
- Verificar que todo funcione correctamente
