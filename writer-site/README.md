## Sitio editorial para escritor – Laravel + Tailwind + Stripe

Proyecto completo en Laravel para un escritor que vende sus libros online, con:

- **Frontend público** minimalista y oscuro (Blade + Tailwind + Alpine.js).
- **Panel de administración en `/admin`** para editar textos, imágenes y precios sin tocar código.
- **Pagos con Stripe Checkout** por libro.
- **Contacto** con formulario y envío de correo.

---

### 1. Requisitos

- PHP 8.2+
- Composer
- Node.js 20+ y npm

---

### 2. Instalación

1. Ir a la carpeta del proyecto:

```bash
cd writer-site
```

2. Instalar dependencias PHP:

```bash
composer install
```

3. Instalar dependencias front:

```bash
npm install
```

4. Copiar el archivo de entorno y generar clave:

```bash
cp .env.example .env
php artisan key:generate
```

5. Base de datos SQLite (por defecto):

- Asegúrate de que existe `database/database.sqlite` (Laravel ya lo incluye; si no, créalo vacío).
- En `.env` debe estar:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/ruta/completa/al/proyecto/writer-site/database/database.sqlite
```

6. Ejecutar migraciones y datos de ejemplo:

```bash
php artisan migrate --seed
php artisan storage:link
```

7. Levantar el servidor y el build front:

En una terminal:

```bash
php artisan serve
```

En otra:

```bash
npm run dev
```

La web estará disponible normalmente en `http://127.0.0.1:8000`.

---

### 3. Acceso al panel de administración

- **URL**: `http://127.0.0.1:8000/login`
- **Usuario inicial** (creado por el seeder `AdminUserSeeder`):

  - Correo: `admin@example.com`
  - Contraseña: `password`

Una vez dentro, accede al panel desde `http://127.0.0.1:8000/admin`.

---

### 4. Configuración de Stripe

1. Crea una cuenta en Stripe y obtén tus claves.

2. En el archivo `.env`, añade:

```env
STRIPE_SECRET=sk_test_tu_clave_secreta
```

3. En el panel de Stripe, crea productos/precios (`Price ID`) para cada libro.

4. En el panel `/admin`:

   - Ve a **Libros** → edita un libro.
   - Rellena el campo **“Precio de Stripe”** con el `price_xxx` que te da Stripe.
   - Asegúrate de que el libro está marcado como **visible**.

Cuando el lector pulse **“Comprar”**, se abrirá la página segura de Stripe y, al finalizar:

- Éxito → `/checkout/success`
- Cancelación → `/checkout/cancel`

---

### 5. Cómo editar contenidos (admin no técnico)

Todo se hace desde el panel `/admin` (una vez identificado).

- **Página de inicio**:
  - Menú: “Página de inicio”.
  - Campos:
    - **Texto principal**: frase grande que aparece en la portada.
    - **Imagen de fondo**: imagen oscura de fondo (opcional).

- **Libros**:
  - Menú: “Libros”.
  - Acciones:
    - **Añadir libro**: título, descripción breve, texto largo, precio, portada, visibilidad.
    - **Editar**: mismos campos, más el `Precio de Stripe`.
    - **Eliminar**: quita el libro de la lista.

- **Sobre el autor**:
  - Menú: “Sobre el autor”.
  - Editor de texto enriquecido (Trix). El texto que se escriba aquí aparecerá en `/about`.

- **Contacto**:
  - Menú: “Contacto”.
  - Texto que aparecerá encima del formulario en `/contact`.

- **Datos generales**:
  - Menú: “Datos generales”.
  - **Nombre del sitio**: aparece en la cabecera.
  - **Frase breve (tagline)**: pequeña línea bajo el nombre.
  - **Correo para recibir mensajes**: email que recibirá los formularios de contacto.

---

### 6. Flujo de compra y contacto

- **Compra de libro**:
  - El visitante va a `/books`.
  - Elige un libro y pulsa “Comprar”.
  - Se crea una sesión de **Stripe Checkout** usando el `stripe_price_id` del libro.
  - Tras el pago, se redirige a `/checkout/success` o `/checkout/cancel`.

- **Formulario de contacto**:
  - Página `/contact`.
  - Campos: nombre, correo, mensaje.
  - Envía un email a la dirección configurada en “Datos generales”.

---

### 7. Notas técnicas

- **Framework**: Laravel 12 (SQLite por defecto, fácilmente cambiable a MySQL desde `.env`).
- **Frontend**: Blade + Tailwind CSS + Alpine.js.
- **Auth**: Laravel Breeze (login/registro por email).
- **Almacenamiento de imágenes**: disco `public` (`storage/app/public`) servido mediante `php artisan storage:link`.
