<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    public function viewAny(?User $user): bool
    {
        return true; // все видят список
    }

    public function view(?User $user, Comment $comment): bool
    {
        return true; // все видят один комментарий
    }

    public function create(User $user): bool
    {
        return true; // авторизованные могут создавать (читатель и модератор)
    }

    // Редактирование — только автор или модератор (модератор пройдёт через Gate::before)
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    // Удаление — только автор или модератор
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }
}
