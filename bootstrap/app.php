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
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->group('api', [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);

    // 🔥 daftar alias middleware custom
    $middleware->alias([
        'superadmin' => \App\Http\Middleware\SuperadminMiddleware::class,
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();