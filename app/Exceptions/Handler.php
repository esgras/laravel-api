<?php

namespace App\Exceptions;

use App\Http\Response\ApiResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return ApiResponse::error($exception->validator->errors()->first());
        }

        if ($exception instanceof ModelNotFoundException) {
            return ApiResponse::error('Model not found', Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof NotFoundException) {
            return ApiResponse::error($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof FileException) {
            return ApiResponse::error($exception->getMessage());
        }

        if ($exception instanceof HttpExceptionInterface) {
            return ApiResponse::error($exception->getMessage(), $exception->getStatusCode());
        }

//        if ($exception instanceof Exception) {
//            return ApiResponse::error($exception->getMessage());
//        }

        return parent::render($request, $exception);
    }
}
