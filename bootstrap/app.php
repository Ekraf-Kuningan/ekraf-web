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
    ->withMiddleware(function (Middleware $middleware): void {
<<<<<<< HEAD
        $middleware->alias([
            'redirect.admin' => \App\Http\Middleware\RedirectAdmin::class,
            'check.superadmin' => \App\Http\Middleware\CheckSuperAdmin::class,
            'check.admin' => \App\Http\Middleware\CheckAdminLevel::class,
=======
        // Register API security middleware
        $middleware->alias([
            'api.security.headers' => \App\Http\Middleware\ApiSecurityHeaders::class,
>>>>>>> 55429e9da719d0d4f3e3c82dfb4884050e952892
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
