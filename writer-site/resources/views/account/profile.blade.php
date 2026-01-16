@extends('layouts.site')

@section('title', 'Mi perfil')

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
                <a href="{{ localized_route('account.index') }}" class="inline-flex items-center gap-2 text-xs text-zinc-400 hover:text-zinc-200 transition-colors mb-3 sm:mb-4 group">
                    <x-icons.arrow-right class="w-3.5 h-3.5 sm:w-4 sm:h-4 rotate-180 transition-transform group-hover:-translate-x-1" />
                    <span>Volver a mi cuenta</span>
                </a>
                <div class="inline-flex items-center gap-2 mb-2 sm:mb-3">
                    <x-icons.user class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400" />
                    <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                        Perfil
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl tracking-tight mb-2">
                    Mi perfil
                </h1>
                <p class="text-xs sm:text-sm text-zinc-400">
                    Actualiza tu información personal y dirección de envío
                </p>
            </div>

            @if (session('status'))
                <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                <!-- Menú lateral -->
                <div class="md:col-span-1">
                    <nav class="space-y-2 border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40" role="navigation">
                        <a href="{{ localized_route('account.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-zinc-400 hover:bg-zinc-800 hover:text-zinc-200 transition-colors">
                            <x-icons.user class="w-4 h-4" />
                            <span class="text-sm font-medium">Resumen</span>
                        </a>
                        <a href="{{ localized_route('account.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-zinc-800 text-zinc-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium">Mi perfil</span>
                        </a>
                        <a href="{{ localized_route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-zinc-400 hover:bg-zinc-800 hover:text-zinc-200 transition-colors">
                            <x-icons.shopping-cart class="w-4 h-4" />
                            <span class="text-sm font-medium">Mis pedidos</span>
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

                <!-- Formulario de perfil -->
                <div class="md:col-span-2 space-y-4 sm:space-y-6">
                    <!-- Información personal -->
                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <h2 class="text-base sm:text-lg font-semibold mb-4 text-zinc-100">Información personal</h2>
                        <form method="POST" action="{{ localized_route('account.profile.update') }}" class="space-y-3 sm:space-y-4">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label for="name" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    Nombre completo <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                                @error('name')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    Correo electrónico <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                                @error('email')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    Teléfono <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    value="{{ old('phone', $user->phone) }}"
                                    required
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                                @error('phone')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-2">
                                <x-button type="submit" class="w-full sm:w-auto">
                                    Guardar cambios
                                </x-button>
                            </div>
                        </form>
                    </div>

                    <!-- Dirección de envío -->
                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <h2 class="text-base sm:text-lg font-semibold mb-4 text-zinc-100">Dirección de envío</h2>
                        <form method="POST" action="{{ localized_route('account.profile.update') }}" class="space-y-3 sm:space-y-4">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label for="address" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    Dirección <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="address" 
                                    name="address" 
                                    value="{{ old('address', $user->address) }}"
                                    required
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                                @error('address')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <div>
                                    <label for="city" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                        Ciudad <span class="text-red-400">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="city" 
                                        name="city" 
                                        value="{{ old('city', $user->city) }}"
                                        required
                                        class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                    >
                                    @error('city')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="postal_code" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                        Código postal <span class="text-red-400">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="postal_code" 
                                        name="postal_code" 
                                        value="{{ old('postal_code', $user->postal_code) }}"
                                        required
                                        class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                    >
                                    @error('postal_code')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <div>
                                    <label for="province" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                        Provincia <span class="text-red-400">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="province" 
                                        name="province" 
                                        value="{{ old('province', $user->province) }}"
                                        required
                                        class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                    >
                                    @error('province')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="country" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                        País <span class="text-red-400">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="country" 
                                        name="country" 
                                        value="{{ old('country', $user->country ?? 'España') }}"
                                        required
                                        class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                    >
                                    @error('country')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="pt-2">
                                <x-button type="submit" class="w-full sm:w-auto">
                                    Guardar dirección
                                </x-button>
                            </div>
                        </form>
                    </div>

                    <!-- Cambio de contraseña -->
                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <h2 class="text-base sm:text-lg font-semibold mb-4 text-zinc-100">Cambiar contraseña</h2>
                        <form method="POST" action="{{ route('password.update') }}" class="space-y-3 sm:space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="current_password" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    Contraseña actual <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    id="current_password" 
                                    name="current_password" 
                                    required
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                                @error('current_password', 'updatePassword')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    Nueva contraseña <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    required
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                                @error('password', 'updatePassword')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    Confirmar nueva contraseña <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    required
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                            </div>

                            <div class="pt-2">
                                <x-button type="submit" class="w-full sm:w-auto">
                                    Actualizar contraseña
                                </x-button>
                            </div>
                        </form>
                        @if (session('status') === 'password-updated')
                            <div class="mt-4 rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm">
                                Tu contraseña se ha actualizado correctamente.
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
