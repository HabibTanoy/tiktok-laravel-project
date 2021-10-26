<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
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
            // dd($e);
        });
        $this->renderable(function (ThrottleRequestsException $e, $request) {
            $code = 'REACHED_LIMIT';
            return response()->view('errors.500', ['code' => $code], 500);
        });
        $this->renderable(function (\Exception $e, $request) {
            $code = 'GENERAL';
            return response()->view('errors.500', ['code' => $code], 500);
        });
    }

//    public function render($request, Throwable $e)
//    {
//        if ($e instanceof ThrottleRequestsException)
//        {
//            $code = 'REACHED_LIMIT';
//        }else{
//            $code = 'GENERAL';
//        }
//        $message = $e->getMessage();
//        return view('errors.500',compact('code','message'));
////        if ($e instanceof ValidationException)
////        {
////            return parent::render($request, $e);
////        }
////        switch ($e->getCode()){
////            case 404:
////                return redirect('/not-found');
////            default:
////                return redirect('/error');
////        }
//    }
}
