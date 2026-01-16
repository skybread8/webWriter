<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureAdmin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware para proteger el panel de administración.
        $middleware->alias([
            'admin' => EnsureAdmin::class,
            'locale' => \App\Http\Middleware\SetLocale::class,
            'track.visit' => \App\Http\Middleware\TrackVisit::class,
        ]);
        
        // Aplicar tracking de visitas a todas las rutas web
        // El middleware TrackVisit ya filtra las rutas admin internamente
        $middleware->web(append: [
            \App\Http\Middleware\TrackVisit::class,
        ]);
        
        // NO aplicar middleware de idioma globalmente - solo en rutas específicas
        // El middleware se aplica manualmente en las rutas que lo necesitan
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
