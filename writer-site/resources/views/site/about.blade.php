@extends('layouts.site')

@section('title', $page?->title ?? 'Sobre el autor')

@section('content')
    <section class="px-5 sm:px-8 py-14 sm:py-20 max-w-4xl mx-auto">
        <header class="mb-8 sm:mb-10">
            <p class="text-[11px] tracking-[0.3em] uppercase text-zinc-500 mb-2">
                Sobre
            </p>
            <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl tracking-tight">
                {{ $page?->title ?? 'Sobre el autor' }}
            </h1>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_minmax(0,2fr)] gap-6 sm:gap-8 md:gap-10 items-start">
            @if($page && $page->image)
                <figure class="w-full max-w-xs mx-auto md:max-w-none">
                    <img 
                        src="{{ asset('storage/'.$page->image) }}" 
                        alt="Foto de {{ $page->title ?? 'Kevin Pérez Alarcón' }}" 
                        class="w-full rounded-2xl sm:rounded-3xl border-2 border-zinc-800 object-cover shadow-2xl shadow-black/50"
                        loading="lazy"
                    >
                </figure>
            @endif

            <article class="prose prose-invert prose-zinc max-w-none text-sm leading-relaxed">
                @if($page && $page->content)
                    {!! $page->content !!}
                @else
                    <p>
                        Esta página está pensada para contar quién eres, cómo escribes y qué pueden esperar los lectores de tus libros.
                    </p>
                    <p>
                        Puedes editar este texto desde el panel privado, en la sección "Sobre el autor".
                    </p>
                @endif
            </article>
        </div>
    </section>
@endsection

