@extends('layouts.app')

@section('title', 'Редактирование комментария')

@section('content')
<div class="container py-5">
    <h1>Редактировать комментарий</h1>

    <div class="card my-4">
        <div class="card-body">
            <form action="{{ route('comments.update', $comment) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" 
                              rows="6" required>{{ old('content', $comment->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Сохранить изменения</button>
                <a href="{{ route('articles.show', $comment->article) }}" class="btn btn-secondary ms-2">
                    Отмена
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
