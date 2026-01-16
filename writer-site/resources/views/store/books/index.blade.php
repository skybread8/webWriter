@extends('layouts.site')

@section('title', 'Libros')

@section('content')
    <section 
        x-data="scrollReveal(0)"
        class="px-4 sm:px-5 md:px-8 py-10 sm:py-14 md:py-20 max-w-6xl mx-auto"
    >
        <div 
            class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 sm:gap-6 mb-8 sm:mb-12"
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
                <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl lg:text-6xl tracking-tight">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                @foreach ($books as $index => $book)
                    <article 
                        class="group border border-zinc-800 rounded-2xl sm:rounded-3xl overflow-hidden bg-zinc-900/40 hover:bg-zinc-900/80 hover:border-zinc-700 transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl hover:shadow-black/50 flex flex-col"
                        :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        x-data="scrollReveal({{ ($index + 1) * 100 }})"
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        x-transition:enter-end="opacity-100 translate-y-0"
                    >
                        <a href="{{ localized_route('books.show', $book) }}" class="block relative overflow-hidden" aria-label="Ver detalles de {{ $book->title }}">
                            <figure class="aspect-[3/4] bg-zinc-900 relative">
                                @if($book->cover_image)
                                    <img 
                                        src="{{ get_image_url($book->cover_image) }}" 
                                        alt="Portada del libro {{ $book->title }}" 
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                        loading="lazy"
                                        width="300"
                                        height="400"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500" aria-hidden="true"></div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-zinc-500" role="img" aria-label="Portada no disponible">
                                        <x-icons.book class="w-12 h-12 opacity-20" aria-hidden="true" />
                                    </div>
                                @endif
                            </figure>
                        </a>
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
                                <p class="text-sm sm:text-base font-bold text-amber-400">
                                    {{ number_format($book->price, 2, ',', '.') }} €
                                </p>
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

