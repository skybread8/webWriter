<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class StorageHelper
{
    /**
     * Store file and ensure correct permissions
     */
    public static function storeWithPermissions($file, string $path, string $disk = 'public'): string
    {
        $storedPath = $file->store($path, $disk);
        
        // Asegurar permisos del archivo subido
        $fullPath = storage_path('app/' . $disk . '/' . $storedPath);
        if (file_exists($fullPath)) {
            @chmod($fullPath, 0644);
            // Intentar cambiar el propietario si es posible (solo en Linux)
            if (function_exists('posix_getpwuid') && fileowner($fullPath) !== 0) {
                @chown($fullPath, 'www-data');
            }
        }
        
        return $storedPath;
    }
}
