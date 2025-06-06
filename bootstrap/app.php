<?php

use App\Http\Middleware\CheckIfHasRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.role' => CheckIfHasRole::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'checkout/paidNiubiz'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
