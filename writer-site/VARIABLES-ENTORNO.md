# Variables de Entorno para Render.com

Añade estas variables de entorno en la sección "Environment Variables" de Render.com:

## 🔴 OBLIGATORIAS (Mínimo para que funcione)

```
APP_NAME=Kevin Pérez Alarcón
APP_ENV=production
APP_KEY=base64:TU_CLAVE_AQUI_GENERADA
APP_DEBUG=false
APP_URL=https://tu-servicio.onrender.com
LOG_LEVEL=error
```

## 🟡 BASE DE DATOS (Elige una opción)

### Opción A: SQLite (Simple para empezar)
```
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
```

### Opción B: PostgreSQL (Recomendado para producción)
```
DB_CONNECTION=pgsql
DB_HOST=tu-host-postgresql.render.com
DB_PORT=5432
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña
```

## 🟢 STRIPE (Para pagos - OBLIGATORIO si quieres vender libros)

```
STRIPE_SECRET=sk_live_tu_clave_secreta_de_stripe
```

**Nota:** Si aún no tienes las claves de Stripe, puedes dejarlo vacío temporalmente, pero los pagos no funcionarán.

## 🔵 IDIOMAS (Opcional, tiene valores por defecto)

```
APP_LOCALE=es
APP_FALLBACK_LOCALE=es
```

## 🟣 SESIONES Y CACHE (Opcional, tiene valores por defecto)

```
SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

## 🟠 EMAIL (Opcional, solo si quieres enviar emails)

Si quieres que el formulario de contacto envíe emails:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_usuario
MAIL_PASSWORD=tu_contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tudominio.com
MAIL_FROM_NAME="${APP_NAME}"
```

## ⚪ OTRAS (Opcional)

```
FILESYSTEM_DISK=local
```

---

## 📝 INSTRUCCIONES RÁPIDAS

1. **APP_KEY**: Es la más importante. Si no la tienes, puedes generarla localmente con:
   ```bash
   php artisan key:generate --show
   ```
   O Render.com puede generarla automáticamente si añades un "Build Command" (aunque con Docker no es necesario).

2. **APP_URL**: Reemplaza `tu-servicio.onrender.com` con la URL real que Render.com te asigne (algo como `writer-site-xxxx.onrender.com`).

3. **STRIPE_SECRET**: Obtén esta clave desde tu dashboard de Stripe (https://dashboard.stripe.com/apikeys). Usa la clave de **producción** (sk_live_...) para producción.

4. **Base de datos**: 
   - Para SQLite: Necesitarás crear un "Disk" en Render.com y montarlo en `/var/www/html/database`
   - Para PostgreSQL: Crea una base de datos PostgreSQL en Render.com y copia las credenciales

---

## ✅ CHECKLIST MÍNIMO

- [ ] APP_NAME
- [ ] APP_ENV=production
- [ ] APP_KEY (¡MUY IMPORTANTE!)
- [ ] APP_DEBUG=false
- [ ] APP_URL (tu URL de Render.com)
- [ ] LOG_LEVEL=error
- [ ] DB_CONNECTION
- [ ] DB_DATABASE (o credenciales de PostgreSQL)
- [ ] STRIPE_SECRET (si vas a vender libros)

Con estas variables mínimas, tu aplicación debería funcionar en Render.com.
