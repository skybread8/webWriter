<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        // Establecer idioma a español para las páginas de autenticación
        app()->setLocale('es');
        
        // Guardar la URL previa si el usuario viene de otra página y no hay una URL intended ya guardada
        // Laravel automáticamente guarda url.intended cuando se intenta acceder a una ruta protegida,
        // pero si el usuario hace clic en "Iniciar sesión" desde el menú, necesitamos guardarla manualmente
        if (!$request->session()->has('url.intended')) {
            $referer = $request->headers->get('referer');
            $previous = url()->previous();
            
            // Solo guardar si la URL previa no es la página de login o registro
            if ($referer && 
                !str_contains($referer, '/login') && 
                !str_contains($referer, '/register') &&
                $referer !== route('login') &&
                $referer !== url('/login')) {
                $request->session()->put('url.intended', $referer);
            } elseif ($previous && 
                     !str_contains($previous, '/login') && 
                     !str_contains($previous, '/register') &&
                     $previous !== route('login') &&
                     $previous !== url('/login')) {
                $request->session()->put('url.intended', $previous);
            }
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Establecer idioma a español para los mensajes de error
        app()->setLocale('es');
        
        $request->authenticate();

        $request->session()->regenerate();

        // Obtener la URL previa guardada
        $intendedUrl = $request->session()->pull('url.intended');
        
        // Si hay una URL previa válida y no es la página de login o registro, redirigir allí
        if ($intendedUrl && 
            !str_contains($intendedUrl, '/login') && 
            !str_contains($intendedUrl, '/register') &&
            $intendedUrl !== route('login') &&
            $intendedUrl !== url('/login')) {
            return redirect($intendedUrl);
        }

        // Si no hay URL previa o es la página de login, redirigir a la cuenta del usuario
        $locale = app()->getLocale() ?: 'es';
        
        // Usar localized_route si está disponible, sino construir la URL manualmente
        if (function_exists('localized_route')) {
            return redirect()->to(localized_route('account.index', [], false));
        }
        
        // Fallback: construir la URL manualmente
        return redirect()->to('/' . $locale . '/account');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
