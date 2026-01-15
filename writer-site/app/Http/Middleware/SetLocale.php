<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        $locale = $request->segment(1);
        
        // Idiomas permitidos
        $allowedLocales = ['es', 'ca', 'en'];
        
        // Si el primer segmento es un idioma válido, usarlo
        if (in_array($locale, $allowedLocales)) {
            app()->setLocale($locale);
        } else {
            // Si no hay idioma en la URL, detectar del navegador o usar español por defecto
            $browserLocale = substr($request->server('HTTP_ACCEPT_LANGUAGE', 'es'), 0, 2);
            $locale = in_array($browserLocale, $allowedLocales) ? $browserLocale : 'es';
            app()->setLocale($locale);
        }
        
        return $next($request);
    }
}
