<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'description' => null,
    'image' => null,
    'image_alt' => null,
    'type' => 'website',
    'url' => null,
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
    'title' => null,
    'description' => null,
    'image' => null,
    'image_alt' => null,
    'type' => 'website',
    'url' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $settings = \App\Models\SiteSetting::first();
    $siteName = $settings?->site_name ?? 'Kevin Pérez Alarcón';
    $defaultDescription = 'Escritor independiente. Más de 5.000 libros vendidos en las calles. Novelas de misterio, terror, romance y drama.';
    $pageTitle = $title ? $title . ' – ' . $siteName : $siteName;
    $pageDescription = $description ?? $defaultDescription;
    $pageImage = $image ?? ($settings?->hero_image ? get_image_url($settings->hero_image) : asset('images/default-og.jpg'));
    $pageUrl = $url ?? url()->current();
?>

<!-- Primary Meta Tags -->
<title><?php echo e($pageTitle); ?></title>
<meta name="title" content="<?php echo e($pageTitle); ?>">
<meta name="description" content="<?php echo e($pageDescription); ?>">
<meta name="keywords" content="Kevin Pérez Alarcón, escritor, novelas, libros, autoedición, literatura española, misterio, terror, romance">
<meta name="author" content="<?php echo e($siteName); ?>">
<meta name="robots" content="index, follow">
<meta name="language" content="<?php echo e(app()->getLocale()); ?>">
<meta name="revisit-after" content="7 days">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="<?php echo e($type); ?>">
<meta property="og:url" content="<?php echo e($pageUrl); ?>">
<meta property="og:title" content="<?php echo e($pageTitle); ?>">
<meta property="og:description" content="<?php echo e($pageDescription); ?>">
<meta property="og:image" content="<?php echo e($pageImage); ?>">
<?php if($image_alt): ?>
<meta property="og:image:alt" content="<?php echo e($image_alt); ?>">
<?php endif; ?>
<meta property="og:site_name" content="<?php echo e($siteName); ?>">
<meta property="og:locale" content="<?php echo e(app()->getLocale() === 'es' ? 'es_ES' : (app()->getLocale() === 'ca' ? 'ca_ES' : 'en_US')); ?>">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="<?php echo e($pageUrl); ?>">
<meta name="twitter:title" content="<?php echo e($pageTitle); ?>">
<meta name="twitter:description" content="<?php echo e($pageDescription); ?>">
<meta name="twitter:image" content="<?php echo e($pageImage); ?>">
<?php if($image_alt): ?>
<meta name="twitter:image:alt" content="<?php echo e($image_alt); ?>">
<?php endif; ?>

<!-- Canonical URL -->
<link rel="canonical" href="<?php echo e($pageUrl); ?>">

<!-- Alternate languages -->
<link rel="alternate" hreflang="es" href="<?php echo e(str_replace(['/ca/', '/en/'], '/es/', $pageUrl)); ?>">
<link rel="alternate" hreflang="ca" href="<?php echo e(str_replace(['/es/', '/en/'], '/ca/', $pageUrl)); ?>">
<link rel="alternate" hreflang="en" href="<?php echo e(str_replace(['/es/', '/ca/'], '/en/', $pageUrl)); ?>">
<link rel="alternate" hreflang="x-default" href="<?php echo e(str_replace(['/ca/', '/en/'], '/es/', $pageUrl)); ?>">

<!-- Schema.org JSON-LD -->
<?php
    $socialLinks = [];
    if ($settings?->instagram_url) {
        $socialLinks[] = $settings->instagram_url;
    }
    if ($settings?->facebook_url) {
        $socialLinks[] = $settings->facebook_url;
    }
    if ($settings?->tiktok_url) {
        $socialLinks[] = $settings->tiktok_url;
    }
    
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'Person',
        'name' => $siteName,
        'jobTitle' => 'Escritor',
        'description' => $pageDescription,
        'url' => url('/'),
    ];
    
    if (!empty($socialLinks)) {
        $schemaData['sameAs'] = $socialLinks;
    }
?>
<script type="application/ld+json">
<?php echo json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

</script>
<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/components/seo-meta.blade.php ENDPATH**/ ?>