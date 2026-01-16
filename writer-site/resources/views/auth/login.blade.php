@extends('layouts.site')

@section('title', 'Iniciar sesión')

@section('content')
    <section class="px-5 sm:px-8 py-14 sm:py-20 max-w-md mx-auto">
        <div class="space-y-6">
            <div>
                <div class="inline-flex items-center gap-2 mb-3">
                    <x-icons.user class="w-5 h-5 text-amber-400" />
                    <p class="text-[11px] tracking-[0.3em] uppercase text-zinc-400">
                        Acceso
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-4xl sm:text-5xl tracking-tight mb-2">
                    Iniciar sesión
                </h1>
                <p class="text-sm text-zinc-400">
                    Accede a tu cuenta para gestionar tus pedidos
                </p>
            </div>

            @if (session('status'))
                <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

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
                        autofocus 
                        autocomplete="username"
                        class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                    />
                    @error('email')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
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
                        autocomplete="current-password"
                        class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                    />
                    @error('password')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        name="remember"
                        class="rounded border-zinc-700 bg-zinc-900 text-amber-400 focus:ring-amber-400/50"
                    />
                    <label for="remember_me" class="ms-2 text-sm text-zinc-400">
                        Recordarme
                    </label>
                </div>

                <div class="flex items-center justify-between pt-2">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-zinc-400 hover:text-zinc-200 underline" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif

                    <x-button type="submit" class="ml-auto">
                        Iniciar sesión
                    </x-button>
                </div>
            </form>

            <div class="pt-4 border-t border-zinc-800">
                <p class="text-sm text-zinc-400 text-center">
                    ¿No tienes cuenta? 
                    <a href="{{ route('register') }}" class="text-amber-400 hover:text-amber-300 underline">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </section>
@endsection
