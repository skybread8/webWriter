@extends('layouts.site')

@section('title', $book->title)

@section('content')
    <section 
        x-data="scrollReveal(0)"
        class="px-5 sm:px-8 py-14 sm:py-20 max-w-6xl mx-auto"
    >
        <div 
            class="grid md:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] gap-10 md:gap-16 items-start"
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div class="space-y-6">
                <figure class="aspect-[3/4] rounded-3xl border-2 border-zinc-800 overflow-hidden bg-zinc-900 shadow-2xl shadow-black/50">
                    @if($book->cover_image)
                        <img 
                            src="{{ asset('storage/'.$book->cover_image) }}" 
                            alt="Portada del libro {{ $book->title }} de Kevin Pérez Alarcón" 
                            class="w-full h-full object-cover"
                            loading="lazy"
                            width="400"
                            height="600"
                        >
                    @else
                        <div class="w-full h-full flex items-center justify-center text-xs text-zinc-500" role="img" aria-label="Portada no disponible">
                            <x-icons.book class="w-16 h-16 opacity-20" aria-hidden="true" />
                        </div>
                    @endif
                </figure>
                <div class="space-y-4">
                    <div class="p-4 rounded-2xl bg-zinc-900/60 border border-zinc-800">
                        <div class="mb-3">
                            <p class="text-[10px] tracking-[0.3em] uppercase text-zinc-500 mb-1">
                                Precio
                            </p>
                            <p class="text-2xl font-bold text-amber-400">
                                {{ number_format($book->price, 2, ',', '.') }} €
                            </p>
                        </div>
                        <p class="text-xs text-zinc-400 leading-relaxed">
                            Todo incluido: libro + dedicatoria (opcional) + marcapáginas + envío certificado (con seguro) + embalaje.
                        </p>
                    </div>
                    <div class="space-y-3">
                        <form method="POST" action="{{ route('cart.add', $book) }}">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <x-button type="submit" variant="secondary" class="w-full flex items-center justify-center gap-2">
                                <x-icons.shopping-cart class="w-4 h-4" />
                                <span>Añadir al carrito</span>
                            </x-button>
                        </form>
                        <form method="POST" action="{{ route('books.checkout', $book) }}">
                            @csrf
                            <x-button class="w-full flex items-center justify-center gap-2">
                                <span>Comprar ahora</span>
                                <x-icons.arrow-right class="w-4 h-4" />
                            </x-button>
                        </form>
                    </div>
                    @if (! $book->stripe_price_id)
                        <div class="p-3 rounded-xl bg-amber-900/20 border border-amber-800/50">
                            <p class="text-xs text-amber-300">
                                Este libro aún no tiene un precio de Stripe configurado. El botón de compra no estará activo hasta añadirlo desde el panel.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <div class="inline-flex items-center gap-2 mb-3">
                        <x-icons.book class="w-5 h-5 text-amber-400" />
                        <p class="text-[11px] tracking-[0.3em] uppercase text-zinc-400">
                            Libro
                        </p>
                    </div>
                    <h1 class="font-['DM_Serif_Display'] text-4xl sm:text-5xl md:text-6xl tracking-tight leading-tight">
                        {{ $book->title }}
                    </h1>
                </div>
                <p class="text-base text-zinc-300 leading-relaxed">
                    {{ $book->description }}
                </p>
                @if($book->long_description)
                    <div class="prose prose-invert prose-zinc max-w-none text-base leading-relaxed space-y-4">
                        {!! nl2br(e($book->long_description)) !!}
                    </div>
                @endif
                <a href="{{ route('books.index.public') }}" class="inline-flex items-center gap-2 text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100 transition-colors group">
                    <x-icons.arrow-right class="w-4 h-4 rotate-180 transition-transform group-hover:-translate-x-1" />
                    <span>Volver a todos los libros</span>
                </a>
            </div>
        </div>
    </section>
@endsection

