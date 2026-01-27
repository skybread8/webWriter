@extends('layouts.site')

@section('title', $page?->title ?? 'Contacto')

@section('content')
    <section class="px-5 sm:px-8 py-8 sm:py-12 max-w-4xl mx-auto">
        <header class="mb-8 sm:mb-10 space-y-3">
            <div>
                <p class="text-[11px] tracking-[0.3em] uppercase text-zinc-500 mb-2">
                    Contacto
                </p>
                <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl tracking-tight">
                    {{ __('common.contact.title') }}
                </h1>
            </div>
            <div class="prose prose-invert prose-zinc max-w-none text-sm leading-relaxed">
                @if($page && $page->content)
                    {!! $page->content !!}
                @else
                    <p>
                        Usa este formulario para escribir un mensaje breve. Intentaremos responder con la mayor rapidez posible.
                    </p>
                @endif
            </div>
        </header>

        @if (session('status'))
            <div class="mb-6 rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ localized_route('contact.send') }}" class="space-y-5 max-w-xl">
            @csrf

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    {{ __('common.contact.name') }}
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                >
                @error('name')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    {{ __('common.contact.email') }}
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                >
                @error('email')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    {{ __('common.contact.message') }}
                </label>
                <textarea
                    name="message"
                    rows="5"
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                >{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <x-button>
                    {{ __('common.contact.send') }}
                </x-button>
            </div>

            @if (! $settings?->contact_email)
                <p class="text-[11px] text-amber-400 mt-4">
                    Aviso: aún no se ha configurado un correo de destino. Puedes hacerlo en el panel, sección "Datos generales".
                </p>
            @endif
        </form>

        @if($settings && ($settings->instagram_url || $settings->facebook_url || $settings->tiktok_url || $settings->twitter_url || $settings->youtube_url || $settings->linkedin_url || $settings->pinterest_url))
            <div class="mt-12 pt-8 border-t border-zinc-800">
                <h2 class="text-sm font-semibold text-zinc-300 mb-4">{{ __('common.contact.follow_social') }}</h2>
                <div class="flex flex-wrap items-center gap-4">
                    @if($settings?->instagram_url)
                        <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-4 py-2 rounded-lg border border-zinc-800 hover:border-zinc-700 hover:bg-zinc-900/40 transition-all" aria-label="{{ __('common.social.instagram') }}">
                            <x-icons.instagram class="w-5 h-5" aria-hidden="true" />
                            <span class="text-sm">Instagram</span>
                        </a>
                    @endif
                    @if($settings?->facebook_url)
                        <a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-4 py-2 rounded-lg border border-zinc-800 hover:border-zinc-700 hover:bg-zinc-900/40 transition-all" aria-label="{{ __('common.social.facebook') }}">
                            <x-icons.facebook class="w-5 h-5" aria-hidden="true" />
                            <span class="text-sm">Facebook</span>
                        </a>
                    @endif
                    @if($settings?->tiktok_url)
                        <a href="{{ $settings->tiktok_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-4 py-2 rounded-lg border border-zinc-800 hover:border-zinc-700 hover:bg-zinc-900/40 transition-all" aria-label="{{ __('common.social.tiktok') }}">
                            <x-icons.tiktok class="w-5 h-5" aria-hidden="true" />
                            <span class="text-sm">TikTok</span>
                        </a>
                    @endif
                    @if($settings?->twitter_url)
                        <a href="{{ $settings->twitter_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-4 py-2 rounded-lg border border-zinc-800 hover:border-zinc-700 hover:bg-zinc-900/40 transition-all" aria-label="{{ __('common.social.twitter') }}">
                            <x-icons.twitter class="w-5 h-5" aria-hidden="true" />
                            <span class="text-sm">Twitter/X</span>
                        </a>
                    @endif
                    @if($settings?->youtube_url)
                        <a href="{{ $settings->youtube_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-4 py-2 rounded-lg border border-zinc-800 hover:border-zinc-700 hover:bg-zinc-900/40 transition-all" aria-label="{{ __('common.social.youtube') }}">
                            <x-icons.youtube class="w-5 h-5" aria-hidden="true" />
                            <span class="text-sm">YouTube</span>
                        </a>
                    @endif
                    @if($settings?->linkedin_url)
                        <a href="{{ $settings->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-4 py-2 rounded-lg border border-zinc-800 hover:border-zinc-700 hover:bg-zinc-900/40 transition-all" aria-label="{{ __('common.social.linkedin') }}">
                            <x-icons.linkedin class="w-5 h-5" aria-hidden="true" />
                            <span class="text-sm">LinkedIn</span>
                        </a>
                    @endif
                    @if($settings?->pinterest_url)
                        <a href="{{ $settings->pinterest_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-4 py-2 rounded-lg border border-zinc-800 hover:border-zinc-700 hover:bg-zinc-900/40 transition-all" aria-label="{{ __('common.social.pinterest') }}">
                            <x-icons.pinterest class="w-5 h-5" aria-hidden="true" />
                            <span class="text-sm">Pinterest</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </section>
@endsection

