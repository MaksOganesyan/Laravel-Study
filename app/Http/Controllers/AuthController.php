<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Регистрация — форма
    public function create()
    {
        return view('auth.register');
    }

    // Регистрация — сохранение
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Регистрация успешна! Теперь войдите в аккаунт.');
    }

    // Логин — форма
    public function loginForm()
    {
        return view('auth.login');
    }

    // Логин — обработка
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Вы вошли в аккаунт!');
        }

        return back()->withErrors(['email' => 'Неверный email или пароль']);
    }
}
