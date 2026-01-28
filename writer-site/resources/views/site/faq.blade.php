@extends('layouts.site')

@section('title', __('common.nav.faq'))

@section('content')
    <section
        x-data="scrollReveal(0)"
        class="px-5 sm:px-8 py-8 sm:py-12 max-w-4xl mx-auto"
    >
        <div
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <header class="mb-8 sm:mb-10">
                <p class="text-[11px] tracking-[0.3em] uppercase text-zinc-500 mb-2">
                    {{ __('common.nav.faq') }}
                </p>
                <h1 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl tracking-tight">
                    Preguntas frecuentes
                </h1>
            </header>

            @if($faqs->isEmpty())
                <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-8 text-center text-zinc-400">
                    <p class="text-sm">Aún no hay preguntas frecuentes publicadas. Vuelve pronto.</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($faqs as $faq)
                        <div class="border border-zinc-800 rounded-2xl bg-zinc-900/40 overflow-hidden">
                            <div class="px-5 sm:px-6 py-4 border-b border-zinc-800">
                                <h2 class="text-base font-semibold text-zinc-50">
                                    {{ $faq->question }}
                                </h2>
                            </div>
                            @if($faq->answer)
                                <div class="px-5 sm:px-6 py-4 prose prose-invert prose-zinc max-w-none text-sm leading-relaxed">
                                    {!! $faq->answer !!}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
