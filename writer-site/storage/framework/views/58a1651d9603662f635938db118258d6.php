<?php $__env->startSection('title', 'Inicio'); ?>

<?php
    /** @var \App\Models\SiteSetting|null $settings */
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books */
?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section con animaciones -->
    <section
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 100)"
        class="relative overflow-hidden"
    >
        <div class="relative min-h-[70vh] sm:min-h-[80vh] md:min-h-[85vh] lg:min-h-[90vh] flex items-center">
            <?php if($settings && $settings->hero_image): ?>
                <div
                    class="absolute inset-0 pointer-events-none"
                    aria-hidden="true"
                >
                    <img
                        src="<?php echo e(get_image_url($settings->hero_image)); ?>"
                        alt=""
                        class="w-full h-full object-cover"
                        style="opacity: 0.65;"
                    >
                    <div class="absolute inset-0" style="background-color: rgba(9, 9, 11, 0.35);"></div>
                </div>
            <?php endif; ?>

            <div class="relative z-10 px-4 sm:px-5 md:px-8 py-10 sm:py-12 md:py-16 max-w-6xl mx-auto w-full">
                <div class="space-y-6 sm:space-y-8 max-w-3xl" 
                     x-show="show" 
                     x-transition:enter="transition ease-out duration-1000"
                     x-transition:enter-start="opacity-0 translate-y-8"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <h1 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl 2xl:text-7xl tracking-tight leading-[0.95]">
                        <?php echo nl2br(e($settings?->hero_text ?? 'Historias escritas en la sombra,<br>para leerse en silencio.')); ?>

                    </h1>
                    <p class="text-sm sm:text-base md:text-lg text-zinc-300 max-w-xl leading-relaxed">
                        Libros pensados para una lectura íntima, nocturna, casi en voz baja. Cada página es una conversación con el silencio.
                    </p>
                    <div class="pt-2 sm:pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                        <a href="<?php echo e(localized_route('books.index.public')); ?>" class="group inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 rounded-full bg-zinc-100 text-zinc-950 text-xs sm:text-sm font-semibold tracking-wide uppercase hover:bg-white transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-zinc-100/20">
                            <span><?php echo e(__('common.home.explore_books')); ?></span>
                            <?php if (isset($component)) { $__componentOriginal37a3f047daccd28b87517bd215a12923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37a3f047daccd28b87517bd215a12923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-right','data' => ['class' => 'w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform group-hover:translate-x-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform group-hover:translate-x-1']); ?>
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
                        <a href="<?php echo e(localized_route('about')); ?>" class="inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 rounded-full border border-zinc-700 text-zinc-300 text-xs sm:text-sm font-medium tracking-wide uppercase hover:border-zinc-600 hover:text-zinc-100 hover:bg-zinc-900/40 transition-all duration-300">
                            <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-3.5 h-3.5 sm:w-4 sm:h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3.5 h-3.5 sm:w-4 sm:h-4']); ?>
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
                            <span><?php echo e(__('common.home.about_kevin')); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Libros destacados con animación de scroll -->
    <?php if($books->isNotEmpty()): ?>
        <section 
            x-data="scrollReveal(100)"
            class="px-4 sm:px-5 md:px-8 py-8 sm:py-10 md:py-12 lg:py-16 border-t border-zinc-800/50 bg-gradient-to-b from-zinc-950 to-zinc-900/50"
        >
            <div class="max-w-7xl mx-auto">
                <div 
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-4 mb-8 sm:mb-12"
                    :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-y-6"
                    x-transition:enter-end="opacity-100 translate-y-0"
                >
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
                            <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.28em] uppercase text-zinc-400">
                                <?php echo e(__('common.home.catalog')); ?>

                            </p>
                        </div>
                        <h2 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl lg:text-5xl tracking-tight">
                            <?php echo e(__('common.home.featured_books')); ?>

                        </h2>
                        <p class="mt-2 sm:mt-3 text-xs sm:text-sm text-zinc-400 max-w-md">
                            <?php echo e(__('common.home.available_now')); ?>

                        </p>
                    </div>
                    <a href="<?php echo e(localized_route('books.index.public')); ?>" class="flex sm:hidden items-center gap-2 text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100 transition-colors group">
                        <span><?php echo e(__('common.home.view_all')); ?></span>
                        <?php if (isset($component)) { $__componentOriginal37a3f047daccd28b87517bd215a12923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37a3f047daccd28b87517bd215a12923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-right','data' => ['class' => 'w-4 h-4 transition-transform group-hover:translate-x-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 transition-transform group-hover:translate-x-1']); ?>
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
                    <a href="<?php echo e(localized_route('books.index.public')); ?>" class="hidden sm:flex items-center gap-2 text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100 transition-colors group">
                        <span><?php echo e(__('common.home.view_all')); ?></span>
                        <?php if (isset($component)) { $__componentOriginal37a3f047daccd28b87517bd215a12923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37a3f047daccd28b87517bd215a12923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-right','data' => ['class' => 'w-4 h-4 transition-transform group-hover:translate-x-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 transition-transform group-hover:translate-x-1']); ?>
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">
                    <?php $__currentLoopData = $books->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a 
                            href="<?php echo e(localized_route('books.show', $book)); ?>" 
                            class="group border border-zinc-800 rounded-3xl overflow-hidden bg-zinc-900/40 hover:bg-zinc-900/80 hover:border-zinc-700 transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl hover:shadow-black/50 block"
                            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                            x-data="scrollReveal(<?php echo e(($index + 1) * 100); ?>)"
                            x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                        >
                            <?php
                                $allImages = $book->getAllImages();
                                $imagesArray = $allImages->toArray();
                            ?>
                            <figure class="aspect-[3/4] overflow-hidden bg-zinc-900 relative">
                                <?php if($allImages->isNotEmpty()): ?>
                                    <div 
                                        x-data="{
                                            currentIndex: 0,
                                            images: <?php echo \Illuminate\Support\Js::from($imagesArray)->toHtml() ?>,
                                            touchStartX: 0,
                                            touchEndX: 0,
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
                                            handleTouchStart(e) {
                                                this.touchStartX = e.touches[0].clientX;
                                            },
                                            handleTouchEnd(e) {
                                                this.touchEndX = e.changedTouches[0].clientX;
                                                const diff = this.touchStartX - this.touchEndX;
                                                if (Math.abs(diff) > 50) {
                                                    if (diff > 0) {
                                                        this.next();
                                                    } else {
                                                        this.prev();
                                                    }
                                                }
                                            },
                                            handleButtonClick(action, event) {
                                                event.stopPropagation();
                                                event.preventDefault();
                                                action();
                                                return false;
                                            }
                                        }"
                                        class="relative w-full h-full"
                                        @touchstart="handleTouchStart"
                                        @touchend="handleTouchEnd"
                                    >
                                        <div class="relative w-full h-full pointer-events-none">
                                            <template x-for="(image, index) in images" :key="index">
                                                <img 
                                                    :src="image.url"
                                                    :alt="image.alt"
                                                    class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 group-hover:scale-110 transition-transform duration-700"
                                                    :class="currentIndex === index ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                                                    loading="lazy"
                                                    width="300"
                                                    height="400"
                                                    x-on:error="$el.style.display = 'none'"
                                                >
                                            </template>
                                        </div>
                                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none" aria-hidden="true"></div>
                                    </div>
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-xs text-zinc-500" role="img" aria-label="Portada no disponible">
                                        <?php if (isset($component)) { $__componentOriginal285eddc9278dae58281aa961bf08a625 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal285eddc9278dae58281aa961bf08a625 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.book','data' => ['class' => 'w-12 h-12 opacity-20','ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-12 h-12 opacity-20','aria-hidden' => 'true']); ?>
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
                            </figure>
                            <div class="p-5 sm:p-6 space-y-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1">
                                        <div class="text-[10px] tracking-[0.3em] uppercase text-zinc-500 mb-1.5">
                                            <?php echo e(__('common.books.book')); ?>

                                        </div>
                                        <h3 class="text-base font-semibold text-zinc-50 leading-tight group-hover:text-zinc-100 transition-colors">
                                            <?php echo e($book->title); ?>

                                        </h3>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-amber-400">
                                            <?php echo e(number_format($book->price, 2, ',', '.')); ?> €
                                        </p>
                                    </div>
                                </div>
                                <p class="text-xs text-zinc-400 line-clamp-2 leading-relaxed">
                                    <?php echo e($book->description); ?>

                                </p>
                                <?php if($book->reviews_count > 0): ?>
                                    <div class="flex items-center gap-2 pt-1">
                                        <?php if (isset($component)) { $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.star-rating','data' => ['rating' => $book->average_rating,'maxRating' => 10,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('star-rating'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($book->average_rating),'maxRating' => 10,'size' => 'sm']); ?>
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
                                        <span class="text-xs text-zinc-400">
                                            <?php echo e(number_format($book->average_rating, 1)); ?>/10
                                        </span>
                                        <span class="text-[10px] text-zinc-500">
                                            (<?php echo e($book->reviews_count); ?> <?php echo e($book->reviews_count === 1 ? 'reseña' : 'reseñas'); ?>)
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <div class="pt-2 flex items-center gap-2 text-[10px] text-zinc-500 group-hover:text-zinc-400 transition-colors">
                                    <span>Ver detalles</span>
                                    <?php if (isset($component)) { $__componentOriginal37a3f047daccd28b87517bd215a12923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37a3f047daccd28b87517bd215a12923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-right','data' => ['class' => 'w-3 h-3 transition-transform group-hover:translate-x-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 transition-transform group-hover:translate-x-1']); ?>
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
                                </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="mt-10 text-center sm:hidden">
                    <a href="<?php echo e(localized_route('books.index.public')); ?>" class="inline-flex items-center gap-2 text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100 transition-colors">
                        <span>Ver todos los libros</span>
                        <?php if (isset($component)) { $__componentOriginal37a3f047daccd28b87517bd215a12923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37a3f047daccd28b87517bd215a12923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-right','data' => ['class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
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
        </section>
    <?php endif; ?>

    <!-- Testimonios con animación de scroll -->
    <?php
        $testimonials = \App\Models\Testimonial::where('active', true)->orderBy('order')->orderBy('created_at', 'desc')->take(3)->get();
    ?>

    <?php if($testimonials->isNotEmpty()): ?>
        <section 
            x-data="scrollReveal(200)"
            class="px-5 sm:px-8 py-12 sm:py-16 border-t border-zinc-800/50 bg-zinc-950"
        >
            <div class="max-w-7xl mx-auto">
                <div 
                    class="text-center mb-12"
                    :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-y-6"
                    x-transition:enter-end="opacity-100 translate-y-0"
                >
                    <div class="inline-flex items-center gap-2 mb-3">
                        <?php if (isset($component)) { $__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.star','data' => ['class' => 'w-5 h-5 text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-amber-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf)): ?>
<?php $attributes = $__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf; ?>
<?php unset($__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf)): ?>
<?php $component = $__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf; ?>
<?php unset($__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf); ?>
<?php endif; ?>
                        <p class="text-[11px] tracking-[0.28em] uppercase text-zinc-400">
                            <?php echo e(__('common.home.testimonials')); ?>

                        </p>
                    </div>
                    <h2 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl tracking-tight">
                        <?php echo e(__('common.home.what_readers_say')); ?>

                    </h2>
                    <p class="mt-3 text-sm text-zinc-400 max-w-md mx-auto">
                        <?php echo e(__('common.home.reviews_from')); ?>

                    </p>
                </div>
                <div class="grid sm:grid-cols-3 gap-6 lg:gap-8">
                    <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div 
                            class="border border-zinc-800 rounded-3xl p-6 sm:p-8 bg-zinc-900/40 hover:bg-zinc-900/60 hover:border-zinc-700 transition-all duration-500 hover:scale-[1.02] space-y-5"
                            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                            x-data="scrollReveal(<?php echo e(($index + 1) * 150); ?>)"
                            x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                        >
                            <div class="flex items-center gap-4">
                                <img 
                                    src="<?php echo e($testimonial->photo_url); ?>" 
                                    alt="<?php echo e($testimonial->name); ?>" 
                                    class="w-14 h-14 rounded-full object-cover border-2 border-zinc-800 ring-2 ring-zinc-700"
                                >
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-zinc-50"><?php echo e($testimonial->name); ?></p>
                                    <div class="flex items-center gap-1 mt-1">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if (isset($component)) { $__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.star','data' => ['class' => 'w-4 h-4 '.e($i <= $testimonial->rating ? 'text-amber-400' : 'text-zinc-700').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 '.e($i <= $testimonial->rating ? 'text-amber-400' : 'text-zinc-700').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf)): ?>
<?php $attributes = $__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf; ?>
<?php unset($__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf)): ?>
<?php $component = $__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf; ?>
<?php unset($__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf); ?>
<?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-zinc-300 leading-relaxed">
                                "<?php echo e($testimonial->review); ?>"
                            </p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- CTA Final -->
    <section 
        x-data="scrollReveal(300)"
        class="px-5 sm:px-8 py-12 sm:py-16 border-t border-zinc-800/50 bg-gradient-to-b from-zinc-900/50 to-zinc-950"
    >
        <div class="max-w-4xl mx-auto text-center">
            <div 
                :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 translate-y-6"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="space-y-6"
            >
                <h2 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl tracking-tight">
                    <?php echo e(__('common.home.cta_title')); ?>

                </h2>
                <p class="text-base text-zinc-400 max-w-xl mx-auto">
                    <?php echo e(__('common.home.cta_description')); ?>

                </p>
                <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                    <a href="<?php echo e(localized_route('books.index.public')); ?>" class="group inline-flex items-center gap-2 px-8 py-4 rounded-full bg-zinc-100 text-zinc-950 text-sm font-semibold tracking-wide uppercase hover:bg-white transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-zinc-100/20">
                        <?php if (isset($component)) { $__componentOriginal285eddc9278dae58281aa961bf08a625 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal285eddc9278dae58281aa961bf08a625 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.book','data' => ['class' => 'w-5 h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
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
                        <span><?php echo e(__('common.home.view_catalog')); ?></span>
                        <?php if (isset($component)) { $__componentOriginal37a3f047daccd28b87517bd215a12923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37a3f047daccd28b87517bd215a12923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-right','data' => ['class' => 'w-4 h-4 transition-transform group-hover:translate-x-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 transition-transform group-hover:translate-x-1']); ?>
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
                    <a href="<?php echo e(localized_route('contact')); ?>" class="inline-flex items-center gap-2 px-8 py-4 rounded-full border border-zinc-700 text-zinc-300 text-sm font-medium tracking-wide uppercase hover:border-zinc-600 hover:text-zinc-100 hover:bg-zinc-900/40 transition-all duration-300">
                        <?php if (isset($component)) { $__componentOriginalce4e5b3a3927cd89cc73a7e1ee3516ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce4e5b3a3927cd89cc73a7e1ee3516ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.envelope','data' => ['class' => 'w-5 h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.envelope'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
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
                        <span><?php echo e(__('common.home.contact')); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/site/home.blade.php ENDPATH**/ ?>