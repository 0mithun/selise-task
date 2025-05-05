<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException && $request->expectsJson() && $request->is('api/*')) {
            return response()->json([
                'message' => 'The resource was not found.',
                'errors' => [
                    'resource' => 'resource_not_found',
                ],
                'status' => false,
            ], 404);
        }

        if ($exception instanceof NotFoundHttpException && $request->expectsJson() && $request->is('api/*')) {
            return response()->json([
                'message' => $exception->getMessage() ?: "The specified URL can't be found",
                'errors' => [
                    'url' => 'url_not_found',
                ],
                'status' => false,
            ], 404);
        }

        if ($exception instanceof ValidationException && $request->expectsJson() && $request->is('api/*')) {
            $firstErrorMessage = Arr::first(Arr::flatten($exception->errors()));

            $error = ['message' => $firstErrorMessage, 'errors' => $exception->errors(), 'status' => false];
            return response()->json($error, 422);
        }

        if ($exception instanceof AuthenticationException && $request->expectsJson() && $request->is('api/*')) {
            $error = ['message' => $exception->getMessage(),
                'errors' => [
                    'auth' => 'unauthenticated',
                ],
                'status' => false];
            return response()->json($error, 401);
        }

        if ($exception instanceof AuthorizationException  && $request->expectsJson() && $request->is('api/*')) {
            return response()->json([
                "message" => $exception->getMessage() ?: "You are not authorized to access this resource",
                "errors" => [
                    'auth' => 'unauthorized',
                ],
                'status' => false,
            ], 403);
        }

        if ($exception instanceof \Illuminate\Http\Exceptions\PostTooLargeException) {
            $error = ['message' => 'File too large',
                'errors' => [
                    'file' => 'file_too_large',
                ],
                'status' => false];
            return response()->json($error, $exception->getStatusCode());
        }

        if ($exception instanceof HttpException && $request->expectsJson() && $request->is('api/*')) {
            $error = [
                'message' => $exception->getMessage(),
                'errors' => [
                    'http' => 'http_exception',
                ],
                'status' => false];
            return response()->json($error, $exception->getStatusCode());
        }

        if ($exception instanceof MethodNotAllowedException) {
            return response()->json([
                'message' => $exception->getMessage() ?: "The specified method for this request is invalid",
                'errors' => [
                    'method' => 'method_not_allowed',
                ],
                'status' => false,
            ], 405);
        }


        if ($exception instanceof InvalidSignatureException) {
            dd($exception->getMessage());
            return response()->json([
                'message' => $exception->getMessage(),
                'errors' => [
                    'signature' => 'invalid_signature',
                ],
                'status' => false,
            ], 403);
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }
        if ($request->expectsJson()) {
            return response()->json([
                "message" => 'Something went wrong, please try again',
                "errors" => [
                    'server' => 'server_error',
                ],
            ], 500);
        }

        return response()->json([
            "message" => 'Something went wrong, please try again',
            "errors" => [
                'server' => 'server_error',
            ],
        ], 500);
    }
}
