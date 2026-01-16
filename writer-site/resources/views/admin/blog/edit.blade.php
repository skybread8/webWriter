<x-admin.layout title="Editar artículo: {{ $blogPost->title }}">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">{{ __('common.admin.blog') }}</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                {{ __('common.admin.edit_article') }}
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                {{ __('common.admin.edit_article_description', ['title' => $blogPost->title]) }}
            </p>
        </div>

        <form method="POST" action="{{ route('admin.blog.update', $blogPost) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @include('admin.blog.form', ['post' => $blogPost])
            
            <div class="flex items-center gap-4 pt-6">
                <x-button>{{ __('common.admin.save_changes') }}</x-button>
                <a href="{{ route('admin.blog.index') }}" class="text-zinc-400 hover:text-zinc-100 text-sm underline">
                    {{ __('common.admin.cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-admin.layout>
