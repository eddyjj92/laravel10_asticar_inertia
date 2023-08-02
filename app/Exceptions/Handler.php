<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });


        $this->renderable(function (Throwable $e) {
            return $this->handleException($e);
        });
    }

    public function handleException( Throwable $e){
        if ($e instanceof HttpException) {
            $code = $e->getStatusCode();
            $defaultMessage = \Symfony\Component\HttpFoundation\Response::$statusTexts[$code];
            $message = $e->getMessage() == "" ? $defaultMessage : $e->getMessage();
            return $this->errorResponse($message, $code);
        } else if ($e instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($e->getModel()));
            return $this->errorResponse("Does not exist any instance of {$model} with the given id", Response::HTTP_NOT_FOUND);
        } else if ($e instanceof AuthorizationException) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
        } else if ($e instanceof ValidationException) {
            $errors = $e->validator->errors()->getMessages();
            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            if (config('app.debug'))
                return $this->dataResponse($e->getMessage(), $e->getCode());
            else {
                return $this->errorResponse('Try later', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * Data Response
     * @param $data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dataResponse($data, $statusCode): \Illuminate\Http\RedirectResponse
    {
        if($statusCode == "23000"){
            /*return response()->json(['success' => false, 'message' => 'No puede insertar datos repetidos', 'code' => $statusCode ], Response::HTTP_OK);*/
            return back()->withErrors(['validacion' => 'No puede insertar datos repetidos']);
        }else if($data == 'Unauthenticated.') {
          return back()->withErrors(['validacion' => 'Necesita autenticarse para acceder a esta ruta']);
        }else if($data == 'There is no role named `Cliente`.'){
          return back()->withErrors(['validacion' => 'Para usar las importaciones de forma masiva necesita crear el rol de usuarios (Cliente) y asignarle los permisos correspondientes']);
        }
        return back()->withErrors(['validacion' => $data]);
    }

    /**
     * Success Response
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(string $message, $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message, 'code' => $code], $code);
    }

    /**
     * Error Response
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function errorResponse($message, $code = Response::HTTP_BAD_REQUEST): \Illuminate\Http\RedirectResponse
    {
        if($code == 403){
          return back()->withErrors(['validacion' => 'No tiene privilegios para realizar esta operación']);
        }
        return back()->withErrors(['validacion' => $message.' '.$code]);
    }
}
