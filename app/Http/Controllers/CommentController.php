<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Добавление комментария — только авторизованным пользователям
     */
    public function store(Request $request, Article $article)
    {
        // Защищаем роут middleware('auth') или проверяем здесь
        if (!Auth::check()) {
            return back()->with('error', 'Только зарегистрированные пользователи могут комментировать.');
        }

        // Проверка через Policy (может создавать комментарий)
        $this->authorize('create', Comment::class);

        // Валидация — теперь только текст комментария
        $request->validate([
            'content' => 'required|string|min:5|max:2000',
        ]);

        // Создаём комментарий от имени текущего пользователя
        $article->comments()->create([
            'content' => $request->content,
            'user_id' => Auth::id(), // ← обязательно заполняем
        ]);

        return back()->with('success', 'Комментарий добавлен!');
    }

    public function edit(Comment $comment)
{
    $this->authorize('update', $comment);

    // Передаём статью для возврата назад
    return view('comments.edit', compact('comment'));
}

public function update(Request $request, Comment $comment)
{
    $this->authorize('update', $comment);

    $request->validate([
        'content' => 'required|string|min:5|max:2000',
    ]);

    $comment->update($request->only('content'));

    return redirect()->route('articles.show', $comment->article)
                     ->with('success', 'Комментарий обновлён!');
}
    /**
     * Удаление комментария — только автор или модератор
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Комментарий удалён!');
    }
}
