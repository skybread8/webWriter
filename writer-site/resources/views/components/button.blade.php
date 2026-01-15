@props([
    'variant' => 'primary',
    'type' => 'submit',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full text-xs font-semibold tracking-wide uppercase transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-zinc-950';
    $variants = [
        'primary' => 'bg-zinc-100 text-zinc-950 hover:bg-white focus:ring-zinc-400',
        'secondary' => 'bg-zinc-800 text-zinc-100 border border-zinc-700 hover:bg-zinc-700 hover:border-zinc-600 focus:ring-zinc-500',
        'ghost' => 'bg-transparent text-zinc-100 border border-zinc-700 hover:border-zinc-500 hover:bg-zinc-900/60 focus:ring-zinc-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-500 focus:ring-red-500',
    ];
    $classes = $base.' '.($variants[$variant] ?? $variants['primary']);
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
