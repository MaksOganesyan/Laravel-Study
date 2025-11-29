{{-- resources/views/articles/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Добавить новость')

@section('content')
<div class="container py-5">
    <h1 class="display-5 fw-bold mb-4">Добавить новую новость</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Заголовок <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="title" 
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" 
                           required 
                           placeholder="Введите заголовок новости">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Краткое описание <span class="text-danger">*</span></label>
                    <textarea name="short_description" 
                              rows="3" 
                              class="form-control @error('short_description') is-invalid @enderror"
                              required 
                              placeholder="Кратко о чём новость">{{ old('short_description') }}</textarea>
                    @error('short_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Полный текст новости <span class="text-danger">*</span></label>
                    <textarea name="content" 
                              rows="10" 
                              class="form-control @error('content') is-invalid @enderror"
                              required 
                              placeholder="Полный текст статьи">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Картинка превью <span class="text-danger">*</span></label>
                    <input type="file" 
                           name="preview_image" 
                           class="form-control @error('preview_image') is-invalid @enderror"
                           accept="image/jpeg,image/jpg,image/png"
                           required>
                    <div class="form-text">JPG, JPEG или PNG. Максимум 2 МБ.</div>
                    @error('preview_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Дата публикации <span class="text-danger">*</span></label>
                    <input type="date" 
                           name="published_at" 
                           class="form-control @error('published_at') is-invalid @enderror"
                           value="{{ old('published_at', now()->format('Y-m-d')) }}"
                           required>
                    @error('published_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-success btn-lg">
                        Опубликовать новость
                    </button>
                    <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary btn-lg">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
