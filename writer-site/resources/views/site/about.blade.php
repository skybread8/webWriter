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
                        src="{{ get_image_url($page->image) }}" 
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

        <!-- Fotos con lectores -->
        @php
            $readerPhotos = \App\Models\ReaderPhoto::where('active', true)
                ->orderBy('order')
                ->orderBy('created_at', 'desc')
                ->get();
        @endphp

        @if($readerPhotos->isNotEmpty())
            <div class="mt-16 sm:mt-20">
                <div class="mb-6 sm:mb-8">
                    <p class="text-[11px] tracking-[0.3em] uppercase text-zinc-500 mb-2">
                        Lectores
                    </p>
                    <h2 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl tracking-tight">
                        Fotos con lectores
                    </h2>
                    <p class="text-sm text-zinc-400 mt-2">
                        Algunos lectores que han comprado mis libros y se han hecho una foto conmigo.
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($readerPhotos as $photo)
                        <figure class="group relative aspect-square overflow-hidden rounded-xl sm:rounded-2xl border border-zinc-800 bg-zinc-900/40 hover:border-zinc-700 transition-colors">
                            <img 
                                src="{{ $photo->photo_url }}" 
                                alt="{{ $photo->reader_name ?? 'Foto con lector' }}" 
                                class="w-full h-full object-cover"
                                loading="lazy"
                            >
                            @if($photo->reader_name || $photo->caption)
                                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/90 via-zinc-950/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3 sm:p-4">
                                    <div class="w-full">
                                        @if($photo->reader_name)
                                            <p class="text-xs sm:text-sm font-medium text-zinc-100 mb-1">
                                                {{ $photo->reader_name }}
                                            </p>
                                        @endif
                                        @if($photo->caption)
                                            <p class="text-[10px] sm:text-xs text-zinc-300 line-clamp-2">
                                                {{ $photo->caption }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </figure>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection

