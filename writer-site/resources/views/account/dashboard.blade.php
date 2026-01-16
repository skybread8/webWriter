@extends('layouts.site')

@section('title', 'Mi cuenta')

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
                        Cuenta
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl tracking-tight mb-2">
                    Mi cuenta
                </h1>
                <p class="text-xs sm:text-sm text-zinc-400">
                    Gestiona tu información personal y revisa tus pedidos
                </p>
            </div>

            @if (session('status'))
                <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                <!-- Menú de navegación -->
                <div class="md:col-span-1">
                    <nav class="space-y-2 border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40" role="navigation" aria-label="Menú de cuenta">
                        <a href="{{ localized_route('account.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('account.index') ? 'bg-zinc-800 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-800 hover:text-zinc-200' }} transition-colors">
                            <x-icons.user class="w-4 h-4" />
                            <span class="text-sm font-medium">Resumen</span>
                        </a>
                        <a href="{{ localized_route('account.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('account.profile*') ? 'bg-zinc-800 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-800 hover:text-zinc-200' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium">Mi perfil</span>
                        </a>
                        <a href="{{ localized_route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('orders.*') ? 'bg-zinc-800 text-zinc-100' : 'text-zinc-400 hover:bg-zinc-800 hover:text-zinc-200' }} transition-colors">
                            <x-icons.shopping-cart class="w-4 h-4" />
                            <span class="text-sm font-medium">Mis pedidos</span>
                            @if($ordersCount > 0)
                                <span class="ml-auto px-2 py-0.5 text-xs font-semibold text-zinc-950 bg-amber-400 rounded-full">{{ $ordersCount }}</span>
                            @endif
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-zinc-800">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-zinc-400 hover:bg-zinc-800 hover:text-red-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="text-sm font-medium">Cerrar sesión</span>
                            </button>
                        </form>
                    </nav>
                </div>

                <!-- Contenido principal -->
                <div class="md:col-span-2 space-y-4 sm:space-y-6">
                    <!-- Información del usuario -->
                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <h2 class="text-base sm:text-lg font-semibold mb-4 text-zinc-100">Información personal</h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-zinc-400 mb-1">Nombre completo</p>
                                <p class="text-sm sm:text-base text-zinc-100">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-zinc-400 mb-1">Correo electrónico</p>
                                <p class="text-sm sm:text-base text-zinc-100 break-all">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-zinc-400 mb-1">Teléfono</p>
                                <p class="text-sm sm:text-base text-zinc-100">{{ $user->phone ?? 'No especificado' }}</p>
                            </div>
                            <a href="{{ localized_route('account.profile') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm text-amber-400 hover:text-amber-300 transition-colors mt-4">
                                <span>Editar perfil</span>
                                <x-icons.arrow-right class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                            </a>
                        </div>
                    </div>

                    <!-- Dirección de envío -->
                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <h2 class="text-base sm:text-lg font-semibold mb-4 text-zinc-100">Dirección de envío</h2>
                        <div class="space-y-2">
                            <p class="text-sm sm:text-base text-zinc-100">{{ $user->address ?? 'No especificada' }}</p>
                            <p class="text-sm sm:text-base text-zinc-100">
                                {{ $user->postal_code ?? '' }} {{ $user->city ?? '' }}
                            </p>
                            <p class="text-sm sm:text-base text-zinc-100">
                                {{ $user->province ?? '' }}{{ $user->province && $user->country ? ', ' : '' }}{{ $user->country ?? '' }}
                            </p>
                            <a href="{{ localized_route('account.profile') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm text-amber-400 hover:text-amber-300 transition-colors mt-4">
                                <span>Editar dirección</span>
                                <x-icons.arrow-right class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                            </a>
                        </div>
                    </div>

                    <!-- Pedidos recientes -->
                    @if($recentOrders->isNotEmpty())
                        <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-base sm:text-lg font-semibold text-zinc-100">Pedidos recientes</h2>
                                <a href="{{ localized_route('orders.index') }}" class="text-xs sm:text-sm text-amber-400 hover:text-amber-300 transition-colors">
                                    Ver todos
                                </a>
                            </div>
                            <div class="space-y-3">
                                @foreach($recentOrders as $order)
                                    <a href="{{ localized_route('orders.show', $order) }}" class="block p-3 rounded-lg border border-zinc-800 hover:border-zinc-700 hover:bg-zinc-900/60 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-xs sm:text-sm font-medium text-zinc-100">{{ $order->order_number }}</p>
                                                <p class="text-xs text-zinc-400 mt-1">{{ $order->created_at->format('d/m/Y') }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs sm:text-sm font-semibold text-amber-400">{{ number_format($order->total, 2, ',', '.') }} €</p>
                                                <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-medium
                                                    @if($order->status === 'paid') bg-emerald-900/40 text-emerald-300 border border-emerald-800/50
                                                    @elseif($order->status === 'processing') bg-blue-900/40 text-blue-300 border border-blue-800/50
                                                    @elseif($order->status === 'shipped') bg-purple-900/40 text-purple-300 border border-purple-800/50
                                                    @elseif($order->status === 'delivered') bg-zinc-900/40 text-zinc-300 border border-zinc-800/50
                                                    @elseif($order->status === 'cancelled') bg-red-900/40 text-red-300 border border-red-800/50
                                                    @else bg-amber-900/40 text-amber-300 border border-amber-800/50
                                                    @endif
                                                ">
                                                    @if($order->status === 'pending') Pendiente
                                                    @elseif($order->status === 'paid') Pagado
                                                    @elseif($order->status === 'processing') En proceso
                                                    @elseif($order->status === 'shipped') Enviado
                                                    @elseif($order->status === 'delivered') Entregado
                                                    @elseif($order->status === 'cancelled') Cancelado
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40 text-center">
                            <p class="text-sm text-zinc-400 mb-4">Aún no has realizado ningún pedido</p>
                            <a href="{{ localized_route('books.index.public') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm text-amber-400 hover:text-amber-300 transition-colors">
                                <span>Explorar libros</span>
                                <x-icons.arrow-right class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
