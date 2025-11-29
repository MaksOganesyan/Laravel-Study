<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

// Главная — новости
Route::get('/', [MainController::class, 'index']);

// Галерея
Route::get('/gallery/{id}', [MainController::class, 'gallery']);

// О нас и Контакты — старые страницы
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