@extends('layouts.site')

@section('title', 'Pedido ' . $order->order_number)

@section('content')
    <section 
        x-data="scrollReveal(0)"
        class="px-4 sm:px-5 md:px-8 py-10 sm:py-14 md:py-20 max-w-4xl mx-auto"
    >
        <div 
            class="space-y-6 sm:space-y-8"
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div>
                <a href="{{ localized_route('orders.index') }}" class="inline-flex items-center gap-2 text-xs text-zinc-400 hover:text-zinc-200 transition-colors mb-3 sm:mb-4 group">
                    <x-icons.arrow-right class="w-3.5 h-3.5 sm:w-4 sm:h-4 rotate-180 transition-transform group-hover:-translate-x-1" />
                    <span>{{ __('common.orders.back_to_orders') }}</span>
                </a>
                <div class="inline-flex items-center gap-2 mb-2 sm:mb-3">
                    <x-icons.shopping-cart class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400" />
                    <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                        Pedido
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl tracking-tight mb-2">
                    {{ __('common.orders.order_details') }}
                </h1>
                <p class="text-xs sm:text-sm text-zinc-400">
                    {{ __('common.orders.order_number') }}: <strong class="text-zinc-200">{{ $order->order_number }}</strong>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <!-- Información del pedido -->
                <div class="space-y-4 sm:space-y-6">
                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-zinc-100">{{ __('common.orders.customer_info') }}</h2>
                        <div class="space-y-2 text-xs sm:text-sm">
                            <p><span class="text-zinc-400">Nombre:</span> <span class="text-zinc-100">{{ $order->customer_name }}</span></p>
                            <p><span class="text-zinc-400">Email:</span> <span class="text-zinc-100 break-all">{{ $order->customer_email }}</span></p>
                            <p><span class="text-zinc-400">Teléfono:</span> <span class="text-zinc-100">{{ $order->customer_phone }}</span></p>
                        </div>
                    </div>

                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-zinc-100">{{ __('common.orders.shipping_info') }}</h2>
                        <div class="space-y-2 text-xs sm:text-sm">
                            <p class="text-zinc-100">{{ $order->customer_address }}</p>
                            <p class="text-zinc-100">{{ $order->customer_postal_code }} {{ $order->customer_city }}</p>
                            <p class="text-zinc-100">{{ $order->customer_province }}, {{ $order->customer_country }}</p>
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                            <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-zinc-100">Notas</h2>
                            <p class="text-xs sm:text-sm text-zinc-300 whitespace-pre-wrap">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>

                <!-- Items del pedido -->
                <div class="space-y-4 sm:space-y-6">
                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4 mb-3 sm:mb-4">
                            <h2 class="text-base sm:text-lg font-semibold text-zinc-100">{{ __('common.orders.items') }}</h2>
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
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-start gap-3 sm:gap-4 pb-3 sm:pb-4 border-b border-zinc-800 last:border-0">
                                    @if($item->book && $item->book->cover_image)
                                        <img src="{{ asset('storage/'.$item->book->cover_image) }}" alt="{{ $item->book_title }}" class="w-12 h-16 sm:w-16 sm:h-20 rounded-lg object-cover border border-zinc-800 flex-shrink-0">
                                    @else
                                        <div class="w-12 h-16 sm:w-16 sm:h-20 rounded-lg border border-dashed border-zinc-700 flex items-center justify-center bg-zinc-950 flex-shrink-0">
                                            <x-icons.book class="w-4 h-4 sm:w-6 sm:h-6 text-zinc-700" />
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-xs sm:text-sm font-medium text-zinc-100 mb-1 truncate">{{ $item->book_title }}</h3>
                                        <p class="text-[10px] sm:text-xs text-zinc-400 mb-1 sm:mb-2">{{ __('common.checkout.quantity') }}: {{ $item->quantity }}</p>
                                        <p class="text-xs sm:text-sm font-semibold text-amber-400">{{ number_format($item->subtotal, 2, ',', '.') }} €</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-zinc-800 flex items-center justify-between">
                            <span class="text-sm sm:text-base font-semibold text-zinc-300">{{ __('common.orders.total') }}:</span>
                            <span class="text-xl sm:text-2xl font-bold text-amber-400">{{ number_format($order->total, 2, ',', '.') }} €</span>
                        </div>
                    </div>

                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-zinc-100">Información del pedido</h2>
                        <div class="space-y-2 text-xs sm:text-sm">
                            <p><span class="text-zinc-400">{{ __('common.orders.date') }}:</span> <span class="text-zinc-100">{{ $order->created_at->format('d/m/Y H:i') }}</span></p>
                            @if($order->stripe_session_id)
                                <p class="break-all"><span class="text-zinc-400">ID de pago:</span> <span class="text-zinc-100 font-mono text-[10px] sm:text-xs">{{ $order->stripe_session_id }}</span></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
