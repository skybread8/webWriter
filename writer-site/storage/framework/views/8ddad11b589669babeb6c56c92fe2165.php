<?php
    $settings = \App\Models\SiteSetting::first();
?>

<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        
        <!-- Favicon - Icono de libro -->
        <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">
        <link rel="apple-touch-icon" href="<?php echo e(asset('favicon.svg')); ?>">

        <?php
            $pageTitle = $settings?->site_name ?? 'Kevin Pérez Alarcón';
            if (View::hasSection('title')) {
                $pageTitle .= ' – ' . View::yieldContent('title');
            }
            $pageDescription = View::hasSection('description') 
                ? View::yieldContent('description') 
                : 'Escritor independiente. Más de 5.000 libros vendidos en las calles. Novelas de misterio, terror, romance y drama.';
        ?>

        <?php if (! empty(trim($__env->yieldContent('seo')))): ?>
            <?php echo $__env->yieldContent('seo'); ?>
        <?php else: ?>
            <?php if (isset($component)) { $__componentOriginal84f9df3f620371229981225e7ba608d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal84f9df3f620371229981225e7ba608d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seo-meta','data' => ['title' => $pageTitle,'description' => $pageDescription,'image' => $settings?->hero_image ? get_image_url($settings->hero_image) : null,'imageAlt' => $settings?->hero_image_alt]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo-meta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageTitle),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageDescription),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($settings?->hero_image ? get_image_url($settings->hero_image) : null),'image_alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($settings?->hero_image_alt)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal84f9df3f620371229981225e7ba608d7)): ?>
<?php $attributes = $__attributesOriginal84f9df3f620371229981225e7ba608d7; ?>
<?php unset($__attributesOriginal84f9df3f620371229981225e7ba608d7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal84f9df3f620371229981225e7ba608d7)): ?>
<?php $component = $__componentOriginal84f9df3f620371229981225e7ba608d7; ?>
<?php unset($__componentOriginal84f9df3f620371229981225e7ba608d7); ?>
<?php endif; ?>
        <?php endif; ?>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600|dm-serif-display:400&display=swap" rel="stylesheet" />
        
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased font-['DM_Sans']" x-data="{ mobileMenuOpen: false }">
        <div class="min-h-screen flex flex-col">
            <header class="px-4 sm:px-5 md:px-8 py-4 sm:py-5 border-b border-zinc-800/80 flex items-center justify-between gap-4 sticky top-0 bg-zinc-950/80 backdrop-blur z-20" role="banner">
                <a href="<?php echo e(localized_route('home')); ?>" class="group flex-shrink-0" aria-label="Ir a la página de inicio">
                    <div class="flex items-baseline gap-2 sm:gap-3">
                        <h1 class="font-['DM_Serif_Display'] text-lg sm:text-xl md:text-2xl tracking-tight group-hover:text-zinc-50 transition-colors">
                            <?php echo e($settings?->site_name ?? 'Kevin Pérez Alarcón'); ?>

                        </h1>
                    </div>
                </a>

                <!-- Menú móvil -->
                <div class="lg:hidden flex items-center gap-3">
                    <?php
                        $cartCount = count(session()->get('cart', []));
                    ?>
                    <a href="<?php echo e(localized_route('cart.index')); ?>" class="relative flex items-center text-zinc-400 hover:text-zinc-200 transition-colors" aria-label="Carrito de compra<?php echo e($cartCount > 0 ? ' (' . $cartCount . ' ' . ($cartCount === 1 ? 'artículo' : 'artículos') . ')' : ''); ?>">
                        <?php if (isset($component)) { $__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shopping-cart','data' => ['class' => 'w-5 h-5','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shopping-cart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5','aria-hidden' => 'true']); ?>
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
                        <?php if($cartCount > 0): ?>
                            <span class="absolute -top-1.5 -right-1.5 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1.5 text-[9px] font-semibold text-zinc-950 bg-amber-400 rounded-full" aria-label="<?php echo e($cartCount); ?> <?php echo e($cartCount === 1 ? 'artículo' : 'artículos'); ?> en el carrito">
                                <?php echo e($cartCount); ?>

                            </span>
                        <?php endif; ?>
                    </a>
                    <?php if(auth()->guard()->check()): ?>
                        <div class="relative" x-data="{ open: false }">
                            <button
                                @click="open = !open"
                                class="flex items-center text-zinc-400 hover:text-zinc-200 transition-colors"
                                aria-label="Mi cuenta"
                                aria-expanded="false"
                                :aria-expanded="open"
                            >
                                <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-5 h-5','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5','aria-hidden' => 'true']); ?>
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
                            </button>

                            <div
                                x-show="open"
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-zinc-900 border border-zinc-800 rounded-lg shadow-lg z-50"
                                role="menu"
                                aria-label="Menú de cuenta"
                                style="display: none;"
                            >
                                <a
                                    href="<?php echo e(localized_route('account.index')); ?>"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors <?php echo e(request()->routeIs('account.index') ? 'bg-zinc-800 text-zinc-100' : ''); ?>"
                                    role="menuitem"
                                    @click="open = false"
                                >
                                    <?php if (isset($component)) { $__componentOriginal4710407deeab122b4cc56ae776da2d23 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4710407deeab122b4cc56ae776da2d23 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.home','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.home'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4710407deeab122b4cc56ae776da2d23)): ?>
<?php $attributes = $__attributesOriginal4710407deeab122b4cc56ae776da2d23; ?>
<?php unset($__attributesOriginal4710407deeab122b4cc56ae776da2d23); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4710407deeab122b4cc56ae776da2d23)): ?>
<?php $component = $__componentOriginal4710407deeab122b4cc56ae776da2d23; ?>
<?php unset($__componentOriginal4710407deeab122b4cc56ae776da2d23); ?>
<?php endif; ?>
                                    <span class="text-[11px] uppercase tracking-[0.25em]"><?php echo e(__('common.account.dashboard')); ?></span>
                                </a>
                                <a
                                    href="<?php echo e(localized_route('account.profile')); ?>"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors <?php echo e(request()->routeIs('account.profile') ? 'bg-zinc-800 text-zinc-100' : ''); ?>"
                                    role="menuitem"
                                    @click="open = false"
                                >
                                    <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
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
                                    <span class="text-[11px] uppercase tracking-[0.25em]"><?php echo e(__('common.account.my_profile')); ?></span>
                                </a>
                                <a
                                    href="<?php echo e(localized_route('orders.index')); ?>"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors <?php echo e(request()->routeIs('orders.*') ? 'bg-zinc-800 text-zinc-100' : ''); ?>"
                                    role="menuitem"
                                    @click="open = false"
                                >
                                    <?php if (isset($component)) { $__componentOriginal322e1f710791f2d7b89990e0d5387343 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal322e1f710791f2d7b89990e0d5387343 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shopping-bag','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shopping-bag'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal322e1f710791f2d7b89990e0d5387343)): ?>
<?php $attributes = $__attributesOriginal322e1f710791f2d7b89990e0d5387343; ?>
<?php unset($__attributesOriginal322e1f710791f2d7b89990e0d5387343); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal322e1f710791f2d7b89990e0d5387343)): ?>
<?php $component = $__componentOriginal322e1f710791f2d7b89990e0d5387343; ?>
<?php unset($__componentOriginal322e1f710791f2d7b89990e0d5387343); ?>
<?php endif; ?>
                                    <span class="text-[11px] uppercase tracking-[0.25em]"><?php echo e(__('common.account.my_orders')); ?></span>
                                </a>
                                <div class="border-t border-zinc-800"></div>
                                <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button
                                        type="submit"
                                        class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors w-full text-left"
                                        role="menuitem"
                                        @click="open = false"
                                    >
                                        <?php if (isset($component)) { $__componentOriginal88de01fd0a2dfb43f9ff296f6277e232 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.logout','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.logout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232)): ?>
<?php $attributes = $__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232; ?>
<?php unset($__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88de01fd0a2dfb43f9ff296f6277e232)): ?>
<?php $component = $__componentOriginal88de01fd0a2dfb43f9ff296f6277e232; ?>
<?php unset($__componentOriginal88de01fd0a2dfb43f9ff296f6277e232); ?>
<?php endif; ?>
                                        <span class="text-[11px] uppercase tracking-[0.25em]"><?php echo e(__('common.nav.logout')); ?></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="flex items-center text-zinc-400 hover:text-zinc-200 transition-colors" aria-label="Iniciar sesión">
                            <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-5 h-5','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5','aria-hidden' => 'true']); ?>
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
                        </a>
                    <?php endif; ?>
                    <button 
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="flex items-center justify-center w-10 h-10 text-zinc-400 hover:text-zinc-200 transition-colors"
                        aria-label="Abrir menú"
                        aria-expanded="false"
                        :aria-expanded="mobileMenuOpen"
                    >
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Menú desktop -->
                <nav class="hidden lg:flex items-center gap-3 xl:gap-4 text-[11px] uppercase tracking-[0.25em] text-zinc-400" role="navigation" aria-label="Navegación principal">
                    <a href="<?php echo e(localized_route('books.index.public')); ?>" class="flex items-center gap-1.5 <?php echo e(request()->routeIs('books.*') ? 'text-zinc-100' : 'hover:text-zinc-200'); ?> transition-colors" aria-label="Ver todos los libros">
                        <?php if (isset($component)) { $__componentOriginal285eddc9278dae58281aa961bf08a625 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal285eddc9278dae58281aa961bf08a625 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.book','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
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
                        <span><?php echo e(__('common.nav.books')); ?></span>
                    </a>
                    <a href="<?php echo e(localized_route('about')); ?>" class="flex items-center gap-1.5 <?php echo e(request()->routeIs('about') ? 'text-zinc-100' : 'hover:text-zinc-200'); ?> transition-colors" aria-label="Sobre el autor">
                        <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
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
                        <span><?php echo e(__('common.nav.about')); ?></span>
                    </a>
                    <a href="<?php echo e(localized_route('photos.readers')); ?>" class="flex items-center gap-1.5 <?php echo e(request()->routeIs('photos.readers') ? 'text-zinc-100' : 'hover:text-zinc-200'); ?> transition-colors" aria-label="Fotos con lectores">
                        <?php if (isset($component)) { $__componentOriginal1a3a288e8e56eced3e867d93889b9079 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a3a288e8e56eced3e867d93889b9079 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.camera','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.camera'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a3a288e8e56eced3e867d93889b9079)): ?>
<?php $attributes = $__attributesOriginal1a3a288e8e56eced3e867d93889b9079; ?>
<?php unset($__attributesOriginal1a3a288e8e56eced3e867d93889b9079); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a3a288e8e56eced3e867d93889b9079)): ?>
<?php $component = $__componentOriginal1a3a288e8e56eced3e867d93889b9079; ?>
<?php unset($__componentOriginal1a3a288e8e56eced3e867d93889b9079); ?>
<?php endif; ?>
                        <span><?php echo e(__('common.nav.photos_readers')); ?></span>
                    </a>
                    <a href="<?php echo e(localized_route('offers')); ?>" class="flex items-center gap-1.5 <?php echo e(request()->routeIs('offers') ? 'text-zinc-100' : 'hover:text-zinc-200'); ?> transition-colors" aria-label="Ofertas y packs">
                        <?php if (isset($component)) { $__componentOriginala05e44402895b3da4676553f4367d765 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala05e44402895b3da4676553f4367d765 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.gift','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.gift'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala05e44402895b3da4676553f4367d765)): ?>
<?php $attributes = $__attributesOriginala05e44402895b3da4676553f4367d765; ?>
<?php unset($__attributesOriginala05e44402895b3da4676553f4367d765); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala05e44402895b3da4676553f4367d765)): ?>
<?php $component = $__componentOriginala05e44402895b3da4676553f4367d765; ?>
<?php unset($__componentOriginala05e44402895b3da4676553f4367d765); ?>
<?php endif; ?>
                        <span><?php echo e(__('common.nav.offers')); ?></span>
                    </a>
                    <a href="<?php echo e(localized_route('blog')); ?>" class="flex items-center gap-1.5 <?php echo e(request()->routeIs('blog') ? 'text-zinc-100' : 'hover:text-zinc-200'); ?> transition-colors" aria-label="Blog">
                        <?php if (isset($component)) { $__componentOriginal92483fb63b4a1a364b758601317175c6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal92483fb63b4a1a364b758601317175c6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.document-text','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.document-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal92483fb63b4a1a364b758601317175c6)): ?>
<?php $attributes = $__attributesOriginal92483fb63b4a1a364b758601317175c6; ?>
<?php unset($__attributesOriginal92483fb63b4a1a364b758601317175c6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal92483fb63b4a1a364b758601317175c6)): ?>
<?php $component = $__componentOriginal92483fb63b4a1a364b758601317175c6; ?>
<?php unset($__componentOriginal92483fb63b4a1a364b758601317175c6); ?>
<?php endif; ?>
                        <span><?php echo e(__('common.nav.blog')); ?></span>
                    </a>
                    <a href="<?php echo e(localized_route('contact')); ?>" class="flex items-center gap-1.5 <?php echo e(request()->routeIs('contact') ? 'text-zinc-100' : 'hover:text-zinc-200'); ?> transition-colors" aria-label="Contacto">
                        <?php if (isset($component)) { $__componentOriginalce4e5b3a3927cd89cc73a7e1ee3516ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce4e5b3a3927cd89cc73a7e1ee3516ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.envelope','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.envelope'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce4e5b3a3927cd89cc73a7e1ee3516ee)): ?>
<?php $attributes = $__attributesOriginalce4e5b3a3927cd89cc73a7e1ee3516ee; ?>
<?php unset($__attributesOriginalce4e5b3a3927cd89cc73a7e1ee3516ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce4e5b3a3927cd89cc73a7e1ee3516ee)): ?>
<?php $component = $__componentOriginalce4e5b3a3927cd89cc73a7e1ee3516ee; ?>
<?php unset($__componentOriginalce4e5b3a3927cd89cc73a7e1ee3516ee); ?>
<?php endif; ?>
                        <span><?php echo e(__('common.nav.contact')); ?></span>
                    </a>
                    <?php
                        $cartCount = count(session()->get('cart', []));
                    ?>
                    <a href="<?php echo e(localized_route('cart.index')); ?>" class="relative flex items-center gap-1.5 <?php echo e(request()->routeIs('cart.*') ? 'text-zinc-100' : 'hover:text-zinc-200'); ?> transition-colors" aria-label="Carrito de compra<?php echo e($cartCount > 0 ? ' (' . $cartCount . ' ' . ($cartCount === 1 ? 'artículo' : 'artículos') . ')' : ''); ?>">
                        <?php if (isset($component)) { $__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shopping-cart','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shopping-cart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
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
                        <span><?php echo e(__('common.nav.cart')); ?></span>
                        <?php if($cartCount > 0): ?>
                            <span class="absolute -top-1.5 -right-1.5 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1.5 text-[9px] font-semibold text-zinc-950 bg-amber-400 rounded-full" aria-label="<?php echo e($cartCount); ?> <?php echo e($cartCount === 1 ? 'artículo' : 'artículos'); ?> en el carrito">
                                <?php echo e($cartCount); ?>

                            </span>
                        <?php endif; ?>
                    </a>
                    <?php if(auth()->guard()->check()): ?>
                        <div class="relative" x-data="{ open: false }">
                            <button
                                @click="open = !open"
                                class="flex items-center gap-1.5 <?php echo e(request()->routeIs('account.*') || request()->routeIs('orders.*') ? 'text-zinc-100' : 'hover:text-zinc-200'); ?> transition-colors"
                                aria-label="Mi cuenta"
                                aria-expanded="false"
                                :aria-expanded="open"
                            >
                                <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
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
                                <span class="hidden sm:inline text-[11px] uppercase tracking-[0.25em]"><?php echo e(__('common.nav.account')); ?></span>
                                <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div
                                x-show="open"
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-zinc-900 border border-zinc-800 rounded-lg shadow-lg z-50"
                                role="menu"
                                aria-label="Menú de cuenta"
                                style="display: none;"
                            >
                                <a
                                    href="<?php echo e(localized_route('account.index')); ?>"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors <?php echo e(request()->routeIs('account.index') ? 'bg-zinc-800 text-zinc-100' : ''); ?>"
                                    role="menuitem"
                                    @click="open = false"
                                >
                                    <?php if (isset($component)) { $__componentOriginal4710407deeab122b4cc56ae776da2d23 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4710407deeab122b4cc56ae776da2d23 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.home','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.home'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4710407deeab122b4cc56ae776da2d23)): ?>
<?php $attributes = $__attributesOriginal4710407deeab122b4cc56ae776da2d23; ?>
<?php unset($__attributesOriginal4710407deeab122b4cc56ae776da2d23); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4710407deeab122b4cc56ae776da2d23)): ?>
<?php $component = $__componentOriginal4710407deeab122b4cc56ae776da2d23; ?>
<?php unset($__componentOriginal4710407deeab122b4cc56ae776da2d23); ?>
<?php endif; ?>
                                    <span class="text-[11px] uppercase tracking-[0.25em]"><?php echo e(__('common.account.dashboard')); ?></span>
                                </a>
                                <a
                                    href="<?php echo e(localized_route('account.profile')); ?>"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors <?php echo e(request()->routeIs('account.profile') ? 'bg-zinc-800 text-zinc-100' : ''); ?>"
                                    role="menuitem"
                                    @click="open = false"
                                >
                                    <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
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
                                    <span class="text-[11px] uppercase tracking-[0.25em]"><?php echo e(__('common.account.my_profile')); ?></span>
                                </a>
                                <a
                                    href="<?php echo e(localized_route('orders.index')); ?>"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors <?php echo e(request()->routeIs('orders.*') ? 'bg-zinc-800 text-zinc-100' : ''); ?>"
                                    role="menuitem"
                                    @click="open = false"
                                >
                                    <?php if (isset($component)) { $__componentOriginal322e1f710791f2d7b89990e0d5387343 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal322e1f710791f2d7b89990e0d5387343 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shopping-bag','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shopping-bag'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal322e1f710791f2d7b89990e0d5387343)): ?>
<?php $attributes = $__attributesOriginal322e1f710791f2d7b89990e0d5387343; ?>
<?php unset($__attributesOriginal322e1f710791f2d7b89990e0d5387343); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal322e1f710791f2d7b89990e0d5387343)): ?>
<?php $component = $__componentOriginal322e1f710791f2d7b89990e0d5387343; ?>
<?php unset($__componentOriginal322e1f710791f2d7b89990e0d5387343); ?>
<?php endif; ?>
                                    <span class="text-[11px] uppercase tracking-[0.25em]"><?php echo e(__('common.account.my_orders')); ?></span>
                                </a>
                                <div class="border-t border-zinc-800"></div>
                                <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button
                                        type="submit"
                                        class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors w-full text-left"
                                        role="menuitem"
                                        @click="open = false"
                                    >
                                        <?php if (isset($component)) { $__componentOriginal88de01fd0a2dfb43f9ff296f6277e232 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.logout','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.logout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232)): ?>
<?php $attributes = $__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232; ?>
<?php unset($__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88de01fd0a2dfb43f9ff296f6277e232)): ?>
<?php $component = $__componentOriginal88de01fd0a2dfb43f9ff296f6277e232; ?>
<?php unset($__componentOriginal88de01fd0a2dfb43f9ff296f6277e232); ?>
<?php endif; ?>
                                        <span class="text-[11px] uppercase tracking-[0.25em]"><?php echo e(__('common.nav.logout')); ?></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="flex items-center gap-1.5 hover:text-zinc-200 transition-colors" aria-label="Iniciar sesión">
                            <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
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
                            <span class="hidden sm:inline text-[11px] uppercase tracking-[0.25em]"><?php echo e(__('common.nav.login')); ?></span>
                        </a>
                    <?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal8d3bff7d7383a45350f7495fc470d934 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8d3bff7d7383a45350f7495fc470d934 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.language-switcher','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('language-switcher'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8d3bff7d7383a45350f7495fc470d934)): ?>
<?php $attributes = $__attributesOriginal8d3bff7d7383a45350f7495fc470d934; ?>
<?php unset($__attributesOriginal8d3bff7d7383a45350f7495fc470d934); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8d3bff7d7383a45350f7495fc470d934)): ?>
<?php $component = $__componentOriginal8d3bff7d7383a45350f7495fc470d934; ?>
<?php unset($__componentOriginal8d3bff7d7383a45350f7495fc470d934); ?>
<?php endif; ?>
                </nav>

                <!-- Menú móvil desplegable -->
                <nav 
                    x-show="mobileMenuOpen"
                    @click.away="mobileMenuOpen = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="lg:hidden absolute top-full left-0 right-0 bg-zinc-950 border-b border-zinc-800/80 shadow-xl z-10"
                    style="display: none;"
                    role="navigation"
                    aria-label="Navegación móvil"
                >
                    <div class="px-4 py-4 space-y-1">
                        <a href="<?php echo e(localized_route('books.index.public')); ?>" class="flex items-center gap-2 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('books.*') ? 'bg-zinc-900 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-900 hover:text-zinc-200'); ?> transition-colors">
                            <?php if (isset($component)) { $__componentOriginal285eddc9278dae58281aa961bf08a625 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal285eddc9278dae58281aa961bf08a625 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.book','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
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
                            <span class="text-sm"><?php echo e(__('common.nav.books')); ?></span>
                        </a>
                        <a href="<?php echo e(localized_route('about')); ?>" class="flex items-center gap-2 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('about') ? 'bg-zinc-900 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-900 hover:text-zinc-200'); ?> transition-colors">
                            <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
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
                            <span class="text-sm"><?php echo e(__('common.nav.about')); ?></span>
                        </a>
                        <a href="<?php echo e(localized_route('photos.readers')); ?>" class="flex items-center gap-2 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('photos.readers') ? 'bg-zinc-900 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-900 hover:text-zinc-200'); ?> transition-colors">
                            <?php if (isset($component)) { $__componentOriginal1a3a288e8e56eced3e867d93889b9079 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a3a288e8e56eced3e867d93889b9079 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.camera','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.camera'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a3a288e8e56eced3e867d93889b9079)): ?>
<?php $attributes = $__attributesOriginal1a3a288e8e56eced3e867d93889b9079; ?>
<?php unset($__attributesOriginal1a3a288e8e56eced3e867d93889b9079); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a3a288e8e56eced3e867d93889b9079)): ?>
<?php $component = $__componentOriginal1a3a288e8e56eced3e867d93889b9079; ?>
<?php unset($__componentOriginal1a3a288e8e56eced3e867d93889b9079); ?>
<?php endif; ?>
                            <span class="text-sm"><?php echo e(__('common.nav.photos_readers')); ?></span>
                        </a>
                        <a href="<?php echo e(localized_route('offers')); ?>" class="flex items-center gap-2 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('offers') ? 'bg-zinc-900 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-900 hover:text-zinc-200'); ?> transition-colors">
                            <?php if (isset($component)) { $__componentOriginala05e44402895b3da4676553f4367d765 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala05e44402895b3da4676553f4367d765 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.gift','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.gift'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala05e44402895b3da4676553f4367d765)): ?>
<?php $attributes = $__attributesOriginala05e44402895b3da4676553f4367d765; ?>
<?php unset($__attributesOriginala05e44402895b3da4676553f4367d765); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala05e44402895b3da4676553f4367d765)): ?>
<?php $component = $__componentOriginala05e44402895b3da4676553f4367d765; ?>
<?php unset($__componentOriginala05e44402895b3da4676553f4367d765); ?>
<?php endif; ?>
                            <span class="text-sm"><?php echo e(__('common.nav.offers')); ?></span>
                        </a>
                        <a href="<?php echo e(localized_route('blog')); ?>" class="flex items-center gap-2 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('blog') ? 'bg-zinc-900 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-900 hover:text-zinc-200'); ?> transition-colors">
                            <?php if (isset($component)) { $__componentOriginal92483fb63b4a1a364b758601317175c6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal92483fb63b4a1a364b758601317175c6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.document-text','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.document-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal92483fb63b4a1a364b758601317175c6)): ?>
<?php $attributes = $__attributesOriginal92483fb63b4a1a364b758601317175c6; ?>
<?php unset($__attributesOriginal92483fb63b4a1a364b758601317175c6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal92483fb63b4a1a364b758601317175c6)): ?>
<?php $component = $__componentOriginal92483fb63b4a1a364b758601317175c6; ?>
<?php unset($__componentOriginal92483fb63b4a1a364b758601317175c6); ?>
<?php endif; ?>
                            <span class="text-sm"><?php echo e(__('common.nav.blog')); ?></span>
                        </a>
                        <a href="<?php echo e(localized_route('contact')); ?>" class="flex items-center gap-2 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('contact') ? 'bg-zinc-900 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-900 hover:text-zinc-200'); ?> transition-colors">
                            <?php if (isset($component)) { $__componentOriginalce4e5b3a3927cd89cc73a7e1ee3516ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce4e5b3a3927cd89cc73a7e1ee3516ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.envelope','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.envelope'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce4e5b3a3927cd89cc73a7e1ee3516ee)): ?>
<?php $attributes = $__attributesOriginalce4e5b3a3927cd89cc73a7e1ee3516ee; ?>
<?php unset($__attributesOriginalce4e5b3a3927cd89cc73a7e1ee3516ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce4e5b3a3927cd89cc73a7e1ee3516ee)): ?>
<?php $component = $__componentOriginalce4e5b3a3927cd89cc73a7e1ee3516ee; ?>
<?php unset($__componentOriginalce4e5b3a3927cd89cc73a7e1ee3516ee); ?>
<?php endif; ?>
                            <span class="text-sm"><?php echo e(__('common.nav.contact')); ?></span>
                        </a>
                        <div class="pt-2 border-t border-zinc-800 mt-2">
                            <div class="px-4 py-2">
                                <?php if (isset($component)) { $__componentOriginal8d3bff7d7383a45350f7495fc470d934 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8d3bff7d7383a45350f7495fc470d934 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.language-switcher','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('language-switcher'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8d3bff7d7383a45350f7495fc470d934)): ?>
<?php $attributes = $__attributesOriginal8d3bff7d7383a45350f7495fc470d934; ?>
<?php unset($__attributesOriginal8d3bff7d7383a45350f7495fc470d934); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8d3bff7d7383a45350f7495fc470d934)): ?>
<?php $component = $__componentOriginal8d3bff7d7383a45350f7495fc470d934; ?>
<?php unset($__componentOriginal8d3bff7d7383a45350f7495fc470d934); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <main class="flex-1" role="main">
                <?php echo $__env->yieldContent('content'); ?>
            </main>

            <footer class="border-t border-zinc-900/80 px-4 sm:px-5 md:px-8 py-6 sm:py-8 text-[10px] sm:text-[11px] text-zinc-500" role="contentinfo">
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-4 sm:mb-6">
                        <div>
                            <h2 class="text-zinc-300 font-semibold mb-3 uppercase tracking-wider"><?php echo e(__('common.footer.navigation')); ?></h2>
                            <ul class="space-y-2" role="list">
                                <li><a href="<?php echo e(localized_route('books.index.public')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.nav.books')); ?></a></li>
                                <li><a href="<?php echo e(localized_route('about')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.nav.about')); ?></a></li>
                                <li><a href="<?php echo e(localized_route('photos.readers')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.nav.photos_readers')); ?></a></li>
                                <li><a href="<?php echo e(localized_route('offers')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.nav.offers')); ?></a></li>
                                <li><a href="<?php echo e(localized_route('blog')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.nav.blog')); ?></a></li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="text-zinc-300 font-semibold mb-3 uppercase tracking-wider"><?php echo e(__('common.footer.information')); ?></h2>
                            <ul class="space-y-2" role="list">
                                <li><a href="<?php echo e(localized_route('faq')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.nav.faq')); ?></a></li>
                                <li><a href="<?php echo e(localized_route('contact')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.nav.contact')); ?></a></li>
                                <li><a href="<?php echo e(localized_route('photos.readers')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.nav.photos_readers')); ?></a></li>
                                <li><a href="<?php echo e(localized_route('photos.books')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.nav.photos_books')); ?></a></li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="text-zinc-300 font-semibold mb-3 uppercase tracking-wider"><?php echo e(__('common.footer.social_media')); ?></h2>
                            <ul class="space-y-2" role="list">
                                <?php if($settings?->instagram_url): ?>
                                    <li><a href="<?php echo e($settings->instagram_url); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="<?php echo e(__('common.social.instagram')); ?>">
                                        <?php if (isset($component)) { $__componentOriginal1ea42232d0b13214e79b5e861644d3ac = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ea42232d0b13214e79b5e861644d3ac = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.instagram','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.instagram'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1ea42232d0b13214e79b5e861644d3ac)): ?>
<?php $attributes = $__attributesOriginal1ea42232d0b13214e79b5e861644d3ac; ?>
<?php unset($__attributesOriginal1ea42232d0b13214e79b5e861644d3ac); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1ea42232d0b13214e79b5e861644d3ac)): ?>
<?php $component = $__componentOriginal1ea42232d0b13214e79b5e861644d3ac; ?>
<?php unset($__componentOriginal1ea42232d0b13214e79b5e861644d3ac); ?>
<?php endif; ?>
                                        <span>Instagram</span>
                                    </a></li>
                                <?php endif; ?>
                                <?php if($settings?->facebook_url): ?>
                                    <li><a href="<?php echo e($settings->facebook_url); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="<?php echo e(__('common.social.facebook')); ?>">
                                        <?php if (isset($component)) { $__componentOriginal1c905e780cce2dce10f915dce1e1ac5b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c905e780cce2dce10f915dce1e1ac5b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.facebook','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.facebook'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c905e780cce2dce10f915dce1e1ac5b)): ?>
<?php $attributes = $__attributesOriginal1c905e780cce2dce10f915dce1e1ac5b; ?>
<?php unset($__attributesOriginal1c905e780cce2dce10f915dce1e1ac5b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c905e780cce2dce10f915dce1e1ac5b)): ?>
<?php $component = $__componentOriginal1c905e780cce2dce10f915dce1e1ac5b; ?>
<?php unset($__componentOriginal1c905e780cce2dce10f915dce1e1ac5b); ?>
<?php endif; ?>
                                        <span>Facebook</span>
                                    </a></li>
                                <?php endif; ?>
                                <?php if($settings?->tiktok_url): ?>
                                    <li><a href="<?php echo e($settings->tiktok_url); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="<?php echo e(__('common.social.tiktok')); ?>">
                                        <?php if (isset($component)) { $__componentOriginal55fb16c72e18dadef3b8ad39feae4ebd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal55fb16c72e18dadef3b8ad39feae4ebd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.tiktok','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.tiktok'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal55fb16c72e18dadef3b8ad39feae4ebd)): ?>
<?php $attributes = $__attributesOriginal55fb16c72e18dadef3b8ad39feae4ebd; ?>
<?php unset($__attributesOriginal55fb16c72e18dadef3b8ad39feae4ebd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal55fb16c72e18dadef3b8ad39feae4ebd)): ?>
<?php $component = $__componentOriginal55fb16c72e18dadef3b8ad39feae4ebd; ?>
<?php unset($__componentOriginal55fb16c72e18dadef3b8ad39feae4ebd); ?>
<?php endif; ?>
                                        <span>TikTok</span>
                                    </a></li>
                                <?php endif; ?>
                                <?php if($settings?->twitter_url): ?>
                                    <li><a href="<?php echo e($settings->twitter_url); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="<?php echo e(__('common.social.twitter')); ?>">
                                        <?php if (isset($component)) { $__componentOriginala14b67a17cec523d3bc8f40208ee0ef9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala14b67a17cec523d3bc8f40208ee0ef9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.twitter','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.twitter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala14b67a17cec523d3bc8f40208ee0ef9)): ?>
<?php $attributes = $__attributesOriginala14b67a17cec523d3bc8f40208ee0ef9; ?>
<?php unset($__attributesOriginala14b67a17cec523d3bc8f40208ee0ef9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala14b67a17cec523d3bc8f40208ee0ef9)): ?>
<?php $component = $__componentOriginala14b67a17cec523d3bc8f40208ee0ef9; ?>
<?php unset($__componentOriginala14b67a17cec523d3bc8f40208ee0ef9); ?>
<?php endif; ?>
                                        <span>Twitter/X</span>
                                    </a></li>
                                <?php endif; ?>
                                <?php if($settings?->youtube_url): ?>
                                    <li><a href="<?php echo e($settings->youtube_url); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="<?php echo e(__('common.social.youtube')); ?>">
                                        <?php if (isset($component)) { $__componentOriginal4264b316fb7dd2921d622fbdacbeb877 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4264b316fb7dd2921d622fbdacbeb877 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.youtube','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.youtube'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4264b316fb7dd2921d622fbdacbeb877)): ?>
<?php $attributes = $__attributesOriginal4264b316fb7dd2921d622fbdacbeb877; ?>
<?php unset($__attributesOriginal4264b316fb7dd2921d622fbdacbeb877); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4264b316fb7dd2921d622fbdacbeb877)): ?>
<?php $component = $__componentOriginal4264b316fb7dd2921d622fbdacbeb877; ?>
<?php unset($__componentOriginal4264b316fb7dd2921d622fbdacbeb877); ?>
<?php endif; ?>
                                        <span>YouTube</span>
                                    </a></li>
                                <?php endif; ?>
                                <?php if($settings?->linkedin_url): ?>
                                    <li><a href="<?php echo e($settings->linkedin_url); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="<?php echo e(__('common.social.linkedin')); ?>">
                                        <?php if (isset($component)) { $__componentOriginalf887a8bd15c5a211b880c96f0e212bc5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf887a8bd15c5a211b880c96f0e212bc5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.linkedin','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.linkedin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf887a8bd15c5a211b880c96f0e212bc5)): ?>
<?php $attributes = $__attributesOriginalf887a8bd15c5a211b880c96f0e212bc5; ?>
<?php unset($__attributesOriginalf887a8bd15c5a211b880c96f0e212bc5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf887a8bd15c5a211b880c96f0e212bc5)): ?>
<?php $component = $__componentOriginalf887a8bd15c5a211b880c96f0e212bc5; ?>
<?php unset($__componentOriginalf887a8bd15c5a211b880c96f0e212bc5); ?>
<?php endif; ?>
                                        <span>LinkedIn</span>
                                    </a></li>
                                <?php endif; ?>
                                <?php if($settings?->pinterest_url): ?>
                                    <li><a href="<?php echo e($settings->pinterest_url); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="<?php echo e(__('common.social.pinterest')); ?>">
                                        <?php if (isset($component)) { $__componentOriginal0f5d256a7fe5a799de93490a88dbf9b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f5d256a7fe5a799de93490a88dbf9b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.pinterest','data' => ['class' => 'w-4 h-4','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.pinterest'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4','aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f5d256a7fe5a799de93490a88dbf9b5)): ?>
<?php $attributes = $__attributesOriginal0f5d256a7fe5a799de93490a88dbf9b5; ?>
<?php unset($__attributesOriginal0f5d256a7fe5a799de93490a88dbf9b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f5d256a7fe5a799de93490a88dbf9b5)): ?>
<?php $component = $__componentOriginal0f5d256a7fe5a799de93490a88dbf9b5; ?>
<?php unset($__componentOriginal0f5d256a7fe5a799de93490a88dbf9b5); ?>
<?php endif; ?>
                                        <span>Pinterest</span>
                                    </a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div>
                            <h2 class="text-zinc-300 font-semibold mb-3 uppercase tracking-wider"><?php echo e(__('common.footer.contact')); ?></h2>
                            <?php if($settings?->contact_email): ?>
                                <p class="mb-2">
                                    <a href="mailto:<?php echo e($settings->contact_email); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e($settings->contact_email); ?></a>
                                </p>
                            <?php endif; ?>
                            <p class="text-zinc-600 text-[10px] mt-4">
                                <?php echo e(__('common.footer.designed_by')); ?> <span class="text-zinc-400">Skybread</span>
                            </p>
                        </div>
                    </div>
                    <div class="pt-4 sm:pt-6 border-t border-zinc-800">
                        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-4 text-[10px] sm:text-xs text-zinc-500 mb-2 sm:mb-3">
                            <a href="<?php echo e(localized_route('legal.privacy')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.legal.privacy_title')); ?></a>
                            <span class="hidden sm:inline">•</span>
                            <a href="<?php echo e(localized_route('legal.terms')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.legal.terms_title')); ?></a>
                            <span class="hidden sm:inline">•</span>
                            <a href="<?php echo e(localized_route('legal.notice')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.legal.notice_title')); ?></a>
                            <span class="hidden sm:inline">•</span>
                            <a href="<?php echo e(localized_route('legal.cookies')); ?>" class="hover:text-zinc-300 transition-colors"><?php echo e(__('common.legal.cookies_title')); ?></a>
                        </div>
                        <p class="text-center text-[10px] sm:text-xs text-zinc-500">
                            © <?php echo e(date('Y')); ?> <?php echo e($settings?->site_name ?? 'Kevin Pérez Alarcón'); ?>. <?php echo e(__('common.footer.rights')); ?>

                        </p>
                    </div>
                </div>
            </footer>
        </div>

        <?php if (isset($component)) { $__componentOriginalceaf3fe1766c78c4907eaa2dfb569a19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalceaf3fe1766c78c4907eaa2dfb569a19 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cookie-banner','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cookie-banner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalceaf3fe1766c78c4907eaa2dfb569a19)): ?>
<?php $attributes = $__attributesOriginalceaf3fe1766c78c4907eaa2dfb569a19; ?>
<?php unset($__attributesOriginalceaf3fe1766c78c4907eaa2dfb569a19); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalceaf3fe1766c78c4907eaa2dfb569a19)): ?>
<?php $component = $__componentOriginalceaf3fe1766c78c4907eaa2dfb569a19; ?>
<?php unset($__componentOriginalceaf3fe1766c78c4907eaa2dfb569a19); ?>
<?php endif; ?>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html>

<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/layouts/site.blade.php ENDPATH**/ ?>