@extends('layouts.site')

@section('title', 'Finalizar compra')

@section('content')
    <section class="px-4 sm:px-5 md:px-8 py-10 sm:py-14 md:py-20 max-w-4xl mx-auto">
        <div 
            x-data="scrollReveal(0)"
            class="space-y-6 sm:space-y-8"
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div 
                x-data="{
                    subtotal: {{ (float) $subtotal }},
                    shippingPrice: null,
                    shippingZoneLabel: null,
                    loading: false,
                    shippingCostUrl: '{{ localized_route('checkout.shipping-cost') }}',
                    shippingMin: {{ (float) ($shippingRange['min'] ?? 6.65) }},
                    shippingMax: {{ (float) ($shippingRange['max'] ?? 17.61) }},
                    get totalWithShipping() {
                        if (this.shippingPrice !== null) return this.subtotal + this.shippingPrice;
                        return this.subtotal;
                    },
                    async fetchShipping() {
                        const province = document.getElementById('customer_province')?.value?.trim();
                        if (!province) {
                            this.shippingPrice = null;
                            this.shippingZoneLabel = null;
                            return;
                        }
                        this.loading = true;
                        try {
                            const url = this.shippingCostUrl + (this.shippingCostUrl.includes('?') ? '&' : '?') + 'province=' + encodeURIComponent(province);
                            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                            const data = await res.json();
                            this.shippingPrice = data.price ?? null;
                            this.shippingZoneLabel = data.zone_label ?? null;
                        } catch (e) {
                            this.shippingPrice = null;
                            this.shippingZoneLabel = null;
                        }
                        this.loading = false;
                    }
                }"
                x-init="$nextTick(() => { if (document.getElementById('customer_province')?.value?.trim()) fetchShipping(); })"
            >
            <div>
                <div class="inline-flex items-center gap-2 mb-2 sm:mb-3">
                    <x-icons.shopping-cart class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400" />
                    <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                        {{ __('common.checkout.title') }}
                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl tracking-tight mb-2">
                    {{ __('common.checkout.title') }}
                </h1>
                <p class="text-xs sm:text-sm text-zinc-400">
                    {{ __('common.checkout.description') }}
                </p>
            </div>

            @if (session('status'))
                <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                <!-- Resumen del pedido -->
                <div class="space-y-4 sm:space-y-6 order-2 md:order-1">
                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-zinc-100">{{ __('common.checkout.order_summary') }}</h2>
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex items-start gap-3 sm:gap-4 pb-3 sm:pb-4 border-b border-zinc-800 last:border-0">
                                    @if($item['book']->first_image_url)
                                        <img src="{{ $item['book']->first_image_url }}" alt="{{ $item['book']->title }}" class="w-12 h-16 sm:w-16 sm:h-20 rounded-lg object-cover border border-zinc-800 flex-shrink-0">
                                    @else
                                        <div class="w-12 h-16 sm:w-16 sm:h-20 rounded-lg border border-dashed border-zinc-700 flex items-center justify-center bg-zinc-950 flex-shrink-0">
                                            <x-icons.book class="w-4 h-4 sm:w-6 sm:h-6 text-zinc-700" />
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-xs sm:text-sm font-medium text-zinc-100 mb-1 truncate">{{ $item['book']->title }}</h3>
                                        <p class="text-[10px] sm:text-xs text-zinc-400 mb-1 sm:mb-2">{{ __('common.checkout.quantity') }}: {{ $item['quantity'] }}</p>
                                        <p class="text-xs sm:text-sm font-semibold text-amber-400">{{ number_format($item['subtotal'], 2, ',', '.') }} €</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 space-y-3 border-t border-zinc-800">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-zinc-400">{{ __('common.checkout.subtotal') }}:</span>
                                <span class="text-sm font-medium text-zinc-300" x-text="subtotal.toFixed(2).replace('.', ',') + ' €'">{{ number_format($subtotal, 2, ',', '.') }} €</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-zinc-400">{{ __('common.checkout.shipping') }}:</span>
                                <span class="text-sm font-medium text-zinc-300" x-show="shippingPrice !== null && !loading">
                                    <span x-text="shippingPrice !== null ? shippingPrice.toFixed(2).replace('.', ',') + ' €' : ''"></span>
                                    <span x-show="shippingZoneLabel" class="text-zinc-500 text-xs ml-1" x-text="shippingZoneLabel ? '(' + shippingZoneLabel + ')' : ''"></span>
                                </span>
                                <span class="text-sm text-zinc-500" x-show="shippingPrice === null && !loading" x-transition>
                                    {{ __('common.checkout.shipping_by_province') }} (<span x-text="shippingMin.toFixed(2).replace('.', ',')"></span> – <span x-text="shippingMax.toFixed(2).replace('.', ',')"></span> €)
                                </span>
                                <span class="text-sm text-zinc-400" x-show="loading">...</span>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-zinc-800">
                                <span class="text-sm sm:text-base font-semibold text-zinc-300">{{ __('common.checkout.total') }}:</span>
                                <span class="text-xl sm:text-2xl font-bold text-amber-400" x-text="totalWithShipping.toFixed(2).replace('.', ',') + ' €'">{{ number_format($subtotal, 2, ',', '.') }} €</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario de datos -->
                <div class="space-y-4 sm:space-y-6 order-1 md:order-2">
                    @auth
                        <div class="border border-emerald-600/40 bg-emerald-900/20 rounded-xl p-3 sm:p-4 mb-4 sm:mb-6">
                            <p class="text-xs sm:text-sm text-emerald-100">
                                <strong>{{ __('common.checkout.logged_in_as') }}</strong> {{ auth()->user()->name }} ({{ auth()->user()->email }})
                            </p>
                        </div>
                    @else
                        <div class="border border-zinc-800 rounded-xl p-3 sm:p-4 mb-4 sm:mb-6 bg-zinc-900/40">
                            <p class="text-xs sm:text-sm text-zinc-300 mb-2 sm:mb-3">{{ __('common.checkout.guest_checkout') }}</p>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <a href="{{ route('login') }}" class="text-xs text-zinc-400 hover:text-zinc-200 underline">
                                    {{ __('common.checkout.already_account') }}
                                </a>
                                <span class="hidden sm:inline text-zinc-600">•</span>
                                <a href="{{ route('register') }}" class="text-xs text-zinc-400 hover:text-zinc-200 underline">
                                    {{ __('common.checkout.create_account') }}
                                </a>
                            </div>
                        </div>
                    @endauth

                    <form method="POST" action="{{ localized_route('checkout.process') }}" class="space-y-3 sm:space-y-4">
                        @csrf

                        <div>
                            <label for="customer_name" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                {{ __('common.checkout.name') }} <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="customer_name" 
                                name="customer_name" 
                                value="{{ old('customer_name', auth()->user()?->name) }}"
                                required
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                            >
                            @error('customer_name')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-zinc-300 mb-1">
                                {{ __('common.checkout.email') }} <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="customer_email" 
                                name="customer_email" 
                                value="{{ old('customer_email', auth()->user()?->email) }}"
                                required
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                            >
                            @error('customer_email')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-zinc-300 mb-1">
                                {{ __('common.checkout.phone') }} <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="tel" 
                                id="customer_phone" 
                                name="customer_phone" 
                                value="{{ old('customer_phone', auth()->user()?->phone) }}"
                                required
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                            >
                            @error('customer_phone')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="customer_address" class="block text-sm font-medium text-zinc-300 mb-1">
                                {{ __('common.checkout.address') }} <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="customer_address" 
                                name="customer_address" 
                                value="{{ old('customer_address', auth()->user()?->address) }}"
                                required
                                autocomplete="address-line1"
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                            >
                            @if(config('services.google.maps_api_key'))
                                <p class="text-[10px] sm:text-xs text-zinc-500 mt-1">{{ __('common.checkout.address_with_google') }}</p>
                            @endif
                            @error('customer_address')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label for="customer_city" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    {{ __('common.checkout.city') }} <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="customer_city" 
                                    name="customer_city" 
                                    value="{{ old('customer_city', auth()->user()?->city) }}"
                                    required
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                                @error('customer_city')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_postal_code" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    {{ __('common.checkout.postal_code') }} <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="customer_postal_code" 
                                    name="customer_postal_code" 
                                    value="{{ old('customer_postal_code', auth()->user()?->postal_code) }}"
                                    required
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                                @error('customer_postal_code')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label for="customer_province" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    {{ __('common.checkout.province') }} <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="customer_province" 
                                    name="customer_province" 
                                    value="{{ old('customer_province', auth()->user()?->province) }}"
                                    required
                                    @input.debounce.400ms="fetchShipping()"
                                    @change="fetchShipping()"
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                                @error('customer_province')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_country" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    {{ __('common.checkout.country') }} <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="customer_country" 
                                    name="customer_country" 
                                    value="España"
                                    readonly
                                    class="w-full rounded-lg bg-zinc-900 border border-zinc-700 text-zinc-400 text-sm px-3 sm:px-4 py-2 cursor-not-allowed"
                                >
                                <p class="text-[10px] sm:text-xs text-zinc-500 mt-1">{{ __('common.checkout.spain_only') }}</p>
                                @error('customer_country')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Dedicatorias por libro -->
                        <div class="space-y-3 sm:space-y-4">
                            <h3 class="text-sm sm:text-base font-semibold text-zinc-300 mb-2">
                                {{ __('common.checkout.dedications_title') }} ({{ __('common.checkout.optional') }})
                            </h3>
                            @foreach($cartItems as $index => $item)
                                <div>
                                    <label for="dedication_{{ $item['book']->id }}" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                        {{ __('common.checkout.dedication_for') }} "{{ $item['book']->title }}"
                                    </label>
                                    <textarea 
                                        id="dedication_{{ $item['book']->id }}" 
                                        name="dedications[{{ $item['book']->id }}]" 
                                        rows="2"
                                        maxlength="500"
                                        class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-xs sm:text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                        placeholder="{{ __('common.checkout.dedication_placeholder') }}"
                                    >{{ old('dedications.' . $item['book']->id) }}</textarea>
                                    <p class="text-[10px] sm:text-xs text-zinc-500 mt-1">{{ __('common.checkout.dedication_max_chars') }}</p>
                                    @error('dedications.' . $item['book']->id)
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-zinc-300 mb-1">
                                {{ __('common.checkout.notes') }} ({{ __('common.checkout.optional') }})
                            </label>
                            <textarea 
                                id="notes" 
                                name="notes" 
                                rows="3"
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                placeholder="{{ __('common.checkout.notes_placeholder') }}"
                            >{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Aceptación de políticas legales -->
                        <div class="space-y-3 pt-4 border-t border-zinc-800">
                            <p class="text-xs sm:text-sm font-medium text-zinc-300 mb-2">
                                {{ __('common.checkout.legal_acceptance') }}
                            </p>
                            
                            <div class="space-y-2">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input
                                        type="checkbox"
                                        name="accept_privacy"
                                        id="accept_privacy"
                                        value="1"
                                        required
                                        class="mt-0.5 rounded bg-zinc-900 border-zinc-800 text-amber-400 focus:ring-amber-400/50 focus:ring-offset-zinc-950"
                                    >
                                    <span class="text-xs sm:text-sm text-zinc-300 flex-1">
                                        {{ __('common.checkout.accept_privacy') }}
                                        <a href="{{ localized_route('legal.privacy') }}" target="_blank" class="text-amber-400 hover:text-amber-300 underline underline-offset-2">
                                            {{ __('common.legal.privacy_title') }}
                                        </a>
                                    </span>
                                </label>
                                @error('accept_privacy')
                                    <p class="text-xs text-red-400 ml-6">{{ $message }}</p>
                                @enderror

                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input
                                        type="checkbox"
                                        name="accept_terms"
                                        id="accept_terms"
                                        value="1"
                                        required
                                        class="mt-0.5 rounded bg-zinc-900 border-zinc-800 text-amber-400 focus:ring-amber-400/50 focus:ring-offset-zinc-950"
                                    >
                                    <span class="text-xs sm:text-sm text-zinc-300 flex-1">
                                        {{ __('common.checkout.accept_terms') }}
                                        <a href="{{ localized_route('legal.terms') }}" target="_blank" class="text-amber-400 hover:text-amber-300 underline underline-offset-2">
                                            {{ __('common.legal.terms_title') }}
                                        </a>
                                    </span>
                                </label>
                                @error('accept_terms')
                                    <p class="text-xs text-red-400 ml-6">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-4">
                            <x-button type="submit" class="w-full flex items-center justify-center gap-2">
                                <span>{{ __('common.checkout.proceed_payment') }}</span>
                                <x-icons.arrow-right class="w-4 h-4" />
                            </x-button>
                        </div>

                        <a href="{{ localized_route('cart.index') }}" class="block text-center text-xs text-zinc-400 hover:text-zinc-200 transition-colors underline">
                            {{ __('common.checkout.back_to_cart') }}
                        </a>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </section>

    @if(config('services.google.maps_api_key'))
    @push('scripts')
    <script>
(function() {
    var apiKey = @json(config('services.google.maps_api_key'));
    if (!apiKey) return;
    function initCheckoutPlaces() {
        var addressInput = document.getElementById('customer_address');
        if (!addressInput || typeof google === 'undefined' || !google.maps || !google.maps.places) return;
        var autocomplete = new google.maps.places.Autocomplete(addressInput, {
            componentRestrictions: { country: 'es' },
            fields: ['address_components'],
            types: ['address']
        });
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.address_components) return;
            var street = '', city = '', postalCode = '', province = '';
            for (var i = 0; i < place.address_components.length; i++) {
                var c = place.address_components[i];
                if (c.types.indexOf('street_number') !== -1) street = (street + ' ' + c.long_name).trim();
                if (c.types.indexOf('route') !== -1) street = (street + ' ' + c.long_name).trim();
                if (c.types.indexOf('locality') !== -1) city = c.long_name;
                if (c.types.indexOf('postal_code') !== -1) postalCode = c.long_name;
                if (c.types.indexOf('administrative_area_level_1') !== -1) province = c.long_name;
            }
            if (!city && place.address_components.length) {
                for (var j = 0; j < place.address_components.length; j++) {
                    if (place.address_components[j].types.indexOf('administrative_area_level_2') !== -1) {
                        city = place.address_components[j].long_name;
                        break;
                    }
                }
            }
            if (street) addressInput.value = street;
            var cityEl = document.getElementById('customer_city');
            if (cityEl && city) cityEl.value = city;
            var postalEl = document.getElementById('customer_postal_code');
            if (postalEl && postalCode) postalEl.value = postalCode;
            var provinceEl = document.getElementById('customer_province');
            if (provinceEl && province) {
                provinceEl.value = province;
                provinceEl.dispatchEvent(new Event('input', { bubbles: true }));
                provinceEl.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    }
    window.initCheckoutPlaces = initCheckoutPlaces;
    var s = document.createElement('script');
    s.src = 'https://maps.googleapis.com/maps/api/js?key=' + apiKey + '&libraries=places&callback=initCheckoutPlaces';
    s.async = true;
    s.defer = true;
    document.head.appendChild(s);
})();
    </script>
    @endpush
    @endif
@endsection
