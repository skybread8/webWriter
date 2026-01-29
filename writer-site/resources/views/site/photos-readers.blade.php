@extends('layouts.site')

@section('title', __('common.nav.photos_readers'))

@section('content')
    <section class="px-5 sm:px-8 py-8 sm:py-12 max-w-6xl mx-auto">
        <header class="mb-8 sm:mb-12 text-center">
            <p class="text-[11px] tracking-[0.3em] uppercase text-zinc-500 mb-2">
                {{ __('common.nav.photos_readers') }}
            </p>
            <h1 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl tracking-tight mb-4">
                Fotos con mis lectores
            </h1>
            <p class="text-sm sm:text-base text-zinc-400 max-w-2xl mx-auto">
                Algunos lectores que han comprado mis libros en el mercado y se han hecho una foto conmigo. ¡Gracias por vuestro apoyo!
            </p>
        </header>

        @if($photos->isEmpty())
            <div class="text-center py-12 sm:py-16">
                <svg class="w-16 h-16 text-zinc-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-sm text-zinc-500">
                    Aún no hay fotos disponibles. Vuelve pronto.
                </p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 sm:gap-6">
                @foreach($photos as $photo)
                    <figure class="group relative aspect-square overflow-hidden rounded-xl sm:rounded-2xl border border-zinc-800 bg-zinc-900/40 hover:border-zinc-700 transition-all duration-300 hover:shadow-xl hover:shadow-black/50">
                        <img 
                            src="{{ $photo->photo_url }}" 
                            alt="{{ $photo->photo_alt ?: ($photo->reader_name ?: 'Foto con lector') }}" 
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                            loading="lazy"
                        >
                        @if($photo->reader_name || $photo->caption)
                            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/95 via-zinc-950/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-3 sm:p-4">
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
        @endif

        <div class="mt-12 sm:mt-16 text-center">
            <a href="{{ localized_route('about') }}" class="inline-flex items-center gap-2 text-[10px] sm:text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100 transition-colors group">
                <x-icons.arrow-right class="w-3.5 h-3.5 sm:w-4 sm:h-4 rotate-180 transition-transform group-hover:-translate-x-1" />
                <span>Volver a "Sobre el autor"</span>
            </a>
        </div>
    </section>
@endsection
