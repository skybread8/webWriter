@props(['book' => null])

@php
    $isEdit = (bool) $book;
@endphp

<div class="space-y-6">
    <div class="grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                Título del libro
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                Nombre que verá la gente en la web y en el panel.
            </p>
            <input
                type="text"
                name="title"
                value="{{ old('title', $book?->title) }}"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            @error('title')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                Precio
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                Importe final que pagará el lector (en euros).
            </p>
            <input
                type="number"
                step="0.01"
                name="price"
                value="{{ old('price', $book?->price) }}"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            @error('price')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            Descripción corta
        </label>
        <p class="text-xs text-zinc-500 mb-1">
            Aparece en la lista de libros. Ideal: una o dos frases.
        </p>
        <textarea
            name="description"
            rows="2"
            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
        >{{ old('description', $book?->description) }}</textarea>
        @error('description')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            Texto largo (opcional)
        </label>
        <p class="text-xs text-zinc-500 mb-1">
            Se muestra en la ficha completa del libro. Puedes escribir con calma.
        </p>
        <textarea
            name="long_description"
            rows="5"
            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
        >{{ old('long_description', $book?->long_description) }}</textarea>
        @error('long_description')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                Precio de Stripe (opcional)
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                Código “Price ID” de Stripe para este libro. Si lo dejas vacío, podrás rellenarlo más adelante.
            </p>
            <input
                type="text"
                name="stripe_price_id"
                value="{{ old('stripe_price_id', $book?->stripe_price_id) }}"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            @error('stripe_price_id')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror

            <div class="mt-4 flex items-center gap-2">
                <input
                    type="checkbox"
                    id="active"
                    name="active"
                    value="1"
                    @checked(old('active', $book?->active ?? true))
                    class="rounded border-zinc-700 bg-zinc-900 text-zinc-100 focus:ring-zinc-500"
                >
                <label for="active" class="text-xs text-zinc-200">
                    Mostrar este libro en la web
                </label>
            </div>
        </div>

        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                Texto alternativo SEO (portada / primera imagen)
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                Palabras clave para buscadores (ej: &quot;Portada del libro [título]&quot;). Mejora el posicionamiento de las imágenes.
            </p>
            <input
                type="text"
                name="cover_image_alt"
                value="{{ old('cover_image_alt', $book?->cover_image_alt) }}"
                placeholder="Ej: Portada de [nombre del libro]"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            @error('cover_image_alt')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                Stock (unidades disponibles)
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                Deja vacío para no controlar stock (ilimitado). Si pones un número, se irá restando con cada venta. A 0 se bloqueará la compra y se avisará al admin.
            </p>
            <input
                type="number"
                name="stock"
                value="{{ old('stock', $book?->stock !== null ? $book->stock : '') }}"
                min="0"
                placeholder="Ilimitado"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            @error('stock')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                Orden de aparición
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                Número que determina el orden. Los números más bajos aparecen primero. Por defecto: 0.
            </p>
            <input
                type="number"
                name="order"
                value="{{ old('order', $book?->order ?? 0) }}"
                min="0"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            @error('order')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

