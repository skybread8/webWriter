@extends('layouts.site')

@section('title', 'Blog')

@section('content')
    <section 
        x-data="scrollReveal(0)"
        class="px-5 sm:px-8 py-8 sm:py-12 max-w-6xl mx-auto"
    >
        <div 
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 mb-3">
                    <x-icons.book class="w-5 h-5 text-amber-400" />
                    <p class="text-[11px] tracking-[0.28em] uppercase text-zinc-400">
                        Blog
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl tracking-tight">
                    {{ __('common.blog.title') }}
                </h1>
                <p class="mt-3 text-sm text-zinc-400 max-w-md mx-auto">
                    Artículos sobre escritura, experiencias y reflexiones
                </p>
            </div>

            @if($posts->isEmpty())
                <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center text-zinc-400">
                    {{ __('common.blog.no_posts') }}
                </div>
            @else
                <div class="space-y-8">
                    @foreach($posts as $index => $post)
                        <article 
                            class="border border-zinc-800 rounded-3xl overflow-hidden bg-zinc-900/40 hover:bg-zinc-900/60 hover:border-zinc-700 transition-all duration-500"
                            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                            x-data="scrollReveal({{ ($index + 1) * 100 }})"
                            x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                        >
                            <a href="{{ route('blog.post', $post->slug) }}" class="block">
                                <div class="grid md:grid-cols-3 gap-6">
                                    @if($post->featured_image)
                                        <figure class="md:col-span-1">
                                            <img 
                                                src="{{ get_image_url($post->featured_image) }}" 
                                                alt="{{ $post->title }}" 
                                                class="w-full h-48 md:h-full object-cover"
                                                loading="lazy"
                                                width="400"
                                                height="300"
                                            >
                                        </figure>
                                    @endif
                                    <div class="md:col-span-{{ $post->featured_image ? '2' : '3' }} p-6 sm:p-8">
                                        <div class="text-[10px] tracking-[0.3em] uppercase text-zinc-500 mb-2">
                                            {{ $post->published_at ? $post->published_at->format('d M Y') : '' }}
                                        </div>
                                        <h2 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl tracking-tight mb-3 group-hover:text-zinc-50 transition-colors">
                                            {{ $post->title }}
                                        </h2>
                                        @if($post->excerpt)
                                            <p class="text-sm text-zinc-400 line-clamp-3 mb-4">
                                                {{ $post->excerpt }}
                                            </p>
                                        @endif
                                        <div class="flex items-center gap-2 text-[11px] text-zinc-500 group-hover:text-zinc-400 transition-colors">
                                            <span>{{ __('common.blog.read_more') }}</span>
                                            <x-icons.arrow-right class="w-3 h-3 transition-transform group-hover:translate-x-1" />
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
