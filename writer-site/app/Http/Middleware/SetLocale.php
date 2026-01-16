<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si estamos en una ruta del admin, establecer español
        if ($request->is('admin*') || $request->routeIs('admin.*')) {
            app()->setLocale('es');
            return $next($request);
        }
        
        // Si estamos en rutas de autenticación (login, register, password reset), establecer español
        if ($request->is('login*') || 
            $request->is('register*') || 
            $request->is('forgot-password*') || 
            $request->is('reset-password*') ||
            $request->routeIs('login*') ||
            $request->routeIs('register*') ||
            $request->routeIs('password.*')) {
            app()->setLocale('es');
            return $next($request);
        }
        
        // Obtener el locale de la ruta (ahora es obligatorio)
        $locale = $request->route('locale');
        
        // Idiomas permitidos
        $allowedLocales = ['es', 'ca', 'en'];
        
        // Si el locale es válido, usarlo
        if ($locale && in_array($locale, $allowedLocales)) {
            app()->setLocale($locale);
            session(['locale' => $locale]);
        } else {
            // Si no hay locale válido, redirigir a español
            return redirect('/es' . $request->getPathInfo());
        }
        
        return $next($request);
    }
    
    private function detectBrowserLocale(Request $request): string
    {
        $allowedLocales = ['es', 'ca', 'en'];
        $defaultLocale = 'es';
        
        // Obtener el idioma preferido del navegador
        $acceptLanguage = $request->server('HTTP_ACCEPT_LANGUAGE', '');
        
        if (empty($acceptLanguage)) {
            return $defaultLocale;
        }
        
        // Parsear Accept-Language header
        $languages = [];
        $parts = explode(',', $acceptLanguage);
        
        foreach ($parts as $part) {
            $part = trim($part);
            if (strpos($part, ';') !== false) {
                list($lang, $q) = explode(';', $part);
                $q = (float) str_replace('q=', '', $q);
            } else {
                $lang = $part;
                $q = 1.0;
            }
            
            $lang = strtolower(substr(trim($lang), 0, 2));
            $languages[$lang] = $q;
        }
        
        // Ordenar por prioridad
        arsort($languages);
        
        // Buscar el primer idioma compatible
        foreach ($languages as $lang => $priority) {
            // Mapear códigos de idioma comunes
            if ($lang === 'ca' || $lang === 'cat') {
                return 'ca';
            }
            if ($lang === 'en') {
                return 'en';
            }
            if ($lang === 'es') {
                return 'es';
            }
        }
        
        return $defaultLocale;
    }
}
