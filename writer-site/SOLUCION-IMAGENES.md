# 🖼️ Solución: Imágenes No Se Visualizan

## Problema

Las imágenes subidas no se visualizan, solo aparece el icono de foto.

## Causa

El enlace simbólico `public/storage` → `storage/app/public` no existe o no tiene permisos correctos.

## Solución Automática

El script `start.sh` ahora crea automáticamente el enlace simbólico al iniciar. Si aún no funciona:

### Verificar en los logs de Render.com

Busca estos mensajes en los logs:

```
=== Creating storage symlink ===
✓ Storage symlink exists
```

Si ves `✗ WARNING: Storage symlink could not be created!`, hay un problema.

### Solución Manual (si es necesario)

Si el enlace simbólico no se crea automáticamente, puedes ejecutar manualmente en Render.com:

1. Ve a tu servicio en Render.com
2. Click en "Shell" (consola)
3. Ejecuta:

```bash
cd /var/www/html
php artisan storage:link
```

O manualmente:

```bash
cd /var/www/html
rm -rf public/storage
ln -s ../storage/app/public public/storage
chown -h www-data:www-data public/storage
chmod -R 775 storage/app/public
```

## Verificar que Funciona

Después de crear el enlace, verifica:

```bash
ls -la public/storage
```

Deberías ver algo como:

```
lrwxrwxrwx 1 www-data www-data 25 Jan 16 14:00 public/storage -> ../storage/app/public
```

## Permisos Correctos

Los permisos deben ser:

- `storage/app/public`: `775` (rwxrwxr-x)
- `public/storage`: Enlace simbólico
- Archivos subidos: `644` (rw-r--r--)

## Verificar en el Navegador

Después de subir una imagen, verifica que la URL sea correcta:

- ✅ Correcto: `https://webwriter.onrender.com/storage/covers/imagen.jpg`
- ❌ Incorrecto: `https://webwriter.onrender.com/storage/app/public/covers/imagen.jpg`

## Si Aún No Funciona

1. **Verifica que el archivo existe**:
   ```bash
   ls -la storage/app/public/covers/
   ```

2. **Verifica permisos**:
   ```bash
   ls -la storage/app/public/
   ```

3. **Verifica el enlace simbólico**:
   ```bash
   ls -la public/storage
   ```

4. **Verifica que Apache puede leer**:
   ```bash
   cat public/storage/.htaccess 2>/dev/null || echo "No .htaccess, creating..."
   ```

## Nota sobre Render.com

Render.com puede tener restricciones con enlaces simbólicos. Si no funciona, considera:

1. **Usar un servicio de almacenamiento en la nube** (S3, Cloudinary, etc.)
2. **Usar un Disk de Render.com** montado en `/var/www/html/storage/app/public`

Pero primero, prueba con el enlace simbólico que ahora se crea automáticamente.
