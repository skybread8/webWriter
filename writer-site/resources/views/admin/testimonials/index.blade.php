<x-admin.layout title="Testimonios">
    <div class="space-y-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Testimonios</div>
                <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                    Reseñas y testimonios
                </h1>
                <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                    Gestiona las reseñas de lectores que aparecen en el sitio. Puedes añadir fotos y calificaciones.
                </p>
            </div>
            <div class="shrink-0">
                <x-button as="a" href="{{ route('admin.testimonials.create') }}">
                    Añadir testimonio
                </x-button>
            </div>
        </div>

        @if ($testimonials->isEmpty())
            <p class="text-sm text-zinc-500">
                Aún no hay testimonios. Pulsa "Añadir testimonio" para crear el primero.
            </p>
        @else
            <div class="mb-4 p-3 bg-zinc-900/40 border border-zinc-800 rounded-lg">
                <p class="text-xs text-zinc-400">
                    💡 <strong>Ordenar testimonios:</strong> Cambia el número de orden para controlar el orden de aparición. Los números más bajos aparecen primero.
                </p>
            </div>
            <div class="space-y-3" id="testimonials-list">
                @foreach ($testimonials as $testimonial)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border border-zinc-800 rounded-2xl px-4 py-3 bg-zinc-900/40" data-id="{{ $testimonial->id }}">
                        <div class="flex items-start gap-3 flex-1">
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-xs text-zinc-500 w-8">#{{ $testimonial->order }}</span>
                                <input 
                                    type="number" 
                                    value="{{ $testimonial->order }}" 
                                    min="0"
                                    class="w-16 px-2 py-1 text-xs bg-zinc-950 border border-zinc-800 rounded text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                                    onchange="updateTestimonialOrder({{ $testimonial->id }}, this.value)"
                                >
                            </div>
                            <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full object-cover border border-zinc-800 shrink-0">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h2 class="text-sm font-medium text-zinc-50">{{ $testimonial->name }}</h2>
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-xs {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-zinc-600' }}">★</span>
                                        @endfor
                                    </div>
                                    @if($testimonial->active)
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
                                    {{ $testimonial->review }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 justify-end shrink-0">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-xs text-zinc-200 underline underline-offset-4">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('¿Seguro que quieres eliminar este testimonio?');">
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
                function updateTestimonialOrder(testimonialId, order) {
                    fetch('{{ route("admin.testimonials.update-order") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            testimonials: [{ id: testimonialId, order: parseInt(order) }]
                        })
                    }).then(() => {
                        location.reload();
                    });
                }
            </script>
        @endif
    </div>
</x-admin.layout>
