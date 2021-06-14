<?php

namespace App\Exceptions;

use App\Http\ApiCode;
use App\Http\HttpCode;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Throwable;

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

        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return ResponseBuilder::asError(101)
                ->withData($exception->errors())
                ->withHttpCode(422)
                ->build();
        }

        return ResponseBuilder::asError(104)
            ->withData($exception->getMessage())
            ->withHttpCode(500)
            ->build();
    }
}
