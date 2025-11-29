@extends('layouts.app')

@section('title', 'Новости')

@section('content')
<div class="container py-5">
    <h1 class="mb-5 text-center fw-bold">Новости</h1>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($articles as $item)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <a href="/gallery/{{ $item['id'] }}">
                        <img src="{{ asset('storage/news/' . $item['preview_image']) }}"
                             class="card-img-top"
                             style="height: 220px; object-fit: cover;"
                             alt="{{ $item['name'] }}">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item['name'] }}</h5>
                        <small class="text-muted mb-2">{{ $item['date'] }}</small>
                        <p class="card-text text-secondary">
                            {{ $item['shortDesc'] ?? \Illuminate\Support\Str::limit($item['desc'], 100) }}
                        </p>
                        <div class="mt-auto">
                            <a href="/gallery/{{ $item['id'] }}" class="btn btn-primary w-100">
                                Подробнее →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
