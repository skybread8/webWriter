# 📦 Configuración de Almacenamiento S3 para Imágenes Persistentes

## 🎯 Problema Resuelto

Las imágenes se perdían en cada deploy porque se guardaban en el sistema de archivos local, que es efímero en Render.com. Ahora las imágenes se guardan en **Amazon S3** (o similar), que es persistente y no se pierde entre deploys.

## ✅ Solución Implementada

El código ahora:
- **Detecta automáticamente** si S3 está configurado
- **Usa S3** si las credenciales están disponibles
- **Usa almacenamiento local** como fallback si S3 no está configurado
- **Funciona sin cambios** en desarrollo local (sin S3 configurado)

## 📋 Pasos para Configurar S3 en Render.com

### Opción 1: Amazon S3 (Recomendado)

#### Paso 1: Crear un Bucket en AWS S3

1. Ve a [AWS Console](https://console.aws.amazon.com/s3/)
2. Click en **"Create bucket"**
3. Configura:
   - **Bucket name**: `tu-nombre-bucket` (debe ser único globalmente)
   - **Region**: Elige una región cercana (ej: `eu-west-1` para Europa)
   - **Block Public Access**: **Desmarca** "Block all public access" (necesitamos que las imágenes sean públicas)
   - **Bucket Versioning**: Opcional, puedes desactivarlo
4. Click en **"Create bucket"**

#### Paso 2: Configurar Permisos del Bucket

1. Ve a tu bucket → **"Permissions"** → **"Bucket policy"**
2. Añade esta política (reemplaza `tu-nombre-bucket` con el nombre real):

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Sid": "PublicReadGetObject",
            "Effect": "Allow",
            "Principal": "*",
            "Action": "s3:GetObject",
            "Resource": "arn:aws:s3:::tu-nombre-bucket/*"
        }
    ]
}
```

3. Click en **"Save changes"**

#### Paso 3: Crear un Usuario IAM para Acceso Programático

1. Ve a [IAM Console](https://console.aws.amazon.com/iam/)
2. Click en **"Users"** → **"Create user"**
3. Nombre: `laravel-s3-user` (o el que prefieras)
4. Click en **"Next"**
5. En **"Set permissions"**, selecciona **"Attach policies directly"**
6. Busca y selecciona: **"AmazonS3FullAccess"** (o crea una política más restrictiva)
7. Click en **"Next"** → **"Create user"**
8. **IMPORTANTE**: Click en el usuario recién creado → **"Security credentials"** → **"Create access key"**
9. Selecciona **"Application running outside AWS"**
10. Click en **"Create access key"**
11. **COPIA Y GUARDA**:
    - **Access Key ID**
    - **Secret Access Key** (solo se muestra una vez)

#### Paso 4: Configurar Variables de Entorno en Render.com

En tu servicio web de Render.com, ve a **"Environment Variables"** y añade:

```
AWS_ACCESS_KEY_ID=tu_access_key_id_aqui
AWS_SECRET_ACCESS_KEY=tu_secret_access_key_aqui
AWS_DEFAULT_REGION=eu-west-1
AWS_BUCKET=tu-nombre-bucket
AWS_URL=https://tu-nombre-bucket.s3.eu-west-1.amazonaws.com
FILESYSTEM_DISK=s3
```

**Nota**: Reemplaza:
- `tu_access_key_id_aqui` con tu Access Key ID
- `tu_secret_access_key_aqui` con tu Secret Access Key
- `eu-west-1` con la región que elegiste
- `tu-nombre-bucket` con el nombre de tu bucket
- La URL debe coincidir con tu región (ej: `s3.eu-west-1.amazonaws.com`)

### Opción 2: DigitalOcean Spaces (Alternativa más barata)

DigitalOcean Spaces es compatible con S3 y es más económico.

#### Paso 1: Crear un Space en DigitalOcean

1. Ve a [DigitalOcean Spaces](https://cloud.digitalocean.com/spaces)
2. Click en **"Create a Space"**
3. Configura:
   - **Name**: `tu-nombre-space` (debe ser único)
   - **Region**: Elige una región cercana
   - **File listing**: **Público** (para que las imágenes sean accesibles)
4. Click en **"Create a Space"**

#### Paso 2: Crear una API Key

1. Ve a [API Tokens](https://cloud.digitalocean.com/account/api/tokens)
2. Click en **"Generate New Token"**
3. Nombre: `laravel-spaces`
4. Selecciona **"Write"** como scope
5. Click en **"Generate Token"**
6. **COPIA Y GUARDA** el token (solo se muestra una vez)

#### Paso 3: Configurar Variables de Entorno en Render.com

```
AWS_ACCESS_KEY_ID=tu_spaces_key_aqui
AWS_SECRET_ACCESS_KEY=tu_spaces_secret_aqui
AWS_DEFAULT_REGION=nyc3
AWS_BUCKET=tu-nombre-space
AWS_ENDPOINT=https://nyc3.digitaloceanspaces.com
AWS_USE_PATH_STYLE_ENDPOINT=false
AWS_URL=https://tu-nombre-space.nyc3.digitaloceanspaces.com
FILESYSTEM_DISK=s3
```

**Nota**: 
- `tu_spaces_key_aqui` y `tu_spaces_secret_aqui` son las credenciales de tu Space
- `nyc3` es un ejemplo de región, usa la que elegiste
- La URL debe coincidir con tu región

## 🔄 Migrar Imágenes Existentes a S3

Si ya tienes imágenes en producción y quieres migrarlas a S3:

### Opción A: Subirlas Manualmente

1. Descarga todas las imágenes desde Render.com (si aún están disponibles)
2. Sube cada imagen manualmente a tu bucket S3 manteniendo la misma estructura de carpetas:
   - `covers/`
   - `blog_images/`
   - `testimonials/`
   - `hero/`
   - `author/`

### Opción B: Usar un Script de Migración

Puedes crear un comando Artisan para migrar automáticamente:

```bash
php artisan migrate:images-to-s3
```

(Esto requeriría crear el comando, pero es opcional)

## ✅ Verificación

Después de configurar S3:

1. **Haz un nuevo deploy** en Render.com
2. **Sube una imagen nueva** desde el panel de administración
3. **Verifica** que la imagen se muestra correctamente
4. **Haz otro deploy** y verifica que la imagen **sigue estando** (no se perdió)

## 🛠️ Solución de Problemas

### Error: "Access Denied" al subir imágenes

- Verifica que las credenciales de AWS estén correctas
- Verifica que el usuario IAM tenga permisos de escritura en el bucket
- Verifica que el bucket policy permita operaciones de escritura

### Error: "Bucket not found"

- Verifica que `AWS_BUCKET` tenga el nombre correcto del bucket
- Verifica que `AWS_DEFAULT_REGION` coincida con la región del bucket

### Las imágenes no se muestran

- Verifica que `AWS_URL` esté configurado correctamente
- Verifica que el bucket policy permita lectura pública
- Verifica que las imágenes estén en la ruta correcta dentro del bucket

### Las imágenes se muestran pero son lentas

- Considera usar CloudFront (CDN de AWS) para acelerar la carga
- O usa una región más cercana a tus usuarios

## 💡 Notas Importantes

- **Las imágenes antiguas** (guardadas antes de configurar S3) seguirán funcionando si usas `asset('storage/...')`, pero las nuevas se guardarán en S3
- **En desarrollo local**, sin configurar S3, todo seguirá funcionando con almacenamiento local
- **El código detecta automáticamente** qué usar, no necesitas cambiar nada en el código

## 📚 Recursos

- [Documentación de Laravel Filesystem](https://laravel.com/docs/filesystem)
- [Documentación de AWS S3](https://docs.aws.amazon.com/s3/)
- [Documentación de DigitalOcean Spaces](https://docs.digitalocean.com/products/spaces/)
