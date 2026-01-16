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
            storage_path('app/public/blog_images'),
            storage_path('app/public/testimonials'),
            storage_path('app/public/hero'),
            storage_path('app/public/author'),
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
     */
    function store_image_safely($file, string $directory = 'covers'): ?string
    {
        // Asegurar que los directorios existen
        ensure_storage_directories();
        
        // Crear el directorio específico si no existe
        $targetDir = storage_path('app/public/' . $directory);
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0755, true);
            @chmod($targetDir, 0755);
        }
        
        // Guardar el archivo
        $path = $file->store($directory, 'public');
        
        if ($path) {
            $fullPath = storage_path('app/public/' . $path);
            if (file_exists($fullPath)) {
                @chmod($fullPath, 0644);
                // Verificar que el archivo se guardó correctamente
                if (filesize($fullPath) === 0) {
                    \Log::error("Image file saved but is empty: {$fullPath}");
                    return null;
                }
            } else {
                \Log::error("Image file not found after saving: {$fullPath}");
                return null;
            }
        }
        
        return $path;
    }
}
