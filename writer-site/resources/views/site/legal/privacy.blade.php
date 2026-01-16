@extends('layouts.site')

@section('title', __('common.legal.privacy_title'))

@section('content')
    <section 
        x-data="scrollReveal(0)"
        class="px-5 sm:px-8 py-14 sm:py-20 max-w-4xl mx-auto"
    >
        <article 
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <header class="mb-10">
                <div class="text-[11px] tracking-[0.3em] uppercase text-zinc-500 mb-3">
                    {{ __('common.legal.legal') }}
                </div>
                <h1 class="font-['DM_Serif_Display'] text-4xl sm:text-5xl md:text-6xl tracking-tight mb-4">
                    {{ __('common.legal.privacy_title') }}
                </h1>
            </header>

            <div class="prose prose-invert prose-zinc max-w-none text-base leading-relaxed">
                @if(!empty($content))
                    {!! $content !!}
                @else
                    <p class="text-zinc-400">{{ __('common.legal.no_content') }}</p>
                @endif
            </div>
        </article>
    </section>
@endsection
