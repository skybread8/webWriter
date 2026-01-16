# 🚀 Migración Rápida: SQLite → PostgreSQL

## Pasos Rápidos

### 1. Configurar PostgreSQL en tu `.env` local

```env
DB_CONNECTION=pgsql
DB_HOST=tu-host-postgresql.render.com
DB_PORT=5432
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña
DB_SSLMODE=require
```

### 2. Ejecutar migraciones en PostgreSQL

```bash
php artisan migrate
```

### 3. Migrar los datos

```bash
php artisan db:migrate-from-sqlite
```

El comando:
- ✅ Lee todos los datos de `database/database.sqlite`
- ✅ Los inserta en PostgreSQL
- ✅ Mantiene los IDs y relaciones
- ✅ Muestra progreso y errores

### 4. Verificar

```bash
php artisan tinker
>>> DB::table('users')->count()
>>> DB::table('books')->count()
```

## 📁 Archivos de Imágenes

Los archivos en `storage/app/public` **NO se migran automáticamente**.

**Opción 1: Subir manualmente**
- Comprime: `tar -czf storage-backup.tar.gz storage/app/public`
- Súbelo a Render.com y descomprime

**Opción 2: Usar servicio en la nube**
- Configura S3, Cloudinary, etc. en producción

## ⚠️ Si hay errores

```bash
# Limpiar y empezar de nuevo
php artisan migrate:fresh
php artisan db:migrate-from-sqlite --force
```

## ✅ Listo

Después de migrar, verifica que:
- Puedes iniciar sesión con tus credenciales
- Los libros aparecen en la tienda
- La configuración del sitio está correcta
