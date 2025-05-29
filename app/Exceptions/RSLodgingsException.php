<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class RSLodgingsException extends Exception
{
    public function __construct(
        string $message = "Erroren RS Lodgings",
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        ?Throwable $previous = null
    ){
        parent::__construct($message, $code, $previous);
    }

    public function render(Throwable $exception, Request $request){
        if ($request->isJson()) {
            return response()->json([
                "message" => $this->message,
            ], $this->code);
        }

        if ($exception instanceof UrlGenerationException) {
            if ($request->expectsJson() || $request->header('X-Inertia')) {
                return Inertia::render('Errors/InvalidRouteName', [
                    'message' => 'Nombre de ruta no válido. Es posible que se haya escrito mal.'
                ])->toResponse($request)->setStatusCode(500);
            }
        }
    
        // Error por URL inexistente (ruta mal escrita en navegador)
        if ($exception instanceof NotFoundHttpException) {
            if ($request->expectsJson() || $request->header('X-Inertia')) {
                return Inertia::render('Errors/404')->toResponse($request)->setStatusCode(404);
            }
        }

        return Inertia::render($request, $exception);
    }
}
