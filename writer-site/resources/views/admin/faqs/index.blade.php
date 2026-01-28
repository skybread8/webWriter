<x-admin.layout title="Preguntas frecuentes">
    <div class="space-y-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Preguntas frecuentes</div>
                <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                    Preguntas frecuentes (FAQ)
                </h1>
                <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                    Gestiona las preguntas y respuestas que aparecerán en la sección de Preguntas frecuentes.
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full text-xs font-semibold tracking-wide uppercase transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-zinc-950 bg-zinc-100 text-zinc-950 hover:bg-white focus:ring-zinc-400">
                    Añadir pregunta
                </a>
            </div>
        </div>

        @if ($faqs->isEmpty())
            <p class="text-sm text-zinc-500">
                Aún no hay preguntas frecuentes. Pulsa &quot;Añadir pregunta&quot; para crear la primera.
            </p>
        @else
            <div class="mb-4 p-3 bg-zinc-900/40 border border-zinc-800 rounded-lg">
                <p class="text-xs text-zinc-400">
                    💡 <strong>Ordenar preguntas:</strong> Usa el campo de orden para decidir en qué posición aparece cada pregunta. Los números más bajos aparecen primero.
                </p>
            </div>
            <div class="space-y-3">
                @foreach ($faqs as $faq)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border border-zinc-800 rounded-2xl px-4 py-3 bg-zinc-900/40">
                        <div class="flex items-start gap-3 flex-1">
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-xs text-zinc-500 w-8">#{{ $faq->order }}</span>
                            </div>
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h2 class="text-sm font-medium text-zinc-50">
                                        {{ $faq->question }}
                                    </h2>
                                    @if($faq->active)
                                        <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-2 py-0.5 text-[10px] font-medium text-emerald-300">
                                            visible
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-zinc-800 px-2 py-0.5 text-[10px] font-medium text-zinc-400">
                                            oculto
                                        </span>
                                    @endif
                                </div>
                                @if($faq->answer)
                                    <div class="prose prose-invert prose-zinc max-w-none text-xs leading-relaxed line-clamp-3">
                                        {!! $faq->answer !!}
                                    </div>
                                @else
                                    <p class="text-xs text-zinc-500">
                                        Sin respuesta. Edítala para añadir el contenido.
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2 justify-end shrink-0">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-xs text-zinc-200 underline underline-offset-4">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('¿Seguro que quieres eliminar esta pregunta frecuente?');">
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
        @endif
    </div>
</x-admin.layout>

