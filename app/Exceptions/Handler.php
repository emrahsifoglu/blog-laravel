<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param  \Throwable  $e
     * @return Response|JsonResponse
     *
     * @throws \Exception
     */
    public function render($request, \Throwable $e)
    {
      $responseBody = [
        'message' => $e->getMessage()
      ];

      $code = $e->getCode();

      if ($e instanceof AuthorizationException) {
        $code = Response::HTTP_UNAUTHORIZED;
      }

      if ($e instanceof ValidationException) {
        $code = Response::HTTP_UNPROCESSABLE_ENTITY;
        $responseBody = array_merge($responseBody, ['errors' => $e->errors()]);
      }

      if ($e instanceof ModelNotFoundException) {
        $code = Response::HTTP_NOT_FOUND;
      }

      if ($code < 100 || $code > 599) {
        return parent::render($request, $e);
      }

      $responseBody = array_merge($responseBody, ['code' => $code]);
      return response()->json($responseBody, $code);
    }
}
