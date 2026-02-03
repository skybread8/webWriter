<?php
    $post = $post ?? $blogPost ?? null;
?>
<div class="space-y-6">
    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            <?php echo e(__('common.admin.article_title')); ?>

        </label>
        <p class="text-xs text-zinc-500 mb-1">
            <?php echo e(__('common.admin.article_title_description')); ?>

        </p>
        <input
            type="text"
            name="title"
            value="<?php echo e(old('title', $post?->title)); ?>"
            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            required
        >
        <?php $__errorArgs = ['title'];
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

    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            <?php echo e(__('common.admin.article_excerpt')); ?>

        </label>
        <p class="text-xs text-zinc-500 mb-1">
            <?php echo e(__('common.admin.article_excerpt_description')); ?>

        </p>
        <textarea
            name="excerpt"
            rows="3"
            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
        ><?php echo e(old('excerpt', $post?->excerpt)); ?></textarea>
        <?php $__errorArgs = ['excerpt'];
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

    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            <?php echo e(__('common.admin.article_content')); ?>

        </label>
        <p class="text-xs text-zinc-500 mb-1">
            <?php echo e(__('common.admin.article_content_description')); ?>

        </p>
        <?php
            $contentValue = old('content', $post?->content ?? '');
            $contentForAttr = str_replace(['&', '"'], ['&amp;', '&quot;'], $contentValue);
        ?>
        <input id="content" type="hidden" name="content" value="<?php echo $contentForAttr; ?>">
        <script type="text/template" id="content-initial"><?php echo str_replace('</script>', '<\/script>', $contentValue); ?></script>
        <div class="trix-wrapper">
            <trix-editor input="content" class="trix-content"></trix-editor>
        </div>
        <script>
            document.addEventListener('trix-initialize', function(e) {
                if (e.target.getAttribute('input') !== 'content') return;
                var template = document.getElementById('content-initial');
                if (template && template.textContent && (!document.getElementById('content').value || document.getElementById('content').value.length < 5)) {
                    e.target.editor.loadHTML(template.textContent);
                }
            });
        </script>
        <?php $__errorArgs = ['content'];
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

    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            <?php echo e(__('common.admin.article_featured_image')); ?>

        </label>
        <p class="text-xs text-zinc-500 mb-1">
            <?php echo e(__('common.admin.article_featured_image_description')); ?>

        </p>
        <?php if($post?->featured_image): ?>
            <div class="mb-3">
                <img src="<?php echo e(get_image_url($post->featured_image)); ?>" alt="Imagen actual" class="max-h-40 rounded-lg border border-zinc-800 object-cover">
                <label for="remove_featured_image" class="flex items-center mt-2 text-sm text-zinc-400">
                    <input type="checkbox" name="remove_featured_image" id="remove_featured_image" value="1" class="rounded border-zinc-700 text-red-600 shadow-sm focus:ring-red-500">
                                    <span class="ml-2"><?php echo e(__('common.admin.remove_current_image')); ?></span>
                </label>
            </div>
        <?php endif; ?>
        <input
            type="file"
            name="featured_image"
            accept="image/*"
            class="block w-full text-xs text-zinc-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-900 hover:file:bg-white"
        >
        <?php $__errorArgs = ['featured_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="mt-3 space-y-2">
            <label class="block text-xs font-medium text-zinc-300">Texto alternativo SEO (imagen destacada)</label>
            <p class="text-xs text-zinc-500 mb-1">Palabras clave para buscadores (ej: &quot;Portada del artículo: [título]&quot;).</p>
            <input type="text" name="featured_image_alt" value="<?php echo e(old('featured_image_alt', $post?->featured_image_alt)); ?>" placeholder="Ej: Imagen del artículo <?php echo e($post?->title ?? ''); ?>" class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500">
            <?php $__errorArgs = ['featured_image_alt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                <?php echo e(__('common.admin.order')); ?>

            </label>
            <p class="text-xs text-zinc-500 mb-1">
                <?php echo e(__('common.admin.order_description')); ?>

            </p>
            <input
                type="number"
                name="order"
                value="<?php echo e(old('order', $post?->order ?? 0)); ?>"
                min="0"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            <?php $__errorArgs = ['order'];
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

        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                <?php echo e(__('common.admin.publish_date')); ?>

            </label>
            <p class="text-xs text-zinc-500 mb-1">
                <?php echo e(__('common.admin.publish_date_description')); ?>

            </p>
            <input
                type="datetime-local"
                name="published_at"
                value="<?php echo e(old('published_at', $post?->published_at ? $post->published_at->format('Y-m-d\TH:i') : '')); ?>"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            <?php $__errorArgs = ['published_at'];
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

        <div class="flex items-center gap-2 pt-6">
            <input
                type="checkbox"
                name="published"
                id="published"
                value="1"
                <?php echo e(old('published', $post?->published ?? false) ? 'checked' : ''); ?>

                class="rounded border-zinc-700 bg-zinc-900 text-zinc-100 focus:ring-zinc-500"
            >
            <label for="published" class="text-xs text-zinc-200">
                <?php echo e(__('common.admin.publish_article')); ?>

            </label>
        </div>
    </div>
</div>
<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/admin/blog/form.blade.php ENDPATH**/ ?>