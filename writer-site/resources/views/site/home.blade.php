@extends('layouts.site')

@section('title', 'Inicio')

@php
    /** @var \App\Models\SiteSetting|null $settings */
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books */
@endphp

@section('content')
    <!-- Hero Section con animaciones -->
    <section
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 100)"
        class="relative overflow-hidden"
    >
        <div class="relative min-h-[70vh] sm:min-h-[80vh] md:min-h-[85vh] lg:min-h-[90vh] flex items-center">
            @if($settings && $settings->hero_image)
                <div
                    class="absolute inset-0 pointer-events-none"
                    aria-hidden="true"
                >
                    <img
                        src="{{ asset('storage/'.$settings->hero_image) }}"
                        alt=""
                        class="w-full h-full object-cover opacity-75"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/80 to-zinc-950/40"></div>
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,transparent_0%,rgba(0,0,0,0.15)_100%)]"></div>
                </div>
            @endif

            <div class="relative z-10 px-4 sm:px-5 md:px-8 py-16 sm:py-20 md:py-32 max-w-6xl mx-auto w-full">
                <div class="space-y-6 sm:space-y-8 max-w-3xl" 
                     x-show="show" 
                     x-transition:enter="transition ease-out duration-1000"
                     x-transition:enter-start="opacity-0 translate-y-8"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 rounded-full bg-zinc-900/60 border border-zinc-800/50 backdrop-blur-sm">
                        <x-icons.book class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-amber-400" />
                        <p class="text-[10px] sm:text-[11px] tracking-[0.3em] sm:tracking-[0.35em] uppercase text-zinc-300">
                            {{ __('common.home.hero_subtitle') }}
                        </p>
                    </div>
                    <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl 2xl:text-8xl tracking-tight leading-[0.95]">
                        {!! nl2br(e($settings?->hero_text ?? 'Historias escritas en la sombra,<br>para leerse en silencio.')) !!}
                    </h1>
                    <p class="text-sm sm:text-base md:text-lg text-zinc-300 max-w-xl leading-relaxed">
                        Libros pensados para una lectura íntima, nocturna, casi en voz baja. Cada página es una conversación con el silencio.
                    </p>
                    <div class="pt-2 sm:pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                        <a href="{{ localized_route('books.index.public') }}" class="group inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 rounded-full bg-zinc-100 text-zinc-950 text-xs sm:text-sm font-semibold tracking-wide uppercase hover:bg-white transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-zinc-100/20">
                            <span>{{ __('common.home.explore_books') }}</span>
                            <x-icons.arrow-right class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform group-hover:translate-x-1" />
                        </a>
                        <a href="{{ localized_route('about') }}" class="inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 rounded-full border border-zinc-700 text-zinc-300 text-xs sm:text-sm font-medium tracking-wide uppercase hover:border-zinc-600 hover:text-zinc-100 hover:bg-zinc-900/40 transition-all duration-300">
                            <x-icons.user class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                            <span>{{ __('common.home.about_kevin') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Libros destacados con animación de scroll -->
    @if($books->isNotEmpty())
        <section 
            x-data="scrollReveal(100)"
            class="px-4 sm:px-5 md:px-8 py-12 sm:py-16 md:py-20 lg:py-28 border-t border-zinc-800/50 bg-gradient-to-b from-zinc-950 to-zinc-900/50"
        >
            <div class="max-w-7xl mx-auto">
                <div 
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-4 mb-8 sm:mb-12"
                    :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-y-6"
                    x-transition:enter-end="opacity-100 translate-y-0"
                >
                    <div>
                        <div class="inline-flex items-center gap-2 mb-2 sm:mb-3">
                            <x-icons.book class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400" />
                            <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.28em] uppercase text-zinc-400">
                                {{ __('common.home.catalog') }}
                            </p>
                        </div>
                        <h2 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl lg:text-6xl tracking-tight">
                            {{ __('common.home.featured_books') }}
                        </h2>
                        <p class="mt-2 sm:mt-3 text-xs sm:text-sm text-zinc-400 max-w-md">
                            {{ __('common.home.available_now') }}
                        </p>
                    </div>
                    <a href="{{ localized_route('books.index.public') }}" class="flex sm:hidden items-center gap-2 text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100 transition-colors group">
                        <span>{{ __('common.home.view_all') }}</span>
                        <x-icons.arrow-right class="w-4 h-4 transition-transform group-hover:translate-x-1" />
                    </a>
                    <a href="{{ localized_route('books.index.public') }}" class="hidden sm:flex items-center gap-2 text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100 transition-colors group">
                        <span>{{ __('common.home.view_all') }}</span>
                        <x-icons.arrow-right class="w-4 h-4 transition-transform group-hover:translate-x-1" />
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                    @foreach($books->take(6) as $index => $book)
                        <a 
                            href="{{ localized_route('books.show', $book) }}" 
                            class="group border border-zinc-800 rounded-3xl overflow-hidden bg-zinc-900/40 hover:bg-zinc-900/80 hover:border-zinc-700 transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl hover:shadow-black/50"
                            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                            x-data="scrollReveal({{ ($index + 1) * 100 }})"
                            x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                        >
                            <figure class="aspect-[3/4] overflow-hidden bg-zinc-900 relative">
                                @if($book->cover_image)
                                    <img 
                                        src="{{ asset('storage/'.$book->cover_image) }}" 
                                        alt="Portada del libro {{ $book->title }} de Kevin Pérez Alarcón" 
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
                            <div class="p-5 sm:p-6 space-y-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1">
                                        <div class="text-[10px] tracking-[0.3em] uppercase text-zinc-500 mb-1.5">
                                            {{ __('common.books.book') }}
                                        </div>
                                        <h3 class="text-base font-semibold text-zinc-50 leading-tight group-hover:text-zinc-100 transition-colors">
                                            {{ $book->title }}
                                        </h3>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-amber-400">
                                            {{ number_format($book->price, 2, ',', '.') }} €
                                        </p>
                                    </div>
                                </div>
                                <p class="text-xs text-zinc-400 line-clamp-2 leading-relaxed">
                                    {{ $book->description }}
                                </p>
                                <div class="pt-2 flex items-center gap-2 text-[10px] text-zinc-500 group-hover:text-zinc-400 transition-colors">
                                    <span>Ver detalles</span>
                                    <x-icons.arrow-right class="w-3 h-3 transition-transform group-hover:translate-x-1" />
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10 text-center sm:hidden">
                    <a href="{{ localized_route('books.index.public') }}" class="inline-flex items-center gap-2 text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100 transition-colors">
                        <span>Ver todos los libros</span>
                        <x-icons.arrow-right class="w-4 h-4" />
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Testimonios con animación de scroll -->
    @php
        $testimonials = \App\Models\Testimonial::where('active', true)->orderBy('order')->orderBy('created_at', 'desc')->take(3)->get();
    @endphp

    @if($testimonials->isNotEmpty())
        <section 
            x-data="scrollReveal(200)"
            class="px-5 sm:px-8 py-20 sm:py-28 border-t border-zinc-800/50 bg-zinc-950"
        >
            <div class="max-w-7xl mx-auto">
                <div 
                    class="text-center mb-12"
                    :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-y-6"
                    x-transition:enter-end="opacity-100 translate-y-0"
                >
                    <div class="inline-flex items-center gap-2 mb-3">
                        <x-icons.star class="w-5 h-5 text-amber-400" />
                        <p class="text-[11px] tracking-[0.28em] uppercase text-zinc-400">
                            {{ __('common.home.testimonials') }}
                        </p>
                    </div>
                    <h2 class="font-['DM_Serif_Display'] text-4xl sm:text-5xl md:text-6xl tracking-tight">
                        {{ __('common.home.what_readers_say') }}
                    </h2>
                    <p class="mt-3 text-sm text-zinc-400 max-w-md mx-auto">
                        {{ __('common.home.reviews_from') }}
                    </p>
                </div>
                <div class="grid sm:grid-cols-3 gap-6 lg:gap-8">
                    @foreach($testimonials as $index => $testimonial)
                        <div 
                            class="border border-zinc-800 rounded-3xl p-6 sm:p-8 bg-zinc-900/40 hover:bg-zinc-900/60 hover:border-zinc-700 transition-all duration-500 hover:scale-[1.02] space-y-5"
                            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                            x-data="scrollReveal({{ ($index + 1) * 150 }})"
                            x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                        >
                            <div class="flex items-center gap-4">
                                <img 
                                    src="{{ $testimonial->photo_url }}" 
                                    alt="{{ $testimonial->name }}" 
                                    class="w-14 h-14 rounded-full object-cover border-2 border-zinc-800 ring-2 ring-zinc-700"
                                >
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-zinc-50">{{ $testimonial->name }}</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <x-icons.star class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-zinc-700' }}" />
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-zinc-300 leading-relaxed">
                                "{{ $testimonial->review }}"
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA Final -->
    <section 
        x-data="scrollReveal(300)"
        class="px-5 sm:px-8 py-20 sm:py-28 border-t border-zinc-800/50 bg-gradient-to-b from-zinc-900/50 to-zinc-950"
    >
        <div class="max-w-4xl mx-auto text-center">
            <div 
                :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 translate-y-6"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="space-y-6"
            >
                <h2 class="font-['DM_Serif_Display'] text-4xl sm:text-5xl md:text-6xl tracking-tight">
                    {{ __('common.home.cta_title') }}
                </h2>
                <p class="text-base text-zinc-400 max-w-xl mx-auto">
                    {{ __('common.home.cta_description') }}
                </p>
                <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ localized_route('books.index.public') }}" class="group inline-flex items-center gap-2 px-8 py-4 rounded-full bg-zinc-100 text-zinc-950 text-sm font-semibold tracking-wide uppercase hover:bg-white transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-zinc-100/20">
                        <x-icons.book class="w-5 h-5" />
                        <span>{{ __('common.home.view_catalog') }}</span>
                        <x-icons.arrow-right class="w-4 h-4 transition-transform group-hover:translate-x-1" />
                    </a>
                    <a href="{{ localized_route('contact') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-full border border-zinc-700 text-zinc-300 text-sm font-medium tracking-wide uppercase hover:border-zinc-600 hover:text-zinc-100 hover:bg-zinc-900/40 transition-all duration-300">
                        <x-icons.envelope class="w-5 h-5" />
                        <span>{{ __('common.home.contact') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
