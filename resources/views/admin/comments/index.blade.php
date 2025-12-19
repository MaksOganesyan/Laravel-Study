@extends('layouts.app')
@section('title', 'Модерация комментариев')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Комментарии на модерацию</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($comments->isEmpty())
        <p>Нет комментариев на модерацию.</p>
    @else
        @foreach($comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <p><strong>{{ $comment->user->name ?? 'Гость' }}</strong>: {{ $comment->content }}</p>
                    <small>К новости: {{ $comment->article->title }}</small>

                    <div class="mt-3">
                        <form action="{{ route('comments.approve', $comment) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Одобрить</button>
                        </form>
                        <form action="{{ route('comments.reject', $comment) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Отклонить?')">Отклонить</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
