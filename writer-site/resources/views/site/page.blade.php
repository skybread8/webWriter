@extends('layouts.site')

@section('title', $page->title ?? 'Página')

@section('content')
    <section 
        x-data="scrollReveal(0)"
        class="px-5 sm:px-8 py-8 sm:py-12 max-w-4xl mx-auto"
    >
        <div 
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <h1 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl tracking-tight mb-6 text-center">
                {{ $page->title ?? 'Página' }}
            </h1>

            @if($page && $page->content)
                <div class="prose prose-invert prose-zinc max-w-none text-base leading-relaxed">
                    {!! $page->content !!}
                </div>
            @else
                <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center text-zinc-400">
                    Contenido pendiente. Edítalo desde el panel de administración.
                </div>
            @endif
        </div>
    </section>
@endsection
