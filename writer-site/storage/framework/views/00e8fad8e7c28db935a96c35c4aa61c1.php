<?php $__env->startSection('title', 'Mi cuenta'); ?>

<?php $__env->startSection('content'); ?>
    <section 
        x-data="scrollReveal(0)"
        class="px-4 sm:px-5 md:px-8 py-10 sm:py-14 md:py-20 max-w-6xl mx-auto"
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
                    <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-4 h-4 sm:w-5 sm:h-5 text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 sm:w-5 sm:h-5 text-amber-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35)): ?>
<?php $attributes = $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35; ?>
<?php unset($__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35)): ?>
<?php $component = $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35; ?>
<?php unset($__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35); ?>
<?php endif; ?>
                    <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                        Cuenta
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl tracking-tight mb-2">
                    Mi cuenta
                </h1>
                <p class="text-xs sm:text-sm text-zinc-400">
                    Gestiona tu información personal y revisa tus pedidos
                </p>
            </div>

            <?php if(session('status')): ?>
                <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                <!-- Menú de navegación -->
                <div class="md:col-span-1">
                    <nav class="space-y-2 border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40" role="navigation" aria-label="Menú de cuenta">
                        <a href="<?php echo e(localized_route('account.index')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('account.index') ? 'bg-zinc-800 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-800 hover:text-zinc-200'); ?> transition-colors">
                            <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35)): ?>
<?php $attributes = $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35; ?>
<?php unset($__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35)): ?>
<?php $component = $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35; ?>
<?php unset($__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35); ?>
<?php endif; ?>
                            <span class="text-sm font-medium">Resumen</span>
                        </a>
                        <a href="<?php echo e(localized_route('account.profile')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('account.profile*') ? 'bg-zinc-800 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-800 hover:text-zinc-200'); ?> transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium">Mi perfil</span>
                        </a>
                        <a href="<?php echo e(localized_route('orders.index')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('orders.*') ? 'bg-zinc-800 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-800 hover:text-zinc-200'); ?> transition-colors">
                            <?php if (isset($component)) { $__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shopping-cart','data' => ['class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shopping-cart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
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
                            <span class="text-sm font-medium"><?php echo e(__('common.orders.title')); ?></span>
                            <?php if($ordersCount > 0): ?>
                                <span class="ml-auto px-2 py-0.5 text-xs font-semibold text-zinc-950 bg-amber-400 rounded-full"><?php echo e($ordersCount); ?></span>
                            <?php endif; ?>
                        </a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="pt-2 border-t border-zinc-800">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-zinc-400 hover:bg-zinc-800 hover:text-red-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="text-sm font-medium">Cerrar sesión</span>
                            </button>
                        </form>
                    </nav>
                </div>

                <!-- Contenido principal -->
                <div class="md:col-span-2 space-y-4 sm:space-y-6">
                    <!-- Información del usuario -->
                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <h2 class="text-base sm:text-lg font-semibold mb-4 text-zinc-100">Información personal</h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-zinc-400 mb-1">Nombre completo</p>
                                <p class="text-sm sm:text-base text-zinc-100"><?php echo e($user->name); ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-zinc-400 mb-1">Correo electrónico</p>
                                <p class="text-sm sm:text-base text-zinc-100 break-all"><?php echo e($user->email); ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-zinc-400 mb-1">Teléfono</p>
                                <p class="text-sm sm:text-base text-zinc-100"><?php echo e($user->phone ?? 'No especificado'); ?></p>
                            </div>
                            <a href="<?php echo e(localized_route('account.profile')); ?>" class="inline-flex items-center gap-2 text-xs sm:text-sm text-amber-400 hover:text-amber-300 transition-colors mt-4">
                                <span>Editar perfil</span>
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
                            </a>
                        </div>
                    </div>

                    <!-- Dirección de envío -->
                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <h2 class="text-base sm:text-lg font-semibold mb-4 text-zinc-100">Dirección de envío</h2>
                        <div class="space-y-2">
                            <p class="text-sm sm:text-base text-zinc-100"><?php echo e($user->address ?? 'No especificada'); ?></p>
                            <p class="text-sm sm:text-base text-zinc-100">
                                <?php echo e($user->postal_code ?? ''); ?> <?php echo e($user->city ?? ''); ?>

                            </p>
                            <p class="text-sm sm:text-base text-zinc-100">
                                <?php echo e($user->province ?? ''); ?><?php echo e($user->province && $user->country ? ', ' : ''); ?><?php echo e($user->country ?? ''); ?>

                            </p>
                            <a href="<?php echo e(localized_route('account.profile')); ?>" class="inline-flex items-center gap-2 text-xs sm:text-sm text-amber-400 hover:text-amber-300 transition-colors mt-4">
                                <span>Editar dirección</span>
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
                            </a>
                        </div>
                    </div>

                    <!-- Pedidos recientes -->
                    <?php if($recentOrders->isNotEmpty()): ?>
                        <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-base sm:text-lg font-semibold text-zinc-100"><?php echo e(__('common.orders.recent_orders')); ?></h2>
                                <a href="<?php echo e(localized_route('orders.index')); ?>" class="text-xs sm:text-sm text-amber-400 hover:text-amber-300 transition-colors">
                                    <?php echo e(__('common.orders.view_all')); ?>

                                </a>
                            </div>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(localized_route('orders.show', $order)); ?>" class="block p-3 rounded-lg border border-zinc-800 hover:border-zinc-700 hover:bg-zinc-900/60 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-xs sm:text-sm font-medium text-zinc-100"><?php echo e($order->order_number); ?></p>
                                                <p class="text-xs text-zinc-400 mt-1"><?php echo e($order->created_at->format('d/m/Y')); ?></p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs sm:text-sm font-semibold text-amber-400"><?php echo e(number_format($order->total, 2, ',', '.')); ?> €</p>
                                                <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-medium
                                                    <?php if($order->status === 'paid'): ?> bg-emerald-900/40 text-emerald-300 border border-emerald-800/50
                                                    <?php elseif($order->status === 'processing'): ?> bg-blue-900/40 text-blue-300 border border-blue-800/50
                                                    <?php elseif($order->status === 'shipped'): ?> bg-purple-900/40 text-purple-300 border border-purple-800/50
                                                    <?php elseif($order->status === 'delivered'): ?> bg-zinc-900/40 text-zinc-300 border border-zinc-800/50
                                                    <?php elseif($order->status === 'cancelled'): ?> bg-red-900/40 text-red-300 border border-red-800/50
                                                    <?php else: ?> bg-amber-900/40 text-amber-300 border border-amber-800/50
                                                    <?php endif; ?>
                                                ">
                                                    <?php if($order->status === 'pending'): ?> <?php echo e(__('common.orders.status_pending')); ?>

                                                    <?php elseif($order->status === 'paid'): ?> <?php echo e(__('common.orders.status_paid')); ?>

                                                    <?php elseif($order->status === 'processing'): ?> <?php echo e(__('common.orders.status_processing')); ?>

                                                    <?php elseif($order->status === 'shipped'): ?> <?php echo e(__('common.orders.status_shipped')); ?>

                                                    <?php elseif($order->status === 'delivered'): ?> <?php echo e(__('common.orders.status_delivered')); ?>

                                                    <?php elseif($order->status === 'cancelled'): ?> <?php echo e(__('common.orders.status_cancelled')); ?>

                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40 text-center">
                            <p class="text-sm text-zinc-400 mb-4"><?php echo e(__('common.orders.no_orders')); ?></p>
                            <a href="<?php echo e(localized_route('books.index.public')); ?>" class="inline-flex items-center gap-2 text-xs sm:text-sm text-amber-400 hover:text-amber-300 transition-colors">
                                <span><?php echo e(__('common.orders.explore_books')); ?></span>
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
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/account/dashboard.blade.php ENDPATH**/ ?>