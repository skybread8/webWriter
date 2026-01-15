<x-admin.layout title="Añadir testimonio">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Testimonios</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Añadir nuevo testimonio
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Añade una reseña o testimonio de un lector. Aparecerá en el sitio web con su foto y calificación.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <x-admin.testimonials.form />

            <div class="flex items-center gap-4 pt-4">
                <x-button type="submit">
                    Guardar testimonio
                </x-button>
                <a href="{{ route('admin.testimonials.index') }}" class="text-xs text-zinc-400 underline underline-offset-4">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-admin.layout>
