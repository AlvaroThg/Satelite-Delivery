<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();

        // ─── Trust Proxies (ngrok / túneles) ─────────────────────
        // Necesario para que Laravel detecte HTTPS correctamente
        // cuando está detrás de ngrok u otro reverse proxy.
        $middleware->trustProxies(at: '*');

        // ─── Excluir CSRF en rutas API ───────────────────────────
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // ─── JSON responses para rutas API ────────────────────────
        // Garantiza que React Native siempre reciba JSON,
        // nunca una página HTML de error de Laravel.
        $exceptions->shouldRenderJsonWhen(function (Request $request) {
            return $request->is('api/*') || $request->expectsJson();
        });
    })->create();
