<?php

namespace App\Exceptions;

use App\Traits\ApiResponseHelper;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use GuzzleHttp\Exception\RequestException;
use ErrorException;
use TypeError;
use ParseError;
use Exception;
use App\Exceptions\CustomException;
use Error;
use BadMethodCallException;
use Illuminate\Database\Eloquent\RelationNotFoundException;

class Handler extends ExceptionHandler
{
    use ApiResponseHelper;
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

    public function render($request, Throwable $e)
    {
        if ($e instanceof UnauthorizedException) {
            return $this->apiErrorResponse(false, __('api.something_went_wrong'), $e->getMessage(), 403);
        }

        if ($e instanceof AuthenticationException) {
            return $this->apiErrorResponse(false, __('api.something_went_wrong'), $e->getMessage(), Response::HTTP_UNAUTHORIZED);
        }

        if ($e instanceof QueryException) {
            return $this->apiErrorResponse(false, __('api.something_went_wrong'), $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($e instanceof RelationNotFoundException) {
            return $this->apiErrorResponse(false, __('api.something_went_wrong'), $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->apiErrorResponse(false, __('api.record_not_found'), $e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->apiErrorResponse(false, __('api.something_went_wrong'), $e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->apiErrorResponse(false, __('api.something_went_wrong'), $e->getMessage(), Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($e instanceof ErrorException) {
            return $this->apiErrorResponse(false, __('api.something_went_wrong'), $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($e instanceof TypeError) {
            return $this->apiErrorResponse(false, __('api.something_went_wrong'), $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($e instanceof ParseError) {
            return $this->apiErrorResponse(false, __('api.something_went_wrong'), $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($e instanceof Error) {
            return $this->apiErrorResponse(false, __('api.something_went_wrong'), $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($e instanceof BadMethodCallException) {
            return $this->apiErrorResponse(false, __('api.something_went_wrong'), $e->getMessage(), Response::HTTP_BAD_GATEWAY);
        }
        if ($e instanceof ThrottleRequestsException) {
            return $this->apiErrorResponse(false, $e->getMessage(), $e->getMessage(), Response::HTTP_TOO_MANY_REQUESTS);
        }

        if ($e instanceof RequestException) {
            $statusCode = $e->getResponse()->getStatusCode();
            $message = $e->getMessage();
            return $this->apiErrorResponse(false, __('api.something_went_wrong'), $message, $statusCode);
        }

        // Handle other exceptions here as needed.

        return parent::render($request, $e);
    }
}
