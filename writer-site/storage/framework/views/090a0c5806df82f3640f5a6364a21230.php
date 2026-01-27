<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'rating' => 0,
    'maxRating' => 10,
    'size' => 'md', // sm, md, lg
    'interactive' => false,
    'name' => 'rating',
]));

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

foreach (array_filter(([
    'rating' => 0,
    'maxRating' => 10,
    'size' => 'md', // sm, md, lg
    'interactive' => false,
    'name' => 'rating',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $sizes = [
        'sm' => 'w-4 h-4',
        'md' => 'w-5 h-5',
        'lg' => 'w-6 h-6',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
?>

<div class="flex items-center gap-0.5" <?php echo e($attributes); ?>>
    <?php if($interactive): ?>
        <div x-data="{ rating: <?php echo e($rating ?: 0); ?>, hoverRating: 0 }" class="flex items-center gap-0.5">
            <?php for($i = 1; $i <= $maxRating; $i++): ?>
                <button
                    type="button"
                    @click="rating = <?php echo e($i); ?>"
                    @mouseenter="hoverRating = <?php echo e($i); ?>"
                    @mouseleave="hoverRating = 0"
                    class="transition-colors focus:outline-none"
                    aria-label="Valorar <?php echo e($i); ?> de <?php echo e($maxRating); ?>"
                >
                    <svg 
                        class="<?php echo e($sizeClass); ?> transition-colors"
                        :class="(hoverRating >= <?php echo e($i); ?> || (!hoverRating && rating >= <?php echo e($i); ?>)) ? 'text-amber-400 fill-amber-400' : 'text-zinc-700 fill-zinc-700'"
                        fill="currentColor" 
                        viewBox="0 0 20 20"
                    >
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </button>
            <?php endfor; ?>
            <input type="hidden" name="<?php echo e($name); ?>" x-bind:value="rating" required>
        </div>
    <?php else: ?>
        <?php for($i = 1; $i <= $maxRating; $i++): ?>
            <?php if($i <= $rating): ?>
                <svg class="<?php echo e($sizeClass); ?> text-amber-400 fill-amber-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
            <?php else: ?>
                <svg class="<?php echo e($sizeClass); ?> text-zinc-700 fill-zinc-700" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if(isset($showNumber) && $showNumber): ?>
            <span class="ml-2 text-sm text-zinc-400"><?php echo e($rating); ?>/<?php echo e($maxRating); ?></span>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/components/star-rating.blade.php ENDPATH**/ ?>