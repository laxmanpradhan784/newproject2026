<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Create admin middleware group
        $middleware->group('admin', [
            \App\Http\Middleware\AdminMiddleware::class,
        ]);
        
        // Register middleware aliases
        $middleware->alias([
            'auth.redirect' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'cart.session' => \App\Http\Middleware\CartSessionMiddleware::class,
        ]);
        
        // Cart middleware for regular users only (apply to web routes)
        $middleware->web(append: [
            \App\Http\Middleware\CartSessionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();