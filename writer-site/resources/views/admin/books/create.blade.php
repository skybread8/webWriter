<x-admin.layout title="Nuevo libro">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Libros</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Añadir un nuevo libro
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Rellena la información básica. Siempre podrás cambiar estos datos más adelante.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @include('admin.books.form', ['book' => null])

            <div class="pt-2 flex items-center gap-3">
                <x-button>
                    Guardar libro
                </x-button>
                <a href="{{ route('admin.books.index') }}" class="text-xs text-zinc-400 underline underline-offset-4">
                    Volver sin guardar
                </a>
            </div>
        </form>
    </div>
</x-admin.layout>

