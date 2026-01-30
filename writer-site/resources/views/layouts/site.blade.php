@php
    $settings = \App\Models\SiteSetting::first();
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Favicon - Icono de libro -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

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
                :image="$settings?->hero_image ? get_image_url($settings->hero_image) : null"
                :image_alt="$settings?->hero_image_alt"
            />
        @endif

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600|dm-serif-display:400&display=swap" rel="stylesheet" />
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased font-['DM_Sans']" x-data="{ mobileMenuOpen: false }">
        <div class="min-h-screen flex flex-col">
            <header class="px-4 sm:px-5 md:px-8 py-4 sm:py-5 border-b border-zinc-800/80 flex items-center justify-between gap-4 sticky top-0 bg-zinc-950/80 backdrop-blur z-20" role="banner">
                <a href="{{ localized_route('home') }}" class="group flex-shrink-0" aria-label="Ir a la página de inicio">
                    <div class="flex items-baseline gap-2 sm:gap-3">
                        <h1 class="font-['DM_Serif_Display'] text-lg sm:text-xl md:text-2xl tracking-tight group-hover:text-zinc-50 transition-colors">
                            {{ $settings?->site_name ?? 'Kevin Pérez Alarcón' }}
                        </h1>
                    </div>
                </a>

                <!-- Menú móvil -->
                <div class="lg:hidden flex items-center gap-3">
                    @php
                        $cartCount = count(session()->get('cart', []));
                    @endphp
                    <a href="{{ localized_route('cart.index') }}" class="relative flex items-center text-zinc-400 hover:text-zinc-200 transition-colors" aria-label="Carrito de compra{{ $cartCount > 0 ? ' (' . $cartCount . ' ' . ($cartCount === 1 ? 'artículo' : 'artículos') . ')' : '' }}">
                        <x-icons.shopping-cart class="w-5 h-5" aria-hidden="true" />
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1.5 text-[9px] font-semibold text-zinc-950 bg-amber-400 rounded-full" aria-label="{{ $cartCount }} {{ $cartCount === 1 ? 'artículo' : 'artículos' }} en el carrito">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button
                                @click="open = !open"
                                class="flex items-center text-zinc-400 hover:text-zinc-200 transition-colors"
                                aria-label="Mi cuenta"
                                aria-expanded="false"
                                :aria-expanded="open"
                            >
                                <x-icons.user class="w-5 h-5" aria-hidden="true" />
                            </button>

                            <div
                                x-show="open"
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-zinc-900 border border-zinc-800 rounded-lg shadow-lg z-50"
                                role="menu"
                                aria-label="Menú de cuenta"
                                style="display: none;"
                            >
                                <a
                                    href="{{ localized_route('account.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors {{ request()->routeIs('account.index') ? 'bg-zinc-800 text-zinc-100' : '' }}"
                                    role="menuitem"
                                    @click="open = false"
                                >
                                    <x-icons.home class="w-4 h-4" aria-hidden="true" />
                                    <span class="text-[11px] uppercase tracking-[0.25em]">{{ __('common.account.dashboard') }}</span>
                                </a>
                                <a
                                    href="{{ localized_route('account.profile') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors {{ request()->routeIs('account.profile') ? 'bg-zinc-800 text-zinc-100' : '' }}"
                                    role="menuitem"
                                    @click="open = false"
                                >
                                    <x-icons.user class="w-4 h-4" aria-hidden="true" />
                                    <span class="text-[11px] uppercase tracking-[0.25em]">{{ __('common.account.my_profile') }}</span>
                                </a>
                                <a
                                    href="{{ localized_route('orders.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors {{ request()->routeIs('orders.*') ? 'bg-zinc-800 text-zinc-100' : '' }}"
                                    role="menuitem"
                                    @click="open = false"
                                >
                                    <x-icons.shopping-bag class="w-4 h-4" aria-hidden="true" />
                                    <span class="text-[11px] uppercase tracking-[0.25em]">{{ __('common.account.my_orders') }}</span>
                                </a>
                                <div class="border-t border-zinc-800"></div>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors w-full text-left"
                                        role="menuitem"
                                        @click="open = false"
                                    >
                                        <x-icons.logout class="w-4 h-4" aria-hidden="true" />
                                        <span class="text-[11px] uppercase tracking-[0.25em]">{{ __('common.nav.logout') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center text-zinc-400 hover:text-zinc-200 transition-colors" aria-label="Iniciar sesión">
                            <x-icons.user class="w-5 h-5" aria-hidden="true" />
                        </a>
                    @endauth
                    <button 
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="flex items-center justify-center w-10 h-10 text-zinc-400 hover:text-zinc-200 transition-colors"
                        aria-label="Abrir menú"
                        aria-expanded="false"
                        :aria-expanded="mobileMenuOpen"
                    >
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Menú desktop -->
                <nav class="hidden lg:flex items-center gap-3 xl:gap-4 text-[11px] uppercase tracking-[0.25em] text-zinc-400" role="navigation" aria-label="Navegación principal">
                    <a href="{{ localized_route('books.index.public') }}" class="flex items-center gap-1.5 {{ request()->routeIs('books.*') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Ver todos los libros">
                        <x-icons.book class="w-4 h-4" aria-hidden="true" />
                        <span>{{ __('common.nav.books') }}</span>
                    </a>
                    <a href="{{ localized_route('about') }}" class="flex items-center gap-1.5 {{ request()->routeIs('about') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Sobre el autor">
                        <x-icons.user class="w-4 h-4" aria-hidden="true" />
                        <span>{{ __('common.nav.about') }}</span>
                    </a>
                    <a href="{{ localized_route('photos.readers') }}" class="flex items-center gap-1.5 {{ request()->routeIs('photos.readers') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Fotos con lectores">
                        <x-icons.camera class="w-4 h-4" aria-hidden="true" />
                        <span>{{ __('common.nav.photos_readers') }}</span>
                    </a>
                    <a href="{{ localized_route('offers') }}" class="flex items-center gap-1.5 {{ request()->routeIs('offers') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Ofertas y packs">
                        <x-icons.gift class="w-4 h-4" aria-hidden="true" />
                        <span>{{ __('common.nav.offers') }}</span>
                    </a>
                    <a href="{{ localized_route('blog') }}" class="flex items-center gap-1.5 {{ request()->routeIs('blog') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Blog">
                        <x-icons.document-text class="w-4 h-4" aria-hidden="true" />
                        <span>{{ __('common.nav.blog') }}</span>
                    </a>
                    <a href="{{ localized_route('contact') }}" class="flex items-center gap-1.5 {{ request()->routeIs('contact') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Contacto">
                        <x-icons.envelope class="w-4 h-4" aria-hidden="true" />
                        <span>{{ __('common.nav.contact') }}</span>
                    </a>
                    @php
                        $cartCount = count(session()->get('cart', []));
                    @endphp
                    <a href="{{ localized_route('cart.index') }}" class="relative flex items-center gap-1.5 {{ request()->routeIs('cart.*') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors" aria-label="Carrito de compra{{ $cartCount > 0 ? ' (' . $cartCount . ' ' . ($cartCount === 1 ? 'artículo' : 'artículos') . ')' : '' }}">
                        <x-icons.shopping-cart class="w-4 h-4" aria-hidden="true" />
                        <span>{{ __('common.nav.cart') }}</span>
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1.5 text-[9px] font-semibold text-zinc-950 bg-amber-400 rounded-full" aria-label="{{ $cartCount }} {{ $cartCount === 1 ? 'artículo' : 'artículos' }} en el carrito">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button
                                @click="open = !open"
                                class="flex items-center gap-1.5 {{ request()->routeIs('account.*') || request()->routeIs('orders.*') ? 'text-zinc-100' : 'hover:text-zinc-200' }} transition-colors"
                                aria-label="Mi cuenta"
                                aria-expanded="false"
                                :aria-expanded="open"
                            >
                                <x-icons.user class="w-4 h-4" aria-hidden="true" />
                                <span class="hidden sm:inline text-[11px] uppercase tracking-[0.25em]">{{ __('common.nav.account') }}</span>
                                <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div
                                x-show="open"
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-zinc-900 border border-zinc-800 rounded-lg shadow-lg z-50"
                                role="menu"
                                aria-label="Menú de cuenta"
                                style="display: none;"
                            >
                                <a
                                    href="{{ localized_route('account.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors {{ request()->routeIs('account.index') ? 'bg-zinc-800 text-zinc-100' : '' }}"
                                    role="menuitem"
                                    @click="open = false"
                                >
                                    <x-icons.home class="w-4 h-4" aria-hidden="true" />
                                    <span class="text-[11px] uppercase tracking-[0.25em]">{{ __('common.account.dashboard') }}</span>
                                </a>
                                <a
                                    href="{{ localized_route('account.profile') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors {{ request()->routeIs('account.profile') ? 'bg-zinc-800 text-zinc-100' : '' }}"
                                    role="menuitem"
                                    @click="open = false"
                                >
                                    <x-icons.user class="w-4 h-4" aria-hidden="true" />
                                    <span class="text-[11px] uppercase tracking-[0.25em]">{{ __('common.account.my_profile') }}</span>
                                </a>
                                <a
                                    href="{{ localized_route('orders.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors {{ request()->routeIs('orders.*') ? 'bg-zinc-800 text-zinc-100' : '' }}"
                                    role="menuitem"
                                    @click="open = false"
                                >
                                    <x-icons.shopping-bag class="w-4 h-4" aria-hidden="true" />
                                    <span class="text-[11px] uppercase tracking-[0.25em]">{{ __('common.account.my_orders') }}</span>
                                </a>
                                <div class="border-t border-zinc-800"></div>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors w-full text-left"
                                        role="menuitem"
                                        @click="open = false"
                                    >
                                        <x-icons.logout class="w-4 h-4" aria-hidden="true" />
                                        <span class="text-[11px] uppercase tracking-[0.25em]">{{ __('common.nav.logout') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-1.5 hover:text-zinc-200 transition-colors" aria-label="Iniciar sesión">
                            <x-icons.user class="w-4 h-4" aria-hidden="true" />
                            <span class="hidden sm:inline text-[11px] uppercase tracking-[0.25em]">{{ __('common.nav.login') }}</span>
                        </a>
                    @endauth
                    <x-language-switcher />
                </nav>

                <!-- Menú móvil desplegable -->
                <nav 
                    x-show="mobileMenuOpen"
                    @click.away="mobileMenuOpen = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="lg:hidden absolute top-full left-0 right-0 bg-zinc-950 border-b border-zinc-800/80 shadow-xl z-10"
                    style="display: none;"
                    role="navigation"
                    aria-label="Navegación móvil"
                >
                    <div class="px-4 py-4 space-y-1">
                        <a href="{{ localized_route('books.index.public') }}" class="flex items-center gap-2 px-4 py-3 rounded-lg {{ request()->routeIs('books.*') ? 'bg-zinc-900 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-900 hover:text-zinc-200' }} transition-colors">
                            <x-icons.book class="w-4 h-4" aria-hidden="true" />
                            <span class="text-sm">{{ __('common.nav.books') }}</span>
                        </a>
                        <a href="{{ localized_route('about') }}" class="flex items-center gap-2 px-4 py-3 rounded-lg {{ request()->routeIs('about') ? 'bg-zinc-900 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-900 hover:text-zinc-200' }} transition-colors">
                            <x-icons.user class="w-4 h-4" aria-hidden="true" />
                            <span class="text-sm">{{ __('common.nav.about') }}</span>
                        </a>
                        <a href="{{ localized_route('photos.readers') }}" class="flex items-center gap-2 px-4 py-3 rounded-lg {{ request()->routeIs('photos.readers') ? 'bg-zinc-900 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-900 hover:text-zinc-200' }} transition-colors">
                            <x-icons.camera class="w-4 h-4" aria-hidden="true" />
                            <span class="text-sm">{{ __('common.nav.photos_readers') }}</span>
                        </a>
                        <a href="{{ localized_route('offers') }}" class="flex items-center gap-2 px-4 py-3 rounded-lg {{ request()->routeIs('offers') ? 'bg-zinc-900 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-900 hover:text-zinc-200' }} transition-colors">
                            <x-icons.gift class="w-4 h-4" aria-hidden="true" />
                            <span class="text-sm">{{ __('common.nav.offers') }}</span>
                        </a>
                        <a href="{{ localized_route('blog') }}" class="flex items-center gap-2 px-4 py-3 rounded-lg {{ request()->routeIs('blog') ? 'bg-zinc-900 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-900 hover:text-zinc-200' }} transition-colors">
                            <x-icons.document-text class="w-4 h-4" aria-hidden="true" />
                            <span class="text-sm">{{ __('common.nav.blog') }}</span>
                        </a>
                        <a href="{{ localized_route('contact') }}" class="flex items-center gap-2 px-4 py-3 rounded-lg {{ request()->routeIs('contact') ? 'bg-zinc-900 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-900 hover:text-zinc-200' }} transition-colors">
                            <x-icons.envelope class="w-4 h-4" aria-hidden="true" />
                            <span class="text-sm">{{ __('common.nav.contact') }}</span>
                        </a>
                        <div class="pt-2 border-t border-zinc-800 mt-2">
                            <div class="px-4 py-2">
                                <x-language-switcher />
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <main class="flex-1" role="main">
                @yield('content')
            </main>

            <footer class="border-t border-zinc-900/80 px-4 sm:px-5 md:px-8 py-6 sm:py-8 text-[10px] sm:text-[11px] text-zinc-500" role="contentinfo">
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-4 sm:mb-6">
                        <div>
                            <h2 class="text-zinc-300 font-semibold mb-3 uppercase tracking-wider">{{ __('common.footer.navigation') }}</h2>
                            <ul class="space-y-2" role="list">
                                <li><a href="{{ localized_route('books.index.public') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.books') }}</a></li>
                                <li><a href="{{ localized_route('about') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.about') }}</a></li>
                                <li><a href="{{ localized_route('photos.readers') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.photos_readers') }}</a></li>
                                <li><a href="{{ localized_route('offers') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.offers') }}</a></li>
                                <li><a href="{{ localized_route('blog') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.blog') }}</a></li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="text-zinc-300 font-semibold mb-3 uppercase tracking-wider">{{ __('common.footer.information') }}</h2>
                            <ul class="space-y-2" role="list">
                                <li><a href="{{ localized_route('faq') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.faq') }}</a></li>
                                <li><a href="{{ localized_route('contact') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.contact') }}</a></li>
                                <li><a href="{{ localized_route('photos.readers') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.photos_readers') }}</a></li>
                                <li><a href="{{ localized_route('photos.books') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.nav.photos_books') }}</a></li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="text-zinc-300 font-semibold mb-3 uppercase tracking-wider">{{ __('common.footer.social_media') }}</h2>
                            <ul class="space-y-2" role="list">
                                @if($settings?->instagram_url)
                                    <li><a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="{{ __('common.social.instagram') }}">
                                        <x-icons.instagram class="w-4 h-4" aria-hidden="true" />
                                        <span>Instagram</span>
                                    </a></li>
                                @endif
                                @if($settings?->facebook_url)
                                    <li><a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="{{ __('common.social.facebook') }}">
                                        <x-icons.facebook class="w-4 h-4" aria-hidden="true" />
                                        <span>Facebook</span>
                                    </a></li>
                                @endif
                                @if($settings?->tiktok_url)
                                    <li><a href="{{ $settings->tiktok_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="{{ __('common.social.tiktok') }}">
                                        <x-icons.tiktok class="w-4 h-4" aria-hidden="true" />
                                        <span>TikTok</span>
                                    </a></li>
                                @endif
                                @if($settings?->twitter_url)
                                    <li><a href="{{ $settings->twitter_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="{{ __('common.social.twitter') }}">
                                        <x-icons.twitter class="w-4 h-4" aria-hidden="true" />
                                        <span>Twitter/X</span>
                                    </a></li>
                                @endif
                                @if($settings?->youtube_url)
                                    <li><a href="{{ $settings->youtube_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="{{ __('common.social.youtube') }}">
                                        <x-icons.youtube class="w-4 h-4" aria-hidden="true" />
                                        <span>YouTube</span>
                                    </a></li>
                                @endif
                                @if($settings?->linkedin_url)
                                    <li><a href="{{ $settings->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="{{ __('common.social.linkedin') }}">
                                        <x-icons.linkedin class="w-4 h-4" aria-hidden="true" />
                                        <span>LinkedIn</span>
                                    </a></li>
                                @endif
                                @if($settings?->pinterest_url)
                                    <li><a href="{{ $settings->pinterest_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-300 transition-colors flex items-center gap-2" aria-label="{{ __('common.social.pinterest') }}">
                                        <x-icons.pinterest class="w-4 h-4" aria-hidden="true" />
                                        <span>Pinterest</span>
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
                    <div class="pt-4 sm:pt-6 border-t border-zinc-800">
                        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-4 text-[10px] sm:text-xs text-zinc-500 mb-2 sm:mb-3">
                            <a href="{{ localized_route('legal.privacy') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.legal.privacy_title') }}</a>
                            <span class="hidden sm:inline">•</span>
                            <a href="{{ localized_route('legal.terms') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.legal.terms_title') }}</a>
                            <span class="hidden sm:inline">•</span>
                            <a href="{{ localized_route('legal.notice') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.legal.notice_title') }}</a>
                            <span class="hidden sm:inline">•</span>
                            <a href="{{ localized_route('legal.cookies') }}" class="hover:text-zinc-300 transition-colors">{{ __('common.legal.cookies_title') }}</a>
                        </div>
                        <p class="text-center text-[10px] sm:text-xs text-zinc-500">
                            © {{ date('Y') }} {{ $settings?->site_name ?? 'Kevin Pérez Alarcón' }}. {{ __('common.footer.rights') }}
                        </p>
                    </div>
                </div>
            </footer>
        </div>

        <x-cookie-banner />
        @stack('scripts')
    </body>
</html>

