@extends('layouts.site')

@section('title', 'Libros')

@section('content')
    <section 
        x-data="scrollReveal(0)"
        class="px-5 sm:px-8 py-14 sm:py-20 max-w-6xl mx-auto"
    >
        <div 
            class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-12"
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div>
                <div class="inline-flex items-center gap-2 mb-3">
                    <x-icons.book class="w-5 h-5 text-amber-400" />
                    <p class="text-[11px] tracking-[0.3em] uppercase text-zinc-400">
                        Catálogo
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-4xl sm:text-5xl md:text-6xl tracking-tight">
                    Libros disponibles
                </h1>
                <p class="mt-3 text-sm text-zinc-400 max-w-md">
                    Selección de títulos activos. Todos pueden comprarse de forma segura mediante Stripe Checkout.
                </p>
            </div>
        </div>

        @if ($books->isEmpty())
            <p class="text-sm text-zinc-500">
                Aún no hay libros activos. Vuelve pronto.
            </p>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach ($books as $index => $book)
                    <article 
                        class="group border border-zinc-800 rounded-3xl overflow-hidden bg-zinc-900/40 hover:bg-zinc-900/80 hover:border-zinc-700 transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl hover:shadow-black/50 flex flex-col"
                        :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        x-data="scrollReveal({{ ($index + 1) * 100 }})"
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        x-transition:enter-end="opacity-100 translate-y-0"
                    >
                        <a href="{{ route('books.show', $book) }}" class="block relative overflow-hidden" aria-label="Ver detalles de {{ $book->title }}">
                            <figure class="aspect-[3/4] bg-zinc-900 relative">
                                @if($book->cover_image)
                                    <img 
                                        src="{{ asset('storage/'.$book->cover_image) }}" 
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
                        <div class="p-5 sm:p-6 flex-1 flex flex-col space-y-4">
                            <div class="flex-1 space-y-3">
                                <div class="text-[10px] tracking-[0.3em] uppercase text-zinc-500">
                                    Libro
                                </div>
                                <h2 class="text-base font-semibold text-zinc-50 leading-tight group-hover:text-zinc-100 transition-colors">
                                    {{ $book->title }}
                                </h2>
                                <p class="text-xs text-zinc-400 line-clamp-3 leading-relaxed">
                                    {{ $book->description }}
                                </p>
                            </div>
                            <div class="space-y-3 pt-2 border-t border-zinc-800">
                                <p class="text-base font-bold text-amber-400">
                                    {{ number_format($book->price, 2, ',', '.') }} €
                                </p>
                                <div class="flex items-center gap-2">
                                    <form method="POST" action="{{ route('cart.add', $book) }}" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <x-button type="submit" variant="secondary" class="w-full text-xs">
                                            Añadir
                                        </x-button>
                                    </form>
                                    <form method="POST" action="{{ route('books.checkout', $book) }}" class="flex-1">
                                        @csrf
                                        <x-button type="submit" class="w-full text-xs">
                                            Comprar
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

