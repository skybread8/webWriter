# Guía Completa de Despliegue en Render.com

## 📋 Configuración del Servicio en Render.com

### 1. Tipo de Servicio
- **Tipo**: Web Service
- **Build Command**: ⚠️ **DEBE ESTAR VACÍO** (no poner nada, ni espacios)
- **Start Command**: ⚠️ **DEBE ESTAR VACÍO** (no poner nada, ni espacios)

### 2. Configuración de Docker
- **Dockerfile Path**: 
  - Si el Dockerfile está en la raíz del repo: `Dockerfile`
  - Si el Dockerfile está en `writer-site/`: `writer-site/Dockerfile`
- **Docker Context**: 
  - Si Dockerfile está en la raíz: `.`
  - Si Dockerfile está en `writer-site/`: `writer-site`

**IMPORTANTE**: Render.com detecta automáticamente el Dockerfile. Si tienes problemas, verifica que el path sea correcto.

### 3. Variables de Entorno OBLIGATORIAS

Configura estas variables en "Environment" → "Environment Variables":

```env
APP_NAME=Kevin Pérez Alarcón
APP_ENV=production
APP_KEY=base64:TU_CLAVE_AQUI_GENERADA
APP_DEBUG=false
APP_URL=https://tu-servicio.onrender.com
LOG_LEVEL=error
```

**Para generar APP_KEY**:
```bash
php artisan key:generate --show
```

### 4. Base de Datos

#### Opción A: SQLite (Simple para empezar)
```env
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
```

**Nota**: Para SQLite en Render.com, necesitarás crear un "Disk" persistente y montarlo en `/var/www/html/database`.

#### Opción B: PostgreSQL (Recomendado para producción)
```env
DB_CONNECTION=pgsql
DB_HOST=tu-host-postgresql.render.com
DB_PORT=5432
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña
```

### 5. Stripe (Para pagos)
```env
STRIPE_SECRET=sk_live_tu_clave_secreta_de_stripe
```

### 6. Configuración de Puerto
- **Puerto**: `10000` (ya configurado en el Dockerfile)
- Render.com detectará automáticamente el puerto desde el Dockerfile

### 7. Migraciones Automáticas (Opcional)
Si quieres que las migraciones se ejecuten automáticamente al iniciar:
```env
RUN_MIGRATIONS=true
```

## 🔧 Solución de Problemas

### Error: "Could not open input file: artisan"

**Causa**: Render.com está intentando ejecutar comandos de Laravel antes de que el contenedor esté listo.

**Solución**:
1. Ve a "Settings" → "Build & Deploy"
2. **Build Command**: Debe estar **COMPLETAMENTE VACÍO**
3. **Start Command**: Debe estar **COMPLETAMENTE VACÍO**
4. Verifica que el tipo de servicio sea "Web Service" (no "Background Worker")
5. Verifica que uses "Docker" (no "Buildpack")
6. Reinicia el servicio después de los cambios

### Error: "artisan file not found after COPY"

**Causa**: El contexto de Docker está en el directorio incorrecto.

**Solución**:
1. Verifica el "Dockerfile Path" en Render.com
2. Si tu estructura es:
   ```
   /repo
     /writer-site
       Dockerfile
   ```
   Entonces:
   - Dockerfile Path: `writer-site/Dockerfile`
   - Docker Context: `writer-site`
3. El Dockerfile detecta automáticamente si el contenido está en un subdirectorio y lo mueve

### Error: "Class Illuminate\Foundation\Application not found"

**Causa**: Los scripts de Composer se ejecutan antes de que Laravel esté configurado.

**Solución**: Ya está resuelto en el Dockerfile. Si persiste:
1. Verifica que `composer install` se ejecutó correctamente
2. Verifica que el archivo `.env` existe (se crea automáticamente si falta)

### Error: "Database connection failed"

**Solución**:
1. Verifica las variables de entorno de base de datos
2. Para SQLite: Asegúrate de que el path sea `/var/www/html/database/database.sqlite`
3. Para PostgreSQL: Verifica credenciales y que la base de datos exista
4. Verifica que `RUN_MIGRATIONS=true` si quieres ejecutar migraciones automáticamente

### Error: "Permission denied"

**Solución**: El Dockerfile ya configura los permisos. Si persiste:
1. Verifica que las variables de entorno estén correctas
2. Revisa los logs de Render.com para más detalles

## 📝 Checklist de Despliegue

Antes de desplegar, verifica:

- [ ] **Build Command** está vacío
- [ ] **Start Command** está vacío
- [ ] **Dockerfile Path** está correcto
- [ ] **APP_KEY** está configurada (generada con `php artisan key:generate --show`)
- [ ] **APP_URL** apunta a tu URL de Render.com
- [ ] **APP_DEBUG=false** en producción
- [ ] **Base de datos** configurada (SQLite o PostgreSQL)
- [ ] **STRIPE_SECRET** configurada (si vas a vender libros)
- [ ] **Puerto** configurado como `10000` o automático

## 🚀 Proceso de Despliegue

1. **Push a tu repositorio** (GitHub, GitLab, etc.)
2. **Render.com detecta el cambio** y comienza el build automáticamente
3. **El Dockerfile construye la imagen**:
   - Instala dependencias del sistema
   - Instala Composer y Node.js
   - Copia archivos del proyecto
   - Instala dependencias PHP y Node
   - Compila assets
   - Configura Apache
4. **El contenedor inicia**:
   - Crea directorios necesarios
   - Ejecuta `php artisan package:discover`
   - Ejecuta migraciones (si `RUN_MIGRATIONS=true`)
   - Limpia y optimiza cachés
   - Inicia Apache en el puerto 10000
5. **Render.com enruta el tráfico** al contenedor

## 🔍 Verificación Post-Despliegue

1. **Visita tu URL**: `https://tu-servicio.onrender.com`
2. **Verifica el panel de admin**: `https://tu-servicio.onrender.com/admin`
3. **Inicia sesión** con las credenciales del seeder
4. **Verifica los logs** en Render.com para errores
5. **Prueba funcionalidades clave**:
   - Ver libros
   - Agregar al carrito
   - Proceso de checkout (con Stripe en modo test)

## 📚 Comandos Útiles para Debugging

Si necesitas ejecutar comandos en el contenedor (usando el shell de Render.com):

```bash
# Ver logs de Apache
tail -f /var/log/apache2/error.log

# Ver logs de Laravel
tail -f /var/www/html/storage/logs/laravel.log

# Ejecutar comandos de Artisan
cd /var/www/html && php artisan [comando]

# Verificar permisos
ls -la /var/www/html/storage

# Verificar que artisan existe
ls -la /var/www/html/artisan

# Verificar variables de entorno
env | grep APP_
```

## ⚠️ Notas Importantes

- **NO configures Build Command ni Start Command** - El Dockerfile maneja todo
- **El puerto 10000** está configurado en el Dockerfile
- **Las variables de entorno son críticas** - Especialmente `APP_KEY` y `APP_URL`
- **SQLite funciona** pero PostgreSQL es más robusto para producción
- **Los assets se compilan durante el build** - No necesitas compilarlos manualmente
- **Las migraciones son opcionales** - Configura `RUN_MIGRATIONS=true` si las quieres automáticas
- **El archivo .env no se copia** - Usa variables de entorno en Render.com

## 🆘 Soporte

Si tienes problemas:
1. Revisa los logs en Render.com
2. Verifica todas las variables de entorno
3. Asegúrate de que Build/Start Commands estén vacíos
4. Verifica que el Dockerfile esté en la ubicación correcta
5. Consulta la documentación de Render.com: https://render.com/docs
