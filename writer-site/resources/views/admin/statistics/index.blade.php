<x-admin.layout title="Estadísticas">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Análisis y ventas</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Estadísticas del sitio
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Monitoriza el tráfico, ventas, pedidos y mensajes de contacto para optimizar tu estrategia de ventas.
            </p>
        </div>

        @if(session('status'))
            <div class="bg-amber-500/10 border border-amber-500/20 rounded-lg p-4 text-sm text-amber-400">
                {{ session('status') }}
            </div>
        @endif

        <!-- Estadísticas de visitas -->
        <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
            <h2 class="font-['DM_Serif_Display'] text-2xl mb-4">Tráfico web</h2>
            <div class="grid gap-4 md:grid-cols-4">
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Total de visitas</div>
                    <div class="text-2xl font-semibold">{{ number_format($totalVisits) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Hoy</div>
                    <div class="text-2xl font-semibold">{{ number_format($visitsToday) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Esta semana</div>
                    <div class="text-2xl font-semibold">{{ number_format($visitsThisWeek) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Este mes</div>
                    <div class="text-2xl font-semibold">{{ number_format($visitsThisMonth) }}</div>
                </div>
            </div>
            
            @if($topPages->isNotEmpty())
                <div class="mt-6 pt-6 border-t border-zinc-800">
                    <h3 class="text-sm font-semibold text-zinc-300 mb-3">Páginas más visitadas</h3>
                    <div class="space-y-2">
                        @foreach($topPages as $page)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-400">{{ $page->path }}</span>
                                <span class="text-zinc-200 font-semibold">{{ number_format($page->visits) }} visitas</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Estadísticas de pedidos -->
        <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
            <h2 class="font-['DM_Serif_Display'] text-2xl mb-4">Pedidos y ventas</h2>
            <div class="grid gap-4 md:grid-cols-4">
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Total pedidos</div>
                    <div class="text-2xl font-semibold">{{ number_format($totalOrders) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Hoy</div>
                    <div class="text-2xl font-semibold">{{ number_format($ordersToday) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Esta semana</div>
                    <div class="text-2xl font-semibold">{{ number_format($ordersThisWeek) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Este mes</div>
                    <div class="text-2xl font-semibold">{{ number_format($ordersThisMonth) }}</div>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2 mt-4">
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Ingresos totales</div>
                    <div class="text-2xl font-semibold text-amber-400">{{ number_format($totalRevenue, 2) }} €</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Ingresos este mes</div>
                    <div class="text-2xl font-semibold text-amber-400">{{ number_format($revenueThisMonth, 2) }} €</div>
                </div>
            </div>
        </div>

        <!-- Pedidos pendientes de envío -->
        <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
            <h2 class="font-['DM_Serif_Display'] text-2xl mb-4">Pedidos pendientes de envío</h2>
            @if($pendingShipments->isEmpty())
                <p class="text-sm text-zinc-500">No hay pedidos pendientes de envío.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-800">
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Pedido</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Cliente</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Email</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Dirección</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Libros</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Total</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Fecha</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingShipments as $order)
                                <tr class="border-b border-zinc-800/50 hover:bg-zinc-900/60">
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-zinc-200">{{ $order->order_number }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-zinc-300">{{ $order->customer_name ?? $order->user?->name ?? 'N/A' }}</div>
                                        @if($order->customer_phone)
                                            <div class="text-xs text-zinc-500">{{ $order->customer_phone }}</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-zinc-300">{{ $order->customer_email ?? $order->user?->email ?? 'N/A' }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-zinc-300 text-xs max-w-xs">
                                            {{ $order->customer_address }}, {{ $order->customer_postal_code }} {{ $order->customer_city }}
                                            @if($order->customer_province)
                                                , {{ $order->customer_province }}
                                            @endif
                                            @if($order->customer_country)
                                                <br>{{ $order->customer_country }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-zinc-300 text-xs">
                                            @foreach($order->items as $item)
                                                <div>{{ $item->quantity }}x {{ $item->book->title }}</div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-amber-400">{{ number_format($order->total, 2) }} €</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-zinc-400 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <form method="POST" action="{{ route('admin.orders.mark-shipped', $order) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-zinc-950 text-xs font-semibold rounded-lg transition-colors">
                                                Marcar como enviado
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Pedidos enviados recientes -->
        @if($shippedOrders->isNotEmpty())
            <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
                <h2 class="font-['DM_Serif_Display'] text-2xl mb-4">Pedidos enviados recientemente</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-800">
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Pedido</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Cliente</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Fecha envío</th>
                                <th class="text-left py-3 px-4 text-zinc-400 font-semibold">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shippedOrders as $order)
                                <tr class="border-b border-zinc-800/50 hover:bg-zinc-900/60">
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-zinc-200">{{ $order->order_number }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-zinc-300">{{ $order->customer_name ?? $order->user?->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-zinc-400 text-xs">{{ $order->shipped_at?->format('d/m/Y H:i') ?? 'N/A' }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <form method="POST" action="{{ route('admin.orders.mark-not-shipped', $order) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-zinc-700 hover:bg-zinc-600 text-zinc-200 text-xs font-semibold rounded-lg transition-colors">
                                                Desmarcar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Estadísticas de emails recibidos -->
        <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
            <h2 class="font-['DM_Serif_Display'] text-2xl mb-4">Mensajes de contacto recibidos</h2>
            <div class="grid gap-4 md:grid-cols-4">
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Total mensajes</div>
                    <div class="text-2xl font-semibold">{{ number_format($totalEmails) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Hoy</div>
                    <div class="text-2xl font-semibold">{{ number_format($emailsToday) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Esta semana</div>
                    <div class="text-2xl font-semibold">{{ number_format($emailsThisWeek) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Este mes</div>
                    <div class="text-2xl font-semibold">{{ number_format($emailsThisMonth) }}</div>
                </div>
            </div>
            @if($unreadEmails > 0)
                <div class="mt-4 pt-4 border-t border-zinc-800">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-zinc-400">Mensajes sin leer:</span>
                        <span class="px-3 py-1 bg-amber-500/20 text-amber-400 text-sm font-semibold rounded-full">{{ $unreadEmails }}</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Estadísticas de emails enviados -->
        <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
            <h2 class="font-['DM_Serif_Display'] text-2xl mb-4">Emails enviados</h2>
            <div class="grid gap-4 md:grid-cols-4">
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Total enviados</div>
                    <div class="text-2xl font-semibold">{{ number_format($totalSentEmails) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Hoy</div>
                    <div class="text-2xl font-semibold">{{ number_format($sentEmailsToday) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Esta semana</div>
                    <div class="text-2xl font-semibold">{{ number_format($sentEmailsThisWeek) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Este mes</div>
                    <div class="text-2xl font-semibold">{{ number_format($sentEmailsThisMonth) }}</div>
                </div>
            </div>
            @if($failedEmails > 0)
                <div class="mt-4 pt-4 border-t border-zinc-800">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-zinc-400">Emails fallidos:</span>
                        <span class="px-3 py-1 bg-red-500/20 text-red-400 text-sm font-semibold rounded-full">{{ $failedEmails }}</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Estadísticas de libros -->
        <div class="border border-zinc-800 rounded-2xl p-6 bg-zinc-900/40">
            <h2 class="font-['DM_Serif_Display'] text-2xl mb-4">Libros</h2>
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Total libros</div>
                    <div class="text-2xl font-semibold">{{ number_format($totalBooks) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Libros activos</div>
                    <div class="text-2xl font-semibold">{{ number_format($activeBooks) }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500 mb-1">Libros vendidos</div>
                    <div class="text-2xl font-semibold text-amber-400">{{ number_format($booksSold) }}</div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
