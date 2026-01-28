@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ? $title . ' – ' : '' }}{{ config('app.name', 'Escritor') }}</title>

        <!-- Fuente más editorial -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600|dm-serif-display:400&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Trix para contenido enriquecido en páginas -->
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
        <script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js" defer></script>
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">
        <div class="min-h-screen flex">
            <aside class="hidden md:flex md:flex-col w-72 border-r border-zinc-800 bg-zinc-950/80 backdrop-blur">
                <div class="px-6 py-6 border-b border-zinc-800">
                    <div class="text-xs tracking-[0.3em] uppercase text-zinc-500 mb-2">Panel</div>
                    <div class="font-['DM_Serif_Display'] text-xl">
                        {{ optional(\App\Models\SiteSetting::first())->site_name ?? 'Autor' }}
                    </div>
                    <p class="text-xs text-zinc-500 mt-1">
                        Espacio privado para actualizar textos, libros e imágenes.
                    </p>
                </div>
                <nav class="flex-1 px-4 py-4 text-sm space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-900' : '' }}">
                        <span>Resumen general</span>
                    </a>
                    <a href="{{ route('admin.home.edit') }}" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 {{ request()->routeIs('admin.home.*') ? 'bg-zinc-900' : '' }}">
                        <span>Página de inicio</span>
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 {{ request()->routeIs('admin.books.*') ? 'bg-zinc-900' : '' }}">
                        <span>Libros</span>
                    </a>
                    <a href="{{ route('admin.testimonials.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 {{ request()->routeIs('admin.testimonials.*') ? 'bg-zinc-900' : '' }}">
                        <span>Testimonios</span>
                    </a>
                    <a href="{{ route('admin.faqs.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 {{ request()->routeIs('admin.faqs.*') ? 'bg-zinc-900' : '' }}">
                        <span>Preguntas frecuentes</span>
                    </a>
                    <a href="{{ route('admin.pages.about.edit') }}" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 {{ request()->routeIs('admin.pages.about.*') ? 'bg-zinc-900' : '' }}">
                        <span>Sobre el autor</span>
                    </a>
                    <a href="{{ route('admin.pages.contact.edit') }}" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 {{ request()->routeIs('admin.pages.contact.*') ? 'bg-zinc-900' : '' }}">
                        <span>Contacto</span>
                    </a>
                    <a href="{{ route('admin.settings.edit') }}" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-zinc-900 {{ request()->routeIs('admin.settings.*') ? 'bg-zinc-900' : '' }}">
                        <span>Datos generales</span>
                    </a>
                </nav>
                <div class="px-4 py-4 border-t border-zinc-800 text-xs text-zinc-500 space-y-2">
                    <div>Conectado como <span class="text-zinc-200">{{ auth()->user()->name }}</span></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="underline hover:text-zinc-200">Cerrar sesión</button>
                    </form>
                </div>
            </aside>

            <div class="flex-1 flex flex-col">
                <header class="md:hidden border-b border-zinc-800 px-4 py-3 flex items-center justify-between bg-zinc-950/90 backdrop-blur">
                    <div class="font-['DM_Serif_Display'] text-lg">
                        {{ optional(\App\Models\SiteSetting::first())->site_name ?? 'Autor' }}
                    </div>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form')?.submit();" class="text-xs underline hidden">
                        Cerrar sesión
                    </a>
                </header>

                <main class="flex-1 px-4 sm:px-8 py-8 max-w-5xl mx-auto">
                    @if (session('status'))
                        <div class="mb-6 rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-4 py-3 text-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>

