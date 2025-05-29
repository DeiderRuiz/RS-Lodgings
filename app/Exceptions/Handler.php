<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $exception) {
            if ($exception instanceof QueryException) {
                return Inertia::render('Errors', ['message' => 'Error en la base de datos.']);
            }
    
            // Modelo no encontrado (cuando buscas un registro inexistente)
            if ($exception instanceof ModelNotFoundException) {
                return Inertia::render('Errors', ['message' => 'El recurso solicitado no existe.']);
            }
    
            // Error de rutas mal escritas (cuando se accede a una URL incorrecta)
            if ($exception instanceof NotFoundHttpException) {
                return Inertia::render('Errors', ['message' => 'Página no encontrada.']);
            }
    
            // Cualquier otro error genérico
            return Inertia::render('Errors', ['message' => 'Algo salió mal en el sistema.']);
        });
    }

    public function render($request, Throwable $exception)
    {

        if ($exception instanceof ValidationException) {
            return parent::render($request, $exception);
        }

        if ($exception instanceof AuthenticationException) {
            return redirect()->route('login'); // o la ruta que uses para el login
        }

        if ($exception instanceof QueryException) {
            return redirect()->route('error')->with('message', 'Error en la base de datos.');
        }

        if ($exception instanceof ModelNotFoundException) {
            return redirect()->route('error')->with('message', 'El recurso solicitado no existe.');
        }

        if ($exception instanceof NotFoundHttpException) {
            return redirect()->route('error')->with('message', 'Página no encontrada.');
        }

        return redirect()->route('error')->with('message', 'Algo salió mal en el sistema.');

    }
}
