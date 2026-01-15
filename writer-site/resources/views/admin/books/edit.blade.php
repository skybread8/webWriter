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
    </div>
</x-admin.layout>

