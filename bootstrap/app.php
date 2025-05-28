<?php

use Illuminate\Foundation\Application;
use App\Exceptions\RestrictPostException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->renderable(function (ThrottleRequestsException $e, $request) {
        //     if ($request->expectsJson()) {
        //         return response()->json([
        //             'message' => 'You have reached the daily limit of 10 scheduled posts. Please try again tomorrow.',
        //             'status' => 429,
        //         ], 429);
        //     }
        // });
        //

        $exceptions->renderable(function (ThrottleRequestsException $e, $request) {
                throw new RestrictPostException();
        });
    })->create();
