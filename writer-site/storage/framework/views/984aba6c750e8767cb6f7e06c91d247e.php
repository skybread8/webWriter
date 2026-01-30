<?php $__env->startSection('title', $book->title); ?>

<?php $__env->startSection('seo'); ?>
    <?php
        $settings = \App\Models\SiteSetting::first();
        $siteName = $settings?->site_name ?? 'Kevin Pérez Alarcón';
        $seoTitle = $siteName . ' – ' . $book->title;
        $seoDescription = \Illuminate\Support\Str::limit(strip_tags($book->description), 160);
        $seoImage = $book->first_image_url ?: ($settings?->hero_image ? get_image_url($settings->hero_image) : null);
        $seoImageAlt = $book->cover_image_alt ?: $book->title;
    ?>
    <?php if (isset($component)) { $__componentOriginal84f9df3f620371229981225e7ba608d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal84f9df3f620371229981225e7ba608d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seo-meta','data' => ['title' => $seoTitle,'description' => $seoDescription,'image' => $seoImage,'imageAlt' => $seoImageAlt,'type' => 'website']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo-meta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoTitle),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoDescription),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoImage),'image_alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoImageAlt),'type' => 'website']); ?>
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
    <?php
        $bookSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Book',
            'name' => $book->title,
            'description' => $seoDescription,
            'author' => ['@type' => 'Person', 'name' => $siteName],
            'url' => url()->current(),
        ];
        if ($seoImage) {
            $bookSchema['image'] = $seoImage;
        }
    ?>
    <script type="application/ld+json"><?php echo json_encode($bookSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section 
        x-data="scrollReveal(0)"
        class="px-4 sm:px-5 md:px-8 py-6 sm:py-8 md:py-12 max-w-6xl mx-auto"
    >
        <div 
            class="grid grid-cols-1 md:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] gap-4 sm:gap-6 md:gap-8 items-start"
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div class="space-y-4 sm:space-y-6">
                <?php
                    // Obtener todas las imágenes usando el método helper
                    $allImages = $book->getAllImages();
                    // Convertir a array para Alpine.js
                    $imagesArray = $allImages->toArray();
                ?>

                <?php if($allImages->isNotEmpty()): ?>
                    <div 
                        x-data="{
                            currentIndex: 0,
                            images: <?php echo \Illuminate\Support\Js::from($imagesArray)->toHtml() ?>,
                            touchStartX: 0,
                            touchEndX: 0,
                            init() {
                                // Debug: verificar que las imágenes se cargaron
                                console.log('Imágenes cargadas:', this.images.length);
                            },
                            next() {
                                if (this.images.length > 1) {
                                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                                }
                            },
                            prev() {
                                if (this.images.length > 1) {
                                    this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                                }
                            },
                            goTo(index) {
                                if (index >= 0 && index < this.images.length) {
                                    this.currentIndex = index;
                                }
                            },
                            handleTouchStart(e) {
                                this.touchStartX = e.touches[0].clientX;
                            },
                            handleTouchEnd(e) {
                                this.touchEndX = e.changedTouches[0].clientX;
                                this.handleSwipe();
                            },
                            handleSwipe() {
                                const diff = this.touchStartX - this.touchEndX;
                                if (Math.abs(diff) > 50) {
                                    if (diff > 0) {
                                        this.next();
                                    } else {
                                        this.prev();
                                    }
                                }
                            }
                        }"
                        class="relative aspect-[3/4] max-w-[200px] sm:max-w-[240px] md:max-w-none mx-auto rounded-2xl sm:rounded-3xl border-2 border-zinc-800 overflow-hidden bg-zinc-900 shadow-2xl shadow-black/50 group cursor-pointer"
                        @touchstart="handleTouchStart"
                        @touchend="handleTouchEnd"
                    >
                        <!-- Imagen actual -->
                        <div class="relative w-full h-full">
                            <template x-for="(image, index) in images" :key="index">
                                <img 
                                    :src="image.url"
                                    :alt="image.alt"
                                    class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500"
                                    :class="currentIndex === index ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                                    loading="lazy"
                                    width="400"
                                    height="600"
                                    x-on:error="$el.style.display = 'none'"
                                >
                            </template>
                        </div>

                        <!-- Botones de navegación (solo si hay más de una imagen) -->
                        <template x-if="images && images.length > 1">
                            <div>
                                <!-- Botón anterior -->
                                <button 
                                    @click.stop="prev()"
                                    class="absolute left-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-zinc-900/95 hover:bg-zinc-800 border-2 border-zinc-700 flex items-center justify-center text-zinc-100 transition-all shadow-lg hover:scale-110"
                                    aria-label="Imagen anterior"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>

                                <!-- Botón siguiente -->
                                <button 
                                    @click.stop="next()"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-zinc-900/95 hover:bg-zinc-800 border-2 border-zinc-700 flex items-center justify-center text-zinc-100 transition-all shadow-lg hover:scale-110"
                                    aria-label="Imagen siguiente"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>

                                <!-- Indicadores de puntos -->
                                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
                                    <template x-for="(image, index) in images" :key="index">
                                        <button 
                                            @click.stop="goTo(index)"
                                            class="w-2 h-2 rounded-full transition-all"
                                            :class="currentIndex === index ? 'bg-amber-400 w-6' : 'bg-zinc-600 hover:bg-zinc-500'"
                                            :aria-label="`Ir a imagen ${index + 1}`"
                                        ></button>
                                    </template>
                                </div>

                                <!-- Contador de imágenes -->
                                <div class="absolute top-3 right-3 z-20 px-2 py-1 rounded-full bg-zinc-900/90 border border-zinc-700 text-xs text-zinc-300 shadow-lg">
                                    <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                <?php else: ?>
                    <figure class="aspect-[3/4] max-w-xs mx-auto md:max-w-none rounded-2xl sm:rounded-3xl border-2 border-zinc-800 overflow-hidden bg-zinc-900 shadow-2xl shadow-black/50">
                        <div class="w-full h-full flex items-center justify-center text-xs text-zinc-500" role="img" aria-label="Portada no disponible">
                            <?php if (isset($component)) { $__componentOriginal285eddc9278dae58281aa961bf08a625 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal285eddc9278dae58281aa961bf08a625 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.book','data' => ['class' => 'w-16 h-16 opacity-20','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-16 h-16 opacity-20','aria-hidden' => 'true']); ?>
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
                    </figure>
                <?php endif; ?>
                <div class="space-y-3 sm:space-y-4">
                    <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-900/60 border border-zinc-800">
                        <div class="mb-2 sm:mb-3">
                            <p class="text-[9px] sm:text-[10px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-500 mb-1">
                                Precio
                            </p>
                            <p class="text-xl sm:text-2xl font-bold text-amber-400">
                                <?php echo e(number_format($book->price, 2, ',', '.')); ?> €
                            </p>
                        </div>
                        <p class="text-xs text-zinc-400 leading-relaxed">
                            <?php echo e(__('common.books.price_includes')); ?>

                        </p>
                    </div>
                    <div class="space-y-2 sm:space-y-3">
                        <?php if($book->isInStock()): ?>
                            <form method="POST" action="<?php echo e(localized_route('cart.add', $book)); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="quantity" value="1">
                                <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'secondary','class' => 'w-full flex items-center justify-center gap-2 text-xs sm:text-sm']); ?>
                                    <?php if (isset($component)) { $__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shopping-cart','data' => ['class' => 'w-3.5 h-3.5 sm:w-4 sm:h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shopping-cart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3.5 h-3.5 sm:w-4 sm:h-4']); ?>
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
                                    <span><?php echo e(__('common.books.add_to_cart')); ?></span>
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
                            </form>
                            <form method="POST" action="<?php echo e(localized_route('books.checkout', $book)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-full flex items-center justify-center gap-2 text-xs sm:text-sm']); ?>
                                    <span><?php echo e(__('common.books.buy')); ?></span>
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
                            </form>
                        <?php else: ?>
                            <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-800/80 border border-zinc-700 text-center">
                                <p class="text-sm font-medium text-zinc-300">No disponible</p>
                                <p class="text-xs text-zinc-500 mt-1">Este libro está agotado. No se pueden realizar compras por el momento.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if($book->isInStock() && ! $book->stripe_price_id): ?>
                        <div class="p-3 rounded-xl bg-amber-900/20 border border-amber-800/50">
                            <p class="text-xs text-amber-300">
                                Este libro aún no tiene un precio de Stripe configurado. El botón de compra no estará activo hasta añadirlo desde el panel.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="space-y-4 sm:space-y-6">
                <div>
                    <div class="inline-flex items-center gap-2 mb-2 sm:mb-3">
                        <?php if (isset($component)) { $__componentOriginal285eddc9278dae58281aa961bf08a625 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal285eddc9278dae58281aa961bf08a625 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.book','data' => ['class' => 'w-4 h-4 sm:w-5 sm:h-5 text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 sm:w-5 sm:h-5 text-amber-400']); ?>
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
                        <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                            Libro
                        </p>
                    </div>
                    <h1 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl lg:text-5xl tracking-tight leading-tight">
                        <?php echo e($book->title); ?>

                    </h1>
                </div>
                <p class="text-sm sm:text-base text-zinc-300 leading-relaxed">
                    <?php echo e($book->description); ?>

                </p>
                <?php if($book->long_description): ?>
                    <div class="prose prose-invert prose-zinc max-w-none text-sm sm:text-base leading-relaxed space-y-3 sm:space-y-4">
                        <?php echo $book->long_description; ?>

                    </div>
                <?php endif; ?>
                <a href="<?php echo e(localized_route('books.index.public')); ?>" class="inline-flex items-center gap-2 text-[10px] sm:text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100 transition-colors group">
                    <?php if (isset($component)) { $__componentOriginal37a3f047daccd28b87517bd215a12923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37a3f047daccd28b87517bd215a12923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-right','data' => ['class' => 'w-3.5 h-3.5 sm:w-4 sm:h-4 rotate-180 transition-transform group-hover:-translate-x-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3.5 h-3.5 sm:w-4 sm:h-4 rotate-180 transition-transform group-hover:-translate-x-1']); ?>
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
                    <span><?php echo e(__('common.books.back_to_books')); ?></span>
                </a>
            </div>
        </div>

        <!-- Reseñas -->
        <div class="mt-8 sm:mt-10 space-y-4 sm:space-y-6">
            <div>
                <div class="inline-flex items-center gap-2 mb-2 sm:mb-3">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                        Reseñas
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                    <div>
                        <h2 class="font-['DM_Serif_Display'] text-xl sm:text-2xl md:text-3xl tracking-tight">
                            Valoraciones de lectores
                        </h2>
                        <?php if(isset($book->reviews_count) && $book->reviews_count > 0): ?>
                            <div class="flex items-center gap-3 mt-2">
                                <?php if (isset($component)) { $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.star-rating','data' => ['rating' => $book->average_rating,'maxRating' => 10,'size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('star-rating'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($book->average_rating),'maxRating' => 10,'size' => 'md']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b)): ?>
<?php $attributes = $__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b; ?>
<?php unset($__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b)): ?>
<?php $component = $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b; ?>
<?php unset($__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b); ?>
<?php endif; ?>
                                <span class="text-sm text-zinc-400">
                                    <?php echo e(number_format($book->average_rating, 1)); ?>/10
                                </span>
                                <span class="text-xs text-zinc-500">
                                    (<?php echo e($book->reviews_count); ?> <?php echo e($book->reviews_count === 1 ? 'reseña' : 'reseñas'); ?>)
                                </span>
                            </div>
                        <?php else: ?>
                            <p class="text-xs sm:text-sm text-zinc-400 mt-2">Aún no hay reseñas para este libro</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if(session('status')): ?>
                <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                <!-- Formulario de reseña -->
                <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base sm:text-lg font-semibold text-zinc-100">
                            <?php echo e(isset($userReview) && $userReview ? 'Editar tu reseña' : 'Escribe tu reseña'); ?>

                        </h3>
                        <?php if(isset($userReview) && $userReview && !$userReview->approved): ?>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-amber-900/40 text-amber-300 border border-amber-800/50">
                                Pendiente de aprobación
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php if(isset($userReview) && $userReview && !$userReview->approved): ?>
                        <div class="mb-4 rounded-xl border border-amber-600/40 bg-amber-900/20 text-amber-100 px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm">
                            Tu reseña está pendiente de aprobación. Se mostrará públicamente una vez que el administrador la apruebe.
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo e(localized_route('reviews.store', $book)); ?>" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-zinc-300 mb-2">
                                Valoración (1-10 estrellas) <span class="text-red-400">*</span>
                            </label>
                            <?php if (isset($component)) { $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.star-rating','data' => ['rating' => isset($userReview) && $userReview ? $userReview->rating : 0,'maxRating' => 10,'size' => 'lg','interactive' => true,'name' => 'rating']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('star-rating'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($userReview) && $userReview ? $userReview->rating : 0),'maxRating' => 10,'size' => 'lg','interactive' => true,'name' => 'rating']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b)): ?>
<?php $attributes = $__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b; ?>
<?php unset($__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b)): ?>
<?php $component = $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b; ?>
<?php unset($__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b); ?>
<?php endif; ?>
                            <?php $__errorArgs = ['rating'];
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
                        <div>
                            <label for="comment" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                Comentario (opcional)
                            </label>
                            <textarea 
                                id="comment" 
                                name="comment" 
                                rows="4"
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                placeholder="Comparte tu opinión sobre este libro..."
                            ><?php echo e(old('comment', isset($userReview) && $userReview ? $userReview->comment : '')); ?></textarea>
                            <?php $__errorArgs = ['comment'];
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
                        <div class="flex items-center gap-3">
                            <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'w-full sm:w-auto']); ?>
                                <?php echo e(isset($userReview) && $userReview ? 'Actualizar reseña' : 'Publicar reseña'); ?>

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
                            <?php if(isset($userReview) && $userReview): ?>
                                <form method="POST" action="<?php echo e(localized_route('reviews.destroy', $userReview)); ?>" onsubmit="return confirm('¿Seguro que quieres eliminar tu reseña?');" class="sm:ml-auto">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-xs text-red-400 hover:text-red-300 transition-colors underline underline-offset-4">
                                        Eliminar reseña
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40 text-center">
                    <p class="text-sm text-zinc-400 mb-3">Inicia sesión para dejar tu reseña</p>
                    <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center gap-2 text-xs sm:text-sm text-amber-400 hover:text-amber-300 transition-colors">
                        <span>Iniciar sesión</span>
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

            <!-- Lista de reseñas -->
            <?php if(isset($reviews) && $reviews->isNotEmpty()): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 rounded-full bg-zinc-800 flex items-center justify-center">
                                            <span class="text-sm font-semibold text-zinc-300">
                                                <?php echo e(strtoupper(substr($review->user->name, 0, 1))); ?>

                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-zinc-100"><?php echo e($review->user->name); ?></p>
                                            <p class="text-xs text-zinc-400"><?php echo e($review->created_at->format('d/m/Y')); ?></p>
                                        </div>
                                    </div>
                                    <?php if (isset($component)) { $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.star-rating','data' => ['rating' => $review->rating,'maxRating' => 10,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('star-rating'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($review->rating),'maxRating' => 10,'size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b)): ?>
<?php $attributes = $__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b; ?>
<?php unset($__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b)): ?>
<?php $component = $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b; ?>
<?php unset($__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b); ?>
<?php endif; ?>
                                </div>
                                <?php if(auth()->check() && auth()->id() === $review->user_id): ?>
                                    <span class="px-2 py-1 rounded-full text-[10px] font-medium bg-amber-900/40 text-amber-300 border border-amber-800/50">
                                        Tu reseña
                                    </span>
                                <?php endif; ?>
                            </div>
                            <?php if($review->comment): ?>
                                <div class="mt-3">
                                    <p class="text-sm sm:text-base text-zinc-300 leading-relaxed whitespace-pre-wrap break-words"><?php echo e($review->comment); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-8 sm:p-12 bg-zinc-900/40 text-center">
                    <svg class="w-12 h-12 text-zinc-700 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <p class="text-sm text-zinc-400">Aún no hay reseñas para este libro</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Fotos de lectores que compraron este libro -->
        <?php if(isset($readerPhotos) && $readerPhotos->isNotEmpty()): ?>
            <div class="mt-12 sm:mt-16 space-y-6 sm:space-y-8">
                <div>
                    <div class="inline-flex items-center gap-2 mb-2 sm:mb-3">
                        <?php if (isset($component)) { $__componentOriginal1a3a288e8e56eced3e867d93889b9079 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a3a288e8e56eced3e867d93889b9079 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.camera','data' => ['class' => 'w-4 h-4 sm:w-5 sm:h-5 text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.camera'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 sm:w-5 sm:h-5 text-amber-400']); ?>
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
                        <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                            Fotos con lectores
                        </p>
                    </div>
                    <h2 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl tracking-tight">
                        Lectores que compraron este libro
                    </h2>
                    <p class="text-xs sm:text-sm text-zinc-400 mt-2">
                        Algunos lectores que han comprado "<?php echo e($book->title); ?>" y se han hecho una foto conmigo.
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 sm:gap-6">
                    <?php $__currentLoopData = $readerPhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <figure class="group relative aspect-square overflow-hidden rounded-xl sm:rounded-2xl border border-zinc-800 bg-zinc-900/40 hover:border-zinc-700 transition-all duration-300 hover:shadow-xl hover:shadow-black/50">
                            <img 
                                src="<?php echo e($photo->photo_url); ?>" 
                                alt="<?php echo e($photo->photo_alt ?: ($photo->reader_name ?: 'Foto con lector')); ?>" 
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                loading="lazy"
                            >
                            <?php if($photo->reader_name || $photo->caption): ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/95 via-zinc-950/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-3 sm:p-4">
                                    <div class="w-full">
                                        <?php if($photo->reader_name): ?>
                                            <p class="text-xs sm:text-sm font-medium text-zinc-100 mb-1">
                                                <?php echo e($photo->reader_name); ?>

                                            </p>
                                        <?php endif; ?>
                                        <?php if($photo->caption): ?>
                                            <p class="text-[10px] sm:text-xs text-zinc-300 line-clamp-2">
                                                <?php echo e($photo->caption); ?>

                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </figure>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/store/books/show.blade.php ENDPATH**/ ?>