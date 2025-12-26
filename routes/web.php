<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\CommentModerationController;


// Главная страница
Route::get('/', [MainController::class, 'index'])->name('home');

// Список всех новостей
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// Просмотр одной новости
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Статические страницы
Route::view('/about', 'about')->name('about');

Route::get('/contacts', function () {
    $contacts = [
        'email'   => 'info@example.com',
        'phone'   => '+7 (900) 000-00-00',
        'address' => 'г. Москва, ул. Примерная, д. 1',
        'social'  => [
            'telegram' => 'https://t.me/example',
            'github'   => 'https://github.com/example',
        ],
    ];

    return view('contacts', compact('contacts'));
})->name('contacts');

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
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/comments', [CommentModerationController::class, 'index'])->name('admin.comments.index');
    Route::post('/comments/{comment}/approve', [CommentModerationController::class, 'approve'])->name('comments.approve');
    Route::post('/comments/{comment}/reject', [CommentModerationController::class, 'reject'])->name('comments.reject');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    
});
