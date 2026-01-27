@extends('layouts.site')

@section('title', 'Libros')

@section('content')
    <section 
        x-data="scrollReveal(0)"
        class="px-4 sm:px-5 md:px-8 py-6 sm:py-8 md:py-12 max-w-6xl mx-auto"
    >
        <div 
            class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 sm:gap-6 mb-6 sm:mb-8"
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div>
                <div class="inline-flex items-center gap-2 mb-2 sm:mb-3">
                    <x-icons.book class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400" />
                    <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                        {{ __('common.home.catalog') }}
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl lg:text-5xl tracking-tight">
                    {{ __('common.books.title') }}
                </h1>
                <p class="mt-2 sm:mt-3 text-xs sm:text-sm text-zinc-400 max-w-md">
                    {{ __('common.books.description') }}
                </p>
            </div>
        </div>

        @if ($books->isEmpty())
            <p class="text-xs sm:text-sm text-zinc-500">
                Aún no hay libros activos. Vuelve pronto.
            </p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">
                @foreach ($books as $index => $book)
                    <article 
                        class="group border border-zinc-800 rounded-2xl sm:rounded-3xl overflow-hidden bg-zinc-900/40 hover:bg-zinc-900/80 hover:border-zinc-700 transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl hover:shadow-black/50 flex flex-col"
                        :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        x-data="scrollReveal({{ ($index + 1) * 100 }})"
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        x-transition:enter-end="opacity-100 translate-y-0"
                    >
                        @php
                            $allImages = $book->getAllImages();
                            $imagesArray = $allImages->toArray();
                        @endphp
                        <div class="relative overflow-hidden">
                            @if($allImages->isNotEmpty())
                                <div 
                                    x-data="{
                                        currentIndex: 0,
                                        images: @js($imagesArray),
                                        touchStartX: 0,
                                        touchEndX: 0,
                                        next() {
                                            if (this.images.length > 1) {
                                                this.currentIndex = (this.currentIndex + 1) % this.images.length;
                                            }
                                        },
                                        prev() {
                                            if (this.images.length > 1) {
                                                this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                                            }
                                        },
                                        handleTouchStart(e) {
                                            this.touchStartX = e.touches[0].clientX;
                                        },
                                        handleTouchEnd(e) {
                                            this.touchEndX = e.changedTouches[0].clientX;
                                            const diff = this.touchStartX - this.touchEndX;
                                            if (Math.abs(diff) > 50) {
                                                if (diff > 0) {
                                                    this.next();
                                                } else {
                                                    this.prev();
                                                }
                                            }
                                        }
                                    }"
                                    class="relative aspect-[3/4] bg-zinc-900 cursor-pointer"
                                    @touchstart="handleTouchStart"
                                    @touchend="handleTouchEnd"
                                >
                                    <a href="{{ localized_route('books.show', $book) }}" class="block relative w-full h-full" aria-label="Ver detalles de {{ $book->title }}">
                                        <div class="relative w-full h-full">
                                            <template x-for="(image, index) in images" :key="index">
                                                <img 
                                                    :src="image.url"
                                                    :alt="image.alt"
                                                    class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 group-hover:scale-110 transition-transform duration-700"
                                                    :class="currentIndex === index ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                                                    loading="lazy"
                                                    width="300"
                                                    height="400"
                                                    x-on:error="$el.style.display = 'none'"
                                                >
                                            </template>
                                        </div>
                                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500" aria-hidden="true"></div>
                                    </a>
                                </div>
                            @else
                                <a href="{{ localized_route('books.show', $book) }}" class="block" aria-label="Ver detalles de {{ $book->title }}">
                                    <figure class="aspect-[3/4] bg-zinc-900 relative">
                                        <div class="w-full h-full flex items-center justify-center text-xs text-zinc-500" role="img" aria-label="Portada no disponible">
                                            <x-icons.book class="w-12 h-12 opacity-20" aria-hidden="true" />
                                        </div>
                                    </figure>
                                </a>
                            @endif
                        </div>
                        <div class="p-4 sm:p-5 md:p-6 flex-1 flex flex-col space-y-3 sm:space-y-4">
                            <div class="flex-1 space-y-2 sm:space-y-3">
                                <div class="text-[9px] sm:text-[10px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-500">
                                    Libro
                                </div>
                                <h2 class="text-sm sm:text-base font-semibold text-zinc-50 leading-tight group-hover:text-zinc-100 transition-colors">
                                    {{ $book->title }}
                                </h2>
                                <p class="text-xs text-zinc-400 line-clamp-3 leading-relaxed">
                                    {{ $book->description }}
                                </p>
                            </div>
                            <div class="space-y-2 sm:space-y-3 pt-2 border-t border-zinc-800">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-sm sm:text-base font-bold text-amber-400">
                                        {{ number_format($book->price, 2, ',', '.') }} €
                                    </p>
                                    @if($book->reviews_count > 0)
                                        <div class="flex items-center gap-1.5">
                                            <x-star-rating :rating="$book->average_rating" :maxRating="10" size="sm" />
                                            <span class="text-xs text-zinc-400">
                                                {{ number_format($book->average_rating, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                    <form method="POST" action="{{ localized_route('cart.add', $book) }}" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <x-button type="submit" variant="secondary" class="w-full text-xs">
                                            {{ __('common.books.add_to_cart') }}
                                        </x-button>
                                    </form>
                                    <form method="POST" action="{{ localized_route('books.checkout', $book) }}" class="flex-1">
                                        @csrf
                                        <x-button type="submit" class="w-full text-xs">
                                            {{ __('common.books.buy') }}
                                        </x-button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection

