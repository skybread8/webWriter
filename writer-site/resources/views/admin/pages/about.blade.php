<x-admin.layout title="Sobre el autor">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Página</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Texto “Sobre el autor”
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Este texto se mostrará en la página de presentación. Puedes escribir en párrafos, como si fuera una mini nota biográfica.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.pages.about.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Título de la página
                </label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $page->title) }}"
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                >
                @error('title')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Texto de la página
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    Usa el editor para escribir con comodidad. Puedes resaltar palabras en negrita o añadir párrafos.
                </p>
                <input id="about-content" type="hidden" name="content" value="{{ old('content', $page->content) }}">
                <div class="trix-wrapper">
                    <trix-editor
                        input="about-content"
                        class="trix-content"
                    ></trix-editor>
                </div>
                @error('content')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Foto del autor
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    Sube una foto tuya. Se mostrará en la página "Sobre el autor". Archivo JPG o PNG.
                </p>
                <input
                    type="file"
                    name="image"
                    accept="image/*"
                    class="block w-full text-xs text-zinc-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-900 hover:file:bg-white"
                >
                @error('image')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror

                @if($page->image)
                    <div class="mt-3">
                        <p class="text-xs text-zinc-500 mb-1">Foto actual:</p>
                        <img src="{{ get_image_url($page->image) }}" alt="{{ $page->image_alt ?: 'Foto del autor' }}" class="max-h-48 rounded-lg border border-zinc-800 object-cover">
                    </div>
                @endif
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">Texto alternativo SEO (foto del autor)</label>
                <p class="text-xs text-zinc-500 mb-1">Palabras clave para buscadores (ej: &quot;Kevin Pérez Alarcón, escritor&quot;).</p>
                <input type="text" name="image_alt" value="{{ old('image_alt', $page->image_alt) }}" placeholder="Ej: Kevin Pérez Alarcón, autor" class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500">
                @error('image_alt')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="pt-2">
                <x-button>
                    Guardar cambios
                </x-button>
            </div>
        </form>
    </div>
</x-admin.layout>

