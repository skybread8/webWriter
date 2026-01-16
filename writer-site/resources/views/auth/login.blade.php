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

            @if ($errors->has('_token') || (session()->has('errors') && session('errors')->has('_token')))
                <div class="rounded-xl border border-red-600/40 bg-red-900/40 text-red-100 px-4 py-3 text-sm">
                    <p class="font-semibold mb-1">Error de sesión</p>
                    <p>El formulario ha expirado. Por favor, recarga la página e inténtalo de nuevo.</p>
                    <a href="{{ route('login') }}" class="underline mt-2 inline-block">Recargar página</a>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4" id="login-form">
                @csrf
                
                <!-- Token CSRF oculto adicional para mantener sincronizado -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="csrf-token">

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

            <script>
                // Refrescar token CSRF cada 5 minutos si el formulario está visible
                (function() {
                    const form = document.getElementById('login-form');
                    if (!form) return;
                    
                    const tokenInput = document.getElementById('csrf-token');
                    const metaTag = document.querySelector('meta[name="csrf-token"]');
                    
                    // Función para actualizar el token
                    function refreshCsrfToken() {
                        fetch('{{ route("login") }}', {
                            method: 'GET',
                            credentials: 'same-origin',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newToken = doc.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                            
                            if (newToken) {
                                if (tokenInput) tokenInput.value = newToken;
                                if (metaTag) metaTag.setAttribute('content', newToken);
                                
                                // Actualizar también el input @csrf si existe
                                const csrfInput = form.querySelector('input[name="_token"]');
                                if (csrfInput) csrfInput.value = newToken;
                            }
                        })
                        .catch(() => {
                            // Si falla, recargar la página para obtener un token fresco
                            console.warn('No se pudo refrescar el token CSRF. Recarga la página si tienes problemas.');
                        });
                    }
                    
                    // Refrescar token cada 5 minutos
                    setInterval(refreshCsrfToken, 5 * 60 * 1000);
                    
                    // También refrescar antes de enviar el formulario si ha pasado mucho tiempo
                    form.addEventListener('submit', function(e) {
                        const lastRefresh = parseInt(sessionStorage.getItem('csrf_last_refresh') || '0');
                        const now = Date.now();
                        
                        // Si han pasado más de 10 minutos desde la última carga, refrescar token
                        if (now - lastRefresh > 10 * 60 * 1000) {
                            e.preventDefault();
                            refreshCsrfToken();
                            
                            // Esperar un momento y reenviar
                            setTimeout(() => {
                                form.submit();
                            }, 500);
                        }
                    });
                    
                    // Guardar timestamp de carga de la página
                    sessionStorage.setItem('csrf_last_refresh', Date.now().toString());
                })();
            </script>

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
