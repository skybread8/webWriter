<?php if (isset($component)) { $__componentOriginal7651faf8e4a1e278424aad70c82de3ba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7651faf8e4a1e278424aad70c82de3ba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layout','data' => ['title' => 'Resumen del sitio']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Resumen del sitio']); ?>
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Vista rápida</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Estado del sitio
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Aquí puedes ver cuántos libros están publicados y si las páginas principales tienen contenido.
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-4">
            <div class="border border-zinc-800 rounded-2xl p-4 bg-zinc-900/40">
                <div class="text-xs text-zinc-500 mb-2">Libros activos</div>
                <div class="text-3xl font-semibold"><?php echo e($activeBooksCount); ?></div>
                <div class="text-xs text-zinc-500 mt-1"><?php echo e($booksCount); ?> en total</div>
            </div>
            <div class="border border-zinc-800 rounded-2xl p-4 bg-zinc-900/40">
                <div class="text-xs text-zinc-500 mb-2">Reseñas pendientes</div>
                <div class="text-3xl font-semibold text-amber-400"><?php echo e($pendingReviewsCount); ?></div>
                <div class="text-xs text-zinc-500 mt-1">
                    <a href="<?php echo e(route('admin.reviews.index')); ?>" class="text-amber-400 hover:text-amber-300 underline">
                        Gestionar reseñas
                    </a>
                </div>
            </div>
            <div class="border border-zinc-800 rounded-2xl p-4 bg-zinc-900/40">
                <div class="text-xs text-zinc-500 mb-2">Sobre el autor</div>
                <div class="text-sm text-zinc-200">
                    <?php echo e($aboutPage && $aboutPage->content ? 'Con texto' : 'Pendiente de rellenar'); ?>

                </div>
            </div>
            <div class="border border-zinc-800 rounded-2xl p-4 bg-zinc-900/40">
                <div class="text-xs text-zinc-500 mb-2">Contacto</div>
                <div class="text-sm text-zinc-200">
                    <?php echo e($contactPage && $contactPage->content ? 'Con texto' : 'Pendiente de rellenar'); ?>

                </div>
                <div class="text-xs text-zinc-500 mt-1">
                    Correo: <?php echo e($settings?->contact_email ?? 'sin configurar'); ?>

                </div>
            </div>
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

<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>