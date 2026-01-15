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

        <article class="prose prose-invert prose-zinc max-w-none text-sm leading-relaxed">
            @if($page && $page->content)
                {!! $page->content !!}
            @else
                <p>
                    Esta página está pensada para contar quién eres, cómo escribes y qué pueden esperar los lectores de tus libros.
                </p>
                <p>
                    Puedes editar este texto desde el panel privado, en la sección “Sobre el autor”.
                </p>
            @endif
        </article>
    </section>
@endsection

