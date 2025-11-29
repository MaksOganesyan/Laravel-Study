{{-- resources/views/articles/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Редактировать новость')

@section('content')
<div class="container py-5">
    <h1 class="display-5 fw-bold mb-4">Редактировать новость</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Заголовок</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $article->title) }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Краткое описание</label>
                    <textarea name="short_description" rows="3" class="form-control @error('short_description') is-invalid @enderror" required>{{ old('short_description', $article->short_description) }}</textarea>
                    @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Полный текст</label>
                    <textarea name="content" rows="10" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $article->content) }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Текущая картинка</label><br>
                    <img src="{{ asset('storage/' . $article->preview_image) }}" alt="preview" class="img-thumbnail" style="max-height: 200px;">
                </div>

                <div class="mb-3">
                    <label class="form-label">Новая картинка (оставьте пустым, если не меняете)</label>
                    <input type="file" name="preview_image" class="form-control" accept="image/*">
                    @error('preview_image') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Дата публикации</label>
                    <input type="date" name="published_at" class="form-control" 
                           value="{{ old('published_at', $article->published_at->format('Y-m-d')) }}" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
