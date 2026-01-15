<x-admin.layout title="Página de inicio">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Inicio</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Texto principal e imagen
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Este texto e imagen aparecen en la parte superior de la web. Piensa en una frase breve y clara.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.home.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Texto principal
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    Se muestra grande, en el centro de la pantalla.
                </p>
                <textarea
                    name="hero_text"
                    rows="3"
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                >{{ old('hero_text', $settings->hero_text) }}</textarea>
                @error('hero_text')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Imagen de fondo (opcional)
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    Idealmente una imagen oscura, limpia. Se recortará a pantalla completa.
                </p>
                <input
                    type="file"
                    name="hero_image"
                    class="block w-full text-xs text-zinc-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-900 hover:file:bg-white"
                >
                @error('hero_image')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror

                @if($settings->hero_image)
                    <div class="mt-3">
                        <p class="text-xs text-zinc-500 mb-1">Imagen actual:</p>
                        <img src="{{ asset('storage/'.$settings->hero_image) }}" alt="Imagen actual" class="max-h-40 rounded-lg border border-zinc-800 object-cover">
                    </div>
                @endif
            </div>

            <div class="pt-2">
                <button class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-zinc-100 text-zinc-950 text-xs font-semibold tracking-wide uppercase hover:bg-white transition">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</x-admin.layout>

