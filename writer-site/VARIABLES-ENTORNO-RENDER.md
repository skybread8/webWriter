# 🔧 Variables de Entorno para Render.com - Guía Rápida

## ⚠️ IMPORTANTE: Configurar APP_URL con HTTPS

**El error de "Mixed Content" se debe a que `APP_URL` no está configurado con HTTPS.**

### Configuración Mínima Requerida:

```
APP_URL=https://webwriter.onrender.com
```

**⚠️ CRÍTICO**: Debe empezar con `https://`, NO con `http://`

---

## ✅ Variables Mínimas Requeridas

### 1. **APP_KEY** (OBLIGATORIO)

Genera la clave localmente:
```bash
cd writer-site
php artisan key:generate --show
```

Configura en Render.com:
```
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx=
```

### 2. **APP_URL** (OBLIGATORIO - CON HTTPS)

```
APP_URL=https://webwriter.onrender.com
```

**IMPORTANTE**: 
- Debe usar `https://` (no `http://`)
- Reemplaza `webwriter.onrender.com` con tu URL real de Render.com
- Si no configuras esto, los assets se cargarán por HTTP y serán bloqueados por el navegador

### 3. **Base de Datos PostgreSQL**

Si tienes `DATABASE_URL` configurada:
```
DATABASE_URL=postgresql://usuario:contraseña@host:5432/database
```

O variables individuales:
```
DB_CONNECTION=pgsql
DB_HOST=dpg-xxxxx-a.oregon-postgres.render.com
DB_PORT=5432
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña
DB_SSLMODE=require
```

### 4. **Variables Básicas**

```
APP_NAME=Kevin Pérez Alarcón
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
SESSION_DRIVER=database
CACHE_DRIVER=file
RUN_MIGRATIONS=true
```

---

## 🔍 Verificar que APP_URL está correcto

Después de configurar, verifica en los logs que `APP_URL` tenga `https://`:

```
=== Database Configuration ===
APP_URL=https://webwriter.onrender.com
```

Si ves `http://`, los assets serán bloqueados por el navegador.

---

## 🚨 Error: "Mixed Content"

Si ves este error en Chrome DevTools:
- "Mixed content: load all resources via HTTPS"
- Assets bloqueados (CSS, JS, imágenes)

**Solución**: Asegúrate de que `APP_URL=https://tu-url.onrender.com` esté configurado correctamente en Render.com.

---

## ✅ Checklist Completo

- [ ] `APP_KEY=base64:...` (generada con `php artisan key:generate --show`)
- [ ] `APP_URL=https://tu-url.onrender.com` (⚠️ DEBE empezar con `https://`)
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `DATABASE_URL=...` o variables `DB_*` configuradas
- [ ] `RUN_MIGRATIONS=true`
- [ ] Redespelgar después de cambiar variables

---

## 💡 Tip

Render.com proporciona automáticamente una variable `RENDER_EXTERNAL_URL` que contiene la URL HTTPS de tu servicio. Puedes usarla como referencia, pero es mejor configurar `APP_URL` explícitamente.
