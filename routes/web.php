<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
// Главная — новости
Route::get('/', [MainController::class, 'index']);

//  Маршруты для регистрации
Route::get('/signin', [AuthController::class, 'create'])->name('signin');
Route::post('/signin', [AuthController::class, 'registration']);

// Галерея
Route::get('/gallery/{id}', [MainController::class, 'gallery']);

Route::resource('articles', ArticleController::class)->except(['show']);

Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
// О нас и Контакты 
Route::view('/about', 'about');
Route::get('/contacts', function () {
    return view('contacts', [
        'contacts' => [
            'email' => 'news@example.com',
            'phone' => '+7 915 888 99 99',
            'address' => 'Москва Россия',
            'social' => ['telegram' => 't.me/news', 'github' => 'github.com']
        ]
    ]);
});
