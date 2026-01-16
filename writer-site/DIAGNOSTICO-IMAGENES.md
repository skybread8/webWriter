# 🔍 Diagnóstico: Imágenes No Se Visualizan (404)

## Problema

Las imágenes no se visualizan y al abrir la URL directamente se obtiene un error 404.

**URL de ejemplo:** `https://webwriter.onrender.com/storage/covers/98H2mxuCfwLWrlqgZMedZIOClT2PK2DRXODsvt33.png`

## Causas Posibles

1. **El enlace simbólico `public/storage` no existe o está roto**
2. **El archivo no existe físicamente en `storage/app/public/covers/`**
3. **Apache no puede seguir el enlace simbólico**
4. **Permisos incorrectos**

## Verificación en Render.com

### Paso 1: Acceder a la Shell de Render.com

1. Ve a tu servicio en Render.com
2. Haz clic en **"Shell"** (consola)
3. Se abrirá una terminal

### Paso 2: Verificar el enlace simbólico

Ejecuta estos comandos uno por uno:

```bash
cd /var/www/html
ls -la public/storage
```

**Resultado esperado:**
```
lrwxrwxrwx 1 www-data www-data 25 Jan 16 14:00 public/storage -> ../storage/app/public
```

**Si ves esto:**
- ✅ El enlace simbólico existe
- Continúa con el Paso 3

**Si NO ves esto o ves un error:**
- ❌ El enlace simbólico no existe
- Ejecuta: `php artisan storage:link`
- O manualmente: `ln -s ../storage/app/public public/storage`

### Paso 3: Verificar que el destino existe

```bash
ls -la public/storage/
```

**Resultado esperado:**
Deberías ver el contenido de `storage/app/public`, incluyendo el directorio `covers/`.

**Si ves "No such file or directory":**
- El enlace simbólico está roto
- Ejecuta: `rm public/storage && php artisan storage:link`

### Paso 4: Verificar el directorio covers

```bash
ls -la storage/app/public/covers/
```

**Resultado esperado:**
Deberías ver los archivos de imágenes, por ejemplo:
```
-rw-r--r-- 1 www-data www-data 123456 Jan 16 14:00 98H2mxuCfwLWrlqgZMedZIOClT2PK2DRXODsvt33.png
```

**Si el directorio no existe:**
```bash
mkdir -p storage/app/public/covers
chown -R www-data:www-data storage/app/public
chmod -R 775 storage/app/public
```

**Si el directorio existe pero está vacío:**
- Los archivos no se están guardando correctamente
- Verifica los permisos (Paso 5)

### Paso 5: Verificar permisos

```bash
ls -la storage/app/public/
```

**Permisos correctos:**
- Directorio: `drwxrwxr-x` (775)
- Archivos: `-rw-r--r--` (644)

**Si los permisos son incorrectos:**
```bash
chown -R www-data:www-data storage/app/public
chmod -R 775 storage/app/public
find storage/app/public -type f -exec chmod 644 {} \;
```

### Paso 6: Verificar que el archivo específico existe

```bash
ls -la storage/app/public/covers/98H2mxuCfwLWrlqgZMedZIOClT2PK2DRXODsvt33.png
```

**Si el archivo NO existe:**
- El archivo no se guardó correctamente cuando se subió
- Necesitas subirlo nuevamente desde el panel de administración

**Si el archivo existe:**
- El problema es con el enlace simbólico o la configuración de Apache
- Continúa con el Paso 7

### Paso 7: Verificar configuración de Apache

```bash
cat /etc/apache2/sites-available/000-default.conf | grep -A 5 "public/storage"
```

O verifica que Apache puede seguir enlaces simbólicos:

```bash
grep -i "FollowSymLinks" /etc/apache2/sites-available/000-default.conf
```

**Debería aparecer:** `Options ... +FollowSymLinks ...`

## Solución Rápida

Si después de verificar todo lo anterior sigue sin funcionar, ejecuta este script completo:

```bash
cd /var/www/html

# Crear directorios
mkdir -p storage/app/public/covers
mkdir -p storage/app/public/blog_images
mkdir -p storage/app/public/testimonials

# Establecer permisos
chown -R www-data:www-data storage/app/public
chmod -R 775 storage/app/public

# Eliminar enlace roto si existe
rm -f public/storage

# Crear enlace simbólico
php artisan storage:link

# Verificar
ls -la public/storage
ls -la storage/app/public/covers/
```

## Verificar en el Navegador

Después de hacer los cambios:

1. **Refresca la página** (Ctrl+F5 o Cmd+Shift+R)
2. **Abre la URL directamente** en una pestaña nueva:
   `https://webwriter.onrender.com/storage/covers/98H2mxuCfwLWrlqgZMedZIOClT2PK2DRXODsvt33.png`

**Si ahora funciona:**
- ✅ Problema resuelto

**Si sigue sin funcionar:**
- Verifica los logs de Apache: `tail -f /var/log/apache2/error.log`
- Verifica que el archivo realmente existe: `ls -la storage/app/public/covers/98H2mxuCfwLWrlqgZMedZIOClT2PK2DRXODsvt33.png`

## Nota sobre la Base de Datos

En PostgreSQL, el campo `cover_image` debe contener **solo** la ruta relativa:
- ✅ Correcto: `covers/98H2mxuCfwLWrlqgZMedZIOClT2PK2DRXODsvt33.png`
- ❌ Incorrecto: `storage/covers/...` o `/storage/covers/...`

Laravel añade automáticamente `storage/` cuando usa `asset('storage/'.$book->cover_image)`.

## Si Nada Funciona

Si después de todos estos pasos las imágenes siguen sin funcionar, puede ser que Render.com tenga restricciones con enlaces simbólicos. En ese caso, considera:

1. **Usar un servicio de almacenamiento en la nube** (S3, Cloudinary, etc.)
2. **Copiar archivos directamente a `public/storage/`** en lugar de usar enlaces simbólicos

Pero primero, prueba con los pasos anteriores.
