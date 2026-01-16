<x-admin.layout title="Políticas legales">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Legal</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Políticas legales
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Gestiona las políticas de privacidad, términos de servicio, aviso legal y política de cookies. Estas páginas son obligatorias para cumplir con la normativa legal.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.legal.update') }}" class="space-y-8">
            @csrf

            <div class="space-y-6">
                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="cookies_enabled"
                        id="cookies_enabled"
                        value="1"
                        {{ old('cookies_enabled', $settings->cookies_enabled ?? true) ? 'checked' : '' }}
                        class="rounded border-zinc-700 bg-zinc-900 text-zinc-100 focus:ring-zinc-500"
                    >
                    <label for="cookies_enabled" class="text-sm text-zinc-200">
                        Mostrar banner de cookies en el sitio
                    </label>
                </div>
            </div>

            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-zinc-300">
                        Política de Privacidad
                    </label>
                    <p class="text-xs text-zinc-500 mb-2">
                        Información sobre cómo se recopilan, utilizan y protegen los datos personales.
                    </p>
                    <input id="privacy_policy" type="hidden" name="privacy_policy" value="{{ old('privacy_policy', $settings->privacy_policy) }}">
                    <div class="trix-wrapper">
                        <trix-editor input="privacy_policy" class="trix-content" style="min-height: 400px;"></trix-editor>
                    </div>
                    @error('privacy_policy')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-zinc-300">
                        Términos de Servicio
                    </label>
                    <p class="text-xs text-zinc-500 mb-2">
                        Condiciones de uso del sitio web y servicios ofrecidos.
                    </p>
                    <input id="terms_of_service" type="hidden" name="terms_of_service" value="{{ old('terms_of_service', $settings->terms_of_service) }}">
                    <div class="trix-wrapper">
                        <trix-editor input="terms_of_service" class="trix-content" style="min-height: 400px;"></trix-editor>
                    </div>
                    @error('terms_of_service')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-zinc-300">
                        Aviso Legal
                    </label>
                    <p class="text-xs text-zinc-500 mb-2">
                        Información legal sobre el propietario del sitio, responsabilidades y derechos de propiedad intelectual.
                    </p>
                    <input id="legal_notice" type="hidden" name="legal_notice" value="{{ old('legal_notice', $settings->legal_notice) }}">
                    <div class="trix-wrapper">
                        <trix-editor input="legal_notice" class="trix-content" style="min-height: 400px;"></trix-editor>
                    </div>
                    @error('legal_notice')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-zinc-300">
                        Política de Cookies
                    </label>
                    <p class="text-xs text-zinc-500 mb-2">
                        Información sobre el uso de cookies en el sitio web.
                    </p>
                    <input id="cookie_policy" type="hidden" name="cookie_policy" value="{{ old('cookie_policy', $settings->cookie_policy) }}">
                    <div class="trix-wrapper">
                        <trix-editor input="cookie_policy" class="trix-content" style="min-height: 400px;"></trix-editor>
                    </div>
                    @error('cookie_policy')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-zinc-800">
                <x-button>
                    Guardar políticas legales
                </x-button>
            </div>
        </form>
    </div>
</x-admin.layout>
