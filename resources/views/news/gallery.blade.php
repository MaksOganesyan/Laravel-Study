@extends('layouts.app')
@section('title', $article['name'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="mb-4">{{ $article['name'] }}</h1>

            <img src="{{ asset('storage/news/' . $article['full_image']) }}"
                 class="img-fluid rounded shadow mb-4" alt="{{ $article['name'] }}">

            <div class="bg-light p-4 rounded">
                <p class="text-muted"><strong>Дата:</strong> {{ $article['date'] }}</p>
                <div class="fs-5">{!! nl2br(e($article['desc'])) !!}</div>
            </div>

            <a href="{{ url('/') }}" class="btn btn-outline-secondary mt-4">← Назад к новостям</a>
        </div>
    </div>
</div>
@endsection
