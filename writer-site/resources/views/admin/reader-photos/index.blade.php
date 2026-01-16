<x-admin.layout title="Fotos con lectores">
    <div class="space-y-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Fotos con lectores</div>
                <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                    Fotos con lectores
                </h1>
                <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                    Gestiona las fotos generales de lectores que se han hecho una foto contigo. Estas fotos aparecerán en la página general "Fotos con lectores". Para añadir fotos específicas de un libro, ve a la edición de ese libro.
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('admin.reader-photos.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full text-xs font-semibold tracking-wide uppercase transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-zinc-950 bg-zinc-100 text-zinc-950 hover:bg-white focus:ring-zinc-400">
                    Añadir foto
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-lg border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($photos->isEmpty())
            <p class="text-sm text-zinc-500">
                Aún no hay fotos. Pulsa "Añadir foto" para crear la primera.
            </p>
        @else
            <div class="mb-4 p-3 bg-zinc-900/40 border border-zinc-800 rounded-lg">
                <p class="text-xs text-zinc-400">
                    💡 <strong>Ordenar fotos:</strong> Cambia el número de orden para controlar el orden de aparición. Los números más bajos aparecen primero.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="photos-list">
                @foreach ($photos as $photo)
                    <div class="border border-zinc-800 rounded-2xl overflow-hidden bg-zinc-900/40" data-id="{{ $photo->id }}">
                        <div class="aspect-square overflow-hidden bg-zinc-950">
                            <img 
                                src="{{ $photo->photo_url }}" 
                                alt="{{ $photo->reader_name ?? 'Foto con lector' }}" 
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-zinc-500 w-8">#{{ $photo->order }}</span>
                                <input 
                                    type="number" 
                                    value="{{ $photo->order }}" 
                                    min="0"
                                    class="w-16 px-2 py-1 text-xs bg-zinc-950 border border-zinc-800 rounded text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                                    onchange="updatePhotoOrder({{ $photo->id }}, this.value)"
                                >
                                @if($photo->active)
                                    <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-2 py-0.5 text-[10px] font-medium text-emerald-300 ml-auto">
                                        visible
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-zinc-800 px-2 py-0.5 text-[10px] font-medium text-zinc-400 ml-auto">
                                        oculto
                                    </span>
                                @endif
                            </div>
                            @if($photo->reader_name)
                                <p class="text-sm font-medium text-zinc-100">{{ $photo->reader_name }}</p>
                            @endif
                            @if($photo->caption)
                                <p class="text-xs text-zinc-400 line-clamp-2">{{ $photo->caption }}</p>
                            @endif
                            <div class="flex items-center gap-2 pt-2 border-t border-zinc-800">
                                <a href="{{ route('admin.reader-photos.edit', $photo) }}" class="text-xs text-zinc-200 underline underline-offset-4 flex-1 text-center">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('admin.reader-photos.destroy', $photo) }}" onsubmit="return confirm('¿Seguro que quieres eliminar esta foto?');" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-400 underline underline-offset-4 w-full">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <script>
                function updatePhotoOrder(photoId, order) {
                    fetch('{{ route("admin.reader-photos.update-order") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            photos: [{ id: photoId, order: parseInt(order) }]
                        })
                    }).then(() => {
                        location.reload();
                    });
                }
            </script>
        @endif
    </div>
</x-admin.layout>
