@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1>Вход</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form autocomplete="off" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Пароль</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label><input type="checkbox" name="remember"> Запомнить меня</label>
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
</div>
@endsection
