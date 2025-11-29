@extends('layouts.app')
@section('title', 'Все новости')

@section('content')
<div class="container py-5">
    <h1 class="display-4 text-center mb-5 fw-bold">Все новости</h1>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($articles as $article)
            <div class="col">
                <div class="card h-100 shadow-sm hover-shadow">
                   <img src="{{ asset('storage/news/' . $article->preview_image) }}"
                   class="card-img-top"
                    style="height: 220px; object-fit: cover;"
     a              lt="{{ $article->title }}">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        
                        <p class="text-muted small mb-2">
                            <i class="bi bi-calendar"></i>
                            {{ $article->published_at->format('d.m.Y') }}
                        </p>

                        <p class="card-text text-secondary">
                            {{ Str::limit($article->short_description, 120) }}
                        </p>

                        <div class="mt-auto">
                            <a href="#" class="btn btn-primary w-100">
                                Читать полностью →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Красивая пагинация по центру -->
   <div class="mt-5">
    {{ $articles->links('vendor.pagination.bootstrap-5') }}
</div>
</div>
@endsection
