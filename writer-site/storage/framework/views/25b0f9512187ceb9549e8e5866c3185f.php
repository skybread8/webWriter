<?php
    $settings = \App\Models\SiteSetting::first();
?>

<?php if($settings?->cookies_enabled ?? true): ?>
    <div 
        x-data="{ 
            show: !localStorage.getItem('cookie_consent'),
            accept() {
                localStorage.setItem('cookie_consent', 'accepted');
                this.show = false;
            },
            reject() {
                localStorage.setItem('cookie_consent', 'rejected');
                this.show = false;
            }
        }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed bottom-0 left-0 right-0 z-50 p-4 sm:p-6 bg-zinc-900 border-t border-zinc-800 shadow-2xl"
        role="dialog"
        aria-labelledby="cookie-banner-title"
        aria-describedby="cookie-banner-description"
    >
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="flex-1">
                    <h3 id="cookie-banner-title" class="text-sm font-semibold text-zinc-100 mb-2">
                        <?php echo e(__('common.cookies.title')); ?>

                    </h3>
                    <p id="cookie-banner-description" class="text-xs text-zinc-400 leading-relaxed">
                        <?php echo e(__('common.cookies.description')); ?>

                        <a href="<?php echo e(localized_route('legal.cookies')); ?>" class="underline hover:text-zinc-300 transition-colors">
                            <?php echo e(__('common.cookies.learn_more')); ?>

                        </a>
                    </p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <button
                        @click="reject()"
                        class="px-4 py-2 text-xs font-medium text-zinc-400 hover:text-zinc-200 transition-colors"
                        aria-label="<?php echo e(__('common.cookies.reject')); ?>"
                    >
                        <?php echo e(__('common.cookies.reject')); ?>

                    </button>
                    <button
                        @click="accept()"
                        class="px-6 py-2 text-xs font-semibold bg-zinc-100 text-zinc-950 rounded-lg hover:bg-white transition-colors"
                        aria-label="<?php echo e(__('common.cookies.accept')); ?>"
                    >
                        <?php echo e(__('common.cookies.accept')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/components/cookie-banner.blade.php ENDPATH**/ ?>