<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => null]));

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

foreach (array_filter((['title' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e($title ? $title . ' – ' : ''); ?><?php echo e(config('app.name', 'Escritor')); ?></title>

        <!-- Fuente más editorial -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600|dm-serif-display:400&display=swap" rel="stylesheet" />

        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

        <!-- Trix para contenido enriquecido en páginas -->
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
        <script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js" defer></script>
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">
        <div class="min-h-screen flex flex-col md:flex-row">
            <!-- Menú móvil (hamburguesa) -->
            <div x-data="{ mobileMenuOpen: false }" class="md:hidden">
                <header class="border-b border-zinc-800 px-4 py-3 flex items-center justify-between bg-zinc-950/90 backdrop-blur sticky top-0 z-50">
                    <a href="<?php echo e(route('home', ['locale' => app()->getLocale()])); ?>" class="font-['DM_Serif_Display'] text-lg hover:text-zinc-200 transition-colors">
                        <?php echo e(optional(\App\Models\SiteSetting::first())->site_name ?? 'Autor'); ?>

                    </a>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg hover:bg-zinc-900 transition-colors" aria-label="Menú">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </header>
                
                <!-- Menú desplegable móvil -->
                <div 
                    x-show="mobileMenuOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="fixed inset-0 z-40 bg-zinc-950/95 backdrop-blur md:hidden"
                    style="display: none;"
                    @click.away="mobileMenuOpen = false"
                >
                    <div class="px-4 py-6 space-y-1 overflow-y-auto h-full">
                        <div class="mb-6 pb-4 border-b border-zinc-800">
                            <div class="text-xs tracking-[0.3em] uppercase text-zinc-500 mb-2"><?php echo e(__('common.admin.panel')); ?></div>
                            <a href="<?php echo e(route('home', ['locale' => app()->getLocale()])); ?>" class="font-['DM_Serif_Display'] text-xl hover:text-zinc-200 transition-colors block" @click="mobileMenuOpen = false">
                                <?php echo e(optional(\App\Models\SiteSetting::first())->site_name ?? 'Autor'); ?>

                            </a>
                            <p class="text-xs text-zinc-500 mt-1">
                                <?php echo e(__('common.admin.private_space')); ?>

                            </p>
                        </div>
                        <nav class="space-y-1">
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.dashboard')); ?></span>
                            </a>
                            <a href="<?php echo e(route('admin.statistics.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.statistics.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.statistics')); ?></span>
                            </a>
                            <a href="<?php echo e(route('admin.orders.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.orders.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.orders')); ?></span>
                                <?php
                                    $pendingOrders = \App\Models\Order::where('status', 'paid')->where('shipped', false)->count();
                                ?>
                                <?php if($pendingOrders > 0): ?>
                                    <span class="px-2 py-0.5 text-xs font-semibold text-zinc-950 bg-amber-400 rounded-full"><?php echo e($pendingOrders); ?></span>
                                <?php endif; ?>
                            </a>
                            <a href="<?php echo e(route('admin.home.edit')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.home.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.home')); ?></span>
                            </a>
                            <a href="<?php echo e(route('admin.books.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.books.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.books')); ?></span>
                            </a>
                            <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.testimonials.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.testimonials')); ?></span>
                            </a>
                            <a href="<?php echo e(route('admin.faqs.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.faqs.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.faqs')); ?></span>
                            </a>
                            <a href="<?php echo e(route('admin.reviews.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.reviews.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.reviews')); ?></span>
                                <?php
                                    $pendingReviews = \App\Models\Review::where('approved', false)->count();
                                ?>
                                <?php if($pendingReviews > 0): ?>
                                    <span class="px-2 py-0.5 text-xs font-semibold text-zinc-950 bg-amber-400 rounded-full"><?php echo e($pendingReviews); ?></span>
                                <?php endif; ?>
                            </a>
                            <a href="<?php echo e(route('admin.blog.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.blog.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.blog')); ?></span>
                            </a>
                            <a href="<?php echo e(route('admin.pages.about.edit')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.pages.about.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.about')); ?></span>
                            </a>
                            <a href="<?php echo e(route('admin.reader-photos.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.reader-photos.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span>Fotos con lectores</span>
                            </a>
                            <a href="<?php echo e(route('admin.pages.contact.edit')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.pages.contact.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.contact')); ?></span>
                            </a>
                            <a href="<?php echo e(route('admin.settings.edit')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.settings')); ?></span>
                            </a>
                            <a href="<?php echo e(route('admin.legal.edit')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.legal.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.legal')); ?></span>
                            </a>
                            <a href="<?php echo e(route('admin.email-templates.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.email-templates.*') ? 'bg-zinc-900' : ''); ?>" @click="mobileMenuOpen = false">
                                <span><?php echo e(__('common.admin.email_templates')); ?></span>
                            </a>
                        </nav>
                        <div class="pt-4 mt-4 border-t border-zinc-800 text-xs text-zinc-500 space-y-2">
                            <div><?php echo e(__('common.admin.logged_in_as')); ?> <span class="text-zinc-200"><?php echo e(auth()->user()->name); ?></span></div>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="underline hover:text-zinc-200"><?php echo e(__('common.admin.logout')); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar desktop -->
            <aside class="hidden md:flex md:flex-col w-72 border-r border-zinc-800 bg-zinc-950/80 backdrop-blur">
                <div class="px-6 py-6 border-b border-zinc-800">
                    <div class="text-xs tracking-[0.3em] uppercase text-zinc-500 mb-2"><?php echo e(__('common.admin.panel')); ?></div>
                    <a href="<?php echo e(route('home', ['locale' => app()->getLocale()])); ?>" class="font-['DM_Serif_Display'] text-xl hover:text-zinc-200 transition-colors block">
                        <?php echo e(optional(\App\Models\SiteSetting::first())->site_name ?? 'Autor'); ?>

                    </a>
                    <p class="text-xs text-zinc-500 mt-1">
                        <?php echo e(__('common.admin.private_space')); ?>

                    </p>
                </div>
                <nav class="flex-1 px-4 py-4 text-sm space-y-1">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.dashboard')); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.statistics.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.statistics.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.statistics')); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.orders.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.orders')); ?></span>
                        <?php
                            $pendingOrders = \App\Models\Order::where('status', 'paid')->where('shipped', false)->count();
                        ?>
                        <?php if($pendingOrders > 0): ?>
                            <span class="px-2 py-0.5 text-xs font-semibold text-zinc-950 bg-amber-400 rounded-full"><?php echo e($pendingOrders); ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo e(route('admin.home.edit')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.home.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.home')); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.books.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.books.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.books')); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.testimonials.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.testimonials')); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.faqs.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.faqs.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.faqs')); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.reviews.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.reviews.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.reviews')); ?></span>
                        <?php
                            $pendingReviews = \App\Models\Review::where('approved', false)->count();
                        ?>
                        <?php if($pendingReviews > 0): ?>
                            <span class="px-2 py-0.5 text-xs font-semibold text-zinc-950 bg-amber-400 rounded-full"><?php echo e($pendingReviews); ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo e(route('admin.blog.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.blog.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.blog')); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.pages.about.edit')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.pages.about.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.about')); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.reader-photos.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.reader-photos.*') ? 'bg-zinc-900' : ''); ?>">
                        <span>Fotos con lectores</span>
                    </a>
                    <a href="<?php echo e(route('admin.pages.contact.edit')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.pages.contact.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.contact')); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.settings.edit')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.settings')); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.legal.edit')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.legal.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.legal')); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.email-templates.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 <?php echo e(request()->routeIs('admin.email-templates.*') ? 'bg-zinc-900' : ''); ?>">
                        <span><?php echo e(__('common.admin.email_templates')); ?></span>
                    </a>
                </nav>
                <div class="px-4 py-4 border-t border-zinc-800 text-xs text-zinc-500 space-y-2">
                    <div><?php echo e(__('common.admin.logged_in_as')); ?> <span class="text-zinc-200"><?php echo e(auth()->user()->name); ?></span></div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="underline hover:text-zinc-200"><?php echo e(__('common.admin.logout')); ?></button>
                    </form>
                </div>
            </aside>

            <div class="flex-1 flex flex-col min-w-0">
                <main class="flex-1 px-4 sm:px-6 md:px-8 py-6 md:py-8 max-w-5xl mx-auto w-full">
                    <?php if(session('status')): ?>
                        <div class="mb-6 rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-4 py-3 text-sm">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <?php echo e($slot); ?>

                </main>
            </div>
        </div>
    </body>
</html>
<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/components/admin/layout.blade.php ENDPATH**/ ?>