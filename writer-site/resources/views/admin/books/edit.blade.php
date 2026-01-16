<x-admin.layout title="Editar libro">
    <div class="space-y-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Libros</div>
                <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                    Editar “{{ $book->title }}”
                </h1>
                <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                    Modifica texto, precio o imagen. Los cambios se reflejarán inmediatamente en la web.
                </p>
            </div>
            <div class="shrink-0 text-right text-xs text-zinc-500">
                @if($book->active)
                    Estado: <span class="text-emerald-300">visible</span>
                @else
                    Estado: <span class="text-zinc-300">oculto</span>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            @include('admin.books.form', ['book' => $book])

            <div class="pt-2 flex items-center gap-3">
                <x-button>
                    Guardar cambios
                </x-button>
                <a href="{{ route('admin.books.index') }}" class="text-xs text-zinc-400 underline underline-offset-4">
                    Volver al listado
                </a>
            </div>
        </form>

        <!-- Fotos de lectores de este libro -->
        <div class="mt-12 pt-12 border-t border-zinc-800">
            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="font-['DM_Serif_Display'] text-2xl md:text-3xl tracking-tight mb-2">
                        Fotos de lectores de este libro
                    </h2>
                    <p class="text-sm text-zinc-400">
                        Gestiona las fotos de lectores que han comprado "{{ $book->title }}" y se han hecho una foto contigo. Estas fotos aparecerán en la página de este libro específico. Para fotos generales, ve a "Fotos con lectores".
                    </p>
                </div>
                <div class="shrink-0">
                    <button 
                        type="button"
                        onclick="document.getElementById('add-photo-form').classList.toggle('hidden')"
                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-zinc-950 text-xs font-semibold rounded-lg transition-colors"
                    >
                        + Añadir foto
                    </button>
                </div>
            </div>

            <!-- Formulario para añadir foto (oculto por defecto) -->
            <div id="add-photo-form" class="hidden mb-6 p-6 bg-zinc-900/40 border border-zinc-800 rounded-xl">
                <h3 class="text-lg font-semibold text-zinc-100 mb-4">Añadir nueva foto</h3>
                <form method="POST" action="{{ route('admin.reader-photos.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-zinc-300">
                            Foto <span class="text-red-400">*</span>
                        </label>
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

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="reader_name" class="block text-xs font-medium text-zinc-300">
                                Nombre del lector (opcional)
                            </label>
                            <input
                                type="text"
                                id="reader_name"
                                name="reader_name"
                                maxlength="255"
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                placeholder="Ej: María García"
                            >
                        </div>

                        <div class="space-y-2">
                            <label for="order" class="block text-xs font-medium text-zinc-300">
                                Orden
                            </label>
                            <input
                                type="number"
                                id="order"
                                name="order"
                                value="0"
                                min="0"
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                            >
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="caption" class="block text-xs font-medium text-zinc-300">
                            Descripción o comentario (opcional)
                        </label>
                        <textarea
                            id="caption"
                            name="caption"
                            rows="2"
                            maxlength="500"
                            class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                            placeholder="Ej: ¡Gracias por venir a la firma de libros!"
                        ></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                name="active"
                                value="1"
                                checked
                                class="rounded border-zinc-700 bg-zinc-900 text-amber-400 focus:ring-amber-400/50"
                            >
                            <span class="text-xs text-zinc-300">Mostrar esta foto públicamente</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-zinc-950 text-xs font-semibold rounded-lg transition-colors">
                            Guardar foto
                        </button>
                        <button 
                            type="button"
                            onclick="document.getElementById('add-photo-form').classList.add('hidden')"
                            class="text-xs text-zinc-400 underline underline-offset-4"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>

            @if(isset($readerPhotos) && $readerPhotos->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($readerPhotos as $photo)
                        <div class="border border-zinc-800 rounded-xl overflow-hidden bg-zinc-900/40">
                            <div class="aspect-square overflow-hidden bg-zinc-950">
                                <img 
                                    src="{{ $photo->photo_url }}" 
                                    alt="{{ $photo->reader_name ?? 'Foto con lector' }}" 
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            <div class="p-3 space-y-2">
                                @if($photo->reader_name)
                                    <p class="text-xs font-medium text-zinc-100 truncate">{{ $photo->reader_name }}</p>
                                @endif
                                @if($photo->caption)
                                    <p class="text-[10px] text-zinc-400 line-clamp-2">{{ $photo->caption }}</p>
                                @endif
                                <div class="flex items-center gap-2 pt-2 border-t border-zinc-800">
                                    <a href="{{ route('admin.reader-photos.edit', $photo) }}" class="text-[10px] text-zinc-300 underline underline-offset-2 flex-1 text-center">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('admin.reader-photos.destroy', $photo) }}" onsubmit="return confirm('¿Seguro que quieres eliminar esta foto?');" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[10px] text-red-400 underline underline-offset-2 w-full">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 bg-zinc-900/40 border border-zinc-800 rounded-xl">
                    <p class="text-sm text-zinc-500">Aún no hay fotos de lectores para este libro.</p>
                    <p class="text-xs text-zinc-600 mt-1">Pulsa "Añadir foto" para crear la primera.</p>
                </div>
            @endif
        </div>
    </div>
</x-admin.layout>

