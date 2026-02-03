<x-admin.layout title="Vista previa: {{ $blogPost->title }}">
    <div class="space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">{{ __('common.admin.blog') }}</div>
                <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                    Vista previa del artículo
                </h1>
                <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                    Así se verá el artículo en la web. Puedes editar o volver al listado.
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ url('admin/blog/'.$blogPost->getKey().'/edit') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-zinc-100 text-zinc-950 text-sm font-semibold hover:bg-white transition-colors">
                    {{ __('common.admin.edit') }}
                </a>
                @php
                    $publicUrl = function_exists('localized_route') ? localized_route('blog.post', ['id' => $blogPost->id]) : url(app()->getLocale().'/blog/'.$blogPost->id);
                @endphp
                <a href="{{ $publicUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-zinc-600 text-zinc-200 text-sm font-medium hover:bg-zinc-800 transition-colors">
                    Ver en web
                </a>
                <a href="{{ route('admin.blog.index') }}" class="text-zinc-400 hover:text-zinc-100 text-sm underline">
                    {{ __('common.admin.cancel') }}
                </a>
            </div>
        </div>

        <article class="border border-zinc-800 rounded-2xl overflow-hidden bg-zinc-900/40">
            <div class="p-6 sm:p-8 md:p-10 max-w-4xl">
                <header class="mb-8">
                    <div class="text-[11px] tracking-[0.3em] uppercase text-zinc-500 mb-2">
                        {{ $blogPost->published_at ? $blogPost->published_at->format('d/m/Y H:i') : 'Sin fecha' }}
                        @if($blogPost->published)
                            <span class="ml-2 inline-flex items-center rounded-full bg-emerald-500/20 px-2 py-0.5 text-[10px] font-medium text-emerald-300">Publicado</span>
                        @else
                            <span class="ml-2 inline-flex items-center rounded-full bg-zinc-700 px-2 py-0.5 text-[10px] font-medium text-zinc-400">Borrador</span>
                        @endif
                    </div>
                    <h2 class="font-['DM_Serif_Display'] text-2xl sm:text-3xl tracking-tight text-zinc-50 mb-3">
                        {{ $blogPost->title }}
                    </h2>
                    @if($blogPost->excerpt)
                        <p class="text-zinc-300 leading-relaxed">
                            {{ $blogPost->excerpt }}
                        </p>
                    @endif
                </header>

                @if($blogPost->featured_image)
                    <figure class="mb-8 rounded-2xl overflow-hidden">
                        <img
                            src="{{ get_image_url($blogPost->featured_image) }}"
                            alt="{{ $blogPost->featured_image_alt ?: $blogPost->title }}"
                            class="w-full h-auto object-cover max-h-96"
                        >
                    </figure>
                @endif

                @if($blogPost->content)
                    <div class="prose prose-invert prose-zinc max-w-none text-base leading-relaxed prose-img:rounded-xl prose-img:max-w-full">
                        {!! $blogPost->content !!}
                    </div>
                @else
                    <p class="text-zinc-500 italic">Sin contenido en el cuerpo del artículo.</p>
                @endif
            </div>
        </article>

        <div class="flex items-center gap-4 pt-4">
            <a href="{{ url('admin/blog/'.$blogPost->getKey().'/edit') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-zinc-100 text-zinc-950 text-sm font-semibold hover:bg-white transition-colors">
                {{ __('common.admin.edit') }}
            </a>
            <a href="{{ route('admin.blog.index') }}" class="text-zinc-400 hover:text-zinc-100 text-sm underline">
                Volver al listado
            </a>
        </div>
    </div>
</x-admin.layout>
