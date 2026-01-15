<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo permitimos acceso si hay usuario autenticado.
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // En este proyecto consideramos "admin" a los usuarios con estos emails.
        // Se puede cambiar fácilmente a un campo is_admin en el futuro.
        $allowedEmails = ['admin@example.com', 'kevin@example.com'];
        if (! in_array(Auth::user()->email, $allowedEmails)) {
            abort(403);
        }

        return $next($request);
    }
}
