<?php

use App\Console\Commands\Unban;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            '/*',
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is-banned' => \App\Http\Middleware\BanMiddleware::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class
        ]);

    })
    // Source - https://stackoverflow.com/a
// Posted by Madusha Prasad
// Retrieved 2026-01-14, License - CC BY-SA 4.0

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('api', \Illuminate\Http\Middleware\HandleCors::class);
    })


    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();




