@extends('layouts.site')

@section('title', $post->title)

@section('seo')
    @php
        $settings = \App\Models\SiteSetting::first();
        $siteName = $settings?->site_name ?? 'Kevin Pérez Alarcón';
        $seoTitle = $siteName . ' – ' . $post->title;
        $seoDescription = $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 160);
        $seoImage = $post->featured_image ? get_image_url($post->featured_image) : ($settings?->hero_image ? get_image_url($settings->hero_image) : null);
        $seoImageAlt = $post->featured_image_alt ?: $post->title;
    @endphp
    <x-seo-meta :title="$seoTitle" :description="$seoDescription" :image="$seoImage" :image_alt="$seoImageAlt" type="article" />
    @php
        $articleSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => $seoDescription,
            'author' => ['@type' => 'Person', 'name' => $siteName],
            'url' => url()->current(),
            'datePublished' => $post->published_at?->toIso8601String(),
        ];
        if ($seoImage) {
            $articleSchema['image'] = $seoImage;
        }
    @endphp
    <script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endsection

@section('content')
    <section 
        x-data="scrollReveal(0)"
        class="px-5 sm:px-8 py-8 sm:py-12 max-w-4xl mx-auto"
    >
        <article 
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <header class="mb-10">
                <div class="text-[11px] tracking-[0.3em] uppercase text-zinc-500 mb-3">
                    {{ $post->published_at ? $post->published_at->format('d M Y') : '' }}
                </div>
                <h1 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl md:text-4xl tracking-tight mb-4">
                    {{ $post->title }}
                </h1>
                @if($post->excerpt)
                    <p class="text-lg text-zinc-300 leading-relaxed">
                        {{ $post->excerpt }}
                    </p>
                @endif
            </header>

            @if($post->featured_image)
                <figure class="mb-10 rounded-3xl overflow-hidden">
                    <img 
                        src="{{ get_image_url($post->featured_image) }}" 
                        alt="{{ $post->featured_image_alt ?: $post->title }}" 
                        class="w-full h-auto object-cover"
                        loading="lazy"
                    >
                </figure>
            @endif

            <div class="prose prose-invert prose-zinc max-w-none text-base leading-relaxed">
                {!! $post->content !!}
            </div>

            <div class="mt-12 pt-8 border-t border-zinc-800">
                <a href="{{ localized_route('blog') }}" class="inline-flex items-center gap-2 text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100 transition-colors group">
                    <x-icons.arrow-right class="w-4 h-4 rotate-180 transition-transform group-hover:-translate-x-1" />
                    <span>{{ __('common.blog.back_to_blog') }}</span>
                </a>
            </div>
        </article>
    </section>
@endsection
