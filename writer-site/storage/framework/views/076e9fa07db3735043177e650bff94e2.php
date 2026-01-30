<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['book' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['book' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $isEdit = (bool) $book;
?>

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
                value="<?php echo e(old('title', $book?->title)); ?>"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                value="<?php echo e(old('price', $book?->price)); ?>"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
        ><?php echo e(old('description', $book?->description)); ?></textarea>
        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            Texto largo (opcional)
        </label>
        <p class="text-xs text-zinc-500 mb-1">
            Se muestra en la ficha completa del libro. Usa el editor para poner negritas, cursivas, listas, etc.
        </p>
        <input id="long_description" type="hidden" name="long_description" value="<?php echo e(old('long_description', $book?->long_description)); ?>">
        <div class="trix-wrapper">
            <trix-editor input="long_description" class="trix-content" style="min-height: 220px;"></trix-editor>
        </div>
        <?php $__errorArgs = ['long_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300 hidden">
                Precio de Stripe (opcional)
            </label>
            <p class="text-xs text-zinc-500 mb-1 hidden">
                Código “Price ID” de Stripe para este libro. Si lo dejas vacío, podrás rellenarlo más adelante.
            </p>
            <input
                type="text"
                name="stripe_price_id"
                value="<?php echo e(old('stripe_price_id', $book?->stripe_price_id)); ?>"
                class="hidden"
            >
            <?php $__errorArgs = ['stripe_price_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <div class="mt-4 flex items-center gap-2">
                <input
                    type="checkbox"
                    id="active"
                    name="active"
                    value="1"
                    <?php if(old('active', $book?->active ?? true)): echo 'checked'; endif; ?>
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
                value="<?php echo e(old('cover_image_alt', $book?->cover_image_alt)); ?>"
                placeholder="Ej: Portada de [nombre del libro]"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            <?php $__errorArgs = ['cover_image_alt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                value="<?php echo e(old('stock', $book?->stock !== null ? $book->stock : '')); ?>"
                min="0"
                placeholder="Ilimitado"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                value="<?php echo e(old('order', $book?->order ?? 0)); ?>"
                min="0"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>
</div>

<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/admin/books/form.blade.php ENDPATH**/ ?>