# 🔧 Configuración de Variables de Entorno en Render.com

## ⚠️ IMPORTANTE: Variables Mínimas Requeridas

Para que la aplicación funcione en Render.com, necesitas configurar estas variables en la sección **"Environment Variables"** de tu servicio:

### 1. **APP_KEY** (OBLIGATORIO)

**NO es API_KEY, es APP_KEY**

Esta es la clave de encriptación de Laravel. Tienes dos opciones:

#### Opción A: Generarla localmente (Recomendado)
```bash
cd writer-site
php artisan key:generate --show
```

Copia el resultado completo (algo como `base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx=`) y pégalo en Render.com como:

```
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx=
```

#### Opción B: Dejar que Render.com la genere automáticamente
Si no configuras `APP_KEY`, el script intentará generarla automáticamente, pero es mejor configurarla manualmente.

---

### 2. **Base de Datos PostgreSQL** (RECOMENDADO - Sin necesidad de Discos)

**Render.com NO permite usar Discos en servicios web**, así que usaremos PostgreSQL que es un servicio gestionado.

#### Paso 1: Crear una base de datos PostgreSQL en Render.com

1. Ve a tu dashboard de Render.com
2. Click en **"New +"** → **"PostgreSQL"**
3. Configura:
   - **Name**: `writer-db` (o el nombre que prefieras)
   - **Database**: `writer_db` (o el nombre que prefieras)
   - **User**: Se generará automáticamente
   - **Region**: La misma región que tu servicio web
   - **PostgreSQL Version**: 15 o superior
   - **Plan**: Free tier está bien para empezar
4. Click en **"Create Database"**
5. Espera a que se cree (tarda 1-2 minutos)

#### Paso 2: Obtener las credenciales de conexión

Una vez creada la base de datos, Render.com te mostrará las credenciales. Necesitarás:
- **Internal Database URL** (o las credenciales individuales)
- **Host**
- **Port** (normalmente 5432)
- **Database Name**
- **User**
- **Password**

#### Paso 3: Configurar las variables de entorno en tu servicio web

En tu servicio web (no en la base de datos), ve a **"Environment Variables"** y añade:

```
DB_CONNECTION=pgsql
DB_HOST=dpg-xxxxx-a.oregon-postgres.render.com
DB_PORT=5432
DB_DATABASE=writer_db
DB_USERNAME=writer_db_user
DB_PASSWORD=tu_contraseña_generada
DB_SSLMODE=require
```

**Nota**: Reemplaza los valores con los que Render.com te proporcionó.

#### Opción Alternativa: Usar DB_URL

Render.com también proporciona una variable `DATABASE_URL`. Si la usas, puedes simplificar a:

```
DB_CONNECTION=pgsql
DB_URL=postgresql://usuario:contraseña@host:5432/nombre_base_datos?sslmode=require
```

**IMPORTANTE**: Si usas `DB_URL`, Laravel la parseará automáticamente y no necesitas configurar `DB_HOST`, `DB_PORT`, etc. por separado.

---

### 3. **Variables Básicas de Laravel** (OBLIGATORIAS)

```
APP_NAME=Kevin Pérez Alarcón
APP_ENV=production
APP_DEBUG=false
APP_URL=https://webwriter.onrender.com
LOG_LEVEL=error
```

**Nota**: Reemplaza `https://webwriter.onrender.com` con la URL real que Render.com te asigne.

---

### 4. **Variables Opcionales pero Recomendadas**

```
SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
```

---

### 5. **Stripe** (Solo si vendes libros)

```
STRIPE_SECRET=sk_live_tu_clave_secreta_de_stripe
```

Obtén esta clave desde: https://dashboard.stripe.com/apikeys

---

## 📋 Checklist Completo para Render.com

### Paso 1: Crear Base de Datos PostgreSQL
- [ ] Ir a Render.com Dashboard
- [ ] Click en **"New +"** → **"PostgreSQL"**
- [ ] Configurar nombre, región, plan
- [ ] Click en **"Create Database"**
- [ ] Esperar a que se cree (1-2 minutos)
- [ ] Copiar las credenciales de conexión

### Paso 2: Configurar Variables de Entorno en tu Servicio Web
- [ ] `APP_NAME=Kevin Pérez Alarcón`
- [ ] `APP_ENV=production`
- [ ] `APP_KEY=base64:...` (generada con `php artisan key:generate --show`)
- [ ] `APP_DEBUG=false`
- [ ] `APP_URL=https://tu-url.onrender.com` (tu URL real de Render.com)
- [ ] `LOG_LEVEL=error`
- [ ] `DB_CONNECTION=pgsql`
- [ ] `DB_HOST=dpg-xxxxx-a.oregon-postgres.render.com` (tu host de PostgreSQL)
- [ ] `DB_PORT=5432`
- [ ] `DB_DATABASE=nombre_de_tu_base_datos`
- [ ] `DB_USERNAME=usuario_de_tu_base_datos`
- [ ] `DB_PASSWORD=contraseña_de_tu_base_datos`
- [ ] `DB_SSLMODE=require`
- [ ] `SESSION_DRIVER=database`
- [ ] `CACHE_DRIVER=file`
- [ ] `STRIPE_SECRET=...` (si vendes libros)
- [ ] `RUN_MIGRATIONS=true` (para ejecutar migraciones automáticamente en el primer despliegue)

### En "Build & Deploy":
- [ ] **Build Command**: (dejar vacío - el Dockerfile lo maneja)
- [ ] **Start Command**: (dejar vacío - el Dockerfile lo maneja)

### En "Settings":
- [ ] **Dockerfile Path**: `Dockerfile` (o `writer-site/Dockerfile` si el contexto es el directorio padre)

---

## 🔍 Solución de Problemas

### Error: "Permission denied" en storage/logs/laravel.log
✅ **Solucionado**: El script `start.sh` ahora crea el archivo y establece permisos automáticamente.

### Error: "Database connection failed"
1. Verifica que todas las credenciales de PostgreSQL estén correctas
2. Asegúrate de que `DB_SSLMODE=require` esté configurado (Render.com requiere SSL)
3. Verifica que la base de datos PostgreSQL esté en la misma región que tu servicio web
4. Comprueba que la base de datos esté en estado "Available" en Render.com

### Error: "APP_KEY not set"
1. Genera la clave localmente: `php artisan key:generate --show`
2. Copia el resultado completo
3. Pégalo en Render.com como `APP_KEY=base64:...`

### Error: "Could not open input file: artisan"
✅ **Solucionado**: El script `start.sh` ahora cambia al directorio correcto antes de ejecutar comandos.

---

## 🚀 Después de Configurar

1. **Crea la base de datos PostgreSQL** en Render.com (ver Paso 1 arriba)
2. **Configura todas las variables de entorno** en tu servicio web (ver Paso 2 arriba)
3. **Añade `RUN_MIGRATIONS=true`** para ejecutar las migraciones automáticamente
4. Guarda las variables de entorno
5. Espera a que el despliegue termine
6. Visita tu URL de Render.com

La primera vez que se ejecute, el script:
- Conectará a la base de datos PostgreSQL
- Ejecutará las migraciones si `RUN_MIGRATIONS=true` está configurado
- Establecerá todos los permisos necesarios

---

## 💡 Tip: Verificar que todo funciona

Después del despliegue, puedes verificar los logs en Render.com. Deberías ver mensajes como:
- "Starting Apache..."
- Si hay errores de conexión a la base de datos, aparecerán en los logs

### Verificar conexión a la base de datos

Si quieres verificar que la conexión funciona, puedes añadir temporalmente `APP_DEBUG=true` y visitar tu sitio. Si hay errores de conexión, aparecerán claramente.

**IMPORTANTE**: Recuerda volver a poner `APP_DEBUG=false` después de verificar.

---

## 🔄 Migrar desde SQLite local a PostgreSQL en Render.com

Si ya tienes datos en SQLite localmente y quieres migrarlos a PostgreSQL:

1. **Exportar datos localmente**:
   ```bash
   php artisan db:seed --class=DatabaseSeeder  # Si tienes seeders
   # O exporta manualmente los datos que necesites
   ```

2. **En Render.com**: Las migraciones se ejecutarán automáticamente si `RUN_MIGRATIONS=true` está configurado

3. **Importar datos**: Puedes usar `php artisan db:seed` o importar manualmente los datos que necesites

---

## ⚠️ Nota sobre SQLite

Si realmente necesitas usar SQLite (no recomendado en Render.com sin Discos), necesitarías:
- Un servicio que soporte Discos (como un servicio de tipo "Background Worker" o similar)
- O usar un servicio de almacenamiento externo

**Recomendación**: Usa PostgreSQL, es más robusto, escalable y no requiere configuración adicional de discos.
