<?php $__env->startSection('title', 'Iniciar sesión'); ?>

<?php $__env->startSection('content'); ?>
    <section class="px-5 sm:px-8 py-14 sm:py-20 max-w-md mx-auto">
        <div class="space-y-6">
            <div>
                <div class="inline-flex items-center gap-2 mb-3">
                    <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-5 h-5 text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-amber-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35)): ?>
<?php $attributes = $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35; ?>
<?php unset($__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35)): ?>
<?php $component = $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35; ?>
<?php unset($__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35); ?>
<?php endif; ?>
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

            <?php if(session('status')): ?>
                <div class="rounded-xl border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-4 py-3 text-sm">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->has('_token') || (session()->has('errors') && session('errors')->has('_token'))): ?>
                <div class="rounded-xl border border-red-600/40 bg-red-900/40 text-red-100 px-4 py-3 text-sm">
                    <p class="font-semibold mb-1">Error de sesión</p>
                    <p>El formulario ha expirado. Por favor, recarga la página e inténtalo de nuevo.</p>
                    <a href="<?php echo e(route('login')); ?>" class="underline mt-2 inline-block">Recargar página</a>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4" id="login-form">
                <?php echo csrf_field(); ?>
                
                <!-- Token CSRF oculto adicional para mantener sincronizado -->
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" id="csrf-token">

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-300 mb-1">
                        Correo electrónico
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="<?php echo e(old('email')); ?>" 
                        required 
                        autofocus 
                        autocomplete="username"
                        class="w-full rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-100 px-4 py-2 focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50 transition-colors"
                    />
                    <?php $__errorArgs = ['email'];
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
                    <?php $__errorArgs = ['password'];
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
                    <?php if(Route::has('password.request')): ?>
                        <a class="text-sm text-zinc-400 hover:text-zinc-200 underline" href="<?php echo e(route('password.request')); ?>">
                            ¿Olvidaste tu contraseña?
                        </a>
                    <?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'ml-auto']); ?>
                        Iniciar sesión
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
                        fetch('<?php echo e(route("login")); ?>', {
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
                                
                                // Actualizar también el input <?php echo csrf_field(); ?> si existe
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
                    <a href="<?php echo e(route('register')); ?>" class="text-amber-400 hover:text-amber-300 underline">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gerardrevo/Documents/GitHub/WebKevin/writer-site/resources/views/auth/login.blade.php ENDPATH**/ ?>