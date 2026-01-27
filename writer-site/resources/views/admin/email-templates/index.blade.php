<x-admin.layout title="Templates de correo">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Correos</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Personalizar correos electrónicos
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Personaliza los textos de los correos que se envían automáticamente. Puedes usar variables como @{{order_number}}, @{{customer_name}}, etc.
            </p>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="space-y-4">
            @foreach($templates as $template)
                <div class="border border-zinc-800 rounded-xl p-4 bg-zinc-900/40">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-base font-semibold text-zinc-100">{{ $template->name }}</h3>
                                @if($template->active)
                                    <span class="px-2 py-0.5 text-xs font-medium bg-emerald-900/40 text-emerald-300 border border-emerald-800 rounded">Activo</span>
                                @else
                                    <span class="px-2 py-0.5 text-xs font-medium bg-zinc-800 text-zinc-400 border border-zinc-700 rounded">Inactivo</span>
                                @endif
                            </div>
                            <p class="text-xs text-zinc-400 mb-1">
                                <strong>Clave:</strong> {{ $template->key }}
                            </p>
                            <p class="text-xs text-zinc-400 mb-2">
                                <strong>Asunto:</strong> {{ $template->subject }}
                            </p>
                            <p class="text-xs text-zinc-500 line-clamp-2">
                                {{ Str::limit($template->body, 150) }}
                            </p>
                        </div>
                        <a 
                            href="{{ route('admin.email-templates.edit', $template) }}" 
                            class="ml-4 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-zinc-100 text-sm font-medium rounded-lg transition-colors"
                        >
                            Editar
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-admin.layout>
