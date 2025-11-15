<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Главная
Route::get('/', function () {
    return view('welcome');
});

// О нас
Route::get('/about', function () {
    return view('about');
});

// Контакты — с передачей данных
Route::get('/contacts', function () {
    $contacts = [
        'email' => 'news@example.com',
        'phone' => '+7 915 888 99 99',
        'address' => 'Москва Россия',
        'social' => [
            'telegram' => 'https://t.me/news_site',
            'github' => 'https://github.com/MaxOnn27'
        ]
    ];

    return view('contacts', compact('contacts'));
});
