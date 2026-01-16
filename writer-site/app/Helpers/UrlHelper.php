<?php

if (!function_exists('localized_route')) {
    /**
     * Genera una URL para una ruta con el locale actual
     * 
     * @param string $name Nombre de la ruta
     * @param mixed $parameters Parámetros de la ruta (puede ser un modelo, un array, o null)
     * @param bool $absolute Si es absoluta o relativa
     * @return string
     */
    function localized_route(string $name, $parameters = [], bool $absolute = true): string
    {
        // Si la ruta es del admin, no añadir locale
        if (strpos($name, 'admin.') === 0) {
            return route($name, $parameters, $absolute);
        }
        
        // Obtener el locale actual (siempre debe existir ahora)
        $locale = app()->getLocale();
        if (empty($locale)) {
            $locale = session('locale', 'es');
        }
        
        // Obtener información de la ruta para detectar parámetros requeridos
        try {
            $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName($name);
            $routeParameterNames = $route ? $route->parameterNames() : [];
            // Filtrar 'locale' ya que es opcional y lo manejamos por separado
            $routeParameterNames = array_filter($routeParameterNames, function($param) {
                return $param !== 'locale';
            });
            $routeParameterNames = array_values($routeParameterNames); // Reindexar
        } catch (\Exception $e) {
            $routeParameterNames = [];
        }
        
        // Convertir $parameters a array si es necesario
        if (is_object($parameters)) {
            // Si es un modelo Eloquent, detectar el nombre del parámetro de la ruta
            if (!empty($routeParameterNames)) {
                // Usar el primer parámetro que no sea 'locale'
                $paramName = $routeParameterNames[0];
                $parameters = [$paramName => $parameters];
            } else {
                // Fallback: intentar detectar por el nombre de la ruta
                if (strpos($name, 'book') !== false) {
                    $parameters = ['book' => $parameters];
                } elseif (strpos($name, 'slug') !== false || strpos($name, 'blog') !== false) {
                    $parameters = ['slug' => $parameters];
                } else {
                    // Último fallback: usar el primer parámetro del modelo
                    $parameters = ['id' => $parameters->id ?? $parameters];
                }
            }
        } elseif (!is_array($parameters) && $parameters !== null && $parameters !== []) {
            // Si es un valor simple (ID o slug), usar el primer parámetro de la ruta
            if (!empty($routeParameterNames)) {
                $paramName = $routeParameterNames[0];
                $parameters = [$paramName => $parameters];
            } else {
                // Fallback: intentar detectar por el nombre de la ruta
                if (strpos($name, 'book') !== false) {
                    $parameters = ['book' => $parameters];
                } elseif (strpos($name, 'slug') !== false || strpos($name, 'blog') !== false) {
                    $parameters = ['slug' => $parameters];
                } else {
                    $parameters = ['id' => $parameters];
                }
            }
        } elseif ($parameters === null || $parameters === []) {
            // Si no hay parámetros, crear array vacío
            $parameters = [];
        }
        
        // Añadir el locale como primer parámetro (ahora siempre es obligatorio)
        unset($parameters['locale']); // Asegurarse de que no esté duplicado
        $parameters = ['locale' => $locale] + $parameters;
        
        try {
            return route($name, $parameters, $absolute);
        } catch (\Illuminate\Routing\Exceptions\UrlGenerationException $e) {
            // Si falla, registrar el error
            if (strpos($e->getMessage(), 'Missing required parameter') !== false) {
                \Log::error("Error generando URL para ruta '{$name}': " . $e->getMessage(), [
                    'parameters' => $parameters,
                    'route_name' => $name,
                    'required_params' => $routeParameterNames,
                    'locale' => $locale
                ]);
            }
            throw $e;
        }
    }
}
