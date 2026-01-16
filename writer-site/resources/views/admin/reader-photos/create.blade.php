<x-admin.layout title="Añadir foto con lector">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Fotos con lectores</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Añadir nueva foto
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Añade una foto general de un lector que se ha hecho una foto contigo. Esta foto aparecerá en la página general "Fotos con lectores". Para añadir fotos específicas de un libro, ve a la edición de ese libro.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.reader-photos.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="book_id" value="">

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Foto <span class="text-red-400">*</span>
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    Sube la foto del lector contigo. Archivo JPG o PNG, máximo 4MB.
                </p>
                <input
                    type="file"
                    name="photo"
                    accept="image/*"
                    required
                    class="block w-full text-xs text-zinc-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-900 hover:file:bg-white"
                >
                @error('photo')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="reader_name" class="block text-xs font-medium text-zinc-300">
                    Nombre del lector (opcional)
                </label>
                <input
                    type="text"
                    id="reader_name"
                    name="reader_name"
                    value="{{ old('reader_name') }}"
                    maxlength="255"
                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                    placeholder="Ej: María García"
                >
                @error('reader_name')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="caption" class="block text-xs font-medium text-zinc-300">
                    Descripción o comentario (opcional)
                </label>
                <textarea
                    id="caption"
                    name="caption"
                    rows="3"
                    maxlength="500"
                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                    placeholder="Ej: ¡Gracias por venir a la firma de libros!"
                >{{ old('caption') }}</textarea>
                @error('caption')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="active"
                        value="1"
                        {{ old('active', true) ? 'checked' : '' }}
                        class="rounded border-zinc-700 bg-zinc-900 text-amber-400 focus:ring-amber-400/50"
                    >
                    <span class="text-xs text-zinc-300">Mostrar esta foto públicamente</span>
                </label>
            </div>

            <div class="space-y-2">
                <label for="order" class="block text-xs font-medium text-zinc-300">
                    Orden
                </label>
                <input
                    type="number"
                    id="order"
                    name="order"
                    value="{{ old('order', 0) }}"
                    min="0"
                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                >
                <p class="text-xs text-zinc-500 mt-1">
                    Los números más bajos aparecen primero. Usa 0 para que aparezca al final.
                </p>
                @error('order')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-4">
                <x-button type="submit">
                    Guardar foto
                </x-button>
                <a href="{{ route('admin.reader-photos.index') }}" class="text-xs text-zinc-400 underline underline-offset-4">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-admin.layout>
