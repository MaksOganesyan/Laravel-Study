@extends('layouts.app')
@section('title', 'Все новости')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-4 fw-bold">Все новости</h1>
        <a href="{{ route('articles.create') }}" class="btn btn-success btn-lg">
            + Добавить новость
        </a>
    </div>

    <!-- Сообщения об успехе -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($articles as $article)
            <div class="col">
                <div class="card h-100 shadow-sm hover-shadow position-relative">
                    <img src="{{ asset('storage/news/' . $article->preview_image) }}"
                         class="card-img-top"
                         style="height: 220px; object-fit: cover;"
                         alt="{{ $article->title }}">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        
                        <p class="text-muted small mb-2">
                            <i class="bi bi-calendar"></i>
                            {{ $article->published_at->format('d.m.Y') }}
                        </p>

                        <p class="card-text text-secondary">
                            {{ Str::limit($article->short_description, 120) }}
                        </p>

                        <div class="mt-auto d-flex gap-2">
                            <a href="#" class="btn btn-primary flex-fill">
                                Читать полностью →
                            </a>
                        </div>

                        <!-- КНОПКИ УПРАВЛЕНИЯ -->
                        <div class="position-absolute top-0 end-0 p-2 bg-white rounded-start shadow-sm">
                            <a href="{{ route('articles.edit', $article) }}" 
                               class="btn btn-sm btn-warning" title="Редактировать">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('articles.destroy', $article) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Точно удалить новость «{{ addslashes($article->title) }}»?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Удалить">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Красивая пагинация -->
    <div class="d-flex justify-content-center mt-5">
        {{ $articles->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection
