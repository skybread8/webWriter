# 🔧 Variables de Entorno para Render.com - Guía Rápida

## ⚠️ PROBLEMA ACTUAL

Si ves el error: `unable to open database file (Connection: sqlite)`, significa que **NO has configurado las variables de entorno de PostgreSQL** en Render.com.

---

## ✅ SOLUCIÓN: Configurar PostgreSQL

### Paso 1: Crear Base de Datos PostgreSQL

1. Ve a tu dashboard de Render.com
2. Click en **"New +"** → **"PostgreSQL"**
3. Configura:
   - **Name**: `writer-db`
   - **Database**: `writer_db`
   - **Region**: La misma que tu servicio web
   - **Plan**: Free tier
4. Click en **"Create Database"**
5. **Espera 1-2 minutos** a que se cree

### Paso 2: Copiar Credenciales

Una vez creada, Render.com te mostrará algo como:

```
Internal Database URL: postgresql://writer_db_user:xxxxx@dpg-xxxxx-a.oregon-postgres.render.com:5432/writer_db
```

O las credenciales individuales:
- **Host**: `dpg-xxxxx-a.oregon-postgres.render.com`
- **Port**: `5432`
- **Database**: `writer_db`
- **User**: `writer_db_user`
- **Password**: `xxxxx` (la contraseña generada)

### Paso 3: Configurar Variables en tu Servicio Web

Ve a tu **servicio web** (no a la base de datos) → **"Environment Variables"** y añade estas variables:

#### 🔴 OBLIGATORIAS (Mínimo para funcionar):

```
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx=
APP_NAME=Kevin Pérez Alarcón
APP_ENV=production
APP_DEBUG=false
APP_URL=https://webwriter.onrender.com
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=dpg-xxxxx-a.oregon-postgres.render.com
DB_PORT=5432
DB_DATABASE=writer_db
DB_USERNAME=writer_db_user
DB_PASSWORD=tu_contraseña_aquí
DB_SSLMODE=require

SESSION_DRIVER=database
CACHE_DRIVER=file
RUN_MIGRATIONS=true
```

**⚠️ IMPORTANTE**: 
- Reemplaza `dpg-xxxxx-a.oregon-postgres.render.com` con tu **Host real**
- Reemplaza `writer_db` con tu **Database Name real**
- Reemplaza `writer_db_user` con tu **User real**
- Reemplaza `tu_contraseña_aquí` con tu **Password real**
- Reemplaza `https://webwriter.onrender.com` con tu **URL real de Render.com**

#### 🟢 OPCIONALES (Pero recomendadas):

```
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
STRIPE_SECRET=sk_live_... (si vendes libros)
```

---

## 🔑 Generar APP_KEY

Si no tienes `APP_KEY`, ejecuta localmente:

```bash
cd writer-site
php artisan key:generate --show
```

Copia el resultado completo (algo como `base64:xxxxxxxxxxxxx=`) y pégalo en Render.com como:

```
APP_KEY=base64:xxxxxxxxxxxxx=
```

---

## ✅ Checklist Rápido

- [ ] Base de datos PostgreSQL creada en Render.com
- [ ] Credenciales copiadas (Host, Port, Database, User, Password)
- [ ] `APP_KEY` generada y configurada
- [ ] `DB_CONNECTION=pgsql` configurado
- [ ] `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` configurados
- [ ] `DB_SSLMODE=require` configurado
- [ ] `RUN_MIGRATIONS=true` configurado
- [ ] `APP_URL` con tu URL real de Render.com
- [ ] Guardar variables y redespelgar

---

## 🚨 Errores Comunes

### Error: "unable to open database file (Connection: sqlite)"
**Causa**: No has configurado `DB_CONNECTION=pgsql` o las credenciales de PostgreSQL.

**Solución**: 
1. Verifica que todas las variables `DB_*` estén configuradas
2. Asegúrate de que `DB_CONNECTION=pgsql` esté configurado
3. Verifica que las credenciales sean correctas
4. Redespelga el servicio

### Error: "Connection refused" o "could not connect"
**Causa**: Credenciales incorrectas o base de datos no disponible.

**Solución**:
1. Verifica que la base de datos esté en estado "Available" en Render.com
2. Verifica que el Host, Port, Database, User y Password sean correctos
3. Asegúrate de que `DB_SSLMODE=require` esté configurado

### Error: "APP_KEY not set"
**Causa**: No has configurado `APP_KEY`.

**Solución**: Genera la clave con `php artisan key:generate --show` y configúrala en Render.com.

---

## 📝 Ejemplo Completo de Variables

Aquí tienes un ejemplo completo de cómo deberían verse tus variables en Render.com:

```
APP_KEY=base64:yJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c=
APP_NAME=Kevin Pérez Alarcón
APP_ENV=production
APP_DEBUG=false
APP_URL=https://webwriter.onrender.com
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=dpg-abc123def456-a.oregon-postgres.render.com
DB_PORT=5432
DB_DATABASE=writer_db_abc1
DB_USERNAME=writer_db_user
DB_PASSWORD=abc123def456ghi789jkl012mno345pqr678stu901vwx234yz
DB_SSLMODE=require

SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
RUN_MIGRATIONS=true
```

**Recuerda**: Reemplaza todos los valores con los tuyos reales de Render.com.

---

## 🚀 Después de Configurar

1. Guarda todas las variables de entorno
2. Render.com redespelgará automáticamente
3. Espera 2-3 minutos a que termine el despliegue
4. Visita tu URL de Render.com
5. Las migraciones se ejecutarán automáticamente si `RUN_MIGRATIONS=true` está configurado

---

## 💡 Verificar que Funciona

Después del despliegue, revisa los logs en Render.com. Deberías ver:
- "PostgreSQL configuration looks good"
- "Starting Apache..."
- Sin errores de conexión a la base de datos

Si ves errores, verifica que todas las credenciales sean correctas.
