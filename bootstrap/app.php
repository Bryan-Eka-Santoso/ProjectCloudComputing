<?php

use App\Http\Middleware\CheckPlayTimeLimit;
use App\Http\Middleware\CheckPrimaryCaregiver;
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
        $middleware->alias([
            'play.limit' => CheckPlayTimeLimit::class,
            'primary.caregiver' => CheckPrimaryCaregiver::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
