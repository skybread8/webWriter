<x-admin.layout title="Contacto">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Página</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Texto de contacto
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Este texto se mostrará encima del formulario de contacto. Puedes explicar cómo te gusta recibir mensajes.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.pages.contact.update') }}" class="space-y-6">
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
                    Este texto aparece sobre el formulario (por ejemplo, horarios o tiempos de respuesta).
                </p>
                <input id="contact-content" type="hidden" name="content" value="{{ old('content', $page->content) }}">
                <div class="trix-wrapper">
                    <trix-editor
                        input="contact-content"
                        class="trix-content"
                    ></trix-editor>
                </div>
                @error('content')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <x-button>
                    Guardar cambios
                </x-button>
            </div>
        </form>
    </div>
</x-admin.layout>

