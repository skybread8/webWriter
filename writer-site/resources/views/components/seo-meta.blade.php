@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'image_alt' => null,
    'type' => 'website',
    'url' => null,
])

@php
    $settings = \App\Models\SiteSetting::first();
    $siteName = $settings?->site_name ?? 'Kevin Pérez Alarcón';
    $defaultDescription = 'Escritor independiente. Más de 5.000 libros vendidos en las calles. Novelas de misterio, terror, romance y drama.';
    $pageTitle = $title ? $title . ' – ' . $siteName : $siteName;
    $pageDescription = $description ?? $defaultDescription;
    $pageImage = $image ?? ($settings?->hero_image ? get_image_url($settings->hero_image) : asset('images/default-og.jpg'));
    $pageUrl = $url ?? url()->current();
@endphp

<!-- Primary Meta Tags -->
<title>{{ $pageTitle }}</title>
<meta name="title" content="{{ $pageTitle }}">
<meta name="description" content="{{ $pageDescription }}">
<meta name="keywords" content="Kevin Pérez Alarcón, escritor, novelas, libros, autoedición, literatura española, misterio, terror, romance">
<meta name="author" content="{{ $siteName }}">
<meta name="robots" content="index, follow">
<meta name="language" content="{{ app()->getLocale() }}">
<meta name="revisit-after" content="7 days">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $pageUrl }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:image" content="{{ $pageImage }}">
@if($image_alt)
<meta property="og:image:alt" content="{{ $image_alt }}">
@endif
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="{{ app()->getLocale() === 'es' ? 'es_ES' : (app()->getLocale() === 'ca' ? 'ca_ES' : 'en_US') }}">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $pageUrl }}">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ $pageImage }}">
@if($image_alt)
<meta name="twitter:image:alt" content="{{ $image_alt }}">
@endif

<!-- Canonical URL -->
<link rel="canonical" href="{{ $pageUrl }}">

<!-- Alternate languages -->
<link rel="alternate" hreflang="es" href="{{ str_replace(['/ca/', '/en/'], '/es/', $pageUrl) }}">
<link rel="alternate" hreflang="ca" href="{{ str_replace(['/es/', '/en/'], '/ca/', $pageUrl) }}">
<link rel="alternate" hreflang="en" href="{{ str_replace(['/es/', '/ca/'], '/en/', $pageUrl) }}">
<link rel="alternate" hreflang="x-default" href="{{ str_replace(['/ca/', '/en/'], '/es/', $pageUrl) }}">

<!-- Schema.org JSON-LD -->
@php
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
@endphp
<script type="application/ld+json">
{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
