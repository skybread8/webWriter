@extends('layouts.site')

@section('title', 'Crear cuenta')

@section('content')
    <section class="px-5 sm:px-8 py-14 sm:py-20 max-w-2xl mx-auto">
        <div class="space-y-6">
            <div>
                <div class="inline-flex items-center gap-2 mb-3">
                    <x-icons.user class="w-5 h-5 text-amber-400" />
                    <p class="text-[11px] tracking-[0.3em] uppercase text-zinc-400">
                        Registro
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-4xl sm:text-5xl tracking-tight mb-2">
                    Crear cuenta
                </h1>
                <p class="text-sm text-zinc-400">
                    Regístrate para gestionar tus pedidos y acceder a contenido exclusivo
                </p>
            </div>
        
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-zinc-300 mb-1">
                    Nombre completo
                </label>
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus 
                    autocomplete="name"
                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                />
                @error('name')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-zinc-300 mb-1">
                    Correo electrónico
                </label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autocomplete="username"
                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                />
                @error('email')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-zinc-300 mb-1">
                    Teléfono
                </label>
                <input 
                    id="phone" 
                    type="tel" 
                    name="phone" 
                    value="{{ old('phone') }}" 
                    required 
                    autocomplete="tel"
                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                />
                @error('phone')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-zinc-300 mb-1">
                    Dirección
                </label>
                <input 
                    id="address" 
                    type="text" 
                    name="address" 
                    value="{{ old('address') }}" 
                    required 
                    autocomplete="street-address"
                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                />
                @error('address')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- City, Postal Code, Province -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="city" class="block text-sm font-medium text-zinc-300 mb-1">
                        Ciudad
                    </label>
                    <input 
                        id="city" 
                        type="text" 
                        name="city" 
                        value="{{ old('city') }}" 
                        required 
                        autocomplete="address-level2"
                        class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                    />
                    @error('city')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="postal_code" class="block text-sm font-medium text-zinc-300 mb-1">
                        Código postal
                    </label>
                    <input 
                        id="postal_code" 
                        type="text" 
                        name="postal_code" 
                        value="{{ old('postal_code') }}" 
                        required 
                        autocomplete="postal-code"
                        class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                    />
                    @error('postal_code')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="province" class="block text-sm font-medium text-zinc-300 mb-1">
                        Provincia
                    </label>
                    <input 
                        id="province" 
                        type="text" 
                        name="province" 
                        value="{{ old('province') }}" 
                        required 
                        autocomplete="address-level1"
                        class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                    />
                    @error('province')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Country -->
            <div>
                <label for="country" class="block text-sm font-medium text-zinc-300 mb-1">
                    País
                </label>
                <input 
                    id="country" 
                    type="text" 
                    name="country" 
                    value="{{ old('country', 'España') }}" 
                    required 
                    autocomplete="country"
                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                />
                @error('country')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-zinc-300 mb-1">
                    Contraseña
                </label>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="new-password"
                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                />
                @error('password')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-zinc-300 mb-1">
                    Confirmar contraseña
                </label>
                <input 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                />
            </div>

            <div class="flex items-center justify-between pt-4">
                <a class="text-sm text-zinc-400 hover:text-zinc-200 underline" href="{{ route('login') }}">
                    ¿Ya tienes cuenta? Inicia sesión
                </a>

                <x-button type="submit">
                    Registrarse
                </x-button>
            </div>
        </form>
        </div>
    </section>
@endsection
