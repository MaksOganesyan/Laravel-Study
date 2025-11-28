@extends('layouts.app')
@section('title', $article['name'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h1 class="mb-4">{{ $article['name'] }}</h1>
            
            <img src="{{ asset('storage/news/' . $article['full_image']) }}"
                 class="img-fluid rounded shadow mb-4"
                 alt="{{ $article['name'] }}">

            <div class="bg-light p-4 rounded">
                <p class="text-muted mb-3"><strong>Дата:</strong> {{ $article['date'] }}</p>
                <div class="fs-5">{!! nl2br(e($article['desc'])) !!}</div>
            </div>

            <div class="mt-4">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    ← Назад к новостям
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
