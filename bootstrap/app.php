<?php

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(fn (NotFoundHttpException     $e) => ApiResponse::notFound());
        $exceptions->render(fn (ModelNotFoundException    $e) => ApiResponse::notFound());
        $exceptions->render(fn (ValidationException       $e) => ApiResponse::validation($e->errors()));
        $exceptions->render(fn (AuthenticationException   $e) => ApiResponse::unauthorized());
        $exceptions->render(fn (AccessDeniedHttpException $e) => ApiResponse::forbidden());
        $exceptions->render(fn (Throwable                 $e) => ApiResponse::error($e->getMessage()));
    })->create();
