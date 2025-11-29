<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.signin');
    }

    public function registration(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        //   В JSON
        $response = [
            'success' => true,
            'message' => 'Регистрация успешна!',
            'data' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'registered_at' => now()->format('Y-m-d H:i:s')
            ]
        ];

        return response()->json($response, 201);
    }
}
