<?php

if (!function_exists('ensure_storage_directories')) {
    /**
     * Asegura que los directorios de almacenamiento existen y tienen permisos correctos
     */
    function ensure_storage_directories(): void
    {
        $directories = [
            storage_path('app/public'),
            storage_path('app/public/covers'),
            storage_path('app/public/books'),
            storage_path('app/public/blog_images'),
            storage_path('app/public/testimonials'),
            storage_path('app/public/hero'),
            storage_path('app/public/author'),
            storage_path('app/public/readers'),
        ];

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                @mkdir($directory, 0755, true);
            }
            @chmod($directory, 0755);
        }

        // Asegurar que el enlace simbólico existe
        $symlink = public_path('storage');
        if (!is_link($symlink) && !is_dir($symlink)) {
            try {
                \Artisan::call('storage:link');
            } catch (\Exception $e) {
                // Si falla, intentar crear manualmente
                if (!is_dir($symlink)) {
                    @symlink(storage_path('app/public'), $symlink);
                }
            }
        }
    }
}

if (!function_exists('store_image_safely')) {
    /**
     * Guarda una imagen asegurando que el directorio existe
     * Usa S3 si está configurado, sino usa el disco 'public' local
     * Optimiza la imagen antes de guardarla
     */
    function store_image_safely($file, string $directory = 'covers', int $maxWidth = 1920, int $quality = 85): ?string
    {
        try {
            // Optimizar la imagen antes de guardarla
            // Intentar usar Imagick primero, si no está disponible usar GD
            $driver = extension_loaded('imagick') ? 'imagick' : 'gd';
            $image = \Intervention\Image\ImageManager::withDriver($driver)->read($file->getRealPath());
            
            // Redimensionar si es necesario (mantener aspect ratio)
            if ($image->width() > $maxWidth) {
                $image->scale(width: $maxWidth);
            }
            
            // Determinar qué disco usar: S3 si está configurado, sino 'public'
            $disk = 'public';
            if (config('filesystems.default') === 's3' || 
                (env('AWS_ACCESS_KEY_ID') && env('AWS_SECRET_ACCESS_KEY') && env('AWS_BUCKET'))) {
                $disk = 's3';
            } else {
                // Asegurar que los directorios existen solo para almacenamiento local
                ensure_storage_directories();
                
                // Crear el directorio específico si no existe
                $targetDir = storage_path('app/public/' . $directory);
                if (!is_dir($targetDir)) {
                    @mkdir($targetDir, 0755, true);
                    @chmod($targetDir, 0755);
                }
            }
            
            // Generar nombre único para el archivo
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = uniqid() . '.' . $extension;
            $path = $directory . '/' . $filename;
            
            // Guardar la imagen optimizada
            if ($disk === 's3') {
                // Para S3, guardar en un archivo temporal primero
                $tempPath = sys_get_temp_dir() . '/' . $filename;
                $image->toJpeg($quality)->save($tempPath);
                
                // Subir a S3
                \Storage::disk('s3')->put($path, file_get_contents($tempPath));
                @unlink($tempPath);
            } else {
                // Para almacenamiento local
                $fullPath = storage_path('app/public/' . $path);
                $image->toJpeg($quality)->save($fullPath);
                @chmod($fullPath, 0644);
                
                // Verificar que el archivo se guardó correctamente
                if (!file_exists($fullPath) || filesize($fullPath) === 0) {
                    \Log::error("Image file saved but is empty or not found: {$fullPath}");
                    return null;
                }
            }
            
            return $path;
        } catch (\Exception $e) {
            \Log::error("Error optimizing and saving image: " . $e->getMessage());
            
            // Fallback: guardar sin optimizar si falla la optimización
            try {
                $disk = 'public';
                if (config('filesystems.default') === 's3' || 
                    (env('AWS_ACCESS_KEY_ID') && env('AWS_SECRET_ACCESS_KEY') && env('AWS_BUCKET'))) {
                    $disk = 's3';
                } else {
                    ensure_storage_directories();
                    $targetDir = storage_path('app/public/' . $directory);
                    if (!is_dir($targetDir)) {
                        @mkdir($targetDir, 0755, true);
                        @chmod($targetDir, 0755);
                    }
                }
                
                $path = $file->store($directory, $disk);
                
                if ($path && $disk === 'public') {
                    $fullPath = storage_path('app/public/' . $path);
                    if (file_exists($fullPath)) {
                        @chmod($fullPath, 0644);
                    }
                }
                
                return $path;
            } catch (\Exception $fallbackException) {
                \Log::error("Error in fallback image save: " . $fallbackException->getMessage());
                return null;
            }
        }
    }
}

if (!function_exists('get_image_url')) {
    /**
     * Obtiene la URL de una imagen, funcionando tanto con S3 como con almacenamiento local
     */
    function get_image_url(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        
        // Si S3 está configurado, usar Storage para obtener la URL
        if (config('filesystems.default') === 's3' || 
            (env('AWS_ACCESS_KEY_ID') && env('AWS_SECRET_ACCESS_KEY') && env('AWS_BUCKET'))) {
            try {
                return \Storage::disk('s3')->url($path);
            } catch (\Exception $e) {
                \Log::error("Error getting S3 URL for {$path}: " . $e->getMessage());
                // Fallback a local si falla S3
                return asset('storage/' . $path);
            }
        }
        
        // Para almacenamiento local, usar asset()
        return asset('storage/' . $path);
    }
}
