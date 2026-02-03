<?php if (isset($component)) { $__componentOriginal7651faf8e4a1e278424aad70c82de3ba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7651faf8e4a1e278424aad70c82de3ba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layout','data' => ['title' => 'Blog']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Blog']); ?>
    <div class="space-y-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Blog</div>
                <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                    Artículos del blog
                </h1>
                <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                    Gestiona los artículos de tu blog. Puedes crear, editar y publicar contenido.
                </p>
            </div>
            <div class="shrink-0">
                <a href="<?php echo e(route('admin.blog.create')); ?>" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-zinc-100 text-zinc-950 text-sm font-semibold tracking-wide uppercase hover:bg-white transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-zinc-100/20">
                    Añadir artículo
                </a>
            </div>
        </div>

        <?php if($posts->isEmpty()): ?>
            <p class="text-sm text-zinc-500">
                <?php echo e(__('common.admin.no_articles')); ?>

            </p>
        <?php else: ?>
            <div class="mb-4 p-3 bg-zinc-900/40 border border-zinc-800 rounded-lg">
                <p class="text-xs text-zinc-400">
                    💡 <strong><?php echo e(__('common.admin.order_articles')); ?>:</strong> <?php echo e(__('common.admin.order_articles_description')); ?>

                </p>
            </div>
            <div class="space-y-3" id="posts-list">
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border border-zinc-800 rounded-2xl px-4 py-3 bg-zinc-900/40" data-id="<?php echo e($post->id); ?>">
                        <div class="flex items-start gap-3 flex-1">
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-xs text-zinc-500 w-8">#<?php echo e($post->order); ?></span>
                                <input 
                                    type="number" 
                                    value="<?php echo e($post->order); ?>" 
                                    min="0"
                                    class="w-16 px-2 py-1 text-xs bg-zinc-950 border border-zinc-800 rounded text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                                    onchange="updatePostOrder(<?php echo e($post->id); ?>, this.value)"
                                >
                            </div>
                            <?php if($post->featured_image): ?>
                                <img src="<?php echo e(get_image_url($post->featured_image)); ?>" alt="<?php echo e($post->title); ?>" class="w-16 h-16 rounded-md object-cover border border-zinc-800 shrink-0">
                            <?php else: ?>
                                <div class="w-16 h-16 rounded-md border border-dashed border-zinc-700 flex items-center justify-center text-[10px] text-zinc-600 shrink-0">
                                    Sin imagen
                                </div>
                            <?php endif; ?>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h2 class="text-sm font-medium text-zinc-50"><?php echo e($post->title); ?></h2>
                                    <?php if($post->published): ?>
                                        <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-2 py-0.5 text-[10px] font-medium text-emerald-300">
                                            <?php echo e(__('common.admin.published')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center rounded-full bg-zinc-800 px-2 py-0.5 text-[10px] font-medium text-zinc-400">
                                            <?php echo e(__('common.admin.draft')); ?>

                                        </span>
                                    <?php endif; ?>
                                    <?php if($post->published_at): ?>
                                        <span class="text-xs text-zinc-500">
                                            <?php echo e($post->published_at->format('d/m/Y')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                <?php if($post->excerpt): ?>
                                    <p class="text-xs text-zinc-400 line-clamp-2 mt-1">
                                        <?php echo e($post->excerpt); ?>

                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 justify-end shrink-0 flex-wrap">
                            <a href="<?php echo e(url('admin/blog/'.$post->id)); ?>" class="text-xs text-zinc-300 hover:text-zinc-100 underline underline-offset-4">
                                Vista previa
                            </a>
                            <a href="<?php echo e(url('admin/blog/'.$post->id.'/edit')); ?>" class="text-xs text-zinc-200 underline underline-offset-4">
                                <?php echo e(__('common.admin.edit')); ?>

                            </a>
                            <form method="POST" action="<?php echo e(url('admin/blog/'.$post->id)); ?>" class="inline" onsubmit="return confirm(<?php echo e(json_encode(__('common.admin.confirm_delete_article'))); ?>);">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full text-xs font-semibold tracking-wide uppercase transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-zinc-950 bg-red-600 text-white hover:bg-red-500 focus:ring-red-500">
                                    <?php echo e(__('common.admin.delete')); ?>

                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <script>
                function updatePostOrder(postId, order) {
                    fetch('<?php echo e(route("admin.blog.update-order")); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({
                            posts: [{ id: postId, order: parseInt(order) }]
                        })
                    }).then(() => {
                        location.reload();
                    });
                }
            </script>
        <?php endif; ?>
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
<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/admin/blog/index.blade.php ENDPATH**/ ?>