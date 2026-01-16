<x-admin.layout title="Detalles del pedido">
    <div class="space-y-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Pedido</div>
                <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                    {{ $order->order_number }}
                </h1>
                <p class="mt-3 text-sm text-zinc-400">
                    Fecha: {{ $order->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
            <div>
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-zinc-800 text-zinc-200 text-xs font-semibold rounded-lg hover:bg-zinc-700 transition-colors">
                    Volver a pedidos
                </a>
            </div>
        </div>

        @if(session('status'))
            <div class="bg-amber-500/10 border border-amber-500/20 rounded-lg p-4 text-sm text-amber-400">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-6 md:grid-cols-2">
            <!-- Información del cliente -->
            <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
                <h2 class="font-['DM_Serif_Display'] text-xl mb-4">Información del cliente</h2>
                <div class="space-y-3 text-sm">
                    <div>
                        <div class="text-xs text-zinc-500 mb-1">Nombre</div>
                        <div class="text-zinc-200">{{ $order->customer_name ?? $order->user?->name ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-zinc-500 mb-1">Email</div>
                        <div class="text-zinc-200">{{ $order->customer_email ?? $order->user?->email ?? 'N/A' }}</div>
                    </div>
                    @if($order->customer_phone)
                        <div>
                            <div class="text-xs text-zinc-500 mb-1">Teléfono</div>
                            <div class="text-zinc-200">{{ $order->customer_phone }}</div>
                        </div>
                    @endif
                    <div>
                        <div class="text-xs text-zinc-500 mb-1">Dirección de envío</div>
                        <div class="text-zinc-200">
                            {{ $order->customer_address }}<br>
                            {{ $order->customer_postal_code }} {{ $order->customer_city }}
                            @if($order->customer_province)
                                , {{ $order->customer_province }}
                            @endif
                            @if($order->customer_country)
                                <br>{{ $order->customer_country }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado y acciones -->
            <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
                <h2 class="font-['DM_Serif_Display'] text-xl mb-4">Estado del pedido</h2>
                <div class="space-y-4">
                    <div>
                        <div class="text-xs text-zinc-500 mb-1">Estado</div>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-500/20 text-yellow-400',
                                'paid' => 'bg-blue-500/20 text-blue-400',
                                'shipped' => 'bg-green-500/20 text-green-400',
                                'delivered' => 'bg-emerald-500/20 text-emerald-400',
                                'cancelled' => 'bg-red-500/20 text-red-400',
                            ];
                            $statusLabels = [
                                'pending' => 'Pendiente',
                                'paid' => 'Pagado',
                                'shipped' => 'Enviado',
                                'delivered' => 'Entregado',
                                'cancelled' => 'Cancelado',
                            ];
                        @endphp
                        <span class="px-3 py-1.5 text-sm font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-zinc-500/20 text-zinc-400' }}">
                            {{ $statusLabels[$order->status] ?? $order->status }}
                        </span>
                    </div>
                    <div>
                        <div class="text-xs text-zinc-500 mb-1">Total</div>
                        <div class="text-2xl font-semibold text-amber-400">{{ number_format($order->total, 2) }} €</div>
                    </div>
                    <div>
                        <div class="text-xs text-zinc-500 mb-1">Envío</div>
                        @if($order->shipped)
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-green-500/20 text-green-400">
                                    Enviado
                                </span>
                                @if($order->shipped_at)
                                    <span class="text-xs text-zinc-500">el {{ $order->shipped_at->format('d/m/Y H:i') }}</span>
                                @endif
                            </div>
                        @else
                            <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-amber-500/20 text-amber-400">
                                Pendiente de envío
                            </span>
                        @endif
                    </div>
                    @if($order->refunded)
                        <div>
                            <div class="text-xs text-zinc-500 mb-1">Devolución</div>
                            <div class="space-y-2">
                                <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-red-500/20 text-red-400">
                                    Devuelto: {{ number_format($order->refund_amount, 2) }} €
                                </span>
                                @if($order->refund_reason)
                                    <div class="text-xs text-zinc-400 mt-2">{{ $order->refund_reason }}</div>
                                @endif
                                @if($order->refunded_at)
                                    <div class="text-xs text-zinc-500">el {{ $order->refunded_at->format('d/m/Y H:i') }}</div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Items del pedido -->
        <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
            <h2 class="font-['DM_Serif_Display'] text-xl mb-4">Libros pedidos</h2>
            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between py-3 border-b border-zinc-800/50 last:border-0">
                        <div class="flex items-center gap-4">
                            @if($item->book && $item->book->cover_image)
                                <img src="{{ get_image_url($item->book->cover_image) }}" alt="{{ $item->book_title }}" class="w-16 h-20 rounded-md object-cover border border-zinc-800">
                            @endif
                            <div>
                                <div class="font-semibold text-zinc-200">{{ $item->book_title }}</div>
                                <div class="text-xs text-zinc-500">Cantidad: {{ $item->quantity }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-zinc-200">{{ number_format($item->subtotal, 2) }} €</div>
                            <div class="text-xs text-zinc-500">{{ number_format($item->book_price, 2) }} € c/u</div>
                        </div>
                    </div>
                @endforeach
                <div class="flex items-center justify-between pt-3 border-t border-zinc-800">
                    <div class="font-semibold text-lg text-zinc-200">Total</div>
                    <div class="font-semibold text-lg text-amber-400">{{ number_format($order->total, 2) }} €</div>
                </div>
            </div>
        </div>

        @if($order->notes)
            <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
                <h2 class="font-['DM_Serif_Display'] text-xl mb-4">Notas del pedido</h2>
                <p class="text-sm text-zinc-300">{{ $order->notes }}</p>
            </div>
        @endif

        <!-- Acciones -->
        <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
            <h2 class="font-['DM_Serif_Display'] text-xl mb-4">Acciones</h2>
            <div class="space-y-4">
                @if(!$order->shipped && $order->status === 'paid')
                    <form method="POST" action="{{ route('admin.orders.mark-shipped', $order) }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-zinc-950 text-sm font-semibold rounded-lg transition-colors">
                            Marcar como enviado
                        </button>
                    </form>
                @elseif($order->shipped)
                    <form method="POST" action="{{ route('admin.orders.mark-not-shipped', $order) }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-200 text-sm font-semibold rounded-lg transition-colors">
                            Desmarcar como enviado
                        </button>
                    </form>
                @endif

                @if(!$order->refunded && $order->status !== 'cancelled')
                    <div class="pt-4 border-t border-zinc-800">
                        <h3 class="text-sm font-semibold text-zinc-300 mb-3">Procesar devolución</h3>
                        <form method="POST" action="{{ route('admin.orders.refund', $order) }}" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-xs font-medium text-zinc-300 mb-2">Importe a devolver (€)</label>
                                <input 
                                    type="number" 
                                    name="refund_amount" 
                                    step="0.01"
                                    min="0"
                                    max="{{ $order->total }}"
                                    value="{{ $order->total }}"
                                    required
                                    class="w-full md:w-64 px-3 py-2 bg-zinc-950 border border-zinc-800 rounded-lg text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                                >
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-zinc-300 mb-2">Motivo de la devolución</label>
                                <textarea 
                                    name="refund_reason" 
                                    rows="3"
                                    required
                                    placeholder="Explica el motivo de la devolución..."
                                    class="w-full px-3 py-2 bg-zinc-950 border border-zinc-800 rounded-lg text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                                ></textarea>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white text-sm font-semibold rounded-lg transition-colors">
                                Procesar devolución
                            </button>
                        </form>
                    </div>
                @elseif($order->refunded)
                    <div class="pt-4 border-t border-zinc-800">
                        <form method="POST" action="{{ route('admin.orders.cancel-refund', $order) }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-200 text-sm font-semibold rounded-lg transition-colors">
                                Cancelar devolución
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin.layout>
