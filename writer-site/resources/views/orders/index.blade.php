@extends('layouts.site')

@section('title', 'Mis pedidos')

@section('content')
    <section 
        x-data="scrollReveal(0)"
        class="px-4 sm:px-5 md:px-8 py-10 sm:py-14 md:py-20 max-w-6xl mx-auto"
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
                    <x-icons.user class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400" />
                    <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                        {{ __('common.orders.account') }}
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl tracking-tight mb-2">
                    {{ __('common.orders.title') }}
                </h1>
                <p class="text-xs sm:text-sm text-zinc-400">
                    {{ __('common.orders.description') }}
                </p>
            </div>

            @if($orders->isEmpty())
                <div class="text-center py-16 space-y-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-zinc-900 border border-zinc-800 mb-4">
                        <x-icons.shopping-cart class="w-10 h-10 text-zinc-600" />
                    </div>
                    <p class="text-zinc-400 text-lg">{{ __('common.orders.no_orders') }}</p>
                    <a href="{{ localized_route('books.index.public') }}" class="inline-flex items-center gap-2 text-sm tracking-[0.25em] uppercase text-zinc-300 hover:text-zinc-100 transition-colors group">
                        <x-icons.arrow-right class="w-4 h-4 rotate-180 transition-transform group-hover:-translate-x-1" />
                        <span>{{ __('common.books.title') }}</span>
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($orders as $index => $order)
                        <div 
                            class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40 hover:bg-zinc-900/60 hover:border-zinc-700 transition-all duration-300"
                            :class="show ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-4'"
                            x-data="scrollReveal({{ ($index + 1) * 100 }})"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0"
                        >
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:flex-wrap items-start sm:items-center gap-2 sm:gap-4 mb-2">
                                        <h3 class="text-base sm:text-lg font-semibold text-zinc-100 truncate">
                                            {{ __('common.orders.order_number') }}: {{ $order->order_number }}
                                        </h3>
                                        <span class="px-2 sm:px-3 py-1 rounded-full text-[10px] sm:text-xs font-medium
                                            @if($order->status === 'paid') bg-emerald-900/40 text-emerald-300 border border-emerald-800/50
                                            @elseif($order->status === 'processing') bg-blue-900/40 text-blue-300 border border-blue-800/50
                                            @elseif($order->status === 'shipped') bg-purple-900/40 text-purple-300 border border-purple-800/50
                                            @elseif($order->status === 'delivered') bg-zinc-900/40 text-zinc-300 border border-zinc-800/50
                                            @elseif($order->status === 'cancelled') bg-red-900/40 text-red-300 border border-red-800/50
                                            @else bg-amber-900/40 text-amber-300 border border-amber-800/50
                                            @endif
                                        ">
                                            @if($order->status === 'pending') {{ __('common.orders.status_pending') }}
                                            @elseif($order->status === 'paid') {{ __('common.orders.status_paid') }}
                                            @elseif($order->status === 'processing') {{ __('common.orders.status_processing') }}
                                            @elseif($order->status === 'shipped') {{ __('common.orders.status_shipped') }}
                                            @elseif($order->status === 'delivered') {{ __('common.orders.status_delivered') }}
                                            @elseif($order->status === 'cancelled') {{ __('common.orders.status_cancelled') }}
                                            @endif
                                        </span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-zinc-400">
                                        {{ __('common.orders.date') }}: {{ $order->created_at->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="text-xs sm:text-sm text-zinc-400 mt-1">
                                        {{ $order->items->count() }} {{ $order->items->count() === 1 ? __('common.orders.article') : __('common.orders.articles') }}
                                    </p>
                                </div>
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4">
                                    <div class="text-left sm:text-right">
                                        <p class="text-xs text-zinc-400 mb-1">{{ __('common.orders.total') }}</p>
                                        <p class="text-lg sm:text-xl font-bold text-amber-400">{{ number_format($order->total, 2, ',', '.') }} €</p>
                                    </div>
                                    <a href="{{ localized_route('orders.show', $order) }}" class="inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2 rounded-lg bg-zinc-800 text-zinc-100 text-xs sm:text-sm hover:bg-zinc-700 transition-colors w-full sm:w-auto">
                                        <span>{{ __('common.orders.view') }}</span>
                                        <x-icons.arrow-right class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
