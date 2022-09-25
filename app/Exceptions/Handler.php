<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Sanctum\Exceptions\MissingScopeException;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use ErrorException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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

    public function render($request, Throwable $exception)
    {

            if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
                return response()->json(['success' => false,'message' => "Not Found",], 404);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json(['success' => false,'message' => 'Method Not Allowed',], 404);
            }
            if ($exception instanceof ErrorException) {
                if (preg_match('/^file_put_contents/', $exception->getMessage())) {
                    return;
                }
            }


           if ($exception instanceof UnauthorizedHttpException || $exception instanceof UnauthorizedException) {
            return response()->json(['success' => false,'message' => 'unauthorized',], 401);
           }

            if ($exception instanceof AccessDeniedHttpException || $exception instanceof MissingScopeException||$exception instanceof AccessDeniedException) {
                return response()->json(['success' => false,'message' => 'Access Denied',], 403);
            }

         

           if ($exception instanceof ConnectException) {
               return response()->json(['success' => false,'message' => "Connection Error",], 401);
           }

        

}
}
