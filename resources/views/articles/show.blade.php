@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="container py-5">
    <h1 class="mb-4">{{ $article->title }}</h1>

    @if($article->preview_image)
       <img src="{{ asset('storage/' . $article->preview_image) }}"
     class="card-img-top"
     style=" object-fit: cover;"
     alt="{{ $article->title }}">
    @endif

    @if($article->short_description)
        <p class="lead mb-4">{{ $article->short_description }}</p>
    @endif

    <div class="mb-5">{!! nl2br(e($article->content)) !!}</div>

    <p class="text-muted mb-5">
        Опубликовано: {{ $article->published_at->format('d.m.Y') }}
    </p>

    <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary mb-5">
        ← Назад к списку новостей
    </a>

    <hr class="my-5">

    <!-- Форма добавления комментария -->
    @auth
        <div class="card mb-5">
            <div class="card-header"><h4>Добавить комментарий</h4></div>
            <div class="card-body">
                <form action="{{ route('comments.store', $article) }}" method="POST">
                    @csrf
                    <textarea name="content" 
                              class="form-control @error('content') is-invalid @enderror" 
                              rows="4" required minlength="5"
                              placeholder="Напишите ваш комментарий...">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary mt-3">Отправить комментарий</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-info mb-5">
            <a href="{{ route('login') }}">Войдите</a>, чтобы оставить комментарий.
        </div>
    @endauth

    <!-- Список комментариев — только одобренные -->
<div class="card">
    <div class="card-header"><h4>Комментарии ({{ $article->comments->where('approved', true)->count() }})</h4></div>
    <div class="card-body">
        @forelse($article->comments->where('approved', true) as $comment)
            <div class="border-bottom py-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>{{ $comment->user->name }}</strong>
                        <small class="text-muted ms-3">
                            {{ $comment->created_at->format('d.m.Y в H:i') }}
                        </small>
                        <p class="mt-3 mb-0">{{ nl2br(e($comment->content)) }}</p>
                    </div>

                    @can('update', $comment)
                        <a href="{{ route('comments.edit', $comment) }}" class="btn btn-sm btn-warning me-2">
                            Редактировать
                        </a>
                    @endcan

                    @can('delete', $comment)
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Точно удалить?')">
                                Удалить
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <p class="text-muted">Пока нет комментариев.</p>
        @endforelse
    </div>
</div>
@endsection
