@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
    <h1>Контакты</h1>
    <div class="row">
        <div class="col-md-6">
            <h3>Свяжитесь с нами:</h3>
            <ul class="list-unstyled">
                <li><strong>Email:</strong> {{ $contacts['email'] }}</li>
                <li><strong>Телефон:</strong> {{ $contacts['phone'] }}</li>
                <li><strong>Адрес:</strong> {{ $contacts['address'] }}</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h3>Социальные сети:</h3>
            <p>
                <a href="{{ $contacts['social']['telegram'] }}" target="_blank">Telegram</a> |
                <a href="{{ $contacts['social']['github'] }}" target="_blank">GitHub</a>
            </p>
        </div>
    </div>
@endsection
