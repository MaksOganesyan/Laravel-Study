@extends('layouts.app')
@section('title', $article->title)

@section('content')
<div class="container py-5">
    <h1 class="mb-4">{{ $article->title }}</h1>
    <img src="{{ asset('storage/news/' . $article->preview_image) }}"
         class="img-fluid rounded shadow mb-4"
         alt="{{ $article->title }}"
         style="max-width: 100%; height: auto;">

    <p class="lead mb-4">{{ $article->short_description }}</p>
    <div class="mb-4">{!! nl2br(e($article->content)) !!}</div>

    <p class="text-muted mb-5">
        Опубликовано: {{ $article->published_at->format('d.m.Y') }}
    </p>

    <div class="mb-5">
        <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">
            ← Назад к списку новостей
        </a>
    </div>

    <hr>

    <h3 class="mt-5">Комментарии ({{ $article->comments->count() }})</h3>

    @foreach($article->comments as $comment)
        <div class="border p-3 mb-3 rounded bg-light">
            <strong>{{ $comment->author }}</strong>
            <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
            <p class="mt-2 mb-0">{{ $comment->content }}</p>

            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger mt-2" 
                        onclick="return confirm('Удалить комментарий?')">
                    Удалить
                </button>
            </form>
        </div>
    @endforeach

    <!-- Форма добавления комментария -->
    <h4 class="mt-5">Добавить комментарий</h4>
    <form action="{{ route('comments.store', $article) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Ваше имя</label>
            <input type="text" name="author" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Комментарий</label>
            <textarea name="content" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Отправить</button>
    </form>
</div>
@endsection
