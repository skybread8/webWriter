<?php $__env->startSection('title', 'Libros'); ?>

<?php $__env->startSection('content'); ?>
    <section 
        x-data="scrollReveal(0)"
        class="px-4 sm:px-5 md:px-8 py-6 sm:py-8 md:py-12 max-w-6xl mx-auto"
    >
        <div 
            class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 sm:gap-6 mb-6 sm:mb-8"
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
                    <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                        <?php echo e(__('common.home.catalog')); ?>

                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl lg:text-5xl tracking-tight">
                    <?php echo e(__('common.books.title')); ?>

                </h1>
                <p class="mt-2 sm:mt-3 text-xs sm:text-sm text-zinc-400 max-w-md">
                    <?php echo e(__('common.books.description')); ?>

                </p>
            </div>
        </div>

        <?php if($books->isEmpty()): ?>
            <p class="text-xs sm:text-sm text-zinc-500">
                Aún no hay libros activos. Vuelve pronto.
            </p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">
                <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article 
                        class="group border border-zinc-800 rounded-2xl sm:rounded-3xl overflow-hidden bg-zinc-900/40 hover:bg-zinc-900/80 hover:border-zinc-700 transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl hover:shadow-black/50 flex flex-col"
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
                        <div class="relative overflow-hidden">
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
                                        }
                                    }"
                                    class="relative aspect-[3/4] bg-zinc-900 cursor-pointer"
                                    @touchstart="handleTouchStart"
                                    @touchend="handleTouchEnd"
                                >
                                    <a href="<?php echo e(localized_route('books.show', $book)); ?>" class="block relative w-full h-full" aria-label="Ver detalles de <?php echo e($book->title); ?>">
                                        <div class="relative w-full h-full">
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
                                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500" aria-hidden="true"></div>
                                    </a>
                                </div>
                            <?php else: ?>
                                <a href="<?php echo e(localized_route('books.show', $book)); ?>" class="block" aria-label="Ver detalles de <?php echo e($book->title); ?>">
                                    <figure class="aspect-[3/4] bg-zinc-900 relative">
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
                                    </figure>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="p-4 sm:p-5 md:p-6 flex-1 flex flex-col space-y-3 sm:space-y-4">
                            <div class="flex-1 space-y-2 sm:space-y-3">
                                <div class="text-[9px] sm:text-[10px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-500">
                                    Libro
                                </div>
                                <h2 class="text-sm sm:text-base font-semibold text-zinc-50 leading-tight group-hover:text-zinc-100 transition-colors">
                                    <?php echo e($book->title); ?>

                                </h2>
                                <p class="text-xs text-zinc-400 line-clamp-3 leading-relaxed">
                                    <?php echo e($book->description); ?>

                                </p>
                            </div>
                            <div class="space-y-2 sm:space-y-3 pt-2 border-t border-zinc-800">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-sm sm:text-base font-bold text-amber-400">
                                        <?php echo e(number_format($book->price, 2, ',', '.')); ?> €
                                    </p>
                                    <?php if($book->reviews_count > 0): ?>
                                        <div class="flex items-center gap-1.5">
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
                                                <?php echo e(number_format($book->average_rating, 1)); ?>

                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                    <form method="POST" action="<?php echo e(localized_route('cart.add', $book)); ?>" class="flex-1">
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
<?php $component->withAttributes(['type' => 'submit','variant' => 'secondary','class' => 'w-full text-xs']); ?>
                                            <?php echo e(__('common.books.add_to_cart')); ?>

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
                                    <form method="POST" action="<?php echo e(localized_route('books.checkout', $book)); ?>" class="flex-1">
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
<?php $component->withAttributes(['type' => 'submit','class' => 'w-full text-xs']); ?>
                                            <?php echo e(__('common.books.buy')); ?>

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
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/store/books/index.blade.php ENDPATH**/ ?>