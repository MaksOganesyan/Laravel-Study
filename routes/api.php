<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ArticleController;

// Открытые руты (без токена)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Защищённые руты (токен в заголовке Authorization: Bearer token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // CRUD статей
    Route::get('/articles', [ArticleController::class, 'index']);       // список
    Route::get('/articles/{article}', [ArticleController::class, 'show']);  // одна статья
    Route::post('/articles', [ArticleController::class, 'store']);      // создать
    Route::put('/articles/{article}', [ArticleController::class, 'update']);   // обновить
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy']); // удалить
});
