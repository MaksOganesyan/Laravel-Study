<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/article/{id}', [SiteController::class, 'show'])->name('article.show');

Route::view('/about', 'about')->name('about');
Route::get('/contacts', function () {
    $contacts = [
        'email' => 'news@example.com',
        'phone' => '+7 915 888 99 99',
        'address' => 'Москва Россия',
        'social' => ['telegram' => 'https://t.me/news_site', 'github' => 'https://github.com/MaxOnn27']
    ];
    return view('contacts', compact('contacts'));
})->name('contacts');
