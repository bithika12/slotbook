<?php

namespace App\Exceptions;

use Exception;
use Redirect;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e){
          if ($e instanceof \Illuminate\Auth\AuthenticationException){
           return redirect('/login');
       }  
        if ($e instanceof TokenMismatchException) {
            // redirect to form an example of how i handle mine
            return redirect($request->fullUrl())->with(
            'csrf_error',
            "Opps! Seems you couldn't submit form for a longtime. Please try again"
            );
        }
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException){
            return response(view('errors.404'), 404);
        }
        if (($e instanceof \ErrorException || $e instanceof \Illuminate\Database\QueryException) && !config('app.debug')){
            return response(view('errors.500'), 500);
        }
        return parent::render($request, $e);
    }
}