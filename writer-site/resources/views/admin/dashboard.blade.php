<x-admin.layout title="Resumen del sitio">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Vista rápida</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Estado del sitio
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Aquí puedes ver cuántos libros están publicados y si las páginas principales tienen contenido.
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="border border-zinc-800 rounded-2xl p-4 bg-zinc-900/40">
                <div class="text-xs text-zinc-500 mb-2">Libros activos</div>
                <div class="text-3xl font-semibold">{{ $activeBooksCount }}</div>
                <div class="text-xs text-zinc-500 mt-1">{{ $booksCount }} en total</div>
            </div>
            <div class="border border-zinc-800 rounded-2xl p-4 bg-zinc-900/40">
                <div class="text-xs text-zinc-500 mb-2">Sobre el autor</div>
                <div class="text-sm text-zinc-200">
                    {{ $aboutPage && $aboutPage->content ? 'Con texto' : 'Pendiente de rellenar' }}
                </div>
            </div>
            <div class="border border-zinc-800 rounded-2xl p-4 bg-zinc-900/40">
                <div class="text-xs text-zinc-500 mb-2">Contacto</div>
                <div class="text-sm text-zinc-200">
                    {{ $contactPage && $contactPage->content ? 'Con texto' : 'Pendiente de rellenar' }}
                </div>
                <div class="text-xs text-zinc-500 mt-1">
                    Correo: {{ $settings?->contact_email ?? 'sin configurar' }}
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>

