<?php if (isset($component)) { $__componentOriginal7651faf8e4a1e278424aad70c82de3ba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7651faf8e4a1e278424aad70c82de3ba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layout','data' => ['title' => 'Página de inicio']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Página de inicio']); ?>
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Inicio</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Texto principal e imagen
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Este texto e imagen aparecen en la parte superior de la web. Piensa en una frase breve y clara.
            </p>
        </div>

        <form method="POST" action="<?php echo e(route('admin.home.update')); ?>" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Texto principal
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    Se muestra grande, en el centro de la pantalla.
                </p>
                <textarea
                    name="hero_text"
                    rows="3"
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                ><?php echo e(old('hero_text', $settings->hero_text)); ?></textarea>
                <?php $__errorArgs = ['hero_text'];
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
                    Texto debajo del título
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    El párrafo que aparece bajo el texto principal, por ejemplo: &quot;Libros pensados para una lectura íntima...&quot;
                </p>
                <textarea
                    name="hero_description"
                    rows="3"
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                ><?php echo e(old('hero_description', $settings->hero_description)); ?></textarea>
                <?php $__errorArgs = ['hero_description'];
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
                    Texto alternativo / palabras clave SEO (imagen de fondo)
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    Describe la imagen para buscadores y accesibilidad (ej: &quot;Kevin Pérez Alarcón con sus libros&quot;). Mejora el posicionamiento.
                </p>
                <input
                    type="text"
                    name="hero_image_alt"
                    value="<?php echo e(old('hero_image_alt', $settings->hero_image_alt)); ?>"
                    placeholder="Ej: Autor Kevin Pérez Alarcón con sus libros"
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                >
                <?php $__errorArgs = ['hero_image_alt'];
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
                    Imagen de fondo (opcional)
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    Idealmente una imagen oscura, limpia. Se recortará a pantalla completa.
                </p>
                <input
                    type="file"
                    name="hero_image"
                    class="block w-full text-xs text-zinc-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-900 hover:file:bg-white"
                >
                <?php $__errorArgs = ['hero_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <?php if($settings->hero_image): ?>
                    <div class="mt-3">
                        <p class="text-xs text-zinc-500 mb-1">Imagen actual:</p>
                        <img src="<?php echo e(get_image_url($settings->hero_image)); ?>" alt="Imagen actual" class="max-h-40 rounded-lg border border-zinc-800 object-cover">
                    </div>
                <?php endif; ?>
            </div>

            <div class="pt-2">
                <button class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-zinc-100 text-zinc-950 text-xs font-semibold tracking-wide uppercase hover:bg-white transition">
                    Guardar cambios
                </button>
            </div>
        </form>
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

<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/admin/home/edit.blade.php ENDPATH**/ ?>