<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Support\Facades\Response;

class ExceptionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app()->bind('Illuminate\Contracts\Debug\ExceptionHandler', function ($app) {
            return new class($app) extends \Illuminate\Foundation\Exceptions\Handler {

                public function register(): void
                {
                    $this->renderable(function (Throwable $e, $request) {
                        if ($request->is('api/*')) {

                            if ($e instanceof ValidationException) {
                                return Response::json([
                                    'success' => false,
                                    'message' => 'Validation failed',
                                    'errors' => $e->errors(),
                                ], 422);
                            }

                            if ($e instanceof AuthenticationException) {
                                return Response::json([
                                    'success' => false,
                                    'message' => 'Unauthenticated',
                                ], 401);
                            }

                            if ($e instanceof NotFoundHttpException) {
                                return Response::json([
                                    'success' => false,
                                    'message' => 'Resource not found',
                                ], 404);
                            }

                            return Response::json([
                                'success' => false,
                                'message' => $e->getMessage(),
                            ], 500);
                        }
                    });
                }
            };
        });
    }
}
