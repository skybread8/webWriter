<x-admin.layout title="Libros">
    <div class="space-y-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Libros</div>
                <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                    Catálogo de libros
                </h1>
                <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                    Aquí puedes añadir nuevos libros, actualizar títulos, textos, precios e imágenes de portada.
                </p>
            </div>
            <div class="shrink-0">
                <x-button as="a" href="{{ route('admin.books.create') }}">
                    Añadir libro
                </x-button>
            </div>
        </div>

        @if ($books->isEmpty())
            <p class="text-sm text-zinc-500">
                Aún no hay libros. Pulsa "Añadir libro" para crear el primero.
            </p>
        @else
            <div class="mb-4 p-3 bg-zinc-900/40 border border-zinc-800 rounded-lg">
                <p class="text-xs text-zinc-400">
                    💡 <strong>Ordenar libros:</strong> Cambia el número de orden para controlar el orden de aparición. Los números más bajos aparecen primero.
                </p>
            </div>
            <div class="space-y-3" id="books-list">
                @foreach ($books as $book)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border border-zinc-800 rounded-2xl px-4 py-3 bg-zinc-900/40" data-id="{{ $book->id }}">
                        <div class="flex items-start gap-3 flex-1">
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-xs text-zinc-500 w-8">#{{ $book->order }}</span>
                                <input 
                                    type="number" 
                                    value="{{ $book->order }}" 
                                    min="0"
                                    class="w-16 px-2 py-1 text-xs bg-zinc-950 border border-zinc-800 rounded text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                                    onchange="updateBookOrder({{ $book->id }}, this.value)"
                                >
                            </div>
                            @if($book->first_image_url)
                                <img src="{{ $book->first_image_url }}" alt="Portada de {{ $book->title }}" class="w-16 h-20 rounded-md object-cover border border-zinc-800">
                            @else
                                <div class="w-16 h-20 rounded-md border border-dashed border-zinc-700 flex items-center justify-center text-[10px] text-zinc-600">
                                    Sin imagen
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h2 class="text-sm font-medium text-zinc-50">{{ $book->title }}</h2>
                                    @if($book->active)
                                        <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-2 py-0.5 text-[10px] font-medium text-emerald-300">
                                            visible
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-zinc-800 px-2 py-0.5 text-[10px] font-medium text-zinc-400">
                                            oculto
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-zinc-400 line-clamp-2 mt-1">
                                    {{ $book->description }}
                                </p>
                                <p class="text-xs text-zinc-500 mt-2">
                                    Precio: <span class="text-zinc-100 font-medium">{{ number_format($book->price, 2, ',', '.') }} €</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 justify-end shrink-0">
                            <a href="{{ route('admin.books.edit', $book) }}" class="text-xs text-zinc-200 underline underline-offset-4">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('admin.books.destroy', $book) }}" onsubmit="return confirm('¿Seguro que quieres eliminar este libro?');">
                                @csrf
                                @method('DELETE')
                                <x-button variant="danger">
                                    Eliminar
                                </x-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <script>
                function updateBookOrder(bookId, order) {
                    fetch('{{ route("admin.books.update-order") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            books: [{ id: bookId, order: parseInt(order) }]
                        })
                    }).then(() => {
                        location.reload();
                    });
                }
            </script>
        @endif
    </div>
</x-admin.layout>

