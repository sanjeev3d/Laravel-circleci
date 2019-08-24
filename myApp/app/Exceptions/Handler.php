<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        // if ($request->json == null) {   //add Accept: application/json in request
        //     return response(['status'=> 'error', 'message' => 'Please pass json'], 400 );            
        // }

        if($exception instanceof \Illuminate\Auth\AuthenticationException)
        { 
            return response(["status" => 'error', "message"=> __("handler")['auth_exception']], 422);    
        }

        if ($exception instanceof \Illuminate\Session\TokenMismatchException) { 
            return response()->view('errors.tokenMisMatch', ['exception'=>$exception]);
        }
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) { 
            return response(['status'=> 'error', 'message' => __("handler")['404']], 400 );
        }
        if($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException){
            return abort('404');
        }      

        if ($exception instanceof \Illuminate\Validation\ValidationException) {            
            return response(["status" => 'error', "message"=> __("handler")['validation_exception'], 'errors' => $exception->errors()], 422); 
        }

        
        // dump($request->json); 
        
        
        return parent::render($request, $exception);
    }
    
}
