@extends('layouts.app')
@section('title', 'Новости')

@section('content')
<div class="container py-5">
    <h1 class="mb-5 text-center">Новости</h1>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($articles as $item)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <a href="{{ route('article.show', $item['id']) }}">
                        <img src="{{ asset('storage/news/' . $item['preview_image']) }}"
                             class="card-img-top"
                             style="height: 220px; object-fit: cover;"
                             alt="{{ $item['name'] }}">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item['name'] }}</h5>
                        <p class="text-muted small">{{ $item['date'] }}</p>
                        <p class="card-text flex-grow-1">
                            {{ $item['shortDesc'] ?? \Illuminate\Support\Str::limit($item['desc'], 120) }}
                        </p>
                        <a href="{{ route('article.show', $item['id']) }}"
                           class="btn btn-primary mt-auto">Подробнее →</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
