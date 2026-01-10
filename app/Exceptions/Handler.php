<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        // Для API всегда JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'message' => 'Ошибка валидации',
                    'errors' => $exception->errors(),
                ], 422);
            }

            return response()->json([
                'message' => 'Ошибка сервера',
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
