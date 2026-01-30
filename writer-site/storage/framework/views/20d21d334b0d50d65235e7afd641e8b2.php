<?php $__env->startSection('title', 'Blog'); ?>

<?php $__env->startSection('content'); ?>
    <section 
        x-data="scrollReveal(0)"
        class="px-5 sm:px-8 py-8 sm:py-12 max-w-6xl mx-auto"
    >
        <div 
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 mb-3">
                    <?php if (isset($component)) { $__componentOriginal285eddc9278dae58281aa961bf08a625 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal285eddc9278dae58281aa961bf08a625 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.book','data' => ['class' => 'w-5 h-5 text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-amber-400']); ?>
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
                    <p class="text-[11px] tracking-[0.28em] uppercase text-zinc-400">
                        Blog
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl tracking-tight">
                    <?php echo e(__('common.blog.title')); ?>

                </h1>
                <p class="mt-3 text-sm text-zinc-400 max-w-md mx-auto">
                    Artículos sobre escritura, experiencias y reflexiones
                </p>
            </div>

            <?php if($posts->isEmpty()): ?>
                <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center text-zinc-400">
                    <?php echo e(__('common.blog.no_posts')); ?>

                </div>
            <?php else: ?>
                <div class="space-y-8">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article 
                            class="border border-zinc-800 rounded-3xl overflow-hidden bg-zinc-900/40 hover:bg-zinc-900/60 hover:border-zinc-700 transition-all duration-500"
                            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                            x-data="scrollReveal(<?php echo e(($index + 1) * 100); ?>)"
                            x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                        >
                            <a href="<?php echo e(localized_route('blog.post', ['slug' => $post->slug])); ?>" class="block">
                                <div class="grid md:grid-cols-3 gap-6">
                                    <?php if($post->featured_image): ?>
                                        <figure class="md:col-span-1">
                                            <img 
                                                src="<?php echo e(get_image_url($post->featured_image)); ?>" 
                                                alt="<?php echo e($post->featured_image_alt ?: $post->title); ?>" 
                                                class="w-full h-48 md:h-full object-cover"
                                                loading="lazy"
                                                width="400"
                                                height="300"
                                            >
                                        </figure>
                                    <?php endif; ?>
                                    <div class="md:col-span-<?php echo e($post->featured_image ? '2' : '3'); ?> p-6 sm:p-8">
                                        <div class="text-[10px] tracking-[0.3em] uppercase text-zinc-500 mb-2">
                                            <?php echo e($post->published_at ? $post->published_at->format('d M Y') : ''); ?>

                                        </div>
                                        <h2 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl tracking-tight mb-3 group-hover:text-zinc-50 transition-colors">
                                            <?php echo e($post->title); ?>

                                        </h2>
                                        <?php if($post->excerpt): ?>
                                            <p class="text-sm text-zinc-400 line-clamp-3 mb-4">
                                                <?php echo e($post->excerpt); ?>

                                            </p>
                                        <?php endif; ?>
                                        <div class="flex items-center gap-2 text-[11px] text-zinc-500 group-hover:text-zinc-400 transition-colors">
                                            <span><?php echo e(__('common.blog.read_more')); ?></span>
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
                                </div>
                            </a>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-10">
                    <?php echo e($posts->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/site/blog/index.blade.php ENDPATH**/ ?>