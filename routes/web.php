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

// Галерея (старая)
Route::get('/gallery/{id}', [MainController::class, 'gallery']);

// Регистрация
Route::get('/register', [AuthController::class, 'create'])->name('register.form');
Route::post('/register', [AuthController::class, 'store'])->name('register');
// Авторизация
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Выход (один раз!)
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/')->with('success', 'Вы вышли из аккаунта!');
})->name('logout');

// Страница одной новости
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Комментарии
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Защищённые маршруты (только для авторизованных)
Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class)->except(['index', 'show']);
});

// Публичные маршруты для статей (список и просмотр)
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// О нас и Контакты
Route::view('/about', 'about')->name('about');
Route::get('/contacts', function () {
    return view('contacts', [
        'contacts' => [
            'email' => 'news@example.com',
            'phone' => '+7 915 888 99 99',
            'address' => 'Москва Россия',
            'social' => ['telegram' => 't.me/news', 'github' => 'github.com']
        ]
    ]);
})->name('contacts');
