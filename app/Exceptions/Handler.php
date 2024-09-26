<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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

        });
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'data' => [],
            'errors' => [
                'message' => $exception->getMessage(),
                'code' => $exception->status,
            ]
        ], $exception->status);
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            $errorStatusCode = 422;
        }

        if ($exception instanceof NotFoundHttpException) {
            $errorStatusCode = 404;
        }

        if ($exception instanceof HttpException) {
            $errorStatusCode = $exception->getStatusCode();
        }

        if ($exception instanceof AuthenticationException) {
            $errorStatusCode = 400;
        }

        if ($exception instanceof HttpException) {
            $errorStatusCode = $exception->getStatusCode();
        }

        $responseErrorCode = $exception->getCode() == 0 ? $errorStatusCode ?? 500 : 500;
        $responseErrorMessage = $exception->getMessage() ?? null;
        if (App::environment('local')) {
            $responseErrorMessage = $exception->getMessage() . "; " . $exception->getFile() . "; " . $exception->getLine();
         }

        return ApiResponse::errorResponse($responseErrorMessage, $responseErrorCode);
    }
}
