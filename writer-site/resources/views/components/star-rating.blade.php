@props([
    'rating' => 0,
    'maxRating' => 10,
    'size' => 'md', // sm, md, lg
    'interactive' => false,
    'name' => 'rating',
])

@php
    $sizes = [
        'sm' => 'w-4 h-4',
        'md' => 'w-5 h-5',
        'lg' => 'w-6 h-6',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div class="flex items-center gap-0.5" {{ $attributes }}>
    @if($interactive)
        <div x-data="{ rating: {{ $rating ?: 0 }}, hoverRating: 0 }" class="flex items-center gap-0.5">
            @for($i = 1; $i <= $maxRating; $i++)
                <button
                    type="button"
                    @click="rating = {{ $i }}"
                    @mouseenter="hoverRating = {{ $i }}"
                    @mouseleave="hoverRating = 0"
                    class="transition-colors focus:outline-none"
                    aria-label="Valorar {{ $i }} de {{ $maxRating }}"
                >
                    <svg 
                        class="{{ $sizeClass }} transition-colors"
                        :class="(hoverRating >= {{ $i }} || (!hoverRating && rating >= {{ $i }})) ? 'text-amber-400 fill-amber-400' : 'text-zinc-700 fill-zinc-700'"
                        fill="currentColor" 
                        viewBox="0 0 20 20"
                    >
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </button>
            @endfor
            <input type="hidden" name="{{ $name }}" x-bind:value="rating" required>
        </div>
    @else
        @for($i = 1; $i <= $maxRating; $i++)
            @if($i <= $rating)
                <svg class="{{ $sizeClass }} text-amber-400 fill-amber-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
            @else
                <svg class="{{ $sizeClass }} text-zinc-700 fill-zinc-700" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
            @endif
        @endfor
        @if(isset($showNumber) && $showNumber)
            <span class="ml-2 text-sm text-zinc-400">{{ $rating }}/{{ $maxRating }}</span>
        @endif
    @endif
</div>
