<?php
    $currentLocale = app()->getLocale();
    $currentPath = request()->path();
    $locales = [
        'es' => ['name' => 'Español', 'flag' => '🇪🇸'],
        'ca' => ['name' => 'Català', 'flag' => '🇪🇸'],
        'en' => ['name' => 'English', 'flag' => '🇬🇧'],
    ];
?>

<div class="relative" x-data="{ open: false }">
    <button 
        @click="open = !open"
        class="flex items-center gap-2 text-[11px] uppercase tracking-[0.25em] text-zinc-400 hover:text-zinc-100 transition-colors"
        aria-label="Cambiar idioma"
        aria-expanded="false"
        :aria-expanded="open"
    >
        <span><?php echo e($locales[$currentLocale]['flag']); ?></span>
        <span class="hidden sm:inline"><?php echo e(strtoupper($currentLocale)); ?></span>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    
    <div 
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-40 bg-zinc-900 border border-zinc-800 rounded-lg shadow-lg z-50"
        role="menu"
        aria-label="Selector de idioma"
    >
        <?php $__currentLoopData = $locales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(!request()->routeIs('admin.*') && strpos($currentPath, 'admin') !== 0): ?>
                <?php
                    // Obtener la ruta actual y sus parámetros
                    $currentRoute = request()->route();
                    $routeName = $currentRoute ? $currentRoute->getName() : null;
                    $routeParams = $currentRoute ? $currentRoute->parameters() : [];
                    
                    // Remover 'locale' de los parámetros
                    unset($routeParams['locale']);
                    
                    // Si tenemos un nombre de ruta, usar localized_route con el nuevo locale
                    if ($routeName && function_exists('localized_route')) {
                        $originalLocale = app()->getLocale();
                        app()->setLocale($locale);
                        
                        try {
                            $url = localized_route($routeName, $routeParams, true);
                        } catch (\Exception $e) {
                            // Fallback: reemplazar el locale en la URL actual
                            $path = str_replace(['/es/', '/ca/', '/en/'], '/' . $locale . '/', '/' . $currentPath);
                            $url = url($path);
                        }
                        
                        app()->setLocale($originalLocale);
                    } else {
                        // Fallback: reemplazar el locale en la URL actual
                        $path = str_replace(['/es/', '/ca/', '/en/'], '/' . $locale . '/', '/' . $currentPath);
                        $url = url($path);
                    }
                ?>
                <a 
                    href="<?php echo e($url); ?>"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-zinc-300 hover:bg-zinc-800 transition-colors <?php echo e($currentLocale === $locale ? 'bg-zinc-800' : ''); ?>"
                    role="menuitem"
                    hreflang="<?php echo e($locale); ?>"
                >
                    <span><?php echo e($info['flag']); ?></span>
                    <span><?php echo e($info['name']); ?></span>
                    <?php if($currentLocale === $locale): ?>
                        <span class="ml-auto text-amber-400">✓</span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/components/language-switcher.blade.php ENDPATH**/ ?>