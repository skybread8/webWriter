<?php $__env->startSection('title', 'Finalizar compra'); ?>

<?php $__env->startSection('content'); ?>
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
                    subtotal: <?php echo e((float) $subtotal); ?>,
                    shippingPrice: null,
                    shippingZoneLabel: null,
                    loading: false,
                    shippingCostUrl: '<?php echo e(localized_route('checkout.shipping-cost')); ?>',
                    shippingMin: <?php echo e((float) ($shippingRange['min'] ?? 6.65)); ?>,
                    shippingMax: <?php echo e((float) ($shippingRange['max'] ?? 17.61)); ?>,
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
                    <?php if (isset($component)) { $__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shopping-cart','data' => ['class' => 'w-4 h-4 sm:w-5 sm:h-5 text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shopping-cart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 sm:w-5 sm:h-5 text-amber-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb)): ?>
<?php $attributes = $__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb; ?>
<?php unset($__attributesOriginalc6221bf432d0d2487c80c8c8e3ed8cbb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb)): ?>
<?php $component = $__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb; ?>
<?php unset($__componentOriginalc6221bf432d0d2487c80c8c8e3ed8cbb); ?>
<?php endif; ?>
                    <p class="text-[10px] sm:text-[11px] tracking-[0.25em] sm:tracking-[0.3em] uppercase text-zinc-400">
                        <?php echo e(__('common.checkout.title')); ?>

                    </p>
                </div>
                <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl md:text-5xl tracking-tight mb-2">
                    <?php echo e(__('common.checkout.title')); ?>

                </h1>
                <p class="text-xs sm:text-sm text-zinc-400">
                    <?php echo e(__('common.checkout.description')); ?>

                </p>
            </div>

            <?php if(session('status')): ?>
                <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                <!-- Resumen del pedido -->
                <div class="space-y-4 sm:space-y-6 order-2 md:order-1">
                    <div class="border border-zinc-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-zinc-900/40">
                        <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-zinc-100"><?php echo e(__('common.checkout.order_summary')); ?></h2>
                        <div class="space-y-3 sm:space-y-4">
                            <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-start gap-3 sm:gap-4 pb-3 sm:pb-4 border-b border-zinc-800 last:border-0">
                                    <?php if($item['book']->first_image_url): ?>
                                        <img src="<?php echo e($item['book']->first_image_url); ?>" alt="<?php echo e($item['book']->title); ?>" class="w-12 h-16 sm:w-16 sm:h-20 rounded-lg object-cover border border-zinc-800 flex-shrink-0">
                                    <?php else: ?>
                                        <div class="w-12 h-16 sm:w-16 sm:h-20 rounded-lg border border-dashed border-zinc-700 flex items-center justify-center bg-zinc-950 flex-shrink-0">
                                            <?php if (isset($component)) { $__componentOriginal285eddc9278dae58281aa961bf08a625 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal285eddc9278dae58281aa961bf08a625 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.book','data' => ['class' => 'w-4 h-4 sm:w-6 sm:h-6 text-zinc-700']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 sm:w-6 sm:h-6 text-zinc-700']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal285eddc9278dae58281aa961bf08a625)): ?>
<?php $attributes = $__attributesOriginal285eddc9278dae58281aa961bf08a625; ?>
<?php unset($__attributesOriginal285eddc9278dae58281aa961bf08a625); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal285eddc9278dae58281aa961bf08a625)): ?>
<?php $component = $__componentOriginal285eddc9278dae58281aa961bf08a625; ?>
<?php unset($__componentOriginal285eddc9278dae58281aa961bf08a625); ?>
<?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-xs sm:text-sm font-medium text-zinc-100 mb-1 truncate"><?php echo e($item['book']->title); ?></h3>
                                        <p class="text-[10px] sm:text-xs text-zinc-400 mb-1 sm:mb-2"><?php echo e(__('common.checkout.quantity')); ?>: <?php echo e($item['quantity']); ?></p>
                                        <p class="text-xs sm:text-sm font-semibold text-amber-400"><?php echo e(number_format($item['subtotal'], 2, ',', '.')); ?> €</p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 space-y-3 border-t border-zinc-800">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-zinc-400"><?php echo e(__('common.checkout.subtotal')); ?>:</span>
                                <span class="text-sm font-medium text-zinc-300" x-text="subtotal.toFixed(2).replace('.', ',') + ' €'"><?php echo e(number_format($subtotal, 2, ',', '.')); ?> €</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-zinc-400"><?php echo e(__('common.checkout.shipping')); ?>:</span>
                                <span class="text-sm font-medium text-zinc-300" x-show="shippingPrice !== null && !loading">
                                    <span x-text="shippingPrice !== null ? shippingPrice.toFixed(2).replace('.', ',') + ' €' : ''"></span>
                                    <span x-show="shippingZoneLabel" class="text-zinc-500 text-xs ml-1" x-text="shippingZoneLabel ? '(' + shippingZoneLabel + ')' : ''"></span>
                                </span>
                                <span class="text-sm text-zinc-500" x-show="shippingPrice === null && !loading" x-transition>
                                    <?php echo e(__('common.checkout.shipping_by_province')); ?> (<span x-text="shippingMin.toFixed(2).replace('.', ',')"></span> – <span x-text="shippingMax.toFixed(2).replace('.', ',')"></span> €)
                                </span>
                                <span class="text-sm text-zinc-400" x-show="loading">...</span>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-zinc-800">
                                <span class="text-sm sm:text-base font-semibold text-zinc-300"><?php echo e(__('common.checkout.total')); ?>:</span>
                                <span class="text-xl sm:text-2xl font-bold text-amber-400" x-text="totalWithShipping.toFixed(2).replace('.', ',') + ' €'"><?php echo e(number_format($subtotal, 2, ',', '.')); ?> €</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario de datos -->
                <div class="space-y-4 sm:space-y-6 order-1 md:order-2">
                    <?php if(auth()->guard()->check()): ?>
                        <div class="border border-emerald-600/40 bg-emerald-900/20 rounded-xl p-3 sm:p-4 mb-4 sm:mb-6">
                            <p class="text-xs sm:text-sm text-emerald-100">
                                <strong><?php echo e(__('common.checkout.logged_in_as')); ?></strong> <?php echo e(auth()->user()->name); ?> (<?php echo e(auth()->user()->email); ?>)
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="border border-zinc-800 rounded-xl p-3 sm:p-4 mb-4 sm:mb-6 bg-zinc-900/40">
                            <p class="text-xs sm:text-sm text-zinc-300 mb-2 sm:mb-3"><?php echo e(__('common.checkout.guest_checkout')); ?></p>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <a href="<?php echo e(route('login')); ?>" class="text-xs text-zinc-400 hover:text-zinc-200 underline">
                                    <?php echo e(__('common.checkout.already_account')); ?>

                                </a>
                                <span class="hidden sm:inline text-zinc-600">•</span>
                                <a href="<?php echo e(route('register')); ?>" class="text-xs text-zinc-400 hover:text-zinc-200 underline">
                                    <?php echo e(__('common.checkout.create_account')); ?>

                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(localized_route('checkout.process')); ?>" class="space-y-3 sm:space-y-4">
                        <?php echo csrf_field(); ?>

                        <div>
                            <label for="customer_name" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                <?php echo e(__('common.checkout.name')); ?> <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="customer_name" 
                                name="customer_name" 
                                value="<?php echo e(old('customer_name', auth()->user()?->name)); ?>"
                                required
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                            >
                            <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-zinc-300 mb-1">
                                <?php echo e(__('common.checkout.email')); ?> <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="customer_email" 
                                name="customer_email" 
                                value="<?php echo e(old('customer_email', auth()->user()?->email)); ?>"
                                required
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                            >
                            <?php $__errorArgs = ['customer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-zinc-300 mb-1">
                                <?php echo e(__('common.checkout.phone')); ?> <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="tel" 
                                id="customer_phone" 
                                name="customer_phone" 
                                value="<?php echo e(old('customer_phone', auth()->user()?->phone)); ?>"
                                required
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                            >
                            <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="customer_address" class="block text-sm font-medium text-zinc-300 mb-1">
                                <?php echo e(__('common.checkout.address')); ?> <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="customer_address" 
                                name="customer_address" 
                                value="<?php echo e(old('customer_address', auth()->user()?->address)); ?>"
                                required
                                autocomplete="address-line1"
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                            >
                            <?php if(config('services.google.maps_api_key')): ?>
                                <p class="text-[10px] sm:text-xs text-zinc-500 mt-1"><?php echo e(__('common.checkout.address_with_google')); ?></p>
                            <?php endif; ?>
                            <?php $__errorArgs = ['customer_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label for="customer_city" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    <?php echo e(__('common.checkout.city')); ?> <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="customer_city" 
                                    name="customer_city" 
                                    value="<?php echo e(old('customer_city', auth()->user()?->city)); ?>"
                                    required
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                                <?php $__errorArgs = ['customer_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="customer_postal_code" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    <?php echo e(__('common.checkout.postal_code')); ?> <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="customer_postal_code" 
                                    name="customer_postal_code" 
                                    value="<?php echo e(old('customer_postal_code', auth()->user()?->postal_code)); ?>"
                                    required
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                                <?php $__errorArgs = ['customer_postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label for="customer_province" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    <?php echo e(__('common.checkout.province')); ?> <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="customer_province" 
                                    name="customer_province" 
                                    value="<?php echo e(old('customer_province', auth()->user()?->province)); ?>"
                                    required
                                    @input.debounce.400ms="fetchShipping()"
                                    @change="fetchShipping()"
                                    class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                >
                                <?php $__errorArgs = ['customer_province'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="customer_country" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                    <?php echo e(__('common.checkout.country')); ?> <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="customer_country" 
                                    name="customer_country" 
                                    value="España"
                                    readonly
                                    class="w-full rounded-lg bg-zinc-900 border border-zinc-700 text-zinc-400 text-sm px-3 sm:px-4 py-2 cursor-not-allowed"
                                >
                                <p class="text-[10px] sm:text-xs text-zinc-500 mt-1"><?php echo e(__('common.checkout.spain_only')); ?></p>
                                <?php $__errorArgs = ['customer_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Dedicatorias por libro -->
                        <div class="space-y-3 sm:space-y-4">
                            <h3 class="text-sm sm:text-base font-semibold text-zinc-300 mb-2">
                                <?php echo e(__('common.checkout.dedications_title')); ?> (<?php echo e(__('common.checkout.optional')); ?>)
                            </h3>
                            <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div>
                                    <label for="dedication_<?php echo e($item['book']->id); ?>" class="block text-xs sm:text-sm font-medium text-zinc-300 mb-1">
                                        <?php echo e(__('common.checkout.dedication_for')); ?> "<?php echo e($item['book']->title); ?>"
                                    </label>
                                    <textarea 
                                        id="dedication_<?php echo e($item['book']->id); ?>" 
                                        name="dedications[<?php echo e($item['book']->id); ?>]" 
                                        rows="2"
                                        maxlength="500"
                                        class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 text-xs sm:text-sm px-3 sm:px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                        placeholder="<?php echo e(__('common.checkout.dedication_placeholder')); ?>"
                                    ><?php echo e(old('dedications.' . $item['book']->id)); ?></textarea>
                                    <p class="text-[10px] sm:text-xs text-zinc-500 mt-1"><?php echo e(__('common.checkout.dedication_max_chars')); ?></p>
                                    <?php $__errorArgs = ['dedications.' . $item['book']->id];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-zinc-300 mb-1">
                                <?php echo e(__('common.checkout.notes')); ?> (<?php echo e(__('common.checkout.optional')); ?>)
                            </label>
                            <textarea 
                                id="notes" 
                                name="notes" 
                                rows="3"
                                class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                                placeholder="<?php echo e(__('common.checkout.notes_placeholder')); ?>"
                            ><?php echo e(old('notes')); ?></textarea>
                            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-red-400 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Aceptación de políticas legales -->
                        <div class="space-y-3 pt-4 border-t border-zinc-800">
                            <p class="text-xs sm:text-sm font-medium text-zinc-300 mb-2">
                                <?php echo e(__('common.checkout.legal_acceptance')); ?>

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
                                        <?php echo e(__('common.checkout.accept_privacy')); ?>

                                        <a href="<?php echo e(localized_route('legal.privacy')); ?>" target="_blank" class="text-amber-400 hover:text-amber-300 underline underline-offset-2">
                                            <?php echo e(__('common.legal.privacy_title')); ?>

                                        </a>
                                    </span>
                                </label>
                                <?php $__errorArgs = ['accept_privacy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-xs text-red-400 ml-6"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

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
                                        <?php echo e(__('common.checkout.accept_terms')); ?>

                                        <a href="<?php echo e(localized_route('legal.terms')); ?>" target="_blank" class="text-amber-400 hover:text-amber-300 underline underline-offset-2">
                                            <?php echo e(__('common.legal.terms_title')); ?>

                                        </a>
                                    </span>
                                </label>
                                <?php $__errorArgs = ['accept_terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-xs text-red-400 ml-6"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="pt-4">
                            <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'w-full flex items-center justify-center gap-2']); ?>
                                <span><?php echo e(__('common.checkout.proceed_payment')); ?></span>
                                <?php if (isset($component)) { $__componentOriginal37a3f047daccd28b87517bd215a12923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37a3f047daccd28b87517bd215a12923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-right','data' => ['class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal37a3f047daccd28b87517bd215a12923)): ?>
<?php $attributes = $__attributesOriginal37a3f047daccd28b87517bd215a12923; ?>
<?php unset($__attributesOriginal37a3f047daccd28b87517bd215a12923); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal37a3f047daccd28b87517bd215a12923)): ?>
<?php $component = $__componentOriginal37a3f047daccd28b87517bd215a12923; ?>
<?php unset($__componentOriginal37a3f047daccd28b87517bd215a12923); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $attributes = $__attributesOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $component = $__componentOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__componentOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
                        </div>

                        <a href="<?php echo e(localized_route('cart.index')); ?>" class="block text-center text-xs text-zinc-400 hover:text-zinc-200 transition-colors underline">
                            <?php echo e(__('common.checkout.back_to_cart')); ?>

                        </a>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </section>

    <?php if(config('services.google.maps_api_key')): ?>
    <?php $__env->startPush('scripts'); ?>
    <script>
(function() {
    var apiKey = <?php echo json_encode(config('services.google.maps_api_key'), 15, 512) ?>;
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
    <?php $__env->stopPush(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/store/checkout/form.blade.php ENDPATH**/ ?>