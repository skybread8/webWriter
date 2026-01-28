@props(['faq' => null])

@php
    $isEdit = (bool) $faq;
@endphp

<div class="space-y-6">
    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            Pregunta
        </label>
        <p class="text-xs text-zinc-500 mb-1">
            Texto de la pregunta frecuente que verán los lectores.
        </p>
        <input
            type="text"
            name="question"
            value="{{ old('question', $faq?->question) }}"
            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            required
        >
        @error('question')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            Respuesta
        </label>
        <p class="text-xs text-zinc-500 mb-1">
            Respuesta completa a la pregunta. Puedes usar formato (negritas, listas, enlaces).
        </p>
        <input id="answer" type="hidden" name="answer" value="{{ old('answer', $faq?->answer) }}">
        <div class="trix-wrapper">
            <trix-editor input="answer" class="trix-content"></trix-editor>
        </div>
        @error('answer')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="flex items-center gap-2">
            <input
                type="checkbox"
                name="active"
                id="active"
                value="1"
                {{ old('active', $faq?->active ?? true) ? 'checked' : '' }}
                class="rounded border-zinc-700 bg-zinc-900 text-zinc-500 focus:ring-zinc-500"
            >
            <label for="active" class="text-xs text-zinc-300">
                Visible en la página de Preguntas frecuentes
            </label>
        </div>

        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                Orden de aparición
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                Número que determina el orden. Los números más bajos aparecen primero. Por defecto: 0.
            </p>
            <input
                type="number"
                name="order"
                value="{{ old('order', $faq?->order ?? 0) }}"
                min="0"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            @error('order')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

