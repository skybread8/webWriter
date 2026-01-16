@extends('layouts.site')

@section('title', $book->title)

@section('content')
    <section 
        x-data="scrollReveal(0)"
        class="px-4 sm:px-5 md:px-8 py-10 sm:py-14 md:py-20 max-w-6xl mx-auto"
    >
        <div 
            class="grid grid-cols-1 md:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] gap-6 sm:gap-8 md:gap-10 lg:gap-16 items-start"
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div class="space-y-4 sm:space-y-6">
                <figure class="aspect-[3/4] max-w-xs mx-auto md:max-w-none rounded-2xl sm:rounded-3xl border-2 border-zinc-800 overflow-hidden bg-zinc-900 shadow-2xl shadow-black/50">
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
                <div class="space-y-3 sm:space-y-4">
                    <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-900/60 border border-zinc-800">
                        <div class="mb-2 sm:mb-3">
                            <p class="text-[9px] sm:text-[10px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-500 mb-1">
                                Precio
                            </p>
                            <p class="text-xl sm:text-2xl font-bold text-amber-400">
                                {{ number_format($book->price, 2, ',', '.') }} €
                            </p>
                        </div>
                        <p class="text-xs text-zinc-400 leading-relaxed">
                            {{ __('common.books.price_includes') }}
                        </p>
                    </div>
                    <div class="space-y-2 sm:space-y-3">
                        <form method="POST" action="{{ localized_route('cart.add', $book) }}">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <x-button type="submit" variant="secondary" class="w-full flex items-center justify-center gap-2 text-xs sm:text-sm">
                                <x-icons.shopping-cart class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                <span>{{ __('common.books.add_to_cart') }}</span>
                            </x-button>
                        </form>
                        <form method="POST" action="{{ localized_route('books.checkout', $book) }}">
                            @csrf
                            <x-button class="w-full flex items-center justify-center gap-2 text-xs sm:text-sm">
                                <span>{{ __('common.books.buy') }}</span>
                                <x-icons.arrow-right class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
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

            <div class="space-y-4 sm:space-y-6">
                <div>
                    <div class="inline-flex items-center gap-2 mb-2 sm:mb-3">
                        <x-icons.book class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400" />
                        <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                            Libro
                        </p>
                    </div>
                    <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl lg:text-6xl tracking-tight leading-tight">
                        {{ $book->title }}
                    </h1>
                </div>
                <p class="text-sm sm:text-base text-zinc-300 leading-relaxed">
                    {{ $book->description }}
                </p>
                @if($book->long_description)
                    <div class="prose prose-invert prose-zinc max-w-none text-sm sm:text-base leading-relaxed space-y-3 sm:space-y-4">
                        {!! $book->long_description !!}
                    </div>
                @endif
                <a href="{{ localized_route('books.index.public') }}" class="inline-flex items-center gap-2 text-[10px] sm:text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100 transition-colors group">
                    <x-icons.arrow-right class="w-3.5 h-3.5 sm:w-4 sm:h-4 rotate-180 transition-transform group-hover:-translate-x-1" />
                    <span>{{ __('common.books.back_to_books') }}</span>
                </a>
            </div>
        </div>

        <!-- Reseñas -->
        <div class="mt-12 sm:mt-16 space-y-6 sm:space-y-8">
            <div>
                <div class="inline-flex items-center gap-2 mb-2 sm:mb-3">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                        Reseñas
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                    <div>
                        <h2 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl tracking-tight">
                            Valoraciones de lectores
                        </h2>
                        @if(isset($book->reviews_count) && $book->reviews_count > 0)
                            <div class="flex items-center gap-3 mt-2">
                                <x-star-rating :rating="$book->average_rating" :maxRating="10" size="md" />
                                <span class="text-sm text-zinc-400">
                                    {{ number_format($book->average_rating, 1) }}/10
                                </span>
                                <span class="text-xs text-zinc-500">
                                    ({{ $book->reviews_count }} {{ $book->reviews_count === 1 ? 'reseña' : 'reseñas' }})
                                </span>
                            </div>
                        @else
                            <p class="text-xs sm:text-sm text-zinc-400 mt-2">Aún no hay reseñas para este libro</p>
                        @endif
                    </div>
                </div>
            </div>

            @if (session('status'))
                <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @auth
                <!-- Formulario de reseña -->
                <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base sm:text-lg font-semibold text-zinc-100">
                            {{ isset($userReview) && $userReview ? 'Editar tu reseña' : 'Escribe tu reseña' }}
                        </h3>
                        @if(isset($userReview) && $userReview && !$userReview->approved)
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-amber-900/40 text-amber-300 border border-amber-800/50">
                                Pendiente de aprobación
                            </span>
                        @endif
                    </div>
                    @if(isset($userReview) && $userReview && !$userReview->approved)
                        <div class="mb-4 rounded-xl border border-amber-600/40 bg-amber-900/20 text-amber-100 px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm">
                            Tu reseña está pendiente de aprobación. Se mostrará públicamente una vez que el administrador la apruebe.
                        </div>
                    @endif
                    <form method="POST" action="{{ localized_route('reviews.store', $book) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-zinc-300 mb-2">
                                Valoración (1-10 estrellas) <span class="text-red-400">*</span>
                            </label>
                            <x-star-rating 
                                :rating="isset($userReview) && $userReview ? $userReview->rating : 0" 
                                :maxRating="10" 
                                size="lg"
                                :interactive="true"
                                name="rating"
                            />
                            @error('rating')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="comment" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                Comentario (opcional)
                            </label>
                            <textarea 
                                id="comment" 
                                name="comment" 
                                rows="4"
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                placeholder="Comparte tu opinión sobre este libro..."
                            >{{ old('comment', isset($userReview) && $userReview ? $userReview->comment : '') }}</textarea>
                            @error('comment')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center gap-3">
                            <x-button type="submit" class="w-full sm:w-auto">
                                {{ isset($userReview) && $userReview ? 'Actualizar reseña' : 'Publicar reseña' }}
                            </x-button>
                            @if(isset($userReview) && $userReview)
                                <form method="POST" action="{{ localized_route('reviews.destroy', $userReview) }}" onsubmit="return confirm('¿Seguro que quieres eliminar tu reseña?');" class="sm:ml-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-400 hover:text-red-300 transition-colors underline underline-offset-4">
                                        Eliminar reseña
                                    </button>
                                </form>
                            @endif
                        </div>
                    </form>
                </div>
            @else
                <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40 text-center">
                    <p class="text-sm text-zinc-400 mb-3">Inicia sesión para dejar tu reseña</p>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm text-amber-400 hover:text-amber-300 transition-colors">
                        <span>Iniciar sesión</span>
                        <x-icons.arrow-right class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                    </a>
                </div>
            @endauth

            <!-- Lista de reseñas -->
            @if(isset($reviews) && $reviews->isNotEmpty())
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 rounded-full bg-zinc-800 flex items-center justify-center">
                                            <span class="text-sm font-semibold text-zinc-300">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-zinc-100">{{ $review->user->name }}</p>
                                            <p class="text-xs text-zinc-400">{{ $review->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <x-star-rating :rating="$review->rating" :maxRating="10" size="sm" />
                                </div>
                                @if(auth()->check() && auth()->id() === $review->user_id)
                                    <span class="px-2 py-1 rounded-full text-[10px] font-medium bg-amber-900/40 text-amber-300 border border-amber-800/50">
                                        Tu reseña
                                    </span>
                                @endif
                            </div>
                            @if($review->comment)
                                <p class="text-sm text-zinc-300 leading-relaxed whitespace-pre-wrap">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-8 sm:p-12 bg-zinc-900/40 text-center">
                    <svg class="w-12 h-12 text-zinc-700 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <p class="text-sm text-zinc-400">Aún no hay reseñas para este libro</p>
                </div>
            @endif
        </div>
    </section>
@endsection

