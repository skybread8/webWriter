<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo trackear rutas públicas (no admin, no API)
        if (!$request->is('admin*') && !$request->is('api*')) {
            try {
                Visit::create([
                    'ip_address' => $request->ip(),
                    'user_agent' => substr($request->userAgent(), 0, 500),
                    'path' => $request->path(),
                    'referer' => $request->header('referer') ? substr($request->header('referer'), 0, 500) : null,
                    'method' => $request->method(),
                    'status_code' => 200, // Se actualizará después si hay error
                    'visited_at' => now(),
                ]);
            } catch (\Exception $e) {
                // Si falla el tracking, no interrumpir la petición
                \Log::warning('Failed to track visit: ' . $e->getMessage());
            }
        }

        $response = $next($request);

        // Actualizar status_code si hay error
        if ($response->getStatusCode() >= 400) {
            try {
                Visit::where('ip_address', $request->ip())
                    ->where('path', $request->path())
                    ->where('visited_at', '>=', now()->subMinute())
                    ->latest()
                    ->first()
                    ?->update(['status_code' => $response->getStatusCode()]);
            } catch (\Exception $e) {
                // Ignorar errores de actualización
            }
        }

        return $response;
    }
}
