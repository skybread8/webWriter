<x-admin.layout title="Pedidos">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Gestión de pedidos</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Pedidos y envíos
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Gestiona todos los pedidos, controla los envíos y procesa devoluciones cuando sea necesario.
            </p>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="grid gap-4 md:grid-cols-4">
            <div class="border border-zinc-800 rounded-2xl p-4 bg-zinc-900/40">
                <div class="text-xs text-zinc-500 mb-1">Total pedidos</div>
                <div class="text-2xl font-semibold">{{ number_format($totalOrders) }}</div>
            </div>
            <div class="border border-zinc-800 rounded-2xl p-4 bg-zinc-900/40">
                <div class="text-xs text-zinc-500 mb-1">Pendientes de envío</div>
                <div class="text-2xl font-semibold text-amber-400">{{ number_format($pendingShipments) }}</div>
            </div>
            <div class="border border-zinc-800 rounded-2xl p-4 bg-zinc-900/40">
                <div class="text-xs text-zinc-500 mb-1">Enviados</div>
                <div class="text-2xl font-semibold text-green-400">{{ number_format($shippedOrders) }}</div>
            </div>
            <div class="border border-zinc-800 rounded-2xl p-4 bg-zinc-900/40">
                <div class="text-xs text-zinc-500 mb-1">Devoluciones</div>
                <div class="text-2xl font-semibold text-red-400">{{ number_format($refundedOrders) }}</div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="space-y-4">
                <div class="grid gap-4 md:grid-cols-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-300 mb-2">Buscar</label>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Número, nombre, email..."
                            class="w-full px-3 py-2 bg-zinc-950 border border-zinc-800 rounded-lg text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-300 mb-2">Estado</label>
                        <select name="status" class="w-full px-3 py-2 bg-zinc-950 border border-zinc-800 rounded-lg text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500">
                            <option value="">Todos</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Pagado</option>
                            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Enviado</option>
                            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Entregado</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-300 mb-2">Envío</label>
                        <select name="shipped" class="w-full px-3 py-2 bg-zinc-950 border border-zinc-800 rounded-lg text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500">
                            <option value="">Todos</option>
                            <option value="0" {{ request('shipped') === '0' ? 'selected' : '' }}>No enviado</option>
                            <option value="1" {{ request('shipped') === '1' ? 'selected' : '' }}>Enviado</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-300 mb-2">Devolución</label>
                        <select name="refunded" class="w-full px-3 py-2 bg-zinc-950 border border-zinc-800 rounded-lg text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500">
                            <option value="">Todos</option>
                            <option value="0" {{ request('refunded') === '0' ? 'selected' : '' }}>Sin devolución</option>
                            <option value="1" {{ request('refunded') === '1' ? 'selected' : '' }}>Con devolución</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-zinc-100 text-zinc-950 text-xs font-semibold rounded-lg hover:bg-white transition-colors">
                        Filtrar
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-zinc-800 text-zinc-200 text-xs font-semibold rounded-lg hover:bg-zinc-700 transition-colors">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Lista de pedidos -->
        @if($orders->isEmpty())
            <div class="border border-zinc-800 rounded-2xl p-8 bg-zinc-900/40 text-center">
                <p class="text-sm text-zinc-500">No se encontraron pedidos con los filtros seleccionados.</p>
            </div>
        @else
            <div class="border border-zinc-800 rounded-2xl bg-zinc-900/40 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-800 bg-zinc-950/50">
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Pedido</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Cliente</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Fecha</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Total</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Estado</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Envío</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="border-b border-zinc-800/50 hover:bg-zinc-900/60">
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-zinc-200">{{ $order->order_number }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-zinc-300">{{ $order->customer_name ?? $order->user?->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-zinc-500">{{ $order->customer_email ?? $order->user?->email ?? 'N/A' }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-zinc-400 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-amber-400">{{ number_format($order->total, 2) }} €</div>
                                    </td>
                                    <td class="py-3 px-4">
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
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-zinc-500/20 text-zinc-400' }}">
                                            {{ $statusLabels[$order->status] ?? $order->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($order->shipped)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400">
                                                Enviado
                                            </span>
                                            @if($order->shipped_at)
                                                <div class="text-xs text-zinc-500 mt-1">{{ $order->shipped_at->format('d/m/Y') }}</div>
                                            @endif
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-amber-500/20 text-amber-400">
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="px-3 py-1.5 bg-zinc-100 text-zinc-950 text-xs font-semibold rounded-lg hover:bg-white transition-colors">
                                            Ver detalles
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                @if($orders->hasPages())
                    <div class="border-t border-zinc-800 px-4 py-3">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-admin.layout>
