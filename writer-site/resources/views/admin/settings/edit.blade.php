<x-admin.layout title="Datos generales">
    <div class="space-y-8">
        <div>
            <div class="text-xs tracking-[0.25em] uppercase text-zinc-500 mb-2">Ajustes</div>
            <h1 class="font-['DM_Serif_Display'] text-3xl md:text-4xl tracking-tight">
                Información general del sitio
            </h1>
            <p class="mt-3 text-sm text-zinc-400 max-w-xl">
                Estos textos se utilizan en la cabecera de la web y como correo de contacto para los mensajes.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Nombre del sitio
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    Suele ser tu nombre como autor o el nombre del proyecto.
                </p>
                <input
                    type="text"
                    name="site_name"
                    value="{{ old('site_name', $settings->site_name) }}"
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                >
                @error('site_name')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Frase breve (tagline)
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    Una línea corta que acompañe a tu nombre (por ejemplo, “Narrativa breve y poesía en prosa”).
                </p>
                <input
                    type="text"
                    name="tagline"
                    value="{{ old('tagline', $settings->tagline) }}"
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                >
                @error('tagline')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-300">
                    Correo para recibir mensajes
                </label>
                <p class="text-xs text-zinc-500 mb-1">
                    A esta dirección llegarán los correos enviados desde el formulario de contacto.
                </p>
                <input
                    type="email"
                    name="contact_email"
                    value="{{ old('contact_email', $settings->contact_email) }}"
                    class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                >
                @error('contact_email')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6 border-t border-zinc-800">
                <h2 class="text-sm font-semibold text-zinc-300 mb-4">Redes sociales</h2>
                
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-zinc-300">
                            URL de Instagram
                        </label>
                        <input
                            type="url"
                            name="instagram_url"
                            value="{{ old('instagram_url', $settings->instagram_url) }}"
                            placeholder="https://instagram.com/tu-usuario"
                            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                        >
                        @error('instagram_url')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-zinc-300">
                            URL de Facebook
                        </label>
                        <input
                            type="url"
                            name="facebook_url"
                            value="{{ old('facebook_url', $settings->facebook_url) }}"
                            placeholder="https://facebook.com/tu-pagina"
                            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                        >
                        @error('facebook_url')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-zinc-300">
                            URL de TikTok
                        </label>
                        <input
                            type="url"
                            name="tiktok_url"
                            value="{{ old('tiktok_url', $settings->tiktok_url) }}"
                            placeholder="https://tiktok.com/@tu-usuario"
                            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                        >
                        @error('tiktok_url')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-zinc-300">
                            URL de Twitter/X
                        </label>
                        <input
                            type="url"
                            name="twitter_url"
                            value="{{ old('twitter_url', $settings->twitter_url) }}"
                            placeholder="https://twitter.com/tu-usuario"
                            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                        >
                        @error('twitter_url')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-zinc-300">
                            URL de YouTube
                        </label>
                        <input
                            type="url"
                            name="youtube_url"
                            value="{{ old('youtube_url', $settings->youtube_url) }}"
                            placeholder="https://youtube.com/@tu-canal"
                            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                        >
                        @error('youtube_url')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-zinc-300">
                            URL de LinkedIn
                        </label>
                        <input
                            type="url"
                            name="linkedin_url"
                            value="{{ old('linkedin_url', $settings->linkedin_url) }}"
                            placeholder="https://linkedin.com/in/tu-perfil"
                            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                        >
                        @error('linkedin_url')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-zinc-300">
                            URL de Pinterest
                        </label>
                        <input
                            type="url"
                            name="pinterest_url"
                            value="{{ old('pinterest_url', $settings->pinterest_url) }}"
                            placeholder="https://pinterest.com/tu-usuario"
                            class="w-full rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-100 focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500"
                        >
                        @error('pinterest_url')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <x-button>
                    Guardar cambios
                </x-button>
            </div>
        </form>
    </div>
</x-admin.layout>

