<x-admin.layout title="Editar template de correo">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Correos</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Editar: {{ $emailTemplate->name }}
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Personaliza el texto de este correo. Puedes usar variables como @{{order_number}}, @{{customer_name}}, @{{total}}, etc.
            </p>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.email-templates.update', $emailTemplate) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Nombre del template
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $emailTemplate->name) }}"
                    required
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 px-4 py-2 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                >
                @error('name')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Asunto del correo
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    Puedes usar variables como @{{order_number}}, @{{customer_name}}, etc.
                </p>
                <input
                    type="text"
                    name="subject"
                    value="{{ old('subject', $emailTemplate->subject) }}"
                    required
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 px-4 py-2 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                >
                @error('subject')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Cuerpo del correo
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    Puedes usar variables como @{{order_number}}, @{{customer_name}}, @{{total}}, @{{order_date}}, etc. Usa saltos de línea para formatear el texto.
                </p>
                <textarea
                    name="body"
                    rows="12"
                    required
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 px-4 py-3 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500 font-mono"
                >{{ old('body', $emailTemplate->body) }}</textarea>
                @error('body')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input
                    type="checkbox"
                    name="active"
                    id="active"
                    value="1"
                    {{ old('active', $emailTemplate->active) ? 'checked' : '' }}
                    class="rounded bg-zinc-900 border-zinc-800 text-amber-400 focus:ring-amber-400/50"
                >
                <label for="active" class="text-sm text-zinc-300">
                    Template activo (si está desactivado, se usará el texto por defecto)
                </label>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button
                    type="submit"
                    class="px-6 py-2.5 bg-amber-600 hover:bg-amber-500 text-white text-sm font-semibold rounded-lg transition-colors"
                >
                    Guardar cambios
                </button>
                <a
                    href="{{ route('admin.email-templates.index') }}"
                    class="px-6 py-2.5 bg-zinc-800 hover:bg-zinc-700 text-zinc-100 text-sm font-semibold rounded-lg transition-colors"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-admin.layout>
