<?php $__env->startSection('title', $post->title); ?>

<?php $__env->startSection('seo'); ?>
    <?php
        $settings = \App\Models\SiteSetting::first();
        $siteName = $settings?->site_name ?? 'Kevin Pérez Alarcón';
        $seoTitle = $siteName . ' – ' . $post->title;
        $seoDescription = $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 160);
        $seoImage = $post->featured_image ? get_image_url($post->featured_image) : ($settings?->hero_image ? get_image_url($settings->hero_image) : null);
        $seoImageAlt = $post->featured_image_alt ?: $post->title;
    ?>
    <?php if (isset($component)) { $__componentOriginal84f9df3f620371229981225e7ba608d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal84f9df3f620371229981225e7ba608d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seo-meta','data' => ['title' => $seoTitle,'description' => $seoDescription,'image' => $seoImage,'imageAlt' => $seoImageAlt,'type' => 'article']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo-meta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoTitle),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoDescription),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoImage),'image_alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seoImageAlt),'type' => 'article']); ?>
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
        $articleSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => $seoDescription,
            'author' => ['@type' => 'Person', 'name' => $siteName],
            'url' => url()->current(),
            'datePublished' => $post->published_at?->toIso8601String(),
        ];
        if ($seoImage) {
            $articleSchema['image'] = $seoImage;
        }
    ?>
    <script type="application/ld+json"><?php echo json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="px-5 sm:px-8 py-8 sm:py-12 max-w-4xl mx-auto">
        <article class="opacity-100">
            
            <header class="mb-10">
                <?php if($post->published_at): ?>
                    <time class="text-[11px] tracking-[0.3em] uppercase text-zinc-500 mb-3 block" datetime="<?php echo e($post->published_at->toIso8601String()); ?>">
                        <?php echo e($post->published_at->format('d M Y')); ?>

                    </time>
                <?php endif; ?>
                <h1 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl tracking-tight mb-4 text-zinc-50">
                    <?php echo e($post->title); ?>

                </h1>
                <?php if($post->excerpt): ?>
                    <p class="text-lg text-zinc-300 leading-relaxed">
                        <?php echo e($post->excerpt); ?>

                    </p>
                <?php endif; ?>
            </header>

            
            <?php if($post->featured_image): ?>
                <figure class="mb-10 rounded-3xl overflow-hidden">
                    <img 
                        src="<?php echo e(get_image_url($post->featured_image)); ?>" 
                        alt="<?php echo e($post->featured_image_alt ?: $post->title); ?>" 
                        class="w-full h-auto object-cover"
                        loading="lazy"
                    >
                </figure>
            <?php endif; ?>

            
            <div class="prose prose-invert prose-zinc max-w-none text-base leading-relaxed prose-img:rounded-2xl prose-img:w-full prose-img:h-auto">
                <?php if($post->content): ?>
                    <?php echo $post->content; ?>

                <?php else: ?>
                    <p class="text-zinc-500 italic"><?php echo e(__('common.blog.no_content')); ?></p>
                <?php endif; ?>
            </div>

            
            <div class="mt-12 pt-8 border-t border-zinc-800">
                <a href="<?php echo e(localized_route('blog')); ?>" class="inline-flex items-center gap-2 text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100 transition-colors group">
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
                    <span><?php echo e(__('common.blog.back_to_blog')); ?></span>
                </a>
            </div>
        </article>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/site/blog/show.blade.php ENDPATH**/ ?>