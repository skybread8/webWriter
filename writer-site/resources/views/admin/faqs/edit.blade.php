<x-admin.layout title="Editar pregunta frecuente">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Preguntas frecuentes</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Editar pregunta frecuente
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Modifica el texto de la pregunta, su respuesta o su visibilidad.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.faqs.update', $faq) }}" class="space-y-8">
            @csrf
            @method('PUT')

            @include('admin.faqs.form', ['faq' => $faq])

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.faqs.index') }}" class="text-xs text-zinc-400 hover:text-zinc-200 underline underline-offset-4">
                    Cancelar
                </a>
                <x-button>
                    Guardar cambios
                </x-button>
            </div>
        </form>
    </div>
</x-admin.layout>

