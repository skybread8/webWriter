@php
    $settings = \App\Models\SiteSetting::first();
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $pageTitle = $settings?->site_name ?? 'Kevin Pérez Alarcón';
            if (View::hasSection('title')) {
                $pageTitle .= ' – ' . View::yieldContent('title');
            }
            $pageDescription = View::hasSection('description') 
                ? View::yieldContent('description') 
                : 'Escritor independiente. Más de 5.000 libros vendidos en las calles. Novelas de misterio, terror, romance y drama.';
        @endphp

        @hasSection('seo')
            @yield('seo')
        @else
            <x-seo-meta 
                :title="$pageTitle"
                :description="$pageDescription"
                :image="$settings?->hero_image ? asset('storage/'.$settings->hero_image) : null"
            />
        @endif

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600|dm-serif-display:400&display=swap" rel="stylesheet" />
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased font-['DM_Sans']">
        <div class="min-h-screen flex flex-col">
            <header class="px-5 sm:px-8 py-5 border-b border-zinc-800/80 flex items-center justify-between gap-6 sticky top-0 bg-zinc-950/80 backdrop-blur z-20" role="banner">
                <a href="{{ route('home') }}" class="group" aria-label="Ir a la página de inicio">
                    <div class="flex items-baseline gap-3">
                        <h1 class="font-['DM_Serif_Display'] text-xl sm:text-2xl tracking-tight group-hover:text-zinc-50 transition-colors">
                            {{ $settings?->site_name ?? 'Kevin Pérez Alarcón' }}
                        </h1>
                    </div>
                </a>

                <nav class="hidden lg:flex items-center gap-4 text-[11px] uppercase tracking-[0.25em] text-zinc-400" role="navigation" aria-label="Navegación principal">
                    <a href="{{ route('books.index.public') }}" class="flex items-center gap-1.5 {{ request()->routeIs('books.*') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Ver todos los libros">
                        <x-icons.book class="w-4 h-4" aria-hidden="true" />
                        <span>{{ __('common.nav.books') }}</span>
                    </a>
                    <a href="{{ route('about') }}" class="flex items-center gap-1.5 {{ request()->routeIs('about') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Sobre el autor">
                        <x-icons.user class="w-4 h-4" aria-hidden="true" />
                        <span>{{ __('common.nav.about') }}</span>
                    </a>
                    <a href="{{ route('offers') }}" class="flex items-center gap-1.5 {{ request()->routeIs('offers') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Ofertas y packs">
                        <span>{{ __('common.nav.offers') }}</span>
                    </a>
                    <a href="{{ route('blog') }}" class="flex items-center gap-1.5 {{ request()->routeIs('blog') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Blog">
                        <span>{{ __('common.nav.blog') }}</span>
                    </a>
                    <a href="{{ route('contact') }}" class="flex items-center gap-1.5 {{ request()->routeIs('contact') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Contacto">
                        <x-icons.envelope class="w-4 h-4" aria-hidden="true" />
                        <span>{{ __('common.nav.contact') }}</span>
                    </a>
                    @php
                        $cartCount = count(session()->get('cart', []));
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative flex items-center gap-1.5 {{ request()->routeIs('cart.*') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Carrito de compra{{ $cartCount > 0 ? ' (' . $cartCount . ' ' . ($cartCount === 1 ? 'artículo' : 'artículos') . ')' : '' }}">
                        <x-icons.shopping-cart class="w-4 h-4" aria-hidden="true" />
                        <span>{{ __('common.nav.cart') }}</span>
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1.5 text-[9px] font-semibold text-zinc-950 bg-amber-400 rounded-full" aria-label="{{ $cartCount }} {{ $cartCount === 1 ? 'artículo' : 'artículos' }} en el carrito">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    <x-language-switcher />
                </nav>
            </header>

            <main class="flex-1" role="main">
                @yield('content')
            </main>

            <footer class="border-t border-zinc-900/80 px-5 sm:px-8 py-8 text-[11px] text-zinc-500" role="contentinfo">
                <div class="max-w-6xl mx-auto">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div>
                            <h2 class="text-zinc-300 font-semibold mb-3 uppercase tracking-wider">{{ __('common.footer.navigation') }}</h2>
                            <ul class="space-y-2" role="list">
                                <li><a href="{{ route('books.index.public') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.books') }}</a></li>
                                <li><a href="{{ route('about') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.about') }}</a></li>
                                <li><a href="{{ route('offers') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.offers') }}</a></li>
                                <li><a href="{{ route('blog') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.blog') }}</a></li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="text-zinc-300 font-semibold mb-3 uppercase tracking-wider">{{ __('common.footer.information') }}</h2>
                            <ul class="space-y-2" role="list">
                                <li><a href="{{ route('faq') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.faq') }}</a></li>
                                <li><a href="{{ route('contact') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.contact') }}</a></li>
                                <li><a href="{{ route('photos.readers') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.photos_readers') }}</a></li>
                                <li><a href="{{ route('photos.books') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.photos_books') }}</a></li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="text-zinc-300 font-semibold mb-3 uppercase tracking-wider">{{ __('common.footer.social_media') }}</h2>
                            <ul class="space-y-2" role="list">
                                @if($settings?->instagram_url)
                                    <li><a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="Síguenos en Instagram">
                                        <x-icons.instagram class="w-4 h-4" aria-hidden="true" />
                                        <span>Instagram</span>
                                    </a></li>
                                @endif
                                @if($settings?->facebook_url)
                                    <li><a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="Síguenos en Facebook">
                                        <x-icons.facebook class="w-4 h-4" aria-hidden="true" />
                                        <span>Facebook</span>
                                    </a></li>
                                @endif
                                @if($settings?->tiktok_url)
                                    <li><a href="{{ $settings->tiktok_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="Síguenos en TikTok">
                                        <x-icons.tiktok class="w-4 h-4" aria-hidden="true" />
                                        <span>TikTok</span>
                                    </a></li>
                                @endif
                            </ul>
                        </div>
                        <div>
                            <h2 class="text-zinc-300 font-semibold mb-3 uppercase tracking-wider">{{ __('common.footer.contact') }}</h2>
                            @if($settings?->contact_email)
                                <p class="mb-2">
                                    <a href="mailto:{{ $settings->contact_email }}" class="hover:text-zinc-300 transition-colors">{{ $settings->contact_email }}</a>
                                </p>
                            @endif
                            <p class="text-zinc-600 text-[10px] mt-4">
                                {{ __('common.footer.designed_by') }} <span class="text-zinc-400">Skybread</span>
                            </p>
                        </div>
                    </div>
                    <div class="pt-6 border-t border-zinc-800 text-center">
                        <p>© {{ date('Y') }} {{ $settings?->site_name ?? 'Kevin Pérez Alarcón' }}. {{ __('common.footer.rights') }}</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>

