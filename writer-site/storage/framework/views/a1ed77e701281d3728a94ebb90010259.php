<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'variant' => 'primary',
    'type' => 'submit',
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
    'variant' => 'primary',
    'type' => 'submit',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $base = 'inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full text-xs font-semibold tracking-wide uppercase transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-zinc-950';
    $variants = [
        'primary' => 'bg-zinc-100 text-zinc-950 hover:bg-white focus:ring-zinc-400',
        'secondary' => 'bg-zinc-800 text-zinc-100 border border-zinc-700 hover:bg-zinc-700 hover:border-zinc-600 focus:ring-zinc-500',
        'ghost' => 'bg-transparent text-zinc-100 border border-zinc-700 hover:border-zinc-500 hover:bg-zinc-900/60 focus:ring-zinc-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-500 focus:ring-red-500',
    ];
    $classes = $base.' '.($variants[$variant] ?? $variants['primary']);
?>

<button type="<?php echo e($type); ?>" <?php echo e($attributes->merge(['class' => $classes])); ?>>
    <?php echo e($slot); ?>

</button>
<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/components/button.blade.php ENDPATH**/ ?>