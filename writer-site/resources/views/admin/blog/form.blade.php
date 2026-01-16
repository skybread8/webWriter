@props(['post' => null])

<div class="space-y-6">
    <div class="grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                {{ __('common.admin.article_title') }}
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                {{ __('common.admin.article_title_description') }}
            </p>
            <input
                type="text"
                name="title"
                value="{{ old('title', $post?->title) }}"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                required
            >
            @error('title')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                {{ __('common.admin.article_slug') }}
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                {{ __('common.admin.article_slug_description') }}
            </p>
            <input
                type="text"
                name="slug"
                value="{{ old('slug', $post?->slug) }}"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            @error('slug')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            {{ __('common.admin.article_excerpt') }}
        </label>
        <p class="text-xs text-zinc-500 mb-1">
            {{ __('common.admin.article_excerpt_description') }}
        </p>
        <textarea
            name="excerpt"
            rows="3"
            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
        >{{ old('excerpt', $post?->excerpt) }}</textarea>
        @error('excerpt')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            {{ __('common.admin.article_content') }}
        </label>
        <p class="text-xs text-zinc-500 mb-1">
            {{ __('common.admin.article_content_description') }}
        </p>
        <input id="content" type="hidden" name="content" value="{{ old('content', $post?->content) }}">
        <trix-editor input="content" class="bg-zinc-900 text-zinc-100 border-zinc-800 rounded-xl"></trix-editor>
        @error('content')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            {{ __('common.admin.article_featured_image') }}
        </label>
        <p class="text-xs text-zinc-500 mb-1">
            {{ __('common.admin.article_featured_image_description') }}
        </p>
        @if($post?->featured_image)
            <div class="mb-3">
                <img src="{{ asset('storage/'.$post->featured_image) }}" alt="Imagen actual" class="max-h-40 rounded-lg border border-zinc-800 object-cover">
                <label for="remove_featured_image" class="flex items-center mt-2 text-sm text-zinc-400">
                    <input type="checkbox" name="remove_featured_image" id="remove_featured_image" value="1" class="rounded border-zinc-700 text-red-600 shadow-sm focus:ring-red-500">
                                    <span class="ml-2">{{ __('common.admin.remove_current_image') }}</span>
                </label>
            </div>
        @endif
        <input
            type="file"
            name="featured_image"
            accept="image/*"
            class="block w-full text-xs text-zinc-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-900 hover:file:bg-white"
        >
        @error('featured_image')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                {{ __('common.admin.order') }}
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                {{ __('common.admin.order_description') }}
            </p>
            <input
                type="number"
                name="order"
                value="{{ old('order', $post?->order ?? 0) }}"
                min="0"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            @error('order')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                {{ __('common.admin.publish_date') }}
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                {{ __('common.admin.publish_date_description') }}
            </p>
            <input
                type="datetime-local"
                name="published_at"
                value="{{ old('published_at', $post?->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            @error('published_at')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-2 pt-6">
            <input
                type="checkbox"
                name="published"
                id="published"
                value="1"
                {{ old('published', $post?->published ?? false) ? 'checked' : '' }}
                class="rounded border-zinc-700 bg-zinc-900 text-zinc-100 focus:ring-zinc-500"
            >
            <label for="published" class="text-xs text-zinc-200">
                {{ __('common.admin.publish_article') }}
            </label>
        </div>
    </div>
</div>
