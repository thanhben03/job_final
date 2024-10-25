<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'http://127.0.0.1:8001/candidates/review-cv', // <-- exclude this route,
            'http://127.0.0.1:8001/chat/send-to-user', // <-- exclude this route,
            'http://127.0.0.1:8001/chat/send-to-company', // <-- exclude this route,
            'http://127.0.0.1:8000/api/v1/auth/login',
            'http://127.0.0.1:8000/chatbot',
            'http://127.0.0.1:8000/chatbot/search-job',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
