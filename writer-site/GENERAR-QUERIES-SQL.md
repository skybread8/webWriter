# 📝 Generar Queries SQL para PostgreSQL

## Generar el archivo SQL

Ejecuta este comando para generar un archivo SQL con todas las queries INSERT:

```bash
php artisan db:generate-postgresql-queries
```

Esto creará un archivo `postgresql_migration.sql` en la raíz del proyecto.

## Opciones disponibles

```bash
# Especificar ruta del SQLite
php artisan db:generate-postgresql-queries --sqlite-path=/ruta/a/database.sqlite

# Especificar archivo de salida
php artisan db:generate-postgresql-queries --output=mi_migracion.sql
```

## Ejecutar las queries en PostgreSQL

### Opción 1: Desde la línea de comandos (psql)

```bash
psql -h dpg-d5l67ev5r7bs73ci9mu0-a.oregon-postgres.render.com \
     -U databasewriter_user \
     -d databasewriter \
     -f postgresql_migration.sql
```

Te pedirá la contraseña: `thu2e0YD10WtjUvoXJltYTXqrERM89wb`

### Opción 2: Desde Render.com (usando psql en el shell)

1. Ve a tu base de datos PostgreSQL en Render.com
2. Click en "Connect" → "External Connection"
3. Copia el comando `psql` que te proporciona
4. Ejecuta: `psql "tu-connection-string" < postgresql_migration.sql`

### Opción 3: Copiar y pegar en un cliente SQL

1. Abre el archivo `postgresql_migration.sql`
2. Copia todo el contenido
3. Pégalo en tu cliente SQL (pgAdmin, DBeaver, etc.) conectado a PostgreSQL
4. Ejecuta

## Estructura del archivo generado

El archivo contiene:

```sql
-- PostgreSQL Migration Script
-- Generated from SQLite database
-- Date: 2026-01-16 12:00:00

BEGIN;

-- Table: users
-- Records: 3

INSERT INTO users (id, name, email, ...) VALUES (1, 'Administrador', 'admin@example.com', ...) ON CONFLICT (id) DO UPDATE SET ...;
INSERT INTO users (id, name, email, ...) VALUES (2, 'Kevin Perez', 'kevin@example.com', ...) ON CONFLICT (id) DO UPDATE SET ...;

-- Table: books
-- Records: 4

INSERT INTO books (id, title, description, ...) VALUES (1, 'Amor contra todo pronóstico', ...) ON CONFLICT (id) DO UPDATE SET ...;

COMMIT;
```

## Características

- ✅ Usa `ON CONFLICT DO UPDATE` para evitar duplicados
- ✅ Escapa correctamente strings y caracteres especiales
- ✅ Maneja NULL, booleanos, números correctamente
- ✅ Respeta el orden de las tablas (foreign keys)
- ✅ Incluye comentarios para cada tabla

## ⚠️ Nota importante

El archivo generado incluye `DELETE FROM table;` comentado al inicio de cada tabla. Si quieres limpiar las tablas antes de insertar, descomenta esas líneas.

## Verificar después de ejecutar

```sql
SELECT COUNT(*) FROM users;
SELECT COUNT(*) FROM books;
SELECT COUNT(*) FROM site_settings;
```

Deberías ver los mismos números que en SQLite.
