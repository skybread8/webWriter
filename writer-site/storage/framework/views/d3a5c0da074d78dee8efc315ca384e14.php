<?php if (isset($component)) { $__componentOriginal7651faf8e4a1e278424aad70c82de3ba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7651faf8e4a1e278424aad70c82de3ba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layout','data' => ['title' => 'Editar libro']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Editar libro']); ?>
    <div class="space-y-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Libros</div>
                <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                    Editar “<?php echo e($book->title); ?>”
                </h1>
                <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                    Modifica texto, precio o imagen. Los cambios se reflejarán inmediatamente en la web.
                </p>
            </div>
            <div class="shrink-0 text-right text-xs text-zinc-500">
                <?php if($book->active): ?>
                    Estado: <span class="text-emerald-300">visible</span>
                <?php else: ?>
                    Estado: <span class="text-zinc-300">oculto</span>
                <?php endif; ?>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('admin.books.update', $book)); ?>" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <?php echo $__env->make('admin.books.form', ['book' => $book], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="pt-2 flex items-center gap-3">
                <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                    Guardar cambios
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $attributes = $__attributesOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $component = $__componentOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__componentOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
                <a href="<?php echo e(route('admin.books.index')); ?>" class="text-xs text-zinc-400 underline underline-offset-4">
                    Volver al listado
                </a>
            </div>
        </form>

        <!-- Imágenes del libro -->
        <div class="mt-12 pt-12 border-t border-zinc-800">
            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="font-['DM_Serif_Display'] text-2xl md:text-3xl tracking-tight mb-2">
                        Imágenes del libro
                    </h2>
                    <p class="text-sm text-zinc-400">
                        Añade múltiples imágenes para "<?php echo e($book->title); ?>". Estas imágenes se mostrarán en una galería en la página del libro. Los usuarios podrán hacer click o deslizar para verlas todas.
                    </p>
                </div>
                <div class="shrink-0">
                    <button 
                        type="button"
                        onclick="document.getElementById('add-image-form').classList.toggle('hidden')"
                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-zinc-950 text-xs font-semibold rounded-lg transition-colors"
                    >
                        + Añadir imagen
                    </button>
                </div>
            </div>

            <!-- Formulario para añadir imagen (oculto por defecto) -->
            <div id="add-image-form" class="hidden mb-6 p-6 bg-zinc-900/40 border border-zinc-800 rounded-xl">
                <h3 class="text-lg font-semibold text-zinc-100 mb-4">Añadir nueva imagen</h3>
                <form method="POST" action="<?php echo e(route('admin.books.images.store', $book)); ?>" enctype="multipart/form-data" class="space-y-4">
                    <?php echo csrf_field(); ?>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-zinc-300">
                            Imagen <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            required
                            class="block w-full text-xs text-zinc-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-900 hover:file:bg-white"
                        >
                        <?php $__errorArgs = ['image'];
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
                            Texto alternativo SEO (palabras clave para la imagen)
                        </label>
                        <input
                            type="text"
                            name="alt"
                            value="<?php echo e(old('alt')); ?>"
                            placeholder="Ej: Detalle de la portada de <?php echo e($book->title); ?>"
                            class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50"
                        >
                        <?php $__errorArgs = ['alt'];
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
                        <label for="image_order" class="block text-xs font-medium text-zinc-300">
                            Orden (opcional)
                        </label>
                        <input
                            type="number"
                            id="image_order"
                            name="order"
                            value="<?php echo e($book->images->max('order') + 1 ?? 0); ?>"
                            min="0"
                            class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                        >
                        <p class="text-xs text-zinc-500">Los números más bajos aparecen primero. Si no especificas, se añadirá al final.</p>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-zinc-950 text-xs font-semibold rounded-lg transition-colors">
                            Guardar imagen
                        </button>
                        <button 
                            type="button"
                            onclick="document.getElementById('add-image-form').classList.add('hidden')"
                            class="text-xs text-zinc-400 underline underline-offset-4"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>

            <?php if($book->images->isNotEmpty()): ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    <?php $__currentLoopData = $book->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-zinc-800 rounded-xl overflow-hidden bg-zinc-900/40">
                            <div class="aspect-[3/4] overflow-hidden bg-zinc-950">
                                <img 
                                    src="<?php echo e($image->image_url); ?>" 
                                    alt="<?php echo e($image->alt ?: 'Imagen del libro ' . $book->title); ?>" 
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            <div class="p-3 space-y-2">
                                <p class="text-[10px] text-zinc-500">Orden: <?php echo e($image->order); ?></p>
                                <form method="POST" action="<?php echo e(route('admin.books.images.destroy', [$book, $image])); ?>" onsubmit="return confirm('¿Seguro que quieres eliminar esta imagen?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-[10px] text-red-400 underline underline-offset-2 w-full text-center">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8 bg-zinc-900/40 border border-zinc-800 rounded-xl">
                    <p class="text-sm text-zinc-500">Aún no hay imágenes adicionales para este libro.</p>
                    <p class="text-xs text-zinc-600 mt-1">Pulsa "Añadir imagen" para crear la primera. Todas las imágenes se mostrarán en una galería deslizable en la página del libro.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Fotos de lectores de este libro -->
        <div class="mt-12 pt-12 border-t border-zinc-800">
            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="font-['DM_Serif_Display'] text-2xl md:text-3xl tracking-tight mb-2">
                        Fotos de lectores de este libro
                    </h2>
                    <p class="text-sm text-zinc-400">
                        Gestiona las fotos de lectores que han comprado "<?php echo e($book->title); ?>" y se han hecho una foto contigo. Estas fotos aparecerán en la página de este libro específico. Para fotos generales, ve a "Fotos con lectores".
                    </p>
                </div>
                <div class="shrink-0">
                    <button 
                        type="button"
                        onclick="document.getElementById('add-photo-form').classList.toggle('hidden')"
                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-zinc-950 text-xs font-semibold rounded-lg transition-colors"
                    >
                        + Añadir foto
                    </button>
                </div>
            </div>

            <!-- Formulario para añadir foto (oculto por defecto) -->
            <div id="add-photo-form" class="hidden mb-6 p-6 bg-zinc-900/40 border border-zinc-800 rounded-xl">
                <h3 class="text-lg font-semibold text-zinc-100 mb-4">Añadir nueva foto</h3>
                <form method="POST" action="<?php echo e(route('admin.reader-photos.store')); ?>" enctype="multipart/form-data" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-zinc-300">
                            Foto <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="file"
                            name="photo"
                            accept="image/*"
                            required
                            class="block w-full text-xs text-zinc-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-900 hover:file:bg-white"
                        >
                        <?php $__errorArgs = ['photo'];
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

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="reader_name" class="block text-xs font-medium text-zinc-300">
                                Nombre del lector (opcional)
                            </label>
                            <input
                                type="text"
                                id="reader_name"
                                name="reader_name"
                                maxlength="255"
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                placeholder="Ej: María García"
                            >
                        </div>

                        <div class="space-y-2">
                            <label for="order" class="block text-xs font-medium text-zinc-300">
                                Orden
                            </label>
                            <input
                                type="number"
                                id="order"
                                name="order"
                                value="0"
                                min="0"
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                            >
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="caption" class="block text-xs font-medium text-zinc-300">
                            Descripción o comentario (opcional)
                        </label>
                        <textarea
                            id="caption"
                            name="caption"
                            rows="2"
                            maxlength="500"
                            class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                            placeholder="Ej: ¡Gracias por venir a la firma de libros!"
                        ></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                name="active"
                                value="1"
                                checked
                                class="rounded border-zinc-700 bg-zinc-900 text-amber-400 focus:ring-amber-400/50"
                            >
                            <span class="text-xs text-zinc-300">Mostrar esta foto públicamente</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-zinc-950 text-xs font-semibold rounded-lg transition-colors">
                            Guardar foto
                        </button>
                        <button 
                            type="button"
                            onclick="document.getElementById('add-photo-form').classList.add('hidden')"
                            class="text-xs text-zinc-400 underline underline-offset-4"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>

            <?php if(isset($readerPhotos) && $readerPhotos->isNotEmpty()): ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    <?php $__currentLoopData = $readerPhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-zinc-800 rounded-xl overflow-hidden bg-zinc-900/40">
                            <div class="aspect-square overflow-hidden bg-zinc-950">
                                <img 
                                    src="<?php echo e($photo->photo_url); ?>" 
                                    alt="<?php echo e($photo->reader_name ?? 'Foto con lector'); ?>" 
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            <div class="p-3 space-y-2">
                                <?php if($photo->reader_name): ?>
                                    <p class="text-xs font-medium text-zinc-100 truncate"><?php echo e($photo->reader_name); ?></p>
                                <?php endif; ?>
                                <?php if($photo->caption): ?>
                                    <p class="text-[10px] text-zinc-400 line-clamp-2"><?php echo e($photo->caption); ?></p>
                                <?php endif; ?>
                                <div class="flex items-center gap-2 pt-2 border-t border-zinc-800">
                                    <a href="<?php echo e(route('admin.reader-photos.edit', $photo)); ?>" class="text-[10px] text-zinc-300 underline underline-offset-2 flex-1 text-center">
                                        Editar
                                    </a>
                                    <form method="POST" action="<?php echo e(route('admin.reader-photos.destroy', $photo)); ?>" onsubmit="return confirm('¿Seguro que quieres eliminar esta foto?');" class="flex-1">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-[10px] text-red-400 underline underline-offset-2 w-full">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8 bg-zinc-900/40 border border-zinc-800 rounded-xl">
                    <p class="text-sm text-zinc-500">Aún no hay fotos de lectores para este libro.</p>
                    <p class="text-xs text-zinc-600 mt-1">Pulsa "Añadir foto" para crear la primera.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7651faf8e4a1e278424aad70c82de3ba)): ?>
<?php $attributes = $__attributesOriginal7651faf8e4a1e278424aad70c82de3ba; ?>
<?php unset($__attributesOriginal7651faf8e4a1e278424aad70c82de3ba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7651faf8e4a1e278424aad70c82de3ba)): ?>
<?php $component = $__componentOriginal7651faf8e4a1e278424aad70c82de3ba; ?>
<?php unset($__componentOriginal7651faf8e4a1e278424aad70c82de3ba); ?>
<?php endif; ?>

<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/admin/books/edit.blade.php ENDPATH**/ ?>