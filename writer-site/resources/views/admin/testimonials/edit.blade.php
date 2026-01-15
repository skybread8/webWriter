<x-admin.layout title="Editar testimonio">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Testimonios</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Editar testimonio
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Actualiza el contenido, foto o visibilidad de este testimonio.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <x-admin.testimonials.form :testimonial="$testimonial" />

            <div class="flex items-center gap-4 pt-4">
                <x-button type="submit">
                    Guardar cambios
                </x-button>
                <a href="{{ route('admin.testimonials.index') }}" class="text-xs text-zinc-400 underline underline-offset-4">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-admin.layout>
