# Guía de Despliegue en Render.com

## Configuración del Servicio en Render.com

### 1. Tipo de Servicio
- **Tipo**: Web Service
- **Build Command**: (dejar vacío - Docker maneja todo)
- **Start Command**: (dejar vacío - Docker maneja todo)

### 2. Configuración de Docker
- **Dockerfile Path**: `Dockerfile` (o `./Dockerfile` si estás en la raíz)
- **Docker Context**: `.` (directorio raíz del repositorio)

### 3. Variables de Entorno
Configura todas las variables de entorno necesarias. Consulta `VARIABLES-ENTORNO.md` para la lista completa.

**IMPORTANTE**: Asegúrate de configurar:
- `APP_KEY` (genera una con `php artisan key:generate --show`)
- `APP_URL` (tu URL de Render.com)
- `DB_CONNECTION` y `DB_DATABASE`
- `STRIPE_SECRET` (si vas a vender libros)

### 4. Configuración de Puerto
- **Puerto**: `10000` (ya configurado en el Dockerfile)

### 5. Health Check (Opcional)
- **Health Check Path**: `/` o `/es` (cualquier ruta pública)

## Solución de Problemas

### Error: "Could not open input file: artisan"

Este error ocurre cuando Render.com intenta ejecutar comandos de Laravel antes de que el contenedor esté completamente iniciado o desde un directorio incorrecto.

**Solución PASO A PASO**:

1. **Ve a la configuración de tu servicio en Render.com**
2. **En la sección "Settings" o "Environment"**:
   - **Build Command**: Debe estar **COMPLETAMENTE VACÍO** (no pongas nada, ni siquiera espacios)
   - **Start Command**: Debe estar **COMPLETAMENTE VACÍO**
3. **Verifica que estés usando Docker**:
   - En "Docker" o "Dockerfile Path", debe estar configurado como `Dockerfile` o `./Dockerfile`
4. **Si el error persiste**:
   - Ve a "Environment" → "Advanced"
   - Busca cualquier variable que contenga comandos de build o start
   - Elimínalas o déjalas vacías
5. **Reinicia el servicio** después de hacer estos cambios

**IMPORTANTE**: Render.com a veces intenta ejecutar comandos automáticamente. El Dockerfile ya maneja todo, así que NO necesitas Build Command ni Start Command.

### Error: "Database connection failed"

**Solución**:
1. Verifica que las variables de entorno de base de datos estén correctamente configuradas
2. Para SQLite: Asegúrate de que el path sea `/var/www/html/database/database.sqlite`
3. Para PostgreSQL: Verifica que las credenciales sean correctas

### Error: "Permission denied"

**Solución**:
1. El Dockerfile ya configura los permisos correctamente
2. Si persiste, verifica que `RUN_MIGRATIONS=true` esté configurado si quieres ejecutar migraciones automáticamente

## Migraciones de Base de Datos

### Opción 1: Automática (Recomendada)
Configura la variable de entorno:
```
RUN_MIGRATIONS=true
```

Esto ejecutará las migraciones automáticamente al iniciar el contenedor.

### Opción 2: Manual
Si prefieres ejecutar las migraciones manualmente:

1. Conecta al contenedor usando el shell de Render.com
2. Ejecuta:
```bash
cd /var/www/html
php artisan migrate --force
```

## Verificación Post-Despliegue

1. **Verifica que el sitio carga**: Visita tu URL de Render.com
2. **Verifica el panel de admin**: Visita `/admin` y prueba iniciar sesión
3. **Verifica la base de datos**: Asegúrate de que los datos se muestren correctamente
4. **Verifica los logs**: Revisa los logs en Render.com para ver si hay errores

## Notas Importantes

- **No configures Build Command ni Start Command** - El Dockerfile maneja todo
- **El puerto debe ser 10000** - Ya está configurado en el Dockerfile
- **Las variables de entorno son críticas** - Especialmente `APP_KEY` y `APP_URL`
- **SQLite funciona** pero PostgreSQL es más robusto para producción
- **Los assets se compilan durante el build** - No necesitas compilarlos manualmente

## Comandos Útiles para Debugging

Si necesitas ejecutar comandos en el contenedor:

```bash
# Ver logs de Apache
tail -f /var/log/apache2/error.log

# Ver logs de Laravel
tail -f /var/www/html/storage/logs/laravel.log

# Ejecutar comandos de Artisan
cd /var/www/html && php artisan [comando]

# Verificar permisos
ls -la /var/www/html/storage
```
