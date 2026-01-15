@php
    $currentLocale = app()->getLocale();
    $currentPath = request()->path();
    $locales = [
        'es' => ['name' => 'Español', 'flag' => '🇪🇸'],
        'ca' => ['name' => 'Català', 'flag' => '🇪🇸'],
        'en' => ['name' => 'English', 'flag' => '🇬🇧'],
    ];
@endphp

<div class="relative" x-data="{ open: false }">
    <button 
        @click="open = !open"
        class="flex items-center gap-2 text-[11px] uppercase tracking-[0.25em] text-zinc-400 hover:text-zinc-100 transition-colors"
        aria-label="Cambiar idioma"
        aria-expanded="false"
        :aria-expanded="open"
    >
        <span>{{ $locales[$currentLocale]['flag'] }}</span>
        <span class="hidden sm:inline">{{ strtoupper($currentLocale) }}</span>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        class="absolute right-0 mt-2 w-40 bg-zinc-900 border border-zinc-800 rounded-lg shadow-lg z-50"
        role="menu"
        aria-label="Selector de idioma"
    >
        @foreach($locales as $locale => $info)
            @php
                $path = $currentPath;
                // Remover prefijo de idioma actual si existe
                $path = preg_replace('#^/(es|ca|en)/#', '/', $path);
                $path = ltrim($path, '/');
                // Añadir nuevo prefijo
                $url = $locale === 'es' ? url($path ?: '/') : url($locale . '/' . $path);
            @endphp
            <a 
                href="{{ $url }}"
                class="flex items-center gap-2 px-4 py-2 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors {{ $currentLocale === $locale ? 'bg-zinc-800' : '' }}"
                role="menuitem"
                hreflang="{{ $locale }}"
            >
                <span>{{ $info['flag'] }}</span>
                <span>{{ $info['name'] }}</span>
                @if($currentLocale === $locale)
                    <span class="ml-auto text-amber-400">✓</span>
                @endif
            </a>
        @endforeach
    </div>
</div>
