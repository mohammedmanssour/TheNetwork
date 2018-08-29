<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Plank\Mediable\Exceptions\MediaUpload\FileNotSupportedException;

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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json(['meta' => generate_meta('failure', array_flatten($exception->errors()))], 422);
        }

        if($exception instanceof FileNotSupportedException){
            return response()->json(
                ['meta' => generate_meta('failure', 'File type not supported')],
                400
            );
        }

        if($exception instanceof ModelNotFoundException){
            return response()->json(
                ['meta' => generate_meta('failure', ['Not Found'] )],
                404
            );
        }

        if($exception instanceof AuthorizationException){
            return response()->json(
                ['meta' => generate_meta('failure', ['FORBIDDEN'] )],
                403
            );
        }

        return parent::render($request, $exception);
    }
}
