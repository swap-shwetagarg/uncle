<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {
       if($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException){
            if($request->wantsJson() || $request->ajax()){
                return response()->json(['status' => 'error']);
            }
            return parent::render($request, $exception);
        }
        else if($exception instanceof \Illuminate\Database\QueryException){
            if($request->wantsJson() || $request->ajax()){  
                if($exception->getCode()==="23000"){ 
                    $errors = ['error_msg' => 'Oops....Something went wrong.'];
                    return new JsonResponse($errors, 422);
                }
                    return response()->json(['status' => 'error']);
            }
            return parent::render($request, $exception);
        }
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception) {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Override default method.
     * To have separate error page for admin and public area.
     */
    protected function renderHttpException(HttpException $exception) {
        $status = $exception->getStatusCode();
        if (view()->exists($this->getViewName($status))) {
            return response()->view($this->getViewName($status), ['exception' => $exception], $status, $exception->getHeaders());
        } else {
            return $this->convertExceptionToResponse($exception);
        }
    }

    /**
     * Determine what view to show based on route
     *
     * @param int $status
     * @return string 
     */
    protected function getViewName($status) {
        if (request()->is('admin/*')) {
            return "errors.admin.{$status}";
        }
        return "errors.{$status}";
    }

}
