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
            @php
                $photosData = $photos->map(fn($p) => [
                    'url' => $p->photo_url,
                    'alt' => $p->photo_alt ?: $p->reader_name ?: 'Foto con lector',
                    'reader_name' => $p->reader_name,
                    'caption' => $p->caption,
                ])->values()->toArray();
            @endphp
            <div 
                x-data="{
                    photos: @js($photosData),
                    lightboxOpen: false,
                    currentIndex: 0,
                    openLightbox(index) {
                        this.currentIndex = index;
                        this.lightboxOpen = true;
                        document.body.style.overflow = 'hidden';
                    },
                    closeLightbox() {
                        this.lightboxOpen = false;
                        document.body.style.overflow = '';
                    },
                    next() {
                        this.currentIndex = (this.currentIndex + 1) % this.photos.length;
                    },
                    prev() {
                        this.currentIndex = (this.currentIndex - 1 + this.photos.length) % this.photos.length;
                    }
                }"
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 sm:gap-6"
            >
                @foreach($photos as $index => $photo)
                    <figure 
                        @click="openLightbox({{ $index }})"
                        class="group relative aspect-square overflow-hidden rounded-xl sm:rounded-2xl border border-zinc-800 bg-zinc-900/40 hover:border-zinc-700 transition-all duration-300 hover:shadow-xl hover:shadow-black/50 cursor-zoom-in"
                        role="button"
                        tabindex="0"
                        aria-label="Ver foto en grande"
                        @keydown.enter="openLightbox({{ $index }})"
                        @keydown.space.prevent="openLightbox({{ $index }})"
                    >
                        <img 
                            src="{{ $photo->photo_url }}" 
                            alt="{{ $photo->photo_alt ?: ($photo->reader_name ?: 'Foto con lector') }}" 
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105 pointer-events-none"
                            loading="lazy"
                        >
                        @if($photo->reader_name || $photo->caption)
                            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/95 via-zinc-950/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-3 sm:p-4 pointer-events-none">
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

                <!-- Lightbox -->
                <template x-teleport="body">
                    <div 
                        x-show="lightboxOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 p-4"
                        @click.self="closeLightbox()"
                        @keydown.escape.window="lightboxOpen && closeLightbox()"
                        @keydown.right.window="lightboxOpen && photos.length > 1 && next()"
                        @keydown.left.window="lightboxOpen && photos.length > 1 && prev()"
                        x-cloak
                        style="display: none;"
                    >
                        <button 
                            type="button"
                            @click="closeLightbox()"
                            class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-zinc-800 hover:bg-zinc-700 flex items-center justify-center text-zinc-100 transition-colors"
                            aria-label="Cerrar"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <template x-if="photos.length && lightboxOpen">
                            <div class="relative max-w-4xl max-h-[90vh] w-full flex items-center justify-center">
                                <img 
                                    :src="photos[currentIndex].url"
                                    :alt="photos[currentIndex].alt"
                                    class="max-w-full max-h-[90vh] w-auto object-contain rounded-lg shadow-2xl"
                                    @click.stop
                                >
                                <template x-if="photos[currentIndex].reader_name || photos[currentIndex].caption">
                                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 px-4 py-2 rounded-lg bg-zinc-900/90 text-center max-w-md">
                                        <p x-show="photos[currentIndex].reader_name" class="text-sm font-medium text-zinc-100" x-text="photos[currentIndex].reader_name"></p>
                                        <p x-show="photos[currentIndex].caption" class="text-xs text-zinc-400 mt-0.5" x-text="photos[currentIndex].caption"></p>
                                    </div>
                                </template>
                            </div>
                        </template>
                        <template x-if="photos.length > 1">
                            <div class="absolute inset-x-0 bottom-4 flex justify-center gap-2 z-10">
                                <button 
                                    @click.stop="prev()"
                                    class="w-10 h-10 rounded-full bg-zinc-800/90 hover:bg-zinc-700 flex items-center justify-center text-zinc-100"
                                    aria-label="Foto anterior"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <span class="flex items-center px-3 text-sm text-zinc-400" x-text="(currentIndex + 1) + ' / ' + photos.length"></span>
                                <button 
                                    @click.stop="next()"
                                    class="w-10 h-10 rounded-full bg-zinc-800/90 hover:bg-zinc-700 flex items-center justify-center text-zinc-100"
                                    aria-label="Foto siguiente"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </template>
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
