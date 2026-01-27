@extends('layouts.site')

@section('title', 'Carrito de compra')

@section('content')
    <section 
        x-data="scrollReveal(0)"
        class="px-4 sm:px-5 md:px-8 py-10 sm:py-14 md:py-20 max-w-5xl mx-auto"
    >
        <div 
            class="space-y-6 sm:space-y-8"
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div>
                <div class="inline-flex items-center gap-2 mb-2 sm:mb-3">
                    <x-icons.shopping-cart class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400" />
                    <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                        Carrito
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl tracking-tight mb-2">
                    {{ __('common.cart.title') }}
                </h1>
                <p class="text-xs sm:text-sm text-zinc-400">
                    {{ __('common.cart.description') }}
                </p>
            </div>

            @if (session('status'))
                <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if(empty($books))
                <div class="text-center py-16 space-y-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-zinc-900 border border-zinc-800 mb-4">
                        <x-icons.shopping-cart class="w-10 h-10 text-zinc-600" />
                    </div>
                    <p class="text-zinc-400 text-lg">{{ __('common.cart.empty') }}</p>
                    <a href="{{ localized_route('books.index.public') }}" class="inline-flex items-center gap-2 text-sm tracking-[0.25em] uppercase text-zinc-300 hover:text-zinc-100 transition-colors group">
                        <x-icons.arrow-right class="w-4 h-4 rotate-180 transition-transform group-hover:-translate-x-1" />
                        <span>{{ __('common.books.title') }}</span>
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($books as $index => $item)
                        <div 
                            class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4 md:gap-5 border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-5 bg-zinc-900/40 hover:bg-zinc-900/60 hover:border-zinc-700 transition-all duration-300"
                            :class="show ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-4'"
                            x-data="scrollReveal({{ ($index + 1) * 100 }})"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0"
                        >
                            @if($item['image_url'])
                                <img src="{{ $item['image_url'] }}" alt="{{ $item['title'] }}" class="w-20 h-28 sm:w-24 sm:h-32 rounded-xl object-cover border-2 border-zinc-800 shadow-lg flex-shrink-0">
                            @else
                                <div class="w-20 h-28 sm:w-24 sm:h-32 rounded-xl border-2 border-dashed border-zinc-700 flex items-center justify-center bg-zinc-950 flex-shrink-0">
                                    <x-icons.book class="w-6 h-6 sm:w-8 sm:h-8 text-zinc-700" />
                                </div>
                            @endif

                            <div class="flex-1 w-full space-y-2 sm:space-y-3">
                                <div>
                                    <h3 class="text-sm sm:text-base font-semibold text-zinc-50 mb-1">{{ $item['title'] }}</h3>
                                    <p class="text-xs sm:text-sm text-amber-400 font-medium">{{ number_format($item['price'], 2, ',', '.') }} €</p>
                                </div>

                                <div class="flex flex-col sm:flex-row sm:flex-wrap items-start sm:items-center gap-3 sm:gap-4">
                                    <form method="POST" action="{{ localized_route('cart.update', $item['id']) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label class="text-xs text-zinc-400">{{ __('common.cart.quantity') }}:</label>
                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ $item['quantity'] }}"
                                            min="1"
                                            class="w-16 sm:w-20 rounded-lg bg-zinc-950 border border-zinc-800 text-xs sm:text-sm text-zinc-100 text-center focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                            onchange="this.form.submit()"
                                        >
                                    </form>

                                    <div class="text-xs sm:text-sm">
                                        <span class="text-zinc-400">{{ __('common.cart.subtotal') }}: </span>
                                        <span class="text-zinc-100 font-bold text-sm sm:text-base">{{ number_format($item['subtotal'], 2, ',', '.') }} €</span>
                                    </div>

                                    <form method="POST" action="{{ localized_route('cart.remove', $item['id']) }}" class="sm:ml-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-400 hover:text-red-300 transition-colors underline underline-offset-4">
                                            {{ __('common.cart.remove') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-zinc-800 pt-6 sm:pt-8 space-y-4 sm:space-y-6 bg-zinc-900/40 rounded-2xl sm:rounded-3xl p-4 sm:p-6">
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-950 border border-zinc-800">
                        <span class="text-sm sm:text-base text-zinc-400 font-medium">{{ __('common.cart.total') }}:</span>
                        <span class="text-2xl sm:text-3xl font-bold text-amber-400">{{ number_format($total, 2, ',', '.') }} €</span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                        <a href="{{ localized_route('checkout.index') }}" class="flex-1">
                            <x-button type="button" class="w-full flex items-center justify-center gap-2 text-xs sm:text-sm">
                                <span>{{ __('common.cart.checkout') }}</span>
                                <x-icons.arrow-right class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                            </x-button>
                        </a>

                        <form method="POST" action="{{ localized_route('cart.clear') }}" onsubmit="return confirm('¿Seguro que quieres vaciar el carrito?');" class="sm:w-auto w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full sm:w-auto text-xs tracking-[0.25em] uppercase text-zinc-400 hover:text-red-400 transition-colors underline underline-offset-4 px-4 py-2">
                                {{ __('common.cart.clear') }}
                            </button>
                        </form>
                    </div>

                    <a href="{{ localized_route('books.index.public') }}" class="flex items-center justify-center gap-2 text-xs tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-200 transition-colors group">
                        <x-icons.arrow-right class="w-4 h-4 rotate-180 transition-transform group-hover:-translate-x-1" />
                        <span>{{ __('common.cart.continue_shopping') }}</span>
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
