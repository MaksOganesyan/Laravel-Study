<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


// Главная страница
Route::get('/', [MainController::class, 'index'])->name('home');

// Список всех новостей
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// Просмотр одной новости
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Статические страницы
Route::view('/about', 'about')->name('about');
Route::view('/contacts', 'contacts')->name('contacts'); 

// Старая галерея (если нужна)
Route::get('/gallery/{id}', [MainController::class, 'gallery'])->name('gallery');

/*
Авторизация и регистрация (гости)
*/

Route::middleware('guest')->group(function () {
    // Регистрация
    Route::get('/register', [AuthController::class, 'create'])->name('register.form');
    Route::post('/register', [AuthController::class, 'store'])->name('register');

    // Вход
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

/*
| Выход (только авторизованным)
*/

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/')->with('success', 'Вы успешно вышли!');
})->middleware('auth')->name('logout');

/*

| Защищённые маршруты (только авторизованным пользователям)
*/

Route::middleware('auth')->group(function () {

    // Комментарии: добавление и удаление
    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])
         ->name('comments.store');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
         ->name('comments.destroy');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])
     ->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])
     ->name('comments.update');
    Route::resource('articles', ArticleController::class)->except(['index', 'show']);
});
