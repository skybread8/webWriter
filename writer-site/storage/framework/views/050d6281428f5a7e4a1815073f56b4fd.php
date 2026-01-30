<?php $__env->startSection('title', 'Carrito de compra'); ?>

<?php $__env->startSection('content'); ?>
    <section 
        x-data="scrollReveal(0)"
        class="px-4 sm:px-5 md:px-8 py-10 sm:py-14 md:py-20 max-w-5xl mx-auto"
    >
        <div 
            class="space-y-6 sm:space-y-8"
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div>
                <div class="inline-flex items-center gap-2 mb-2 sm:mb-3">
                    <?php if (isset($component)) { $__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shopping-cart','data' => ['class' => 'w-4 h-4 sm:w-5 sm:h-5 text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shopping-cart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 sm:w-5 sm:h-5 text-amber-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb)): ?>
<?php $attributes = $__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb; ?>
<?php unset($__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb)): ?>
<?php $component = $__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb; ?>
<?php unset($__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb); ?>
<?php endif; ?>
                    <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                        Carrito
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl tracking-tight mb-2">
                    <?php echo e(__('common.cart.title')); ?>

                </h1>
                <p class="text-xs sm:text-sm text-zinc-400">
                    <?php echo e(__('common.cart.description')); ?>

                </p>
            </div>

            <?php if(session('status')): ?>
                <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-4 py-3 text-sm">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <?php if(empty($books)): ?>
                <div class="text-center py-16 space-y-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-zinc-900 border border-zinc-800 mb-4">
                        <?php if (isset($component)) { $__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shopping-cart','data' => ['class' => 'w-10 h-10 text-zinc-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shopping-cart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-10 h-10 text-zinc-600']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb)): ?>
<?php $attributes = $__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb; ?>
<?php unset($__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb)): ?>
<?php $component = $__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb; ?>
<?php unset($__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb); ?>
<?php endif; ?>
                    </div>
                    <p class="text-zinc-400 text-lg"><?php echo e(__('common.cart.empty')); ?></p>
                    <a href="<?php echo e(localized_route('books.index.public')); ?>" class="inline-flex items-center gap-2 text-sm tracking-[0.25em] uppercase text-zinc-300 hover:text-zinc-100 transition-colors group">
                        <?php if (isset($component)) { $__componentOriginal37a3f047daccd28b87517bd215a12923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37a3f047daccd28b87517bd215a12923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-right','data' => ['class' => 'w-4 h-4 rotate-180 transition-transform group-hover:-translate-x-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 rotate-180 transition-transform group-hover:-translate-x-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal37a3f047daccd28b87517bd215a12923)): ?>
<?php $attributes = $__attributesOriginal37a3f047daccd28b87517bd215a12923; ?>
<?php unset($__attributesOriginal37a3f047daccd28b87517bd215a12923); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal37a3f047daccd28b87517bd215a12923)): ?>
<?php $component = $__componentOriginal37a3f047daccd28b87517bd215a12923; ?>
<?php unset($__componentOriginal37a3f047daccd28b87517bd215a12923); ?>
<?php endif; ?>
                        <span><?php echo e(__('common.books.title')); ?></span>
                    </a>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div 
                            class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4 md:gap-5 border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-5 bg-zinc-900/40 hover:bg-zinc-900/60 hover:border-zinc-700 transition-all duration-300"
                            :class="show ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-4'"
                            x-data="scrollReveal(<?php echo e(($index + 1) * 100); ?>)"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0"
                        >
                            <?php if($item['image_url']): ?>
                                <img src="<?php echo e($item['image_url']); ?>" alt="<?php echo e($item['title']); ?>" class="w-20 h-28 sm:w-24 sm:h-32 rounded-xl object-cover border-2 border-zinc-800 shadow-lg flex-shrink-0">
                            <?php else: ?>
                                <div class="w-20 h-28 sm:w-24 sm:h-32 rounded-xl border-2 border-dashed border-zinc-700 flex items-center justify-center bg-zinc-950 flex-shrink-0">
                                    <?php if (isset($component)) { $__componentOriginal285eddc9278dae58281aa961bf08a625 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal285eddc9278dae58281aa961bf08a625 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.book','data' => ['class' => 'w-6 h-6 sm:w-8 sm:h-8 text-zinc-700']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 sm:w-8 sm:h-8 text-zinc-700']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal285eddc9278dae58281aa961bf08a625)): ?>
<?php $attributes = $__attributesOriginal285eddc9278dae58281aa961bf08a625; ?>
<?php unset($__attributesOriginal285eddc9278dae58281aa961bf08a625); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal285eddc9278dae58281aa961bf08a625)): ?>
<?php $component = $__componentOriginal285eddc9278dae58281aa961bf08a625; ?>
<?php unset($__componentOriginal285eddc9278dae58281aa961bf08a625); ?>
<?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="flex-1 w-full space-y-2 sm:space-y-3">
                                <div>
                                    <h3 class="text-sm sm:text-base font-semibold text-zinc-50 mb-1"><?php echo e($item['title']); ?></h3>
                                    <p class="text-xs sm:text-sm text-amber-400 font-medium"><?php echo e(number_format($item['price'], 2, ',', '.')); ?> €</p>
                                </div>

                                <?php if(isset($item['in_stock']) && !$item['in_stock']): ?>
                                    <p class="text-xs text-amber-400 font-medium">Sin stock — elimina este producto para poder continuar con el pedido.</p>
                                <?php endif; ?>
                                <div class="flex flex-col sm:flex-row sm:flex-wrap items-start sm:items-center gap-3 sm:gap-4">
                                    <form method="POST" action="<?php echo e(localized_route('cart.update', $item['id'])); ?>" class="flex items-center gap-2">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <label class="text-xs text-zinc-400"><?php echo e(__('common.cart.quantity')); ?>:</label>
                                        <input
                                            type="number"
                                            name="quantity"
                                            value="<?php echo e($item['quantity']); ?>"
                                            min="1"
                                            <?php if(isset($item['max_quantity']) && $item['max_quantity'] !== null): ?> max="<?php echo e($item['max_quantity']); ?>" <?php endif; ?>
                                            class="w-16 sm:w-20 rounded-lg bg-zinc-950 border border-zinc-800 text-xs sm:text-sm text-zinc-100 text-center focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                            onchange="this.form.submit()"
                                            <?php if(isset($item['in_stock']) && !$item['in_stock']): ?> disabled <?php endif; ?>
                                        >
                                    </form>

                                    <div class="text-xs sm:text-sm">
                                        <span class="text-zinc-400"><?php echo e(__('common.cart.subtotal')); ?>: </span>
                                        <span class="text-zinc-100 font-bold text-sm sm:text-base"><?php echo e(number_format($item['subtotal'], 2, ',', '.')); ?> €</span>
                                    </div>

                                    <form method="POST" action="<?php echo e(localized_route('cart.remove', $item['id'])); ?>" class="sm:ml-auto">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-xs text-red-400 hover:text-red-300 transition-colors underline underline-offset-4">
                                            <?php echo e(__('common.cart.remove')); ?>

                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="border-t border-zinc-800 pt-6 sm:pt-8 space-y-4 sm:space-y-6 bg-zinc-900/40 rounded-2xl sm:rounded-3xl p-4 sm:p-6">
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-950 border border-zinc-800">
                        <span class="text-sm sm:text-base text-zinc-400 font-medium"><?php echo e(__('common.cart.total')); ?>:</span>
                        <span class="text-2xl sm:text-3xl font-bold text-amber-400"><?php echo e(number_format($total, 2, ',', '.')); ?> €</span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                        <a href="<?php echo e(localized_route('checkout.index')); ?>" class="flex-1">
                            <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','class' => 'w-full flex items-center justify-center gap-2 text-xs sm:text-sm']); ?>
                                <span><?php echo e(__('common.cart.checkout')); ?></span>
                                <?php if (isset($component)) { $__componentOriginal37a3f047daccd28b87517bd215a12923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37a3f047daccd28b87517bd215a12923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-right','data' => ['class' => 'w-3.5 h-3.5 sm:w-4 sm:h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3.5 h-3.5 sm:w-4 sm:h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal37a3f047daccd28b87517bd215a12923)): ?>
<?php $attributes = $__attributesOriginal37a3f047daccd28b87517bd215a12923; ?>
<?php unset($__attributesOriginal37a3f047daccd28b87517bd215a12923); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal37a3f047daccd28b87517bd215a12923)): ?>
<?php $component = $__componentOriginal37a3f047daccd28b87517bd215a12923; ?>
<?php unset($__componentOriginal37a3f047daccd28b87517bd215a12923); ?>
<?php endif; ?>
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
                        </a>

                        <form method="POST" action="<?php echo e(localized_route('cart.clear')); ?>" onsubmit="return confirm('¿Seguro que quieres vaciar el carrito?');" class="sm:w-auto w-full">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="w-full sm:w-auto text-xs tracking-[0.25em] uppercase text-zinc-400 hover:text-red-400 transition-colors underline underline-offset-4 px-4 py-2">
                                <?php echo e(__('common.cart.clear')); ?>

                            </button>
                        </form>
                    </div>

                    <a href="<?php echo e(localized_route('books.index.public')); ?>" class="flex items-center justify-center gap-2 text-xs tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-200 transition-colors group">
                        <?php if (isset($component)) { $__componentOriginal37a3f047daccd28b87517bd215a12923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37a3f047daccd28b87517bd215a12923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-right','data' => ['class' => 'w-4 h-4 rotate-180 transition-transform group-hover:-translate-x-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 rotate-180 transition-transform group-hover:-translate-x-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal37a3f047daccd28b87517bd215a12923)): ?>
<?php $attributes = $__attributesOriginal37a3f047daccd28b87517bd215a12923; ?>
<?php unset($__attributesOriginal37a3f047daccd28b87517bd215a12923); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal37a3f047daccd28b87517bd215a12923)): ?>
<?php $component = $__componentOriginal37a3f047daccd28b87517bd215a12923; ?>
<?php unset($__componentOriginal37a3f047daccd28b87517bd215a12923); ?>
<?php endif; ?>
                        <span><?php echo e(__('common.cart.continue_shopping')); ?></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/store/cart/index.blade.php ENDPATH**/ ?>