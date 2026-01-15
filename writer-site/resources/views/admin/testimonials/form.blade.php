@props(['testimonial' => null])

@php
    $isEdit = (bool) $testimonial;
@endphp

<div class="space-y-6">
    <div class="grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                Nombre
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                Nombre de la persona que da el testimonio.
            </p>
            <input
                type="text"
                name="name"
                value="{{ old('name', $testimonial?->name) }}"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
            @error('name')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-xs font-medium text-zinc-300">
                Calificación
            </label>
            <p class="text-xs text-zinc-500 mb-1">
                Estrellas de 1 a 5.
            </p>
            <select
                name="rating"
                class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
            >
                @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ old('rating', $testimonial?->rating ?? 5) == $i ? 'selected' : '' }}>
                        {{ $i }} {{ $i == 1 ? 'estrella' : 'estrellas' }}
                    </option>
                @endfor
            </select>
            @error('rating')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            Testimonio
        </label>
        <p class="text-xs text-zinc-500 mb-1">
            Texto completo del testimonio o reseña.
        </p>
        <textarea
            name="review"
            rows="4"
            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
        >{{ old('review', $testimonial?->review) }}</textarea>
        @error('review')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block text-xs font-medium text-zinc-300">
            Foto (opcional)
        </label>
        <p class="text-xs text-zinc-500 mb-1">
            Foto de la persona. Se mostrará como círculo. Si no subes una, se generará automáticamente.
        </p>
        <input
            type="file"
            name="photo"
            accept="image/*"
            class="block w-full text-xs text-zinc-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-900 hover:file:bg-white"
        >
        @error('photo')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
        @enderror

        @if($testimonial?->photo)
            <div class="mt-3">
                <p class="text-xs text-zinc-500 mb-1">Foto actual:</p>
                <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="w-16 h-16 rounded-full object-cover border border-zinc-800">
            </div>
        @endif
    </div>

    <div class="flex items-center gap-2">
        <input
            type="checkbox"
            name="active"
            id="active"
            value="1"
            {{ old('active', $testimonial?->active ?? true) ? 'checked' : '' }}
            class="rounded border-zinc-700 bg-zinc-900 text-zinc-500 focus:ring-zinc-500"
        >
        <label for="active" class="text-xs text-zinc-300">
            Visible en el sitio web
        </label>
    </div>
</div>
