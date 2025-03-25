<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        // Registra tu middleware CORS al final (o al principio, según convenga)
        $middleware->append(\App\Http\Middleware\CorsMiddleware::class);
    })
    ->withExceptions(function ($exceptions) {
        //
    })->create();
