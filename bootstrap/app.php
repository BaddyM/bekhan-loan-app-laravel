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
        $middleware->validateCsrfTokens(except:[
            '/fetch_user_api',
            '/register_user_api',
            'fetch_user_loan_data',
            '/pay_loan',
            '/upload_documents',
            '/support',
            '/change_pin',
            '/request_loan',
            '/fetch_user_files'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

    })->create();
